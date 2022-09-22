<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

abstract class AbstractRequest extends FormRequest
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
     * @param $attribute
     *
     * @return array
     */
    public function formatErrors($attribute)
    {
        $formatErrors = [];
        foreach ($attribute as $key => $value) {
            $formatErrors[$key] = $value[0];
        }

        return [
            'status' => false,
            'message' => config('api-messages.error.invalid'),
            'errors' => $formatErrors,
        ];
    }


    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->response(
            $this->formatErrors($validator->errors()->getMessages())
        ));
    }

    /**
     * @param array $attribute
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function response($attribute = [])
    {
        return response($attribute);
    }
}
