<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;

class UserIsDelete implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $email = null;
    public function __construct($email)
    {
        $this->email =  $email ;
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
        return (User::where('email' , $this->email)->pluck('status_user_id')->first() == 17 ) ? false : true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'user_delete';
    }
}
