<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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

        // Check if user is admin
        if ($user->role !== 'admin') {
            abort(403, 'Access denied. Administrator privileges required.');
        }

        // Check email verification
        if (!$user->email_verified_at) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Please verify your email address.']);
        }

        return $next($request);
    }
}
