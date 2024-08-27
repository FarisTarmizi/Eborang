<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Models\User_info;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user = Auth::user()->getRoleNames();
        $detail = User_info::findOrFail(Auth::user()->staff_id);
        if (!is_null($detail->name)) {
            if ($user[0] == 'KB_BTM')
                return redirect()->intended(route('kb.kb_home'))->with('welcome', 'Selamat datang ' . $detail->username);
            elseif ($user[0] == 'STAFF_BTM')
                return redirect()->intended(route('staff.staff_home'))->with('welcome', 'Selamat datang ' . $detail->username);
            elseif ($user[0] == 'KB')
                return redirect()->intended(route('kb_l.kbl_home'))->with('welcome', 'Selamat datang ' . $detail->username);
            elseif ($user[0] == 'PEMOHON')
                return redirect()->intended(route('borrower.index'));
            else {
                Auth::guard('web')->logout();
                return redirect()->intended(route('login'))->with('error', 'You are not authorized to access this page');
            }
        }
        return redirect(route('details_form'));

    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Goodbye');
    }
}
