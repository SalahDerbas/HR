<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Rules\UserIsDelete;
use App\Rules\UserGoogleIdIsFound;
use App\Rules\UserFacebookIdIsFound;

use App\Models\User;

class AuthRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $route =  $this->route()->getName();

        if ($route == "api.user.login") {
            $rules = [
                'email'      => ['exists:users,email'],
                'password'   => ['required'],
                'status'     => [new UserIsDelete($this->email)]
            ];
        } elseif ($route == "api.user.register") {
            $rules = [
                'name'      => 'required|unique:users|regex:/^[\p{Arabic}a-zA-Z0-9\- .ـ]+$/u',
                'email'     => ['required', 'string', 'email', 'max:255',  Rule::unique(User::getTableName(), "email"), 'regex:/^(?=[^@]*[A-Za-z])([a-zA-Z0-9])(([a-zA-Z0-9])*([\._-])?([a-zA-Z0-9]))*@(([a-zA-Z0-9\-])+(\.))+([a-zA-Z]{2,4})+$/i'],
                'password'  => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/']
            ];
        } elseif ($route == "api.user.check_otp") {
            $rules = [
                'otp'      => ['required'],
                'email'    => ['required', 'email', 'exists:users,email'],
            ];
        } elseif ($route == "api.user.resend_otp") {
            $rules = [
                'email'    => ['exists:users,email'],
                'status'   => [new UserIsDelete($this->email)]
            ];
        } elseif ($route == "api.user.loginByGoogle") {
            $rules = [
                'email'     => ['required', 'email'],
                'google_id' => [new UserGoogleIdIsFound($this)],
                'status'    => [new UserIsDelete($this->email)],
            ];
        } elseif ($route == "api.user.loginByFacebook") {
            $rules = [
                'facebook_id' => [new UserFacebookIdIsFound($this)],
            ];
        } elseif ($route == "api.user.forgetPassword") {
            $rules = [
                'email'    => ['exists:users,email'],
                'status'   => [new UserIsDelete($this->email)]
            ];
        } elseif ($route == "api.user.resetNewPassword") {
            $rules = [
                'email' => 'required|email|exists:users,email',
                'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
                'confirm_password' => 'required_with:password|same:password|min:6'
            ];
        }
        return $rules;
    }
}
