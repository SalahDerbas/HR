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
            APPLE_ID_FAILED_CODE                  => trans('api_response.APPLE_ID_FAILED_CODE'),
            RESET_NEW_PASSWOED_CODE               => trans('api_response.RESET_NEW_PASSWOED_CODE'),
            GET_PROFILE_CODE                      => trans('api_response.GET_PROFILE_CODE'),
            REFRESH_TOKEN_CODE                    => trans('api_response.REFRESH_TOKEN_CODE'),
            USER_LOGOUT_CODE                      => trans('api_response.USER_LOGOUT_CODE'),
            NAME_AR_CODE                          => trans('api_response.NAME_AR_CODE'),
            NAME_EN_CODE                          => trans('api_response.NAME_EN_CODE'),
            PHONE_CODE                            => trans('api_response.PHONE_CODE'),
            ID_CODE_CODE                          => trans('api_response.ID_CODE_CODE'),
            PASSPORT_CODE_CODE                    => trans('api_response.PASSPORT_CODE_CODE'),
            SALARY_CODE                           => trans('api_response.SALARY_CODE'),
            LOCATION_AR_CODE                      => trans('api_response.LOCATION_AR_CODE'),
            LOCATION_EN_CODE                      => trans('api_response.LOCATION_EN_CODE'),
            DATE_OF_BRITH_REQUIRED_CODE           => trans('api_response.DATE_OF_BRITH_REQUIRED_CODE'),
            DATE_OF_BRITH_DATE_CODE               => trans('api_response.DATE_OF_BRITH_DATE_CODE'),
            JOIN_DATE_REQUIRED_CODE               => trans('api_response.JOIN_DATE_REQUIRED_CODE'),
            JOIN_DATE_DATE_CODE                   => trans('api_response.JOIN_DATE_DATE_CODE'),
            COUNTRY_ID_REQUIRED_CODE              => trans('api_response.COUNTRY_ID_REQUIRED_CODE'),
            COUNTRY_ID_EXISTS_CODE                => trans('api_response.COUNTRY_ID_EXISTS_CODE'),
            GENDER_ID_REQUIRED_CODE               => trans('api_response.GENDER_ID_REQUIRED_CODE'),
            GENDER_ID_EXISTS_CODE                 => trans('api_response.GENDER_ID_EXISTS_CODE'),
            REIGON_ID_REQUIRED_CODE               => trans('api_response.REIGON_ID_REQUIRED_CODE'),
            REIGON_ID_EXISTS_CODE                 => trans('api_response.REIGON_ID_EXISTS_CODE'),
            MATERIL_STATUS_ID_REQUIRED_CODE       => trans('api_response.MATERIL_STATUS_ID_REQUIRED_CODE'),
            MATERIL_STATUS_ID_EXISTS_CODE         => trans('api_response.MATERIL_STATUS_ID_EXISTS_CODE'),
            WORK_TYPE_ID_REQUIRED_CODE            => trans('api_response.WORK_TYPE_ID_REQUIRED_CODE'),
            WORK_TYPE_ID_EXISTS_CODE              => trans('api_response.WORK_TYPE_ID_EXISTS_CODE'),
            CONTRACT_TYPE_ID_REQUIRED_CODE        => trans('api_response.CONTRACT_TYPE_ID_REQUIRED_CODE'),
            CONTRACT_TYPE_ID_EXISTS_CODE          => trans('api_response.CONTRACT_TYPE_ID_EXISTS_CODE'),
            DIRECTORY_ID_NULLABLE_CODE            => trans('api_response.DIRECTORY_ID_NULLABLE_CODE'),
            DIRECTORY_ID_EXISTS_CODE              => trans('api_response.DIRECTORY_ID_EXISTS_CODE'),
            PHOTO_FILE_CODE                       => trans('api_response.PHOTO_FILE_CODE'),
            IS_DIRECTORY_REQUIRED_CODE            => trans('api_response.IS_DIRECTORY_REQUIRED_CODE'),
            IS_DIRECTORY_BOOLEAN_CODE             => trans('api_response.IS_DIRECTORY_BOOLEAN_CODE'),
            STORE_USER_SUCCESS_CODE               => trans('api_response.STORE_USER_SUCCESS_CODE'),
            UPDATE_PROFILE_SUCCESS_CODE           => trans('api_response.UPDATE_PROFILE_SUCCESS_CODE'),
            DATA_ERROR_CODE                       => trans('api_response.DATA_ERROR_CODE'),
            DELETE_ACCONT_CODE                    => trans('api_response.DELETE_ACCONT_CODE'),
            LIST_USERS_SUCCESS_CODE               => trans('api_response.LIST_USERS_SUCCESS_CODE'),
            VACATION_EMPTY_CODE                   => trans('api_response.VACATION_EMPTY_CODE'),
            VACATIONS_SUCCESS_CODE                => trans('api_response.VACATIONS_SUCCESS_CODE'),
            START_DATE_REQUIRED_CODE              => trans('api_response.START_DATE_REQUIRED_CODE'),
            START_DATE_DATE_CODE                  => trans('api_response.START_DATE_DATE_CODE'),
            END_DATE_REQUIRED_CODE                => trans('api_response.END_DATE_REQUIRED_CODE'),
            END_DATE_DATE_CODE                    => trans('api_response.END_DATE_DATE_CODE'),
            REASON_REQUIRED_CODE                  => trans('api_response.REASON_REQUIRED_CODE'),
            TYPE_VACATION_ID_REQUIRED_CODE        => trans('api_response.TYPE_VACATION_ID_REQUIRED_CODE'),
            TYPE_VACATION_ID_EXISTS_CODE          => trans('api_response.TYPE_VACATION_ID_EXISTS_CODE'),
            DOCUMENT_REQUIRED_CODE                => trans('api_response.DOCUMENT_REQUIRED_CODE'),
            DOCUMENT_FILE_CODE                    => trans('api_response.DOCUMENT_FILE_CODE'),
            STORE_VACATION_SUCCESS_CODE           => trans('api_response.STORE_VACATION_SUCCESS_CODE'),
            UPDATE_VACATION_SUCCESS_CODE          => trans('api_response.UPDATE_VACATION_SUCCESS_CODE'),
            DELETE_VACATION_CODE                  => trans('api_response.DELETE_VACATION_CODE'),
            MISSING_PUNCH_EMPTY_CODE              => trans('api_response.MISSING_PUNCH_EMPTY_CODE'),
            MISSING_PUNCHS_SUCCESS_CODE           => trans('api_response.MISSING_PUNCHS_SUCCESS_CODE'),
            DATE_REQUIRED_CODE                    => trans('api_response.DATE_REQUIRED_CODE'),
            DATE_DATE_CODE                        => trans('api_response.DATE_DATE_CODE'),
            TYPE_MISSINGPUNCH_ID_REQUIRED_CODE    => trans('api_response.TYPE_MISSINGPUNCH_ID_REQUIRED_CODE'),
            TYPE_MISSINGPUNCH_ID_EXISTS_CODE      => trans('api_response.TYPE_MISSINGPUNCH_ID_EXISTS_CODE'),
            TIME_REQUIRED_CODE                    => trans('api_response.TIME_REQUIRED_CODE'),
            STORE_MISSING_PUNCH_SUCCESS_CODE      => trans('api_response.STORE_MISSING_PUNCH_SUCCESS_CODE'),
            UPDATE_MISSING_PUNCH_SUCCESS_CODE     => trans('api_response.UPDATE_MISSING_PUNCH_SUCCESS_CODE'),
            DELETE_MISSING_PUNCH_CODE             => trans('api_response.DELETE_MISSING_PUNCH_CODE'),
            LEAVE_EMPTY_CODE                      => trans('api_response.LEAVE_EMPTY_CODE'),
            LEAVES_SUCCESS_CODE                   => trans('api_response.LEAVES_SUCCESS_CODE'),
            START_TIME_REQUIRED_CODE              => trans('api_response.START_TIME_REQUIRED_CODE'),
            END_TIME_REQUIRED_CODE                => trans('api_response.END_TIME_REQUIRED_CODE'),
            TYPE_REASON_LEAVE_ID_REQUIRED_CODE    => trans('api_response.TYPE_REASON_LEAVE_ID_REQUIRED_CODE'),
            TYPE_REASON_LEAVE_ID_EXISTS_CODE      => trans('api_response.TYPE_REASON_LEAVE_ID_EXISTS_CODE'),
            STORE_LEAVE_SUCCESS_CODE              => trans('api_response.STORE_LEAVE_SUCCESS_CODE'),
            UPDATE_LEAVE_SUCCESS_CODE             => trans('api_response.UPDATE_LEAVE_SUCCESS_CODE'),
            DELETE_LEAVE_CODE                     => trans('api_response.DELETE_LEAVE_CODE'),
            EXPERINCE_EMPTY_CODE                  => trans('api_response.EXPERINCE_EMPTY_CODE'),
            EXPERINCES_SUCCESS_CODE               => trans('api_response.EXPERINCES_SUCCESS_CODE'),
            STORE_EXPERINCE_SUCCESS_CODE          => trans('api_response.STORE_EXPERINCE_SUCCESS_CODE'),
            COMPANY_NAME_REQUIRED_CODE            => trans('api_response.COMPANY_NAME_REQUIRED_CODE'),
            COMPANY_PHONE_REQUIRED_CODE           => trans('api_response.COMPANY_PHONE_REQUIRED_CODE'),
            COMPANY_LOCATION_REQUIRED_CODE        => trans('api_response.COMPANY_LOCATION_REQUIRED_CODE'),
            LEAVE_REASON_REQUIRED_CODE            => trans('api_response.LEAVE_REASON_REQUIRED_CODE'),
            NOTE_REQUIRED_CODE                    => trans('api_response.NOTE_REQUIRED_CODE'),
            UPDATE_EXPERINCE_SUCCESS_CODE         => trans('api_response.UPDATE_EXPERINCE_SUCCESS_CODE'),
            DELETE_EXPERINCE_CODE                 => trans('api_response.DELETE_EXPERINCE_CODE'),
            EVENT_EMPTY_CODE                      => trans('api_response.EVENT_EMPTY_CODE'),
            EVENTS_SUCCESS_CODE                   => trans('api_response.EVENTS_SUCCESS_CODE'),
            STORE_EVENT_SUCCESS_CODE              => trans('api_response.STORE_EVENT_SUCCESS_CODE'),
            UPDATE_EVENT_SUCCESS_CODE             => trans('api_response.UPDATE_EVENT_SUCCESS_CODE'),
            DELETE_EVENT_CODE                     => trans('api_response.DELETE_EVENT_CODE'),
            DOCUMENT_EMPTY_CODE                   => trans('api_response.DOCUMENT_EMPTY_CODE'),
            DOCUMENTS_SUCCESS_CODE                => trans('api_response.DOCUMENTS_SUCCESS_CODE'),
            STORE_DOCUMENT_SUCCESS_CODE           => trans('api_response.STORE_DOCUMENT_SUCCESS_CODE'),
            UPDATE_DOCUMENT_SUCCESS_CODE          => trans('api_response.UPDATE_DOCUMENT_SUCCESS_CODE'),
            DELETE_DOCUMENT_CODE                  => trans('api_response.DELETE_DOCUMENT_CODE'),
            TYPE_DOCUMENT_ID_REQUIRED_CODE        => trans('api_response.TYPE_DOCUMENT_ID_REQUIRED_CODE'),
            TYPE_DOCUMENT_ID_EXISTS_CODE          => trans('api_response.TYPE_DOCUMENT_ID_EXISTS_CODE'),
            DEPATMENT_EMPTY_CODE                  => trans('api_response.DEPATMENT_EMPTY_CODE'),
            DEPATMENTS_SUCCESS_CODE               => trans('api_response.DEPATMENTS_SUCCESS_CODE'),
            STORE_DEPATMENT_SUCCESS_CODE          => trans('api_response.STORE_DEPATMENT_SUCCESS_CODE'),
            UPDATE_DEPATMENT_SUCCESS_CODE         => trans('api_response.UPDATE_DEPATMENT_SUCCESS_CODE'),
            DELETE_DEPATMENT_CODE                 => trans('api_response.DELETE_DEPATMENT_CODE'),
            CERTIFIATE_EMPTY_CODE                 => trans('api_response.CERTIFIATE_EMPTY_CODE'),
            CERTIFIATES_SUCCESS_CODE              => trans('api_response.CERTIFIATES_SUCCESS_CODE'),
            STORE_CERTIFIATE_SUCCESS_CODE         => trans('api_response.STORE_CERTIFIATE_SUCCESS_CODE'),
            UPDATE_CERTIFIATE_SUCCESS_CODE        => trans('api_response.UPDATE_CERTIFIATE_SUCCESS_CODE'),
            DELETE_CERTIFIATE_CODE                => trans('api_response.DELETE_CERTIFIATE_CODE'),
            ATTENDANCE_EMPTY_CODE                 => trans('api_response.ATTENDANCE_EMPTY_CODE'),
            ATTENDANCES_SUCCESS_CODE              => trans('api_response.ATTENDANCES_SUCCESS_CODE'),
            STORE_ATTENDANCE_SUCCESS_CODE         => trans('api_response.STORE_ATTENDANCE_SUCCESS_CODE'),
            UPDATE_ATTENDANCE_SUCCESS_CODE        => trans('api_response.UPDATE_ATTENDANCE_SUCCESS_CODE'),
            DELETE_ATTENDANCE_CODE                => trans('api_response.DELETE_ATTENDANCE_CODE'),
            STATUS_ATTENDANCE_ID_REQUIRED_CODE    => trans('api_response.STATUS_ATTENDANCE_ID_REQUIRED_CODE'),
            STATUS_ATTENDANCE_ID_EXISTS_CODE      => trans('api_response.STATUS_ATTENDANCE_ID_EXISTS_CODE'),
            ASSET_EMPTY_CODE                      => trans('api_response.ASSET_EMPTY_CODE'),
            ASSETS_SUCCESS_CODE                   => trans('api_response.ASSETS_SUCCESS_CODE'),
            STORE_ASSET_SUCCESS_CODE              => trans('api_response.STORE_ASSET_SUCCESS_CODE'),
            UPDATE_ASSET_SUCCESS_CODE             => trans('api_response.UPDATE_ASSET_SUCCESS_CODE'),
            DELETE_ASSET_CODE                     => trans('api_response.DELETE_ASSET_CODE'),
            AMOUNT_REQUIRED_CODE                  => trans('api_response.AMOUNT_REQUIRED_CODE'),
            TYPE_ASSET_ID_EXISTS_CODE             => trans('api_response.TYPE_ASSET_ID_EXISTS_CODE'),
            TYPE_ASSET_ID_REQUIRED_CODE           => trans('api_response.TYPE_ASSET_ID_REQUIRED_CODE'),
            























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
