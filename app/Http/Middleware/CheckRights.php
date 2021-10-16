<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ImotiModel;
use Auth;

class CheckRights
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
        $imot = ImotiModel::find($request->id);
        //dd($imot->agent_id, Auth::user()->id, Auth::user()->role);
        if($imot->agent_id == Auth::user()->id || Auth::user()->role == 'admin'){
            return $next($request);
        }
        return redirect()->route('dashboard');

        
    }
}
