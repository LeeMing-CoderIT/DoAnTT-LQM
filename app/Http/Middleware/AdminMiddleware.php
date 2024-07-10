<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->root > 0) return $next($request);
            $email = Auth::user()->email;
            Auth::logout();
            return redirect()->route('admin.login')->with('email', $email)
            ->with('msg', 'Tài khoản của bạn không đủ quyền hạn.');
        }
        return redirect()->route('admin.login')
        ->with('msg', 'Bạn chưa đăng nhập tài khoản quản lý.');
    }
}
