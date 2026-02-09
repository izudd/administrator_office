<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModulePin
{
    /**
     * Handle an incoming request.
     * Checks if the user has verified the PIN for this module.
     */
    public function handle(Request $request, Closure $next, string $moduleKey): Response
    {
        $sessionKey = 'module_pin_' . $moduleKey;
        $expiry = session($sessionKey);

        // If session exists and hasn't expired, allow access
        if ($expiry && $expiry > now()->timestamp) {
            return $next($request);
        }

        // For AJAX/JSON requests, return 403
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'PIN required',
                'requires_pin' => true,
                'module_key' => $moduleKey,
            ], 403);
        }

        // For normal page requests, redirect to dashboard with flash
        return redirect()->route('dashboard')->with('pin_required', $moduleKey);
    }
}
