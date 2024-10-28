<?php

namespace App\Http\Requests\API\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Rules\API\Auth\UserIsDelete;
use App\Rules\API\Auth\UserGoogleIdIsFound;
use App\Rules\API\Auth\UserFacebookIdIsFound;

use App\Models\User;

class AuthRequest extends FormRequest
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

        if ($route == "api.user.login") {
            $rules = [
                'email'      => ['exists:users,email'],
                'password'   => ['required'],
                'status'     => [new UserIsDelete($this->email)]
            ];
        } elseif ($route == "api.user.register") {
            $rules = [
                'name'      => 'required|unique:users|regex:/^[\p{Arabic}a-zA-Z0-9\- .ـ]+$/u',
                'email'     => ['required', 'string', 'email', 'max:255',  Rule::unique(User::getTableName(), "email"), 'regex:/^(?=[^@]*[A-Za-z])([a-zA-Z0-9])(([a-zA-Z0-9])*([\._-])?([a-zA-Z0-9]))*@(([a-zA-Z0-9\-])+(\.))+([a-zA-Z]{2,4})+$/i'],
                'password'  => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/']
            ];
        } elseif ($route == "api.user.check_otp") {
            $rules = [
                'otp'      => ['required'],
                'email'    => ['required', 'email', 'exists:users,email'],
            ];
        } elseif ($route == "api.user.resend_otp") {
            $rules = [
                'email'    => ['exists:users,email'],
                'status'   => [new UserIsDelete($this->email)]
            ];
        } elseif ($route == "api.user.login_by_google") {
            $rules = [
                'email'     => ['required', 'email'],
                'google_id' => [new UserGoogleIdIsFound($this)],
                'status'    => [new UserIsDelete($this->email)],
            ];
        } elseif ($route == "api.user.login_by_facebook") {
            $rules = [
                'facebook_id' => [new UserFacebookIdIsFound($this)],
            ];
        } elseif ($route == "api.user.forgetPassword") {
            $rules = [
                'email'    => ['exists:users,email'],
                'status'   => [new UserIsDelete($this->email)]
            ];
        } elseif ($route == "api.user.resetPassword") {
            $rules = [
                'email' => 'required|email|exists:users,email',
                'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
                'confirm_password' => 'required_with:password|same:password|min:6'
            ];
        }
        return $rules;
    }


    public function messages()
    {
        $route =  $this->route()->getName();

        if ($route == "api.user.login") {
            $messages = [
                'email'                 => trans('api_response.EMAIL_EXISTS_CODE'),
                'password'              => trans('api_response.PASSWORD_REQUIRED_CODE'),
                'status'                => trans('api_response.USER_DELETED_CODE')
            ];
        } elseif ($route == "api.user.register") {
            $messages = [
                'name.required'         => trans('api_response.NAME_REQUIRED_CODE') ,
                'name.unique'           => trans('api_response.NAME_UNIQUE_CODE')  ,
                'name.regex'            => trans('api_response.NAME_REGEX_CODE'),
                'email.required'        => trans('api_response.EMAIL_REQUIRED_CODE') ,
                'email.string'          => trans('api_response.EMAIL_STRING_CODE'),
                'email.email'           => trans('api_response.EMAIL_EMAIL_CODE'),
                'email.max'             => trans('api_response.EMAIL_MAX_CODE') ,
                'email.unique'          => trans('api_response.EMAIL_UNIQUE_CODE') ,
                'email.regex'           => trans('api_response.EMAIL_REGEX_CODE') ,
                'password'              => trans('api_response.PASSWORD_VALIDATION_CODE'),
                ];
        } elseif ($route == "api.user.check_otp") {
            $messages = [
                'otp.required'          => trans('api_response.OTP_REQUIRED_CODE'),
                'email.required'        => trans('api_response.EMAIL_REQUIRED_CODE'),
                'email.email'           => trans('api_response.EMAIL_EMAIL_CODE'),
                'email.exists'          => trans('api_response.EMAIL_EXISTS_CODE'),
                ];
        } elseif ($route == "api.user.resend_otp") {
            $messages = [
                'email'                => trans('api_response.EMAIL_EXISTS_CODE'),
                'status'               => trans('api_response.USER_DELETED_CODE')
            ];
        } elseif ($route == "api.user.login_by_google") {
            $messages = [
                'email.required'       => trans('api_response.EMAIL_REQUIRED_CODE'),
                'email.email'          => trans('api_response.EMAIL_EMAIL_CODE'),
                'google_id'            => trans('api_response.GOOGLE_FAILED_CODE'),
                'status'               => trans('api_response.USER_DELETED_CODE'),
                ];
        } elseif ($route == "api.user.login_by_facebook") {
            $messages = [
                'facebook_id'          => trans('api_response.FACEBOOK_FAILED_CODE'),
            ];
        } elseif ($route == "api.user.forgetPassword") {
            $messages = [
                'email'              => trans('api_response.EMAIL_EXISTS_CODE'),
                'status'             => trans('api_response.USER_DELETED_CODE'),
                ];
        } elseif ($route == "api.user.resetPassword") {
            $messages = [
                'email.required'                  => trans('api_response.EMAIL_REQUIRED_CODE'),
                'email.email'                     => trans('api_response.EMAIL_EMAIL_CODE'),
                'email.exists'                    => trans('api_response.EMAIL_EXISTS_CODE'),
                'password'                        => trans('api_response.PASSWORD_VALIDATION_CODE'),
                'confirm_password.required_with'  => trans('api_response.CONFIRM_PASSWORD_REQUIRED_WITH_CODE')  ,
                'confirm_password.same'           => trans('api_response.CONFIRM_PASSWORD_SAME_CODE')  ,
                'confirm_password.min'            => trans('api_response.CONFIRM_PASSWORD_MIN_CODE')   ,
                ];
        }

        return $messages;
    }


    protected function failedValidation(Validator $validator)
    {

        $route             =  $this->route()->getName();
        $messages          = $this->messages();

        if ($route == "api.user.login") {
            $errorMap = [
                $messages['email']                   => EMAIL_EXISTS_CODE,
                $messages['password.required']       => PASSWORD_REQUIRED_CODE,
                $messages['status']                  => USER_DELETED_CODE,
            ];
        } elseif ($route == "api.user.register") {
            $rules = [
                $messages['name.required']           => NAME_REQUIRED_CODE,
                $messages['name.unique']             => NAME_UNIQUE_CODE,
                $messages['name.regex']              => NAME_REGEX,
                $messages['email.required']          => EMAIL_REQUIRED_CODE,
                $messages['email.string']            => EMAIL_STRING_CODE,
                $messages['email.email']             => EMAIL_EMAIL_CODE,
                $messages['email.max']               => EMAIL_MAX_CODE,
                $messages['email.unique']            => EMAIL_UNIQUE_CODE,
                $messages['email.regex']             => EMAIL_REGEX_CODE,
                $messages['password']                => PASSWORD_VALIDATION_CODE,
            ];
        } elseif ($route == "api.user.check_otp") {
            $rules = [
                $messages['otp.required']           => OTP_REQUIRED_CODE,
                $messages['email.required']         => EMAIL_REQUIRED_CODE,
                $messages['email.email']            => EMAIL_EMAIL_CODE,
                $messages['email.exists']           => EMAIL_EXISTS_CODE,
            ];
        } elseif ($route == "api.user.resend_otp") {
            $rules = [
                $messages['email']                 => EMAIL_EXISTS_CODE,
                $messages['status']                => USER_DELETED_CODE,
            ];
        } elseif ($route == "api.user.login_by_google") {
            $rules = [
                $messages['email.required']       => EMAIL_REQUIRED_CODE,
                $messages['email.email']          => EMAIL_EMAIL_CODE,
                $messages['google_id']            => GOOGLE_FAILED_CODE,
                $messages['status']               => USER_DELETED_CODE,
            ];
        } elseif ($route == "api.user.login_by_facebook") {
            $rules = [
                $messages['facebook_id']         => FACEBOOK_FAILED_CODE,
            ];
        } elseif ($route == "api.user.forgetPassword") {
            $rules = [
                $messages['email']               => EMAIL_EXISTS_CODE,
                $messages['status']              => USER_DELETED_CODE,
            ];
        } elseif ($route == "api.user.resetPassword") {
            $rules = [
                $messages['email.required']                 => EMAIL_REQUIRED_CODE,
                $messages['email.email']                    => EMAIL_EMAIL_CODE,
                $messages['email.exists']                   => EMAIL_EXISTS_CODE,
                $messages['password']                       => PASSWORD_VALIDATION_CODE,
                $messages['confirm_password.required_with'] => CONFIRM_PASSWORD_REQUIRED_WITH_CODE,
                $messages['confirm_password.same']          => CONFIRM_PASSWORD_SAME_CODE,
                $messages['confirm_password.min']           => CONFIRM_PASSWORD_MIN_CODE,
            ];
        }

        $errorMessage      = $validator->errors()->all();
        $validCodes        = [];

        foreach ($errorMessage as $message)
            $validCodes[] = $errorMap[$message];


        throw new HttpResponseException(
             respondValidationFailed($errorMessage[0], $validator->errors() , $validCodes[0] )
        );
    }


}
