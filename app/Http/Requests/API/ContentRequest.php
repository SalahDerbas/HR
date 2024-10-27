<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ContentRequest extends FormRequest
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
        $route =  $this->route()->getName();
        if($route == "api.content.contactUs")
        {
            $rules = [
                'name'            => ['required'],
                'email'           => ['required' , 'email'],
                'subject'         => ['required'],
                'message'         => ['required'],
            ];
        }
        return $rules;
    }

    public function messages()
    {
        $route =  $this->route()->getName();
        if($route == "api.content.contactUs")
        {
            $messages =  [
                    'name.required'       =>  trans('api_response.NAME_REQUIRED_CODE'),
                    'email.email'         =>  trans('api_response.EMAIL_EMAIL_CODE'),
                    'email.required'      =>  trans('api_response.EMAIL_REQUIRED_CODE') ,
                    'subject.required'    =>  trans('api_response.SUBJECT_REQUIRED_CODE'),
                    'message.required'    =>  trans('api_response.MESSAGE_REQUIRED_CODE'),
            ];
        }
        return $messages;
    }

    protected function failedValidation(Validator $validator)
    {
        $route             =  $this->route()->getName();
        $messages          = $this->messages();

        if ($route == "api.content.contactUs") {
        $errorMap = [
                    $messages['name.required']          => NAME_REQUIRED_CODE ,
                    $messages['email.required']         => EMAIL_REQUIRED_CODE,
                    $messages['email.email']            => EMAIL_EMAIL_CODE,
                    $messages['subject.required']       => SUBJECT_REQUIRED_CODE,
                    $messages['message.required']       => MESSAGE_REQUIRED_CODE,
             ];
        }

        $errorMessage = $validator->errors->all();
        $validCodes = [];

        foreach ($errorMessage as $message)
            $validCodes[] = $errorMap[$message];

        throw new HttpResponseException(
            respondValidationFailed($errorMessage[0], $validator->errors() , $validCodes[0] )
        );
    }

}
