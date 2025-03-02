<?php

namespace App\Http\Middleware;

use Closure;
use Session;
class StudentMiddleware
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
       

        if($request->session()->get('student_id') === null){

            return redirect('/student-login');
        }
        return $next($request);
        
    }
}
