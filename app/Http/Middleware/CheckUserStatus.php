<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // إذا كان المستخدم في انتظار الموافقة
            if ($user->isPending()) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'حسابك في انتظار موافقة المدير. سيتم إشعارك عند الموافقة.');
            }
            
            // إذا كان المستخدم مرفوض
            if ($user->status === 'rejected') {
                Auth::logout();
                return redirect()->route('login')->with('error', 'تم رفض حسابك من قبل المدير.');
            }
        }
        
        return $next($request);
    }
}