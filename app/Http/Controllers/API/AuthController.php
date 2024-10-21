<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;

use App\Http\Requests\API\AuthRequest;

use App\Http\Resources\API\Auth\UserResource;

use App\Models\User;

use App\Jobs\SendVerifyEmailJob;

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

        $user = User::where(['email'  => $request->email])->with([
                    'getCountry' , 'getGender' , 'getReigon' , 'getMaterialStatus' , 'getWorkType' , 'getContractType' , 'getStatusUser'
                ])->first();
        if(is_null($user->email_verified_at))
            return $this->resendEmail($request->email , rand(10000 , 99999));

        User::where(['email'  => $request->email])->update(['fcm_token' => $request->fcm_token , 'last_login' => Carbon::now()  ]);
        return responseSuccess( new UserResource($user) , getStatusText(LOGIN_SUCCESS_CODE)  , LOGIN_SUCCESS_CODE );
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
    private function resendEmail($email , $otp)
    {
        SendVerifyEmailJob::dispatch($email, $otp);// Dispatch the job to send verification email
        User::where('email' , $email)->update(['code_auth' => $otp]);

        return responseError(getStatusText(EMAIL_VERIFIED_AT), Response::HTTP_UNPROCESSABLE_ENTITY ,EMAIL_VERIFIED_AT);
    }


    public function register(AuthRequest $request)
    {
        $otp = rand(10000 , 99999);
        SendVerifyEmailJob::dispatch($request->email , $otp );
        User::insert([
                'name'          =>   $request->name ,
                'email'         =>   $request->email,
                'password'      =>   bcrypt($request->password),
                'code_auth'     =>   $otp                      ,
                'country'    =>   getCountry($request->ip())
        ]);

        return responseSuccess('' , getStatusText(REGISTER_SUCCESS_CODE)  , REGISTER_SUCCESS_CODE);

    }

}
