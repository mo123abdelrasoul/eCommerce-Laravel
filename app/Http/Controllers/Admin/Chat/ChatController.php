<?php

namespace App\Http\Controllers\Admin\Chat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index($lang)
    {
        $chats = [
            [
                'id' => 1,
                'vendor_name' => 'Lamma Store',
                'last_message' => 'Thanks, waiting for confirmation!',
                'updated_at' => '2025-10-30 09:15:00',
            ],
            [
                'id' => 2,
                'vendor_name' => 'Foodies Market',
                'last_message' => 'Can you check my last order issue?',
                'updated_at' => '2025-10-30 08:47:00',
            ],
        ];

        return view('admin.chats.index', compact('chats'));
    }

    public function show($lang, $chatId)
    {
        $chat = [
            'id' => $chatId,
            'vendor_name' => 'Lamma Store',
            'messages' => [
                [
                    'id' => 1,
                    'sender' => 'admin',
                    'content' => 'Hello! How can I help you today?',
                    'created_at' => '2025-10-30 09:00:00',
                ],
                [
                    'id' => 2,
                    'sender' => 'vendor',
                    'content' => 'I have a question about my last withdrawal request.',
                    'created_at' => '2025-10-30 09:02:00',
                ],
                [
                    'id' => 3,
                    'sender' => 'admin',
                    'content' => 'Sure, let me check that for you.',
                    'created_at' => '2025-10-30 09:03:00',
                ],
                [
                    'id' => 4,
                    'sender' => 'vendor',
                    'content' => 'I have a question about my last withdrawal request.',
                    'created_at' => '2025-10-30 09:02:00',
                ],
                [
                    'id' => 5,
                    'sender' => 'admin',
                    'content' => 'Sure, let me check that for you.',
                    'created_at' => '2025-10-30 09:03:00',
                ],

            ],
        ];

        return view('admin.chats.show', compact('chat'));
    }

    public function sendMessage(Request $request, $lang, $chat)
    {
        dd($request->all(), $chat);
        $admin = auth()->guard('admins')->user();
        if (!$admin) {
            return redirect()->route('admin.login', app()->getLocale());
        }
        if (!$admin->hasRole('admin') || !$admin->can('manage vendors')) {
            abort(403, 'Unauthorized');
        }
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);
    }
}
