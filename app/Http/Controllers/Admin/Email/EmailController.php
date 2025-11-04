<?php

namespace App\Http\Controllers\Admin\Email;

use App\Http\Controllers\Controller;
use App\Mail\emailTest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function index()
    {
        $settings = DB::table('email_settings')->first();
        return view('admin.email.index', compact('settings'));
    }

    public function update($lang, Request $request)
    {
        $data = [
            'mailer'        => $request->input('mailer'),
            'host'          => $request->input('host'),
            'port'          => $request->input('port'),
            'username'      => $request->input('username'),
            'encryption'    => $request->input('encryption'),
            'from_address'  => $request->input('from_address'),
            'from_name'     => $request->input('from_name'),
            'updated_at'    => Carbon::now(),
        ];
        if ($request->filled('password')) {
            $data['password'] = $request->input('password');
        } else {
            $existing = DB::table('email_settings')->first();
            $data['password'] = $existing->password ?? null;
        }
        if (DB::table('email_settings')->count() === 0) {
            $data['created_at'] = Carbon::now();
            DB::table('email_settings')->insert($data);
        } else {
            DB::table('email_settings')->update($data);
        }
        return redirect()->back()->with('success', 'Email settings updated successfully.');
    }

    public function emailTest()
    {
        return view('admin.email.test');
    }

    public function sendEmailTest($lang, Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        $testEmail = $request->input('test_email');
        $fromName = config('mail.from.name');
        try {
            Mail::to($testEmail)->send(new emailTest([
                'message' => 'This is a test email from ' . $fromName
            ]));
            return redirect()->back()->with('success', 'Test email sent successfully to ' . $testEmail);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}
