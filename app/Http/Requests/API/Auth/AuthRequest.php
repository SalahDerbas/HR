<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Validation\Rule;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Rules\API\Auth\UserIsDelete;
use App\Rules\API\Auth\UserGoogleIdIsFound;
use App\Rules\API\Auth\UserFacebookIdIsFound;

use App\Models\User;

class AuthRequest extends BaseRequest
{

    private const ROUTE_LOGIN              = 'api.user.login';
    private const ROUTE_REGISTER           = 'api.user.register';
    private const ROUTE_CHECK_OTP          = 'api.user.check_otp';
    private const ROUTE_RESEND_OTP         = 'api.user.resend_otp';
    private const ROUTE_LOGIN_BY_GOOGLE    = 'api.user.login_by_google';
    private const ROUTE_LOGIN_BY_FACEBOOK  = 'api.user.login_by_facebook';
    private const ROUTE_FORGET_PASSWORD    = 'api.user.forgetPassword';
    private const ROUTE_RESET_PASSWORD     = 'api.user.resetPassword';


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
     * Get the validation rules that apply to the login request.
     *
     * @return array
     */
    private function loginRequest()
    {
        return [
            'rules'   =>  [
                    'email'                  => ['exists:users,email'],
                    'password'               => ['required'],
                    'status'                 => [new UserIsDelete($this->email)],
            ],
            'messages'  => [
                    'email'                 => getStatusText(EMAIL_EXISTS_CODE),
                    'password.required'     => getStatusText(PASSWORD_REQUIRED_CODE),
                    'status'                => getStatusText(USER_DELETED_CODE)
            ],
        ];
    }

