<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use App\Http\Requests\API\Auth\AuthRequest;

use App\Http\Resources\API\User\UserResource;

use App\Models\User;

use App\Jobs\SendOTPEmailJob;


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

        // $user = getUserWithRelations($request->email);
            return $this->sendOTPEmail($request->email , rand(10000 , 99999));

        // User::where(['email'  => $request->email])->update(['fcm_token' => $request->fcm_token , 'last_login' => Carbon::now()  ]);
        // return responseSuccess( new UserResource($user) , getStatusText(LOGIN_SUCCESS_CODE)  , LOGIN_SUCCESS_CODE );
    }

    /**
     * Re-send email to the application.
     *
     * This function handles the Re-send email process for the user.
     *
     * @param string $email The email address of the user.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response containing the authentication token on success.
     * @result string "send OTP to email for user for verify"
     * @throws \Exception
     * @author Salah Derbas
     */
    private function sendOTPEmail($email , $otp)
    {
        SendOTPEmailJob::dispatch($email, $otp);
        User::where('email' , $email)->update(['code_auth' => $otp , 'expire_time' => Carbon::now()->addMinutes(3)]);

        return responseSuccess('', getStatusText(SEND_OTP_SUCCESS_CODE) ,SEND_OTP_SUCCESS_CODE);
    }

    /**
     * Register user to the application.
     *
     * This function handles the Register process for the user.
     *
     * @param string $email The email address of the user.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response containing the authentication token on success.
     * @result string "send OTP to email for user for verify"
     * @throws \Exception
     * @author Salah Derbas
     */
    public function register(AuthRequest $request)
    {

    }

    /**
     * Check the validity of the OTP (One-Time Password) provided by the user.
     *
     * This function verifies if the provided email and OTP match a user record
     * in the database and checks if the OTP has expired. If both conditions
     * are met, the user is logged in and their data is returned.
     *
     * @param AuthRequest $request The request containing email and OTP.
     * @return \Illuminate\Http\JsonResponse The response indicating success or failure.
     */
    public function checkOtp(AuthRequest $request)
    {
        $user     = User::where(['email'=> $request->email , 'code_auth' => $request->otp ])->first();
        if(is_null($user))
            return responseError(getStatusText(OTP_INVALID_CODE), Response::HTTP_UNPROCESSABLE_ENTITY ,OTP_INVALID_CODE);

        $validateDate    = Carbon::parse($user->expire_time);
        if (!$validateDate->isPast())
            return responseError(getStatusText(EXPIRE_TIME_INVALID_CODE), Response::HTTP_UNPROCESSABLE_ENTITY ,EXPIRE_TIME_INVALID_CODE);

        return $this->successOTP($user);
    }

    private function successOTP($user)
    {
        Auth::login($user);
        $user = getUserWithRelations($user->email);
        return responseSuccess( new UserResource($user) , getStatusText(CHECK_OTP_SUCCESS_CODE)  , CHECK_OTP_SUCCESS_CODE );

    }

}
