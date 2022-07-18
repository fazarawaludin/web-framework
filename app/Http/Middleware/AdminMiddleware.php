<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\key;


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

        $jwt = $request->bearerToken();

        if(is_null($jwt) || $jwt == ''){
            return response()->json([
                'messages' => 'Tidak memiliki otoritas, token tidak terpenuhi'
            ])->setStatusCode(401);
        } else {

            $decode = JWT::decode($jwt, new Key(env('JWT_KEY'), 'HS256'));

            if($decode->role == 'admin'){

                return $next($request);
            } else {
                return response()->json([
                    'messages' => 'Tidak memiliki otoritas, token tidak terpenuhi'
                ])->setStatusCode(401);
            }
        }
    }
}
