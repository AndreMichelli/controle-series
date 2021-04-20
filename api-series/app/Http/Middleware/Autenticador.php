<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use App\User;


class Autenticador
{
    public function handle(Request $request, \Closure $next)
    {
        try{
            if ($request->hasHeader('Authorization')) {
                throw new \Exeption();
            }
            $authorizationHeader = $request->header('Authorization');
            $token = str_replace('Bearer', '', $authorizationHeader);
            $dadosAutenticacao = JWT::decode($token, env('JWT_KEY'), ['HS256']);
            $user = User::where('email', $dadosAutenticacao->email)->first();
            if (is_null($user)) {
                throw new \Exeption();
            }
            return $next($request);
        }catch (\Exception $e){
            return response()-json('Não autorizado', 401);
        }
    }
}
