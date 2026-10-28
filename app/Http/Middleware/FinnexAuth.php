<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class FinnexAuth
{
    public function handle(Request $request, Closure $next)
    {
        $userId = session('finnex_user_id');

        if (!$userId) {
            return redirect()->route('login');
        }

        $user = User::with('account')->find($userId);

        if (!$user) {
            session()->forget('finnex_user_id');
            return redirect()->route('login');
        }

        // Compartir el usuario Eloquent con todas las vistas
        view()->share('authUser', $user);

        return $next($request);
    }
}
