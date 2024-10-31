<?php


use App\Http\Response\ApiResponse;
use App\Models\User;
use App\Models\Lookup;
use Carbon\Carbon;






function getStatusText($responseCode){
    $statusTexts = [
            MODEL_NOT_FOUND_CODE                  => trans('api_response.MODEL_NOT_FOUND_CODE'),
            PRIVATE_KEY_CODE                      => trans('api_response.PRIVATE_KEY_CODE'),
            INCCORECT_DATA_ERROR_CODE             => trans('api_response.INCCORECT_DATA_ERROR_CODE'),
            LOGIN_SUCCESS_CODE                    => trans('api_response.LOGIN_SUCCESS_CODE'),
            MESSAGE_NOT_FOUND_CODE                => trans('api_response.MESSAGE_NOT_FOUND_CODE'),
            MESSAGE_CODE_ERROR_CODE               => trans('api_response.MESSAGE_CODE_ERROR_CODE'),
            MESSAGE_CODE_SUCCESS_CODE             => trans('api_response.MESSAGE_CODE_SUCCESS_CODE'),
            LOOKUPS_SUCCESS_CODE                  => trans('api_response.LOOKUPS_SUCCESS_CODE'),
            EMAIL_EXISTS_CODE                     => trans('api_response.EMAIL_EXISTS_CODE'),
            PASSWORD_REQUIRED_CODE                => trans('api_response.PASSWORD_REQUIRED_CODE'),
            USER_DELETED_CODE                     => trans('api_response.USER_DELETED_CODE'),
            NAME_REQUIRED_CODE                    => trans('api_response.NAME_REQUIRED_CODE'),
            NAME_UNIQUE_CODE                      => trans('api_response.NAME_UNIQUE_CODE'),
            NAME_REGEX_CODE                       => trans('api_response.NAME_REGEX_CODE'),
            EMAIL_REQUIRED_CODE                   => trans('api_response.EMAIL_REQUIRED_CODE'),
            EMAIL_STRING_CODE                     => trans('api_response.EMAIL_STRING_CODE'),
            EMAIL_EMAIL_CODE                      => trans('api_response.EMAIL_EMAIL_CODE'),
            EMAIL_MAX_CODE                        => trans('api_response.EMAIL_MAX_CODE'),
            EMAIL_UNIQUE_CODE                     => trans('api_response.EMAIL_UNIQUE_CODE'),
            EMAIL_REGEX_CODE                      => trans('api_response.EMAIL_REGEX_CODE'),
            PASSWORD_VALIDATION_CODE              => trans('api_response.PASSWORD_VALIDATION_CODE'),
            OTP_REQUIRED_CODE                     => trans('api_response.OTP_REQUIRED_CODE'),
            GOOGLE_FAILED_CODE                    => trans('api_response.GOOGLE_FAILED_CODE'),
            FACEBOOK_FAILED_CODE                  => trans('api_response.FACEBOOK_FAILED_CODE'),
            CONFIRM_PASSWORD_REQUIRED_WITH_CODE   => trans('api_response.CONFIRM_PASSWORD_REQUIRED_WITH_CODE'),
            CONFIRM_PASSWORD_SAME_CODE            => trans('api_response.CONFIRM_PASSWORD_SAME_CODE'),
            CONFIRM_PASSWORD_MIN_CODE             => trans('api_response.CONFIRM_PASSWORD_MIN_CODE'),
            EMAIL_VERIFIED_AT_CODE                => trans('api_response.EMAIL_VERIFIED_AT_CODE'),
            CONTENT_EMPTY_CODE                    => trans('api_response.CONTENT_EMPTY_CODE'),
            CONTENT_SUCCESS_CODE                  => trans('api_response.CONTENT_SUCCESS_CODE'),
            MESSAGE_REQUIRED_CODE                 => trans('api_response.MESSAGE_REQUIRED_CODE'),
            SUBJECT_REQUIRED_CODE                 => trans('api_response.SUBJECT_REQUIRED_CODE'),
            CONTACT_US_SUCCESS_CODE               => trans('api_response.CONTACT_US_SUCCESS_CODE'),
            NOTIFICATION_EMPTY_CODE               => trans('api_response.NOTIFICATION_EMPTY_CODE'),
            NOTIFICATIONS_SUCCESS_CODE            => trans('api_response.NOTIFICATIONS_SUCCESS_CODE'),
            USER_NOT_FOUND_CODE                   => trans('api_response.USER_NOT_FOUND_CODE'),
            ENABLED_NOTIFICATION_SUCCESS_CODE     => trans('api_response.ENABLED_NOTIFICATION_SUCCESS_CODE'),
            TITLE_EN_REQUIRED_CODE                => trans('api_response.=TITLE_EN_REQUIRED_CODE'),
            TITLE_AR_REQUIRED_CODE                => trans('api_response.TITLE_AR_REQUIRED_CODE'),
            BODY_EN_REQUIRED_CODE                 => trans('api_response.BODY_EN_REQUIRED_CODE'),
            BODY_AR_REQUIRED_CODE                 => trans('api_response.BODY_AR_REQUIRED_CODE'),
            USERS_STRING_CODE                     => trans('api_response.USERS_STRING_CODE'),
            SEND_NOTIFICATION_SUCCESS_CODE        => trans('api_response.SEND_NOTIFICATION_SUCCESS_CODE'),
            SEND_OTP_SUCCESS_CODE                 => trans('api_response.SEND_OTP_SUCCESS_CODE'),
            OTP_INVALID_CODE                      => trans('api_response.OTP_INVALID_CODE'),
            EXPIRE_TIME_INVALID_CODE              => trans('api_response.EXPIRE_TIME_INVALID_CODE'),
            CHECK_OTP_SUCCESS_CODE                => trans('api_response.CHECK_OTP_SUCCESS_CODE'),
            APPLE_ID_FAILED_CODE                  => trans('api_response.APPLE_ID_FAILED_CODE')












    ];

    return ($responseCode == ALL_MESSAGE_CODE) ? $statusTexts: $statusTexts[$responseCode] ?? MESSAGE_NOT_FOUND_CODE;

}


