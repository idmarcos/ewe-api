<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\API\V1\BaseController as BaseController;

use App\Models\Country;

class CountryController extends BaseController
{
    public function index()
    {
        $countries = Country::all();

        return $this->sendResponse($countries, 'Lista de países.');
    }
}
