<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$user->email_verified_at) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Please verify your email address before accessing the system.']);
        }

        return $next($request);
    }
}
