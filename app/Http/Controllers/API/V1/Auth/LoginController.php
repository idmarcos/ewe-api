<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\API\V1\BaseController as BaseController;

use Auth;
use Validator;

class LoginController extends BaseController
{
    public function signIn(Request $request)
    {
        $email = $request->input('email');
        $pass = $request->input('password');
        $credentials = ['email' => $email, 'password' => $pass];

        $validator = Validator::make($credentials, [
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if($validator->fails()){
            return $this->sendError('Error de validación.', $validator->errors(), 422);
        }        

        if(Auth::attempt($credentials)){ 
            $auth_user = Auth::user();

            $response['token'] = $auth_user->createToken('EweAuthApiApp')->plainTextToken;
            $response['name'] = $auth_user->name;
   
            return $this->sendResponse($response, 'Usuario logueado');
        }else{ 
            return $this->sendError('Usuario y/o contraseña inválidos.', ['error'=>'Unauthorized'], 401);
        }
    }
}
