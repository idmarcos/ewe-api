<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\API\V1\BaseController as BaseController;

use App\Models\Gender;

class GenderController extends BaseController
{
    public function index()
    {
        $genders = Gender::all();

        return $this->sendResponse($genders, 'Lista de géneros.');
    }
}
