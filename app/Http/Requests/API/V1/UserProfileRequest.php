<?php

namespace App\Http\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'gender_id' => 'required|integer',
            'name' => 'required|string',
            'surname' => 'string|nullable',
            'bio' => 'string|nullable',
            'birthdate' => 'date|nullable',
            'telephone' => 'integer|nullable'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $response = response()->json([
            'success' => false,
            'message' => 'Invalid data',
            'data' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}