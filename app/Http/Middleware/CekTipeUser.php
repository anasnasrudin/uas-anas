<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekTipeUser
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::guard('udin')->user();

        if (!$user || !in_array($user->tipe_user, $roles)) {
            return redirect('login')->with('pesan', 'Akses ditolak.');
        }

        return $next($request);
    }
}
