<?php

namespace App\Http\Requests\API\Auth;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Validation\Rule;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Rules\API\Auth\UserIsDelete;
use App\Rules\API\Auth\UserGoogleIdIsFound;
use App\Rules\API\Auth\UserFacebookIdIsFound;
use App\Rules\API\Auth\UserAppleIdIsFound;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthRequest extends BaseRequest
{

    private const ROUTE_LOGIN              = 'api.user.login';
    private const ROUTE_STORE              = 'api.user.store';
    private const ROUTE_UPDATE_PROFILE     = 'api.user.update_profile';
    private const ROUTE_CHECK_OTP          = 'api.user.check_otp';
    private const ROUTE_RESEND_OTP         = 'api.user.resend_otp';
    private const ROUTE_LOGIN_BY_GOOGLE    = 'api.user.login_by_google';
    private const ROUTE_LOGIN_BY_FACEBOOK  = 'api.user.login_by_facebook';
    private const ROUTE_LOGIN_BY_APPLE     = 'api.user.login_by_apple';
    private const ROUTE_FORGET_PASSWORD    = 'api.user.forget_password';
    private const ROUTE_RESET_PASSWORD     = 'api.user.reset_password';


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
     * Get the validation rules that apply to the store request.
     *
     * @return array
     */
    private function storeRequest()
    {
        return [
            'rules'   =>  [
                    'usrename'              => ['required' , 'unique:users' , 'regex:/^[\p{Arabic}a-zA-Z0-9\- .ـ]+$/u'],
                    'email'                 => ['required', 'string', 'email', 'max:255',  Rule::unique(User::getTableName(), "email"), 'regex:/^(?=[^@]*[A-Za-z])([a-zA-Z0-9])(([a-zA-Z0-9])*([\._-])?([a-zA-Z0-9]))*@(([a-zA-Z0-9\-])+(\.))+([a-zA-Z]{2,4})+$/i'],
                    'password'              => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
                    'name_ar'               => ['required' ],
                    'name_en'               => ['required' ],
                    'phone'                 => ['required' ],
                    'ID_code'               => ['required' ],
                    'passport_code'         => ['required' ],
                    'salary'                => ['required' ],
                    'location_ar'           => ['required' ],
                    'location_en'           => ['required' ],
                    'date_of_brith'         => ['required' ,  'date'],
                    'join_date'             => ['required' ,  'date'],
                    'country_id'            => ['required' ,  'exists:countries,id'],
                    'gender_id'             => ['required' ,  'exists:lookups,id'  ],
                    'reigon_id'             => ['required' ,  'exists:lookups,id'  ],
                    'material_status_id'    => ['required' ,  'exists:lookups,id'  ],
                    'work_type_id'          => ['required' ,  'exists:lookups,id'  ],
                    'contract_type_id'      => ['required' ,  'exists:lookups,id'  ],
                    'directory_id'          => ['nullable' ,  'exists:users,id'    ],
                    'photo'                 => ['file'  ],
                    'is_directory'          => ['required' ,  'boolean'],
            ],
            'messages'  => [
                    'usrename.required'           => getStatusText(NAME_REQUIRED_CODE),
                    'usrename.unique'             => getStatusText(NAME_UNIQUE_CODE),
                    'usrename.regex'              => getStatusText(NAME_REGEX_CODE),
                    'email.required'              => getStatusText(EMAIL_REQUIRED_CODE),
                    'email.string'                => getStatusText(EMAIL_STRING_CODE),
                    'email.email'                 => getStatusText(EMAIL_EMAIL_CODE),
                    'email.max'                   => getStatusText(EMAIL_MAX_CODE),
                    'email.unique'                => getStatusText(EMAIL_UNIQUE_CODE) ,
                    'email.regex'                 => getStatusText(EMAIL_REGEX_CODE) ,
                    'password'                    => getStatusText(PASSWORD_VALIDATION_CODE),
                    'name_ar.required'            => getStatusText(NAME_AR_CODE),
                    'name_en.required'            => getStatusText(NAME_EN_CODE),
                    'phone.required'              => getStatusText(PHONE_CODE),
                    'ID_code.required'            => getStatusText(ID_CODE_CODE),
                    'passport_code.required'      => getStatusText(PASSPORT_CODE_CODE),
                    'salary.required'             => getStatusText(SALARY_CODE),
                    'location_ar.required'        => getStatusText(LOCATION_AR_CODE),
                    'location_en.required'        => getStatusText(LOCATION_EN_CODE),
                    'date_of_brith.required'      => getStatusText(DATE_OF_BRITH_REQUIRED_CODE),
                    'date_of_brith.date'          => getStatusText(DATE_OF_BRITH_DATE_CODE),
                    'join_date.required'          => getStatusText(JOIN_DATE_REQUIRED_CODE),
                    'join_date.date'              => getStatusText(JOIN_DATE_DATE_CODE),
                    'country_id.required'         => getStatusText(COUNTRY_ID_REQUIRED_CODE),
                    'country_id.exists'           => getStatusText(COUNTRY_ID_EXISTS_CODE),
                    'gender_id.required'          => getStatusText(GENDER_ID_REQUIRED_CODE),
                    'gender_id.exists'            => getStatusText(GENDER_ID_EXISTS_CODE),
                    'reigon_id.required'          => getStatusText(REIGON_ID_REQUIRED_CODE),
                    'reigon_id.exists'            => getStatusText(REIGON_ID_EXISTS_CODE),
                    'material_status_id.required' => getStatusText(MATERIL_STATUS_ID_REQUIRED_CODE),
                    'material_status_id.exists'   => getStatusText(MATERIL_STATUS_ID_EXISTS_CODE),
                    'work_type_id.required'       => getStatusText(WORK_TYPE_ID_REQUIRED_CODE),
                    'work_type_id.exists'         => getStatusText(WORK_TYPE_ID_EXISTS_CODE),
                    'contract_type_id.required'   => getStatusText(CONTRACT_TYPE_ID_REQUIRED_CODE),
                    'contract_type_id.exists'     => getStatusText(CONTRACT_TYPE_ID_EXISTS_CODE),
                    'directory_id.nullable'       => getStatusText(DIRECTORY_ID_NULLABLE_CODE),
                    'directory_id.exists'         => getStatusText(DIRECTORY_ID_EXISTS_CODE),
                    'photo.file'                  => getStatusText(PHOTO_FILE_CODE),
                    'is_directory.required'       => getStatusText(IS_DIRECTORY_REQUIRED_CODE),
                    'is_directory.boolean'        => getStatusText(IS_DIRECTORY_BOOLEAN_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules that apply to the update request.
     *
     * @return array
     */
    private function updateProfileRequest()
    {
        return [
            'rules'   =>  [
                    'usrename'              => ['required' , 'unique:users,usrename,'. auth()->id() , 'regex:/^[\p{Arabic}a-zA-Z0-9\- .ـ]+$/u'],
                    'email'                 => ['required', 'string', 'email', 'max:255',  'unique:users,email,'. auth()->id(), 'regex:/^(?=[^@]*[A-Za-z])([a-zA-Z0-9])(([a-zA-Z0-9])*([\._-])?([a-zA-Z0-9]))*@(([a-zA-Z0-9\-])+(\.))+([a-zA-Z]{2,4})+$/i'],
                    'name_ar'               => ['required' ],
                    'name_en'               => ['required' ],
                    'phone'                 => ['required' ],
                    'ID_code'               => ['required' ],
                    'passport_code'         => ['required' ],
                    'salary'                => ['required' ],
                    'location_ar'           => ['required' ],
                    'location_en'           => ['required' ],
                    'date_of_brith'         => ['required' ,  'date'],
                    'join_date'             => ['required' ,  'date'],
                    'country_id'            => ['required' ,  'exists:countries,id'],
                    'gender_id'             => ['required' ,  'exists:lookups,id'  ],
                    'reigon_id'             => ['required' ,  'exists:lookups,id'  ],
                    'material_status_id'    => ['required' ,  'exists:lookups,id'  ],
                    'work_type_id'          => ['required' ,  'exists:lookups,id'  ],
                    'contract_type_id'      => ['required' ,  'exists:lookups,id'  ],
                    'directory_id'          => ['nullable' ,  'exists:users,id'    ],
                    'photo'                 => ['file'  ],
                    'is_directory'          => ['required' ,  'boolean'],
            ],
            'messages'  => [
                    'usrename.required'           => getStatusText(NAME_REQUIRED_CODE),
                    'usrename.unique'             => getStatusText(NAME_UNIQUE_CODE),
                    'usrename.regex'              => getStatusText(NAME_REGEX_CODE),
                    'email.required'              => getStatusText(EMAIL_REQUIRED_CODE),
                    'email.string'                => getStatusText(EMAIL_STRING_CODE),
                    'email.email'                 => getStatusText(EMAIL_EMAIL_CODE),
                    'email.max'                   => getStatusText(EMAIL_MAX_CODE),
                    'email.unique'                => getStatusText(EMAIL_UNIQUE_CODE) ,
                    'email.regex'                 => getStatusText(EMAIL_REGEX_CODE) ,
                    'name_ar.required'            => getStatusText(NAME_AR_CODE),
                    'name_en.required'            => getStatusText(NAME_EN_CODE),
                    'phone.required'              => getStatusText(PHONE_CODE),
                    'ID_code.required'            => getStatusText(ID_CODE_CODE),
                    'passport_code.required'      => getStatusText(PASSPORT_CODE_CODE),
                    'salary.required'             => getStatusText(SALARY_CODE),
                    'location_ar.required'        => getStatusText(LOCATION_AR_CODE),
                    'location_en.required'        => getStatusText(LOCATION_EN_CODE),
                    'date_of_brith.required'      => getStatusText(DATE_OF_BRITH_REQUIRED_CODE),
                    'date_of_brith.date'          => getStatusText(DATE_OF_BRITH_DATE_CODE),
                    'join_date.required'          => getStatusText(JOIN_DATE_REQUIRED_CODE),
                    'join_date.date'              => getStatusText(JOIN_DATE_DATE_CODE),
                    'country_id.required'         => getStatusText(COUNTRY_ID_REQUIRED_CODE),
                    'country_id.exists'           => getStatusText(COUNTRY_ID_EXISTS_CODE),
                    'gender_id.required'          => getStatusText(GENDER_ID_REQUIRED_CODE),
                    'gender_id.exists'            => getStatusText(GENDER_ID_EXISTS_CODE),
                    'reigon_id.required'          => getStatusText(REIGON_ID_REQUIRED_CODE),
                    'reigon_id.exists'            => getStatusText(REIGON_ID_EXISTS_CODE),
                    'material_status_id.required' => getStatusText(MATERIL_STATUS_ID_REQUIRED_CODE),
                    'material_status_id.exists'   => getStatusText(MATERIL_STATUS_ID_EXISTS_CODE),
                    'work_type_id.required'       => getStatusText(WORK_TYPE_ID_REQUIRED_CODE),
                    'work_type_id.exists'         => getStatusText(WORK_TYPE_ID_EXISTS_CODE),
                    'contract_type_id.required'   => getStatusText(CONTRACT_TYPE_ID_REQUIRED_CODE),
                    'contract_type_id.exists'     => getStatusText(CONTRACT_TYPE_ID_EXISTS_CODE),
                    'directory_id.nullable'       => getStatusText(DIRECTORY_ID_NULLABLE_CODE),
                    'directory_id.exists'         => getStatusText(DIRECTORY_ID_EXISTS_CODE),
                    'photo.file'                  => getStatusText(PHOTO_FILE_CODE),
                    'is_directory.required'       => getStatusText(IS_DIRECTORY_REQUIRED_CODE),
                    'is_directory.boolean'        => getStatusText(IS_DIRECTORY_BOOLEAN_CODE),
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
     * Get the validation rules for logging in via Apple.
     *
     * @return array
     */
    private function loginByAppleRequest()
    {
        return [
            'rules'   =>  [
                'apple_id'              => [new UserAppleIdIsFound($this)],
            ],
            'messages'  => [
                'apple_id'              => getStatusText(APPLE_ID_FAILED_CODE),
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
        $data  = match ($route) {
                self::ROUTE_LOGIN                => $this->loginRequest(),
                self::ROUTE_STORE                => $this->storeRequest(),
                self::ROUTE_UPDATE_PROFILE       => $this->updateProfileRequest(),
                self::ROUTE_CHECK_OTP            => $this->checkOtpRequest(),
                self::ROUTE_RESEND_OTP           => $this->resendOtpRequest(),
                self::ROUTE_LOGIN_BY_GOOGLE      => $this->loginByGoogleRequest(),
                self::ROUTE_LOGIN_BY_FACEBOOK    => $this->loginByFacebookRequest(),
                self::ROUTE_LOGIN_BY_APPLE       => $this->loginByAppleRequest(),
                self::ROUTE_FORGET_PASSWORD      => $this->forgetPasswordRequest(),
                self::ROUTE_RESET_PASSWORD       => $this->resetPasswordRequest(),

                default => [ 'rules' => [], 'messages' => []  ]
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
            self::ROUTE_STORE => [
                    $messages['usrename.required']           => NAME_REQUIRED_CODE,
                    $messages['usrename.unique']             => NAME_UNIQUE_CODE,
                    $messages['usrename.regex']              => NAME_REGEX_CODE,
                    $messages['email.required']              => EMAIL_REQUIRED_CODE,
                    $messages['email.string']                => EMAIL_STRING_CODE,
                    $messages['email.email']                 => EMAIL_EMAIL_CODE,
                    $messages['email.max']                   => EMAIL_MAX_CODE,
                    $messages['email.unique']                => EMAIL_UNIQUE_CODE,
                    $messages['email.regex']                 => EMAIL_REGEX_CODE,
                    $messages['password']                    => PASSWORD_VALIDATION_CODE,
                    $messages['name_ar.required']            => NAME_AR_CODE,
                    $messages['name_en.required']            => NAME_EN_CODE,
                    $messages['phone.required']              => PHONE_CODE,
                    $messages['ID_code.required']            => ID_CODE_CODE,
                    $messages['passport_code.required']      => PASSPORT_CODE_CODE,
                    $messages['salary.required']             => SALARY_CODE,
                    $messages['location_ar.required']        => LOCATION_AR_CODE,
                    $messages['location_en.required']        => LOCATION_EN_CODE,
                    $messages['date_of_brith.required']      => DATE_OF_BRITH_REQUIRED_CODE,
                    $messages['date_of_brith.date']          => DATE_OF_BRITH_DATE_CODE,
                    $messages['join_date.required']          => JOIN_DATE_REQUIRED_CODE,
                    $messages['join_date.date']              => JOIN_DATE_DATE_CODE,
                    $messages['country_id.required']         => COUNTRY_ID_REQUIRED_CODE,
                    $messages['country_id.exists']           => COUNTRY_ID_EXISTS_CODE,
                    $messages['gender_id.required']          => GENDER_ID_REQUIRED_CODE,
                    $messages['gender_id.exists']            => GENDER_ID_EXISTS_CODE,
                    $messages['reigon_id.required']          => REIGON_ID_REQUIRED_CODE,
                    $messages['reigon_id.exists']            => REIGON_ID_EXISTS_CODE,
                    $messages['material_status_id.required'] => MATERIL_STATUS_ID_REQUIRED_CODE,
                    $messages['material_status_id.exists']   => MATERIL_STATUS_ID_EXISTS_CODE,
                    $messages['work_type_id.required']       => WORK_TYPE_ID_REQUIRED_CODE,
                    $messages['work_type_id.exists']         => WORK_TYPE_ID_EXISTS_CODE,
                    $messages['contract_type_id.required']   => CONTRACT_TYPE_ID_REQUIRED_CODE,
                    $messages['contract_type_id.exists']     => CONTRACT_TYPE_ID_EXISTS_CODE,
                    $messages['directory_id.nullable']       => DIRECTORY_ID_NULLABLE_CODE,
                    $messages['directory_id.exists']         => DIRECTORY_ID_EXISTS_CODE,
                    $messages['photo.file']                  => PHOTO_FILE_CODE,
                    $messages['is_directory.required']       => IS_DIRECTORY_REQUIRED_CODE,
                    $messages['is_directory.boolean']        => IS_DIRECTORY_BOOLEAN_CODE,

            ],
            self::ROUTE_UPDATE_PROFILE => [
                $messages['usrename.required']           => NAME_REQUIRED_CODE,
                $messages['usrename.unique']             => NAME_UNIQUE_CODE,
                $messages['usrename.regex']              => NAME_REGEX_CODE,
                $messages['email.required']              => EMAIL_REQUIRED_CODE,
                $messages['email.string']                => EMAIL_STRING_CODE,
                $messages['email.email']                 => EMAIL_EMAIL_CODE,
                $messages['email.max']                   => EMAIL_MAX_CODE,
                $messages['email.unique']                => EMAIL_UNIQUE_CODE,
                $messages['email.regex']                 => EMAIL_REGEX_CODE,
                $messages['name_ar.required']            => NAME_AR_CODE,
                $messages['name_en.required']            => NAME_EN_CODE,
                $messages['phone.required']              => PHONE_CODE,
                $messages['ID_code.required']            => ID_CODE_CODE,
                $messages['passport_code.required']      => PASSPORT_CODE_CODE,
                $messages['salary.required']             => SALARY_CODE,
                $messages['location_ar.required']        => LOCATION_AR_CODE,
                $messages['location_en.required']        => LOCATION_EN_CODE,
                $messages['date_of_brith.required']      => DATE_OF_BRITH_REQUIRED_CODE,
                $messages['date_of_brith.date']          => DATE_OF_BRITH_DATE_CODE,
                $messages['join_date.required']          => JOIN_DATE_REQUIRED_CODE,
                $messages['join_date.date']              => JOIN_DATE_DATE_CODE,
                $messages['country_id.required']         => COUNTRY_ID_REQUIRED_CODE,
                $messages['country_id.exists']           => COUNTRY_ID_EXISTS_CODE,
                $messages['gender_id.required']          => GENDER_ID_REQUIRED_CODE,
                $messages['gender_id.exists']            => GENDER_ID_EXISTS_CODE,
                $messages['reigon_id.required']          => REIGON_ID_REQUIRED_CODE,
                $messages['reigon_id.exists']            => REIGON_ID_EXISTS_CODE,
                $messages['material_status_id.required'] => MATERIL_STATUS_ID_REQUIRED_CODE,
                $messages['material_status_id.exists']   => MATERIL_STATUS_ID_EXISTS_CODE,
                $messages['work_type_id.required']       => WORK_TYPE_ID_REQUIRED_CODE,
                $messages['work_type_id.exists']         => WORK_TYPE_ID_EXISTS_CODE,
                $messages['contract_type_id.required']   => CONTRACT_TYPE_ID_REQUIRED_CODE,
                $messages['contract_type_id.exists']     => CONTRACT_TYPE_ID_EXISTS_CODE,
                $messages['directory_id.nullable']       => DIRECTORY_ID_NULLABLE_CODE,
                $messages['directory_id.exists']         => DIRECTORY_ID_EXISTS_CODE,
                $messages['photo.file']                  => PHOTO_FILE_CODE,
                $messages['is_directory.required']       => IS_DIRECTORY_REQUIRED_CODE,
                $messages['is_directory.boolean']        => IS_DIRECTORY_BOOLEAN_CODE,
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
                        $messages['facebook_id']      => FACEBOOK_FAILED_CODE,
            ],
            self::ROUTE_LOGIN_BY_APPLE   => [
                        $messages['apple_id']         => APPLE_ID_FAILED_CODE,
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
