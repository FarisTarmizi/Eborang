<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\User_info;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id' => ['required', 'max:5', 'min:5'],
            'role' => ['required', 'min:0', 'max:3'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user_info = User_info::create([
            'id' => $request->id
        ]);
        $user = User::create([
            'staff_id' => $request->id,
            'password' => Hash::make($request->password),
        ]);

        if ($user && $user_info) {
            if ($request->role == 0)
                $user->assignRole('KB_BTM');
            elseif ($request->role == 1)
                $user->assignRole('STAFF_BTM');
            elseif ($request->role == 2)
                $user->assignRole('PEMOHON');
            elseif ($request->role == 3)
                $user->assignRole('KB');
            return redirect()->intended(route('login'))->with('register', 'Berjaya mendaftar, sila log masuk');
        }
        return redirect()->intended(route('login'))->with('error', 'Ralat berlaku');
    }
}
