<?php

namespace App\Http\Controllers\Admin\Chat;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class VendorChatController extends Controller
{
    public function index($lang)
    {
        $chats = Chat::with('vendor')->get();
        return view('admin.chats.vendor.index', compact('chats'));
    }

    public function show($lang, $vendorId)
    {
        $adminId = auth()->guard('admins')->id();
        $messages = Message::where(function ($q) use ($vendorId, $adminId) {
            $q->where('sender_id', $vendorId)
                ->where('sender_type', 'vendor')
                ->where('receiver_id', $adminId)
                ->where('receiver_type', 'admin');
        })
            ->orWhere(function ($q) use ($vendorId, $adminId) {
                $q->where('sender_id', $adminId)
                    ->where('sender_type', 'admin')
                    ->where('receiver_id', $vendorId)
                    ->where('receiver_type', 'vendor');
            })
            ->orderBy('created_at', 'asc')
            ->get();
        $chat = [
            'id' => $vendorId,
            'vendor_name' => \App\Models\Vendor::find($vendorId)->name,
            'messages' => $messages->map(function ($m) {
                return [
                    'sender' => $m->sender_type === 'admin' ? 'admin' : 'vendor',
                    'content' => $m->message,
                    'created_at' => $m->created_at->timezone('Africa/Cairo')->format('h:i A'),
                ];
            })->toArray()
        ];
        return view('admin.chats.vendor.show', compact('chat', 'vendorId', 'adminId'));
    }


    public function sendMessage(Request $request, $lang, $receiverId)
    {
        try {
            $validated = $request->validate([
                'message' => 'required|string|max:1000',
            ]);
            $adminId = auth()->guard('admins')->user()->id;
            $message = Message::create([
                'sender_id' => $adminId,
                'sender_type' => 'admin',
                'receiver_id' => $receiverId,
                'receiver_type' => 'vendor',
                'message' => $validated['message']
            ]);
            $chat = Chat::updateOrCreate(
                [
                    'vendor_id' => $receiverId,
                    'admin_id' => $adminId,
                ],
                [
                    'last_message' => $validated['message'],
                    'last_message_at' => $message->created_at,
                    'is_read' => false
                ]
            );
            
            // Try to broadcast, but don't fail if Pusher has issues
            try {
                broadcast(new MessageSent($message))->toOthers();
            } catch (\Exception $broadcastException) {
                \Log::warning('Broadcasting failed: ' . $broadcastException->getMessage());
                // Continue execution - message was saved successfully
            }
            
            return response()->json([
                'success' => true,
                'message' => $message->message,
                'created_at' => $message->created_at->timezone('Africa/Cairo')->format('h:i A')
            ]);
        } catch (\Exception $e) {
            \Log::error('Message send failed: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
