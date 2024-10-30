<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class BaseRequest extends FormRequest
{

    /**
     * Handle failed validation by mapping error messages to validation codes.
     *
     * @param Validator $validator The validator instance containing the error messages.
     * @param array $errorMap A mapping of error messages to validation codes.
     * @throws HttpResponseException If there are validation errors, this exception is thrown with a response.
     */
    protected function handleFailedValidation(Validator $validator, array $errorMap)
    {
        $errorMessages = $validator->errors()->all();
        $validCodes = [];

        foreach ($errorMessages as $message) {
            if (isset($errorMap[$message])) {
                $validCodes[] = $errorMap[$message];
            }
        }

        if (!empty($validCodes)) {
            throw new HttpResponseException(
                respondValidationFailed($errorMessages[0], $validator->errors(), ($validCodes[0]))
            );
        }
    }

    /**
     * Override the failedValidation method from FormRequest to customize the validation failure handling.
     *
     * @param Validator $validator The validator instance containing the error messages.
     */
    protected function failedValidation(Validator $validator)
    {
        parent::failedValidation($validator);
    }
}