// // =================================================================================================
// //  Start ALL Function for Response Customize


if (!function_exists('responseGlobal')) {
    function responseGlobal($data , $statusCode){
        return (new ApiResponse())->responseGlobal($data , $statusCode);
    }
}

if (!function_exists('responseSuccess')) {
    function responseSuccess($data , $responseMessage, $responseCode){
        return (new ApiResponse())->responseSuccess($data , $responseMessage , $responseCode);
    }
}

if (!function_exists('responseError')) {
    function responseError($message, $statusCode , $code){
        return (new ApiResponse())->responseError($message, $statusCode , $code);
    }
}

if (!function_exists('responseValidator')) {
    function responseValidator($message, $statusCode , $code ,$validate_errors){
        return (new ApiResponse())->responseValidator($message, $statusCode , $code , $validate_errors);
    }
}

if (!function_exists('respondUnauthorized')) {
    function respondUnauthorized($message){
        return (new ApiResponse())->respondUnauthorized($message);
    }
}

if (!function_exists('respondForbidden')) {
    function respondForbidden($message){
        return (new ApiResponse())->respondForbidden($message);
    }
}

if (!function_exists('respondNotFound')) {
    function respondNotFound($message){
        return (new ApiResponse())->respondNotFound($message);
    }
}

if (!function_exists('respondInternalError')) {
    function respondInternalError($message){
        return (new ApiResponse())->respondInternalError($message);
    }
}

if (!function_exists('respondUnprocessableEntity')) {
    function respondUnprocessableEntity($message){
        return (new ApiResponse())->respondUnprocessableEntity($message);
    }
}

if (!function_exists('respondMethodAllowed')) {
    function respondMethodAllowed($message){
        return (new ApiResponse())->respondMethodAllowed($message);
    }
}

if (!function_exists('respondModelNotFound')) {
    function respondModelNotFound($message){
        return (new ApiResponse())->respondModelNotFound($message);
    }
}

if (!function_exists('respondValidationFailed')) {
    function respondValidationFailed($message , $validate_errors , $codes){
        return (new ApiResponse())->respondValidationFailed($message , $validate_errors ,$codes);
    }
}

if (!function_exists('respondPrivateKey')) {
    function respondPrivateKey ($message){
        return (new ApiResponse())->respondPrivateKey($message);
    }
}

if (!function_exists('respondEmpty')) {
    function respondEmpty ($message , $code)
    {
        return (new ApiResponse())->respondEmpty($message , $code);
    }
}

if (!function_exists('respondTooManyRequest')) {
    function respondTooManyRequest($message)
    {
        return (new ApiResponse())->respondTooManyRequest($message);
    }
}
//  End ALL Function for Response Customize
// =================================================================================================



if (!function_exists('UploadPhotoUser')) {
    function UploadPhotoUser($file , $type)
    {
        if($type == 'update')  {
            $file_name = time().$file->getClientOriginalName();
            $file->move('Profile/' , $file_name);
            $Image = env('APP_URL').'/Profile/'.$file_name;
            return $Image;
        }
        $file_name = time().$file->getClientOriginalName();
        $file->move('Profile/' , $file_name);
        $Image = env('APP_URL').'/Profile/'.$file_name;
        return $Image;
    }
}


if (!function_exists('getUserWithRelations')) {
    function getUserWithRelations($email)
    {
        return User::where(['email'  => $email])->with([
                    'getCountry' ,
                    'getGender' ,
                    'getReigon' ,
                    'getMaterialStatus' ,
                    'getWorkType' ,
                    'getContractType' ,
                    'getStatusUser'
        ])->first();
    }
}



if (!function_exists('getIDLookups')) {
    function getIDLookups($key)
    {
        return Lookup::where(['key' => $key ])->pluck('id')->first();
    }
}


if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        return (!is_null($date)) ? Carbon::parse($date)->format('Y-m-d') : NULL ;
    }
}
