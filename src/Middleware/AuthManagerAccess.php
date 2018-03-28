<?php

namespace rijolee\AuthManager\Middleware;

use Auth;

use Closure;

use rijolee\AuthManager\Model\Users;




class AuthManagerAccess
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
        $user = Users::where('user_id',Auth::id())->get()->first();


        if( $user['name'] == "authmanager")
        {
            
            return $next($request);
        }    
        else{
            return redirect()->route('authmanager.notallowed');
        }

        
    }
}
