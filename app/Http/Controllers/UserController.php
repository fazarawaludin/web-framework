<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Firebase\JWT\JWT;
use Carbon\Carbon;


class UserController extends Controller
{
    //
    public function login(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->getMessageBag())->setStatusCode(422);
        }

        if(Auth::attempt($validator->validated())){
            $payload = [
                'iss' => 'https://example.com',
                'name' => Auth::user()->name,
                'role' => Auth::user()->role,
                'iat' => Carbon::now()->timestamp,
                'exp' => Carbon::now()->timestamp + 60*60*2
            ];

            $jwt = JWT::encode($payload, env('JWT_KEY'), 'HS256');

            return response()->json([
                'messages' => 'token berhasil digenerate',
                'name' => Auth::user()->name,
                'token' => 'Bearer '.$jwt
            ]);
        }

        return response()->json([
            'messages' => 'Pengguna Tidak ditemukan'
        ])->setStatusCode(422);
    }
}
