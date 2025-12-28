<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('customer.pages.about');
    }

    public function contact()
    {
        return view('customer.pages.contact');
    }

    public function privacy()
    {
        return view('customer.pages.privacy');
    }

    public function terms()
    {
        return view('customer.pages.terms');
    }

    public function shipping()
    {
        return view('customer.pages.shipping');
    }

    public function returns()
    {
        return view('customer.pages.returns');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
        return back()->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
