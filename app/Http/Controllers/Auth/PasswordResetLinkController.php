<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'forgot_email' => ['required', 'email'],
        ]);

        $forgotEmail = $request->input('forgot_email');

      

        $status = Password::sendResetLink([
            'email' => $forgotEmail
        ]);
  
        

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }   

        return back()
            ->withInput() // flashes all request input
            ->withErrors(['forgot_email' => __($status)])
            ->with('forgot_error', true);
    }
}
