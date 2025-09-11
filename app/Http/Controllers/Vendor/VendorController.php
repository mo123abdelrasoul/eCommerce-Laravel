<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('vendor.login');
    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => [
                'required',
                'email',
                'exists:vendors,email'
            ],
            'password' => 'required|min:6'
        ]);
        $remember = $request->has('remember');
        if (Auth::guard('vendors')->attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']], $remember)) {
            $vendor = Auth::guard('vendors')->user();
            if (!is_null($vendor->deleted_at)) {
                Auth::guard('vendors')->logout();
                return back()->with('error', 'Your account has been deactivated. Please contact support.');
            }
            $orders = DB::table('orders')->where('vendor_id', $vendor->id)->get();
            // return redirect()->route('vendor.dashboard');
            return redirect()->intended(route('vendor.dashboard'));
        }
        return back()->with('error', 'Invalid email or password');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function logout($lang, Request $request)
    {
        $vendor = Auth::guard('vendors')->user();
        if (!$vendor) {
            return redirect()->route('vendor.login');
        }
        Auth::guard('vendors')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('vendor.login');
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
