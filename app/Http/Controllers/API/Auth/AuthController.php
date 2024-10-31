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

        User::where(['email'  => $request->email])->update(['fcm_token' => $request->fcm_token , 'last_login' => Carbon::now()  ]);
        return $this->sendOTPEmail($request->email , rand(10000 , 99999));
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
     * Validate the OTP (One-Time Password) for a user based on the provided email and OTP code.
     * If the OTP is valid and has not expired, the user is authenticated and logged in.
     *
     * @param AuthRequest $request The incoming request containing the user's email and OTP.
     * @return \Illuminate\Http\JsonResponse The response indicating the success or failure of the OTP validation.
     */
    public function checkOtp(AuthRequest $request)
    {
        $user     = User::where(['email'=> $request->email , 'code_auth' => $request->otp ])->first();
        if(is_null($user))
            return responseError(getStatusText(OTP_INVALID_CODE), Response::HTTP_UNPROCESSABLE_ENTITY ,OTP_INVALID_CODE);

        if (Carbon::now()->isAfter($user->expire_time))
            return responseError(getStatusText(EXPIRE_TIME_INVALID_CODE), Response::HTTP_UNPROCESSABLE_ENTITY ,EXPIRE_TIME_INVALID_CODE);

        return $this->successAuth($user);
    }

    /**
     * Log in the user after successful OTP validation and retrieve the user's details with relations.
     *
     * @param User $user The authenticated user object.
     * @return \Illuminate\Http\JsonResponse The response containing the user's information and success status.
     */
    private function successAuth($user)
    {
        Auth::login($user);
        return responseSuccess( new UserResource($user) , getStatusText(CHECK_OTP_SUCCESS_CODE)  , CHECK_OTP_SUCCESS_CODE );
    }

    /**
     * Resend a One-Time Password (OTP) to the user's email address.
     * A random OTP is generated and sent via email to the provided email address.
     *
     * @param AuthRequest $request The incoming request containing the user's email.
     * @return mixed The result of the OTP email sending process.
     */
    public function resendOtp(AuthRequest $request)
    {
        return $this->sendOTPEmail($request->email , rand(10000 , 99999));
    }

    /**
     * Authenticate a user using their Google account.
     * Retrieves the user by their Google ID and logs them in.
     *
     * @param AuthRequest $request The incoming request containing the Google ID.
     * @return \Illuminate\Http\JsonResponse The response indicating the success of the login process.
     */
    public function loginByGoogle(AuthRequest $request)
    {
        $user = User::where(['google_id' => $request->google_id])->first();
        Auth::login($user);
        return responseSuccess( new UserResource($user) , getStatusText(LOGIN_SUCCESS_CODE)  , LOGIN_SUCCESS_CODE );
    }

    /**
     * Authenticate a user using their Facebook account.
     * Retrieves the user by their Facebook ID and logs them in.
     *
     * @param AuthRequest $request The incoming request containing the Facebook ID.
     * @return \Illuminate\Http\JsonResponse The response indicating the success of the login process.
     */
    public function loginByFacebook(AuthRequest $request)
    {
        $user = User::where( 'facebook_id', $request->facebook_id)->first();
        Auth::login($user);
        return responseSuccess( new UserResource( $user ) , getStatusText(LOGIN_SUCCESS_CODE)  , LOGIN_SUCCESS_CODE );
    }

    public function loginByApple(AuthRequest $request)
    {
        return 121212;
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


}
