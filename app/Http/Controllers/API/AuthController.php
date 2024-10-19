<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;

use App\Http\Requests\API\AuthRequest;

use App\Http\Resources\API\UserResource;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * Login to the application.
     *
     * This function handles the login process for the user.
     *
     * @param string $email The email address of the user.
     * @param string $password The password provided by the user.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response containing the authentication token on success.
     * @result string "login to application"
     * @throws \Exception
     * @author Salah Derbas
     */
    public function login(AuthRequest $request)
    {
        if (!Auth::attempt(['email'  => $request->email  ,'password'=>$request->password]))
            return responseError(getStatusText(INCCORECT_DATA_ERROR_CODE), Response::HTTP_UNPROCESSABLE_ENTITY ,INCCORECT_DATA_ERROR_CODE);

        $user = User::where(['email'  => $request->email])->first();
        if(is_null($user->email_verified_at))
            return $this->resendEmail($request->email);

        User::where(['email'  => $request->email])->update(['fcm_id' => $request->fcm_id , 'last_login' => Carbon::now()  ]);
        return responseSuccess( new UserResource(auth()->user()) , getStatusText(LOGIN_SUCCESS_CODE)  , LOGIN_SUCCESS_CODE );
    }



}