    /**
     * Get the validation rules that apply to the registration request.
     *
     * @return array
     */
    private function registerRequest()
    {
        return [
            'rules'   =>  [
                    'name'                  => ['required' , 'unique:users' , 'regex:/^[\p{Arabic}a-zA-Z0-9\- .ـ]+$/u'],
                    'email'                 => ['required', 'string', 'email', 'max:255',  Rule::unique(User::getTableName(), "email"), 'regex:/^(?=[^@]*[A-Za-z])([a-zA-Z0-9])(([a-zA-Z0-9])*([\._-])?([a-zA-Z0-9]))*@(([a-zA-Z0-9\-])+(\.))+([a-zA-Z]{2,4})+$/i'],
                    'password'              => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/']
            ],
            'messages'  => [
                    'name.required'         => getStatusText(NAME_REQUIRED_CODE),
                    'name.unique'           => getStatusText(NAME_UNIQUE_CODE),
                    'name.regex'            => getStatusText(NAME_REGEX_CODE),
                    'email.required'        => getStatusText(EMAIL_REQUIRED_CODE),
                    'email.string'          => getStatusText(EMAIL_STRING_CODE),
                    'email.email'           => getStatusText(EMAIL_EMAIL_CODE),
                    'email.max'             => getStatusText(EMAIL_MAX_CODE),
                    'email.unique'          => getStatusText(EMAIL_UNIQUE_CODE) ,
                    'email.regex'           => getStatusText(EMAIL_REGEX_CODE) ,
                    'password'              => getStatusText(PASSWORD_VALIDATION_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules that apply to the OTP check request.
     *
     * @return array
     */
    private function checkOtpRequest()
    {
        return [
            'rules'   =>  [
                    'otp'                   => ['required'],
                    'email'                 => ['required', 'email', 'exists:users,email'],
            ],
            'messages'  => [
                    'otp.required'          => getStatusText(OTP_REQUIRED_CODE),
                    'email.required'        => getStatusText(EMAIL_REQUIRED_CODE),
                    'email.email'           => getStatusText(EMAIL_EMAIL_CODE),
                    'email.exists'          => getStatusText(EMAIL_EXISTS_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules for resending the OTP.
     *
     * @return array
     */
    private function resendOtpRequest(){
        return [
            'rules'   =>  [
                    'email'                => ['exists:users,email'],
                    'status'               => [new UserIsDelete($this->email)]
            ],
            'messages'  => [
                    'email'                => getStatusText(EMAIL_EXISTS_CODE),
                    'status'               => getStatusText(USER_DELETED_CODE)
            ],
        ];
    }

    /**
     * Get the validation rules for logging in via Google.
     *
     * @return array
     */
    private function loginByGoogleRequest()
    {
        return [
            'rules'   =>  [
                    'email'                    => ['required', 'email'],
                    'google_id'                => [new UserGoogleIdIsFound($this)],
                    'status'                   => [new UserIsDelete($this->email)],
            ],
            'messages'  => [
                    'email.required'           => getStatusText(EMAIL_REQUIRED_CODE),
                    'email.email'              => getStatusText(EMAIL_EMAIL_CODE),
                    'google_id'                => getStatusText(GOOGLE_FAILED_CODE),
                    'status'                   => getStatusText(USER_DELETED_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules for logging in via Facebook.
     *
     * @return array
     */
    private function loginByFacebookRequest()
    {
        return [
            'rules'   =>  [
                'facebook_id'              => [new UserFacebookIdIsFound($this)],
            ],
            'messages'  => [
                'facebook_id'              => getStatusText(FACEBOOK_FAILED_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules for forgetting the password.
     *
     * @return array
     */
    private function forgetPasswordRequest()
    {
        return [
            'rules'   =>  [
                    'email'                    => ['exists:users,email'],
                    'status'                   => [new UserIsDelete($this->email)]
            ],
            'messages'  => [
                    'email'                    => getStatusText(EMAIL_EXISTS_CODE),
                    'status'                   => getStatusText(USER_DELETED_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules for resetting the password.
     *
     * @return array
     */
    private function resetPasswordRequest()
    {
        return [
            'rules'   =>  [
                    'email'                           => ['required' ,'email' , 'exists:users,email' ],
                    'password'                        => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
                    'confirm_password'                => ['required_with:password','same:password','min:6'],
            ],
            'messages'  => [
                    'email.required'                  => getStatusText(EMAIL_REQUIRED_CODE),
                    'email.email'                     => getStatusText(EMAIL_EMAIL_CODE),
                    'email.exists'                    => getStatusText(EMAIL_EXISTS_CODE),
                    'password'                        => getStatusText(PASSWORD_VALIDATION_CODE),
                    'confirm_password.required_with'  => getStatusText(CONFIRM_PASSWORD_REQUIRED_WITH_CODE)  ,
                    'confirm_password.same'           => getStatusText(CONFIRM_PASSWORD_SAME_CODE)  ,
                    'confirm_password.min'            => getStatusText(CONFIRM_PASSWORD_MIN_CODE)   ,
            ],
        ];

    }

    /**
     * Get requested data based on the current route.
     *
     * @param string $key
     * @return mixed
     */
    private function requested($key)
    {
        $route = $this->route()->getName();
        $data = match ($route) {
                self::ROUTE_LOGIN                => $this->loginRequest(),
                self::ROUTE_REGISTER             => $this->registerRequest(),
                self::ROUTE_CHECK_OTP            => $this->checkOtpRequest(),
                self::ROUTE_RESEND_OTP           => $this->resendOtpRequest(),
                self::ROUTE_LOGIN_BY_GOOGLE      => $this->loginByGoogleRequest(),
                self::ROUTE_LOGIN_BY_FACEBOOK    => $this->loginByFacebookRequest(),
                self::ROUTE_FORGET_PASSWORD      => $this->forgetPasswordRequest(),
                self::ROUTE_RESET_PASSWORD       => $this->resetPasswordRequest(),
            default => []
        };
        return $data[$key];

    }

    /**
     * Get the validation rules for the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->requested('rules');
    }

    /**
     * Get the validation messages for the request.
     *
     * @return array
     */
    public function messages()
    {
        return $this->requested('messages');
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $route      = $this->route()->getName();
        $messages   = $this->messages();

        $errorMap = match ($route) {
            self::ROUTE_LOGIN => [
                    $messages['email']                => EMAIL_EXISTS_CODE,
                    $messages['password.required']    => PASSWORD_REQUIRED_CODE,
                    $messages['status']               => USER_DELETED_CODE,
            ],
            self::ROUTE_REGISTER => [
                    $messages['name.required']        => NAME_REQUIRED_CODE,
                    $messages['name.unique']          => NAME_UNIQUE_CODE,
                    $messages['name.regex']           => NAME_REGEX_CODE,
                    $messages['email.required']       => EMAIL_REQUIRED_CODE,
                    $messages['email.string']         => EMAIL_STRING_CODE,
                    $messages['email.email']          => EMAIL_EMAIL_CODE,
                    $messages['email.max']            => EMAIL_MAX_CODE,
                    $messages['email.unique']         => EMAIL_UNIQUE_CODE,
                    $messages['email.regex']          => EMAIL_REGEX_CODE,
                    $messages['password']             => PASSWORD_VALIDATION_CODE,
            ],
            self::ROUTE_CHECK_OTP => [
                    $messages['otp.required']         => OTP_REQUIRED_CODE,
                    $messages['email.required']       => EMAIL_REQUIRED_CODE,
                    $messages['email.email']          => EMAIL_EMAIL_CODE,
                    $messages['email.exists']         => EMAIL_EXISTS_CODE,
            ],
            self::ROUTE_RESEND_OTP => [
                    $messages['email']                => EMAIL_EXISTS_CODE,
                    $messages['status']               => USER_DELETED_CODE,
            ],
            self::ROUTE_LOGIN_BY_GOOGLE => [
                    $messages['email.required']       => EMAIL_REQUIRED_CODE,
                    $messages['email.email']          => EMAIL_EMAIL_CODE,
                    $messages['google_id']            => GOOGLE_FAILED_CODE,
                    $messages['status']               => USER_DELETED_CODE,
            ],
            self::ROUTE_LOGIN_BY_FACEBOOK => [
                    $messages['facebook_id']          => FACEBOOK_FAILED_CODE,
            ],
            self::ROUTE_FORGET_PASSWORD => [
                    $messages['email']                => EMAIL_EXISTS_CODE,
                    $messages['status']               => USER_DELETED_CODE,
            ],
            self::ROUTE_RESET_PASSWORD => [
                    $messages['email.required']                 => EMAIL_REQUIRED_CODE,
                    $messages['email.email']                    => EMAIL_EMAIL_CODE,
                    $messages['email.exists']                   => EMAIL_EXISTS_CODE,
                    $messages['password']                       => PASSWORD_VALIDATION_CODE,
                    $messages['confirm_password.required_with'] => CONFIRM_PASSWORD_REQUIRED_WITH_CODE,
                    $messages['confirm_password.same']          => CONFIRM_PASSWORD_SAME_CODE,
                    $messages['confirm_password.min']           => CONFIRM_PASSWORD_MIN_CODE,
            ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }

}
