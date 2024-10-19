<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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

        if($route == "Dashboard.Users.store")
        {
            $rules = [
                'name'      => ['required' , 'string'] ,
                'email'     => ['required' , 'unique:users,email'] ,
                'password'  => ['required'  , 'min:6' , 'max:10'],
                'firstname' => ['required' , 'string'] ,
                'lastname'  => ['required' , 'string'] ,
                'phone'     => [ 'required']   ,
                'status'    => [ 'required']   ,
                'gender'    => [ 'required']   ,
                'material_status' =>  [ 'required']   ,
            ];
        }
        if($route == "Dashboard.Users.update")
        {
            $rules = [
                'name'      => ['required' , 'string'] ,
                'email'     => ['required' , 'unique:users,email,'.$this->id ] ,
                'password'  => ['required'  , 'min:6' , 'max:10'],
                'firstname' => ['required' , 'string'] ,
                'lastname'  => ['required' , 'string'] ,
                'phone'     => [ 'required']   ,
                'status'    => [ 'required']   ,
                'gender'    => [ 'required']   ,
                'material_status' =>  [ 'required']   ,
            ];
        }
        if ( $route =="Dashboard.Users.destroy")
        {
            $rules = [
                'id' => ['required' , 'exists:users,id']
            ];
        }

        if( $route =="Dashboard.Users.updateProfile"){
            $rules = [
                'name'      => ['required' , 'string'] ,
                'email'     => ['required' ] ,
                'firstname' => ['required' , 'string'] ,
                'lastname'  => ['required' , 'string'] ,
                'phone'     => [ 'required']   ,
            ];
        }

        if( $route == "Dashboard.Users.updatePassword")
        {
            $rules = [
                'new_password' => ['required' , 'confirmed'],
            ];

        }


        return $rules;
    }
}
