<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!auth()->check() || !auth()->user()->hasPermission($permission)) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut!');
        }

        return $next($request);
    }
}