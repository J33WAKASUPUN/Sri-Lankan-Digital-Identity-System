<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\EmailVerification;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    // Show registration form
    public function showRegister()
    {
        return view('auth.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ]);

        // Combine first and last name for the name field
        $fullName = $request->first_name . ' ' . $request->last_name;

        // Create user with explicit password hashing
        $user = User::create([
            'name' => $fullName,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password), // Make sure this is explicit
            'role' => 'applicant',
            'office_location' => null,
        ]);

        // Send verification email
        $this->emailService->sendVerificationEmail($user->email);

        return redirect()->route('login')->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->remember)) {
            $user = Auth::user();

            // Check email verification
            if (!$user->email_verified_at) {
                Auth::logout();
                return back()->withErrors(['email' => 'Please verify your email before logging in.']);
            }

            // Redirect based on role
            return $this->redirectAfterLogin($user);
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // Verify email
    public function verifyEmail($token)
    {
        if ($this->emailService->verifyEmail($token)) {
            return redirect()->route('login')->with('success', 'Email verified successfully! You can now login.');
        }

        return redirect()->route('login')->withErrors(['email' => 'Invalid or expired verification link.']);
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }

    // Role-based redirect
    private function redirectAfterLogin($user)
    {
        switch ($user->role) {
            case 'applicant':
                return redirect()->route('applicant.dashboard');
            case 'grama_sevaka':
                return redirect()->route('gs.dashboard');
            case 'divisional_secretariat':
                return redirect()->route('ds.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            default:
                return redirect()->route('home');
        }
    }
}
