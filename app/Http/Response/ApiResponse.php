<?php

namespace App\Http\Response;

use Symfony\Component\HttpFoundation\Response;


class ApiResponse
{


    // =================================================================================================
    //  Start ALL Function for Response Customize

    public function responseGlobal($data , $statusCode = Response::HTTP_OK)
    {
        return response()->json($data, $statusCode);
    }

    public  function responseSuccess($data , $responseMessage = '' , $responseCode = null )
    {
        return responseGlobal([
            'success'             => true  ,
            'responseMessage'     => $responseMessage  ,
            'responseCode'        => $responseCode  ,
            'data'                => $data  ,
        ], Response::HTTP_OK);
    }

    public function responseError($message, $statusCode , $code = null )
    {
        return responseGlobal([
            'success' => false,
            'error'   => [
                    'message'           => $message,
                    'errorCode'         => $code,
            ]
        ], $statusCode);
    }

    public function responseValidator($message , $statusCode  , $code = null , $errors)
    {
        return responseGlobal([
            'success' => false,
            'error'   => [
                    'message'         => $message,
                    'errorCode'       => $code,
            ] ,
            'validator' => $errors
        ], $statusCode);

    }

    public function respondUnauthorized($message = 'Unauthorized' )
    {
        return responseError($message, Response::HTTP_UNAUTHORIZED , Response::HTTP_UNAUTHORIZED);
    }

    public function respondForbidden($message = 'Forbidden' )
    {
        return responseError($message, Response::HTTP_FORBIDDEN , Response::HTTP_FORBIDDEN);
    }

    public function respondNotFound($message = 'Not Found' )
    {
        return responseError($message, Response::HTTP_NOT_FOUND , Response::HTTP_NOT_FOUND);
    }

    public function respondInternalError($message = 'Internal Server Error' )
    {
        return responseError($message, Response::HTTP_INTERNAL_SERVER_ERROR , Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function respondUnprocessableEntity($message = 'Unprocessable Entity' )
    {
        return responseError($message, Response::HTTP_UNPROCESSABLE_ENTITY , Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    // Exceptions
    public function respondMethodAllowed($message = 'Method Not Allowed')
    {
        return responseError($message, Response::HTTP_METHOD_NOT_ALLOWED , Response::HTTP_METHOD_NOT_ALLOWED );
    }

    public function respondModelNotFound($message = 'Model {$resp} Not found')
    {
        return responseError($message, Response::HTTP_NOT_FOUND , MODEL_NOT_FOUND_CODE );
    }
    public function respondValidationFailed($message = 'Validation failed' , $validate_errors , $codes)
    {
        return responseValidator($message, Response::HTTP_UNPROCESSABLE_ENTITY , $codes , $validate_errors);
    }

    public function respondPrivateKey($message = 'Sweet Key invalid')
    {
        return responseError($message, Response::HTTP_NOT_FOUND , PRIVATE_KEY_CODE );
    }

    public function respondEmpty($message = 'Not Found' , $code)
    {
        return responseError($message, Response::HTTP_OK , $code);
    }
    public function respondTooManyRequest($message = 'Too Many Requests')
    {
        return responseError($message, Response::HTTP_TOO_MANY_REQUESTS , Response::HTTP_TOO_MANY_REQUESTS );

    }
//  End ALL Function for Response Customize
// =================================================================================================

}
