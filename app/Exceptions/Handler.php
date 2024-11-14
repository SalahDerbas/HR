<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     * @author Salah Derbas
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof AuthenticationException)
        return respondUnauthorized('Unauthorized');
        if($exception instanceof ThrottleRequestsException)
            return respondTooManyRequest('Too Many Requests');
        if ($exception instanceof UnauthorizedHttpException)
            return respondUnauthorized('Unauthorized');
        if ($exception instanceof RouteNotFoundException)
            return respondNotFound('Not Found');
        if ($exception instanceof MethodNotAllowedHttpException)
            return respondMethodAllowed('Method Not Allowed');
        if ($exception instanceof NotFoundHttpException)
            return respondNotFound('Not Found');
        if ($exception instanceof ModelNotFoundException){
            $resp = str_replace('App\\Models\\', '', $exception->getModel());
            return respondModelNotFound('Model {$resp} Not found' );
        }
        return parent::render($request, $exception);
    }
}
