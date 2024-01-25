<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //  if user do not register at all in application
        if ($request->is('admin/*') && !Auth::guard('admin')->check()) {
            return redirect()->route('home');

        }

        // if user not Auth from admin guard and he try to go to dashboard
        if ($request->is('admin/*')) {
            if (!Auth::guard('admin')->check()) {
                return redirect()->route('user/profile');
            }
        }

        // if ($request->is('admin/*')) {
        //     // إذا كان المستخدم مسجل كـ "يوزر"، يتم توجيهه إلى الصفحة العادية
        //     if (Auth::guard('web')->check()) {
        //         return redirect()->route('home');
        //     }

        //     // إذا كان المستخدم مسجل كـ "أدمن"، يتم توجيهه إلى الصفحة الإدارية
        //     if (Auth::guard('admin')->check()) {
        //         return $next($request);
        //     }

        //     // إذا لم يكن المستخدم مسجل بالمرة، يتم توجيهه إلى صفحة تسجيل الدخول للأدمن
        //     return redirect()->route('home');
        // }


        return $next($request);
    }
}
