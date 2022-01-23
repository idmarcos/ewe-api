<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\API\V1\BaseController as BaseController;

use Validator;

use App\Models\User;

class RegisterController extends BaseController
{
    public function signUp(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|string|max:55',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        if($validator->fails()){
            return $this->sendError('Error de validación.', $validator->errors(), 422);
        }

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        $response['token'] = $user->createToken('EweAuthApiApp')->plainTextToken;
        $response['name'] = $user->name;
   
        return $this->sendResponse($response, 'Usuario creado correctamente.');
    }
}
