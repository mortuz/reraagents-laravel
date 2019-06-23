<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\User;
use Illuminate\Support\Facades\DB;

class AdminTokenMiddleware
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
        $token = null;
        if (preg_match('/Bearer\s(\S+)/', $request->header('Authorization'), $matches)) {
            $token = $matches[1];
        }

        $accessToken = DB::table('oauth_access_tokens')->find($token);

        if ($accessToken) {
            $user = User::find($accessToken->user_id);
            if($user->role == 10) {
                return $next($request);
            }
            return response()->json(['success' => false, 'message' => 'You are not allowed to perform this action.']);
        }
        // if ($request->header('Authorization')) {
        //     return $next($request);
        // }

        Session::flash('error', 'You are not allowed to perform this action.');
        return response()->json(['success' => false, 'message' => 'You are not allowed to perform this action.']);
    }
}
