<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Log;
use function Pest\Laravel\delete;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $user = Auth::guard('web')->user();

        if ($user) {
            $featured_products = Product::where('status', 'approved')->where('featured', true)->limit(4)->get();
            $best_selling_products = Product::where('status', 'approved')->limit(7)->get();
            return view('user.home', [
                'lang' => app()->getLocale(),
                'featured_products' => $featured_products,
                'best_selling_products' => $best_selling_products
            ]);
        }

        return view('user.login', ['lang' => app()->getLocale()]);
    }
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => [
                'required',
                'email'
            ],
            'password' => 'required|min:6'
        ]);
        $user = \App\Models\User::where('email', $validatedData['email'])->withTrashed()->first();
        Log::info('User lookup', ['user' => optional($user)->toArray()]);
        $remember = $request->has('remember');
        if (Auth::guard('web')
            ->attempt(
                [
                    'email' => $validatedData['email'],
                    'password' => $validatedData['password'],
                    'deleted_at' => null
                ],
                $remember
            )
        ) {
            $user = Auth::guard('web')->user();
            if (!is_null($user->deleted_at)) {
                Auth::guard('web')->logout();
                return back()->with('error', 'Your account has been deactivated. Please contact support.');
            }
            return redirect()->route('home', ['lang' => app()->getLocale()]);
        }
        return back()->with('error', 'Invalid email or password');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            return redirect()->route('user.login', ['lang' => app()->getLocale()]);
        }
        return redirect()->route('user.login', ['lang' => app()->getLocale()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
