<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\Auth\AuthRequest;
use App\Http\Resources\API\User\UserResource;
use App\Http\Resources\API\User\UsersResource;
use App\Models\User;
use App\Jobs\SendOTPEmailJob;
use Carbon\Carbon;


class AuthController extends Controller
{

    /**
     * Retrieve a list of all users.
     *
     * This function fetches all users from the database, wraps them in
     * a `UsersResource` collection, and returns them in a success response.
     * If an exception occurs during the process, an error response is returned.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author Salah Derbas
    */
    public function index()
    {
        try{
            $users = User::all();
            return responseSuccess( UsersResource::collection($users) , getStatusText(LIST_USERS_SUCCESS_CODE), LIST_USERS_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

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
     * @author Salah Derbas
    */
    public function login(AuthRequest $request)
    {
        try{
            if (!Auth::attempt(['email'  => $request->email  ,'password'=>$request->password]))
                return responseError(getStatusText(INCCORECT_DATA_ERROR_CODE), Response::HTTP_UNPROCESSABLE_ENTITY ,INCCORECT_DATA_ERROR_CODE);

            User::where(['email'  => $request->email])->update(['fcm_token' => $request->fcm_token , 'last_login' => Carbon::now()  ]);
            return $this->sendOTPEmail($request->email , rand(10000 , 99999));
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Validate the OTP (One-Time Password) for a user based on the provided email and OTP code.
     * If the OTP is valid and has not expired, the user is authenticated and logged in.
     *
     * @param AuthRequest $request The incoming request containing the user's email and OTP.
     * @return \Illuminate\Http\JsonResponse The response indicating the success or failure of the OTP validation.
     * @author Salah Derbas
    */
    public function checkOtp(AuthRequest $request)
    {
        try{
            $user     = User::where(['email'=> $request->email , 'code_auth' => $request->otp ])->first();
            if(is_null($user))
                return responseError(getStatusText(OTP_INVALID_CODE), Response::HTTP_UNPROCESSABLE_ENTITY ,OTP_INVALID_CODE);

            if (Carbon::now()->isAfter($user->expire_time))
                return responseError(getStatusText(EXPIRE_TIME_INVALID_CODE), Response::HTTP_UNPROCESSABLE_ENTITY ,EXPIRE_TIME_INVALID_CODE);

            return $this->successAuth($user);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }

    }

    /**
     * Resend a One-Time Password (OTP) to the user's email address.
     * A random OTP is generated and sent via email to the provided email address.
     *
     * @param AuthRequest $request The incoming request containing the user's email.
     * @return mixed The result of the OTP email sending process.
     * @author Salah Derbas
    */
    public function resendOtp(AuthRequest $request)
    {
        try{
            return $this->sendOTPEmail($request->email , rand(10000 , 99999));
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Authenticate a user using their Google account.
     * Retrieves the user by their Google ID and logs them in.
     *
     * @param AuthRequest $request The incoming request containing the Google ID.
     * @return \Illuminate\Http\JsonResponse The response indicating the success of the login process.
     * @author Salah Derbas
    */
    public function loginByGoogle(AuthRequest $request)
    {
        try{
            $user = User::where(['google_id' => $request->google_id])->first();
            return $this->successAuth($user);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Authenticate a user using their Facebook account.
     * Retrieves the user by their Facebook ID and logs them in.
     *
     * @param AuthRequest $request The incoming request containing the Facebook ID.
     * @return \Illuminate\Http\JsonResponse The response indicating the success of the login process.
     * @author Salah Derbas
    */
    public function loginByFacebook(AuthRequest $request)
    {
        try{
            $user = User::where(['facebook_id' => $request->facebook_id])->first();
            return $this->successAuth($user);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }

    }

    /**
     * Handle login via Apple ID.
     *
     * Authenticate a user using their Apple account.
     * Retrieves the user by their Apple ID and logs them in.
     *
     * @param AuthRequest $request The request containing the Apple ID.
     * @return \Illuminate\Http\JsonResponse The success response with user data.
     * @author Salah Derbas
    */
    public function loginByApple(AuthRequest $request)
    {
        try{
            $user = User::where(['apple_id' => $request->apple_id])->first();
            return $this->successAuth($user);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Handle the "forgot password" process by sending an OTP email.
     *
     * This function generates a random 5-digit OTP and sends it to the
     * specified email address. It is used to initiate the password reset process.
     *
     * @param AuthRequest $request The request containing the user's email address.
     * @return \Illuminate\Http\JsonResponse The response after sending the OTP.
     * @author Salah Derbas
    */
    public function forgetPassword(AuthRequest $request)
    {
        try{
            return $this->sendOTPEmail($request->email , rand(10000 , 99999));
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Reset the user's password.
     *
     * This function locates the user by email and updates their password with a
     * newly provided password, securely hashing it before storage. It is typically
     * used after successful OTP verification during the password reset process.
     *
     * @param AuthRequest $request The request containing the user's email and new password.
     * @return \Illuminate\Http\JsonResponse A success response indicating password reset completion.
     * @author Salah Derbas
    */
    public function resetPassword(AuthRequest $request)
    {
        try{
            User::where(['email' => $request->email])->update(['password' => bcrypt($request->password)]);
            return responseSuccess('', getStatusText(RESET_NEW_PASSWOED_CODE), RESET_NEW_PASSWOED_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Retrieve the authenticated user's profile.
     *
     * This function retrieves the currently authenticated user's data and
     * returns it in a structured response. If an error occurs during retrieval,
     *
     * @return \Illuminate\Http\JsonResponse The success response with user profile data, or an error response if an exception occurs.
     * @author Salah Derbas
    */
    public function getProfile()
    {
        try{
            return responseSuccess(new UserResource( Auth::user() ) , getStatusText(GET_PROFILE_CODE), GET_PROFILE_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Refresh the user's authentication token.
     *
     * This function revokes the current token of the authenticated user
     * and issues a new token, wrapping the updated user data in a `UserResource`
     * for the response. Returns a success response if the token is successfully
     * refreshed or an error response if an exception occurs.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author Salah Derbas
    */
    public function refreshToken()
    {
        try{
            Auth::user()->token()->revoke();
            return responseSuccess(new UserResource( Auth::user() ) , getStatusText(REFRESH_TOKEN_CODE), REFRESH_TOKEN_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Log out the authenticated user.
     *
     * This function revokes the current token of the authenticated user,
     * effectively logging them out. Returns a success response upon successful
     * logout or an error response if an exception occurs.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author Salah Derbas
    */
    public function logout()
    {
        try{
            Auth::user()->token()->revoke();
            return responseSuccess('', getStatusText(USER_LOGOUT_CODE), USER_LOGOUT_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Store a new user in the database.
     *
     * This function receives an `AuthRequest` containing user data,
     * checks for an uploaded photo, processes it if present, and
     * saves the user information to the database. Returns a success
     * response upon successful creation, or an error response if an
     * exception occurs.
     *
     * @param AuthRequest $request - The request containing user data.
     * @return \Illuminate\Http\JsonResponse
     * @author Salah Derbas
    */
    public function store(AuthRequest $request)
    {
        try{
            $userData           = $request->all();
            if ($request->file('photo'))
            $userData['photo']  = handleFileUpload($request->file('photo'), 'store' , 'User' , NULL);

            User::create($userData);
            return responseSuccess('' , getStatusText(STORE_USER_SUCCESS_CODE)  , STORE_USER_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Update the profile of the authenticated user.
     *
     * This function receives an `AuthRequest` with updated user data,
     * checks for an uploaded photo, processes it if present, and updates
     * the authenticated user's profile in the database. Returns a success
     * response upon successful update, or an error response if an
     * exception occurs.
     *
     * @param AuthRequest $request - The request containing updated user data.
     * @return \Illuminate\Http\JsonResponse
     * @author Salah Derbas
    */
    public function updateProfile(AuthRequest $request)
    {
        try{
            $userData           = $request->all();
            if ($request->file('photo'))
            $userData['photo']  = handleFileUpload($request->file('photo'), 'update' , 'User' , Auth::user()->photo);

            Auth::user()->update($userData);
            return responseSuccess('' , getStatusText(UPDATE_PROFILE_SUCCESS_CODE)  , UPDATE_PROFILE_SUCCESS_CODE);

        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Deactivate the authenticated user's account.
     *
     * This function updates the `status` field of the authenticated user
     * to `false`, marking the account as inactive or "deleted". Returns a
     * success response upon successful deactivation, or an error response
     * if an exception occurs.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author Salah Derbas
    */
    public function delete()
    {
        try{
            Auth::user()->update(['status' => false]);
            return responseSuccess('', getStatusText(DELETE_ACCONT_CODE), DELETE_ACCONT_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
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
     * @author Salah Derbas
    */
    private function sendOTPEmail($email , $otp)
    {
        SendOTPEmailJob::dispatch($email, $otp);
        User::where('email' , $email)->update(['code_auth' => $otp , 'expire_time' => Carbon::now()->addMinutes(3)]);

        return responseSuccess('', getStatusText(SEND_OTP_SUCCESS_CODE) ,SEND_OTP_SUCCESS_CODE);
    }

    /**
     * Log in the user after successful OTP validation and retrieve the user's details with relations.
     *
     * @param User $user The authenticated user object.
     * @return \Illuminate\Http\JsonResponse The response containing the user's information and success status.
     * @author Salah Derbas
    */
    private function successAuth($user)
    {
        Auth::login($user);
        return responseSuccess( new UserResource($user) , getStatusText(LOGIN_SUCCESS_CODE)  , LOGIN_SUCCESS_CODE );
    }


}
