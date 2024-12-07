<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Route;
use Session;


class CheckIsPasswordChanged
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $currentPath= Route::getFacadeRoot()->current()->uri();
        if($currentPath!='admin/logout'){
            if(backpack_auth()->user()){
                if(backpack_auth()->user()->password_changed_at==null){
                    //dump($currentPath);
                    if($currentPath!='admin/change-password'){
                        return redirect('admin/change-password')->withErrors(['Your password has been expired, please change your password']);
                    }
                }    
            }
                
        }
        
        return $next($request);
    }
}
