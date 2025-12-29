<?php

namespace App\Http\Controllers\Vendor\Chat;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function loadMessages($lang)
    {
        $vendorId = auth()->guard('vendors')->user()->id;
        if (!$vendorId) {
            return response()->json([]);
        }
        $messages = Message::where(function ($q) use ($vendorId) {
            $q->where('sender_id', $vendorId)
                ->where('sender_type', 'vendor')
                ->where('receiver_type', 'admin');
        })
            ->orWhere(function ($q) use ($vendorId) {
                $q->where('receiver_id', $vendorId)
                    ->where('receiver_type', 'vendor')
                    ->where('sender_type', 'admin');
            })
            ->orderBy('created_at', 'asc')
            ->get();
        return response()->json(
            $messages->map(function ($m) {
                return [
                    'sender' => $m->sender_type === 'admin' ? 'admin' : 'vendor',
                    'content' => $m->message,
                    'created_at' => $m->created_at
                        ->timezone('Africa/Cairo')
                        ->format('h:i A'),
                ];
            })
        );
    }

    public function sendMessage(Request $request, $lang)
    {
        try {
            $vendorId = auth()->guard('vendors')->id();
            $request->validate(['message' => 'required|string']);

            $message = Message::create([
                'sender_id' => $vendorId,
                'sender_type' => 'vendor',
                'receiver_id' => 1,
                'receiver_type' => 'admin',
                'message' => $request->message,
            ]);

            $chat = Chat::updateOrCreate(
                [
                    'vendor_id' => $vendorId,
                    'admin_id' => 1,
                ],
                [
                    'last_message' => $request['message'],
                    'last_message_at' => $message->created_at,
                    'is_read' => false
                ]
            );
            
            // Try to broadcast, but don't fail if Pusher has issues
            try {
                broadcast(new MessageSent($message));
            } catch (\Exception $broadcastException) {
                \Log::warning('Broadcasting failed: ' . $broadcastException->getMessage());
                // Continue execution - message was saved successfully
            }
            
            return response()->json([
                'status' => 'success',
                'message' => [
                    'content' => $message->message,
                    'sender' => 'customer',
                    'created_at' => $message->created_at
                        ->timezone('Africa/Cairo')
                        ->format('h:i A')
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
