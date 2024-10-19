<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class UserFacebookIdIsFound implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $user = null;
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::where( 'facebook_id', $this->user->facebook_id)->first();
        if(is_null($user))
        {
            User::insert([
                'name' => $this->user->name,
                'email' => 'fb.'.encrypt('123d').'@gmail.com',
                'email_verified_at' => now(),
                'fcm_id' => $this->user->fcm_id,
                'facebook_id' => $this->user->facebook_id,
            ]);
        }
        else {
            $user->update([
                'name' => $this->user->name,
                'facebook_id' => $this->user->facebook_id,
                'fcm_id' => $this->user->fcm_id,
            ]);
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'User_Not_Rigisteration';
    }
}
