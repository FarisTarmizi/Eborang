<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Rules\StaffEmailExists;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('layouts/reset-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $customMessage = [
            'staff_id.required' => 'Sila masukkan id pekerja',
            'email.required' => 'Sila masukkan e-mel',
            'email.email' => 'Sila masukkan alamat e-mel yang sah',
            'staff_id.exists' => 'Id ini tiada dalam pangkalan data',
        ];
        $request->validate([
            'staff_id' => ['required', 'exists:App\Models\User,staff_id'],
            'email' => ['required', 'email', new StaffEmailExists($request->input('staff_id'))],
        ], $customMessage);

        $token = Str::random(60);
        $email = $request->get('email');
        DB::table('password_reset_tokens')->updateOrInsert(
            ['staff_id' => request('staff_id')],
            [
                'staff_id' => request('staff_id'),
                'token' => $token,
                'created_at' => now(),
            ]
        );
        $result = Mail::send('auth/mail/reset_pass', ['token' => $token], function ($message) use ($email) {
            $message->to($email)->subject('Menukar Kata Laluan');
        });
        if ($result)
            return redirect(route('password_request'))->with('success', 'Pautan menukar semula kata laluan dihantar ke ' . $email );
        return redirect(route('password_request'))->with('error', 'Ralat!');

        /*// We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
                ->withErrors(['email' => __($status)]);*/
    }

    public function form($token)
    {
        return \view('auth/reset_form', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => ['required', 'exists:password_reset_tokens,token'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $check_token = DB::table('password_reset_tokens')->where('token', request('token'))->first();
        if (!$check_token)
            return redirect()->route('password.reset')->with('error', 'Token tidak ditemukan!');

        $user = DB::table('users')->where('staff_id', $check_token->staff_id)->first();//cari id staff

        if (!$user)
            return redirect()->route('password.reset')->with('error', 'Id tidak ditemukan!');

        $plan1 = DB::table('users')->where('staff_id', $check_token->staff_id)->update([
            'password' => Hash::make($request->get('password')),
        ]);
        $plan2 = DB::table('password_reset_tokens')->where('token', request('token'))->delete();
        if ($plan1 && $plan2)
            return redirect()->route('login')->with('success', 'Berjaya Menukar Password');
        return redirect()->route('password.reset')->with('error', 'Ralat!');

    }
}
