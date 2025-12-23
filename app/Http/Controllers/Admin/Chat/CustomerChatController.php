<?php

namespace App\Http\Controllers\Admin\Chat;

use App\Events\MessageSent;
use App\Events\MessageSentWithPusher;
use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\CustomerChat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerChatController extends Controller
{
    public function index($lang)
    {
        $chats = CustomerChat::with('customer')->get();
        return view('admin.chats.customer.index', compact('chats'));
    }

    public function show($lang, $customerId)
    {
        $adminId = auth()->guard('admins')->id();
        $messages = Message::where(function ($q) use ($customerId, $adminId) {
            $q->where('sender_id', $customerId)
                ->where('sender_type', 'customer')
                ->where('receiver_id', $adminId)
                ->where('receiver_type', 'admin');
        })
            ->orWhere(function ($q) use ($customerId, $adminId) {
                $q->where('sender_id', $adminId)
                    ->where('sender_type', 'admin')
                    ->where('receiver_id', $customerId)
                    ->where('receiver_type', 'customer');
            })
            ->orderBy('created_at', 'asc')
            ->get();
        $chat = [
            'id' => $customerId,
            'customer_name' => \App\Models\User::find($customerId)->name,
            'messages' => $messages->map(function ($m) {
                return [
                    'sender' => $m->sender_type === 'admin' ? 'admin' : 'customer',
                    'content' => $m->message,
                    'created_at' => $m->created_at->timezone('Africa/Cairo')->format('h:i A'),
                ];
            })->toArray()
        ];
        return view('admin.chats.customer.show', compact('chat', 'customerId', 'adminId'));
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
                'receiver_type' => 'customer',
                'message' => $validated['message']
            ]);
            $chat = CustomerChat::updateOrCreate(
                [
                    'user_id' => $receiverId,
                    'admin_id' => $adminId,
                ],
                [
                    'last_message' => $validated['message'],
                    'last_message_at' => $message->created_at,
                    'is_read' => false
                ]
            );
            broadcast(new MessageSentWithPusher($message))->toOthers();
            return response()->json([
                'success' => true,
                'message' => $message->message,
                'created_at' => $message->created_at->timezone('Africa/Cairo')->format('h:i A')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
