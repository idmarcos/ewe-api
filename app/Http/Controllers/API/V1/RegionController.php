<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\API\V1\BaseController as BaseController;

use App\Models\Region;

use Validator;

class RegionController extends BaseController
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_id' => 'integer',
        ]);
 
        if($validator->fails()){
            return $this->sendError('Error de validación.', $validator->errors(), 422);
        }

        $parameters_validated = $validator->validated();

        $regions = new Region();
        
        if(isset($parameters_validated['country_id'])){
            $regions = $regions->where('country_id', $parameters_validated['country_id']);
        }

        $regions = $regions->get();
        
        return $this->sendResponse($regions, 'Lista de regiones.');
    }
}
