<?php

namespace App\Http\Requests\API\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class NotificationRequest extends FormRequest
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
        if($route == "api.company.notification.send")
        {
            $rules = [
                    'title_en'          => ['required'],
                    'title_ar'          => ['required'],
                    'body_en'           => ['required'],
                    'body_ar'           => ['required'],
                    'ids'               => ['string']   ,
            ];
        }
        return $rules;
    }

    public function messages()
    {
        $route =  $this->route()->getName();
        if($route == "api.company.notification.send")
        {
            $messages =  [
                    'title_en.required'       =>  trans('api_response.TITLE_EN_REQUIRED_CODE'),
                    'title_ar.required'       =>  trans('api_response.TITLE_AR_REQUIRED_CODE') ,
                    'body_en.required'        =>  trans('api_response.BODY_EN_REQUIRED_CODE'),
                    'body_ar.required'        =>  trans('api_response.BODY_AR_REQUIRED_CODE'),
                    'ids.string'               =>  trans('api_response.USERS_STRING_CODE'),
            ];
        }
        return $messages;
    }


    protected function failedValidation(Validator $validator)
    {
        $route             =  $this->route()->getName();
        $messages          = $this->messages();

        if ($route == "api.company.notification.send") {
        $errorMap = [
                    $messages['title_en.required']           => TITLE_EN_REQUIRED_CODE ,
                    $messages['title_ar.required']           => TITLE_AR_REQUIRED_CODE,
                    $messages['body_en.required']            => BODY_EN_REQUIRED_CODE,
                    $messages['body_ar.required']            => BODY_AR_REQUIRED_CODE,
                    $messages['ids.string']                  => USERS_STRING_CODE,
             ];
        }

        $errorMessage      = $validator->errors()->all();
        $validCodes = [];

        foreach ($errorMessage as $message)
            $validCodes[] = $errorMap[$message];

        throw new HttpResponseException(
            respondValidationFailed($errorMessage[0], $validator->errors() , $validCodes[0] )
        );
    }


}
