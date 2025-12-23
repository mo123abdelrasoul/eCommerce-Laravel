<?php

namespace App\Http\Controllers\Customer\Chat;

use App\Events\MessageSentWithPusher;
use App\Http\Controllers\Controller;
use App\Models\CustomerChat;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function loadMessages($lang)
    {
        $customerId = auth()->guard('web')->user()->id;
        if (!$customerId) {
            return response()->json([]);
        }
        $messages = Message::where(function ($q) use ($customerId) {
            $q->where('sender_id', $customerId)
                ->where('sender_type', 'customer')
                ->where('receiver_type', 'admin');
        })
            ->orWhere(function ($q) use ($customerId) {
                $q->where('receiver_id', $customerId)
                    ->where('receiver_type', 'customer')
                    ->where('sender_type', 'admin');
            })
            ->orderBy('created_at', 'asc')
            ->get();
        return response()->json(
            $messages->map(function ($m) {
                return [
                    'sender' => $m->sender_type === 'admin' ? 'admin' : 'customer',
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
            $customerId = auth()->guard('web')->id();
            $request->validate(['message' => 'required|string']);

            $message = Message::create([
                'sender_id' => $customerId,
                'sender_type' => 'customer',
                'receiver_id' => 1,
                'receiver_type' => 'admin',
                'message' => $request->message,
            ]);

            $chat = CustomerChat::updateOrCreate(
                [
                    'user_id' => $customerId,
                    'admin_id' => 1,
                ],
                [
                    'last_message' => $request['message'],
                    'last_message_at' => $message->created_at,
                    'is_read' => false
                ]
            );
            broadcast(new MessageSentWithPusher($message))->toOthers();
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
