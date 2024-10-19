<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Carbon;

class UserGoogleIdIsFound implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    protected $user;
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
        $existingUser = User::where('google_id', $this->user['google_id'])->first();

        if (is_null($existingUser)) {
            $existingUser = User::where('email', $this->user['email'])->first();

            if (is_null($existingUser)) {
                User::insert([
                    'name' => $this->user['name'],
                    'email' => $this->user['email'],
                    'email_verified_at' => Carbon::now() ,
                    'fcm_id' => $this->user['fcm_id'],
                    'google_id' => $this->user['google_id'],
                ]);
            } else {
                $existingUser->update([
                    'name' => $this->user['name'],
                    'google_id' => $this->user['google_id'],
                    'fcm_id' => $this->user['fcm_id'],
                ]);
            }
        } else {
            $existingUser->update([
                'name' => $this->user['name'],
                'fcm_id' => $this->user['fcm_id'],
            ]);
        }

        return true;
    }

    public function message()
    {
        return 'User_Not_Registered';
    }
}
