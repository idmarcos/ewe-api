<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\API\V1\BaseController as BaseController;

use App\Http\Requests\API\V1\UserProfileRequest;

use App\Models\UserProfile;

use Auth;
use Validator;

class UserProfileController extends BaseController
{
    /**
     * Get auth user profile
     */
    public function myProfile(Request $request)
    {
        $auth_user = Auth::user();

        $profile = $auth_user->user_profile;

        if(isset($profile)){
            $profile->gender;

            return $this->sendResponse([$profile], 'Perfil de usuario.');
        }else{
            return $this->sendError('Perfil de usuario no encontrado.', [], 404);
        }
    }

    /**
     * Update auth user profile
     */
    public function updateMyProfile(UserProfileRequest $request)
    {
        $auth_user = Auth::user();
        $parameters_validated = $request->validated();

        $gender_id = $parameters_validated['gender_id'];
        $name = $parameters_validated['name'];
        $surname = $parameters_validated['surname'] ?? null;
        $bio = $parameters_validated['bio'] ?? null;
        $birthdate = $parameters_validated['birthdate'] ?? null;
        $telephone = $parameters_validated['telephone'] ?? null;

        $profile = $auth_user->user_profile;

        if(isset($profile)){
            if($gender_id != $profile->gender_id || $name != $profile->name ||
               $surname != $profile->surname || $bio != $profile->bio ||
               $birthdate != $profile->birthdate || $telephone != $profile->telephone){
                   $profile->gender_id = $gender_id;
                   $profile->name = $name;
                   $profile->surname = $surname;
                   $profile->bio = $bio;
                   $profile->birthdate = $birthdate;
                   $profile->telephone = $telephone;

                   $profile->save();
            }
        }else{
            $profile = new UserProfile();

            $profile->user_id = $auth_user->id;
            $profile->gender_id = $gender_id;
            $profile->name = $name;
            $profile->surname = $surname;
            $profile->bio = $bio;
            $profile->birthdate = $birthdate;
            $profile->telephone = $telephone;

            $profile->save();
        }

        $profile->gender;
        
        return $this->sendResponse([$profile], 'Perfil de usuario actualizado.');
    }
}
