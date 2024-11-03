<?php

namespace App\Http\Controllers\API\Message;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\API\Message\MessageResource;

use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    /**
     * Get List of Message & code (API's)
     *
     * This function handles List of Message & code (API's).
     *
     * @return \Illuminate\Http\JsonResponse Returns a JSON response.
     * @result string "Array of Messages and Codes for End Points "
     * @throws \Exception
     * @author Salah Derbas
     */
    public function index()
    {
        try{
            $messages  = getStatusText(ALL_MESSAGE_CODE);
            $data      = array_map(fn($message, $code) => ['code' => $code, 'message' => $message], $messages, array_keys($messages));

            return responseSuccess(MessageResource::collection($data), getStatusText(MESSAGE_CODE_SUCCESS_CODE), MESSAGE_CODE_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Get Single of Message & code (API)
     *
     * This function handles Message & code (API).
     *
     * @return \Illuminate\Http\JsonResponse Returns a JSON response.
     * @result string "Message and Code for Single End Point "
     * @param string $code The code for response.
     * @throws \Exception
     * @author Salah Derbas
     */
    public function show($code)
    {
        try{
            $message = getStatusText($code);
            if ($message == MESSAGE_NOT_FOUND_CODE)
                return respondNotFound(getStatusText(MESSAGE_CODE_ERROR_CODE), Response::HTTP_NOT_FOUND, MESSAGE_CODE_ERROR_CODE);

            return responseSuccess(new MessageResource(['code' => $code, 'message' => $message]), getStatusText(MESSAGE_CODE_SUCCESS_CODE), MESSAGE_CODE_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }

    }
}
