<?php

namespace App\Http\Response;

use Symfony\Component\HttpFoundation\Response;


class ApiResponse
{

    /**
     * Returns a JSON response with the given data and status code.
     *
     * @param mixed $data The data to be included in the response.
     * @param int $statusCode The HTTP status code for the response. Default is 200 (OK).
     * @return \Illuminate\Http\JsonResponse The JSON response.
     * @author Salah Derbas
     */
    public function responseGlobal($data , $statusCode = Response::HTTP_OK)
    {
        return response()->json($data, $statusCode);
    }

    /**
     * Returns a successful response with the given data and optional message and response code.
     *
     * @param mixed $data The data to be included in the response.
     * @param string $responseMessage Optional message for the response.
     * @param mixed $responseCode Optional custom response code.
     * @return \Illuminate\Http\JsonResponse The successful JSON response.
     * @author Salah Derbas
     */
    public  function responseSuccess($data , $responseMessage = '' , $responseCode = null )
    {
        return responseGlobal([
            'success'             => true  ,
            'responseMessage'     => $responseMessage  ,
            'responseCode'        => $responseCode  ,
            'data'                => $data  ,
        ], Response::HTTP_OK);
    }

    /**
     * Returns an error response with a message and status code.
     *
     * @param string $message The error message.
     * @param int $statusCode The HTTP status code for the error response.
     * @param mixed $code Optional custom error code.
     * @return \Illuminate\Http\JsonResponse The error JSON response.
     * @author Salah Derbas
     */
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

    /**
     * Returns a validation error response with a message, status code, and validation errors.
     *
     * @param string $message The error message.
     * @param int $statusCode The HTTP status code for the error response.
     * @param mixed $code Optional custom error code.
     * @param array $errors The validation errors to include in the response.
     * @return \Illuminate\Http\JsonResponse The validation error JSON response.
     * @author Salah Derbas
     */
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

    /**
     * Returns an unauthorized error response.
     *
     * @param string $message Optional message for the unauthorized error.
     * @return \Illuminate\Http\JsonResponse The unauthorized error JSON response.
     * @author Salah Derbas
     */
    public function respondUnauthorized($message = 'Unauthorized' )
    {
        return responseError($message, Response::HTTP_UNAUTHORIZED , Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Returns a forbidden error response.
     *
     * @param string $message Optional message for the forbidden error.
     * @return \Illuminate\Http\JsonResponse The forbidden error JSON response.
     * @author Salah Derbas
     */
    public function respondForbidden($message = 'Forbidden' )
    {
        return responseError($message, Response::HTTP_FORBIDDEN , Response::HTTP_FORBIDDEN);
    }

    /**
     * Returns a not found error response.
     *
     * @param string $message Optional message for the not found error.
     * @return \Illuminate\Http\JsonResponse The not found error JSON response.
     * @author Salah Derbas
     */
    public function respondNotFound($message = 'Not Found' )
    {
        return responseError($message, Response::HTTP_NOT_FOUND , Response::HTTP_NOT_FOUND);
    }

    /**
     * Returns an internal server error response.
     *
     * @param string $message Optional message for the internal server error.
     * @return \Illuminate\Http\JsonResponse The internal server error JSON response.
     * @author Salah Derbas
     */
    public function respondInternalError($message = 'Internal Server Error' )
    {
        return responseError($message, Response::HTTP_INTERNAL_SERVER_ERROR , Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * Returns an unprocessable entity error response.
     *
     * @param string $message Optional message for the unprocessable entity error.
     * @return \Illuminate\Http\JsonResponse The unprocessable entity error JSON response.
     * @author Salah Derbas
     */
    public function respondUnprocessableEntity($message = 'Unprocessable Entity' )
    {
        return responseError($message, Response::HTTP_UNPROCESSABLE_ENTITY , Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Returns a method not allowed error response.
     *
     * @param string $message Optional message for the method not allowed error.
     * @return \Illuminate\Http\JsonResponse The method not allowed error JSON response.
     * @author Salah Derbas
     */
    public function respondMethodAllowed($message = 'Method Not Allowed')
    {
        return responseError($message, Response::HTTP_METHOD_NOT_ALLOWED , Response::HTTP_METHOD_NOT_ALLOWED );
    }

    /**
     * Returns a model not found error response.
     *
     * @param string $message The message for the model not found error.
     * @return \Illuminate\Http\JsonResponse The model not found error JSON response.
     * @author Salah Derbas
     */
    public function respondModelNotFound($message = 'Model {$resp} Not found')
    {
        return responseError($message, Response::HTTP_NOT_FOUND , MODEL_NOT_FOUND_CODE );
    }

    /**
     * Returns a validation failed response with validation errors.
     *
     * @param string $message The message for the validation failure.
     * @param array $validate_errors The validation errors.
     * @param mixed $codes The validation error codes.
     * @return \Illuminate\Http\JsonResponse The validation failed response.
     * @author Salah Derbas
     */
    public function respondValidationFailed($message = 'Validation failed' , $validate_errors , $codes)
    {
        return responseValidator($message, Response::HTTP_UNPROCESSABLE_ENTITY , $codes , $validate_errors);
    }

    /**
     * Returns an error response for an invalid private key.
     *
     * @param string $message Optional message for the invalid private key error.
     * @return \Illuminate\Http\JsonResponse The private key error JSON response.
     * @author Salah Derbas
     */
    public function respondPrivateKey($message = 'Sweet Key invalid')
    {
        return responseError($message, Response::HTTP_NOT_FOUND , PRIVATE_KEY_CODE );
    }

    /**
     * Returns a response indicating that no content was found.
     *
     * @param string $message The message for the empty response.
     * @param mixed $code The response code.
     * @return \Illuminate\Http\JsonResponse The empty response.
     * @author Salah Derbas
     */
    public function respondEmpty($message = 'Not Found' , $code)
    {
        return responseError($message, Response::HTTP_OK , $code);
    }

    /**
     * Returns a response indicating too many requests.
     *
     * @param string $message Optional message for the too many requests error.
     * @return \Illuminate\Http\JsonResponse The too many requests error JSON response.
     * @author Salah Derbas
     */
    public function respondTooManyRequest($message = 'Too Many Requests')
    {
        return responseError($message, Response::HTTP_TOO_MANY_REQUESTS , Response::HTTP_TOO_MANY_REQUESTS );

    }
}
