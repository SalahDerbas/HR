<?php

namespace App\Rules\API\Auth;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Carbon;

class UserAppleIdIsFound implements Rule
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
     * Validate and manage the user based on the provided Facebook ID.
     * Creates a new user if none exists, or updates the existing user's information.
     *
     * @param string $attribute The attribute being validated (not used here).
     * @param mixed $value The value being validated (not used here).
     * @return bool Always returns true.
     */
    public function passes($attribute, $value)
    {
        $user = User::where('apple_id', $this->user->apple_id)->first();
        dd($user);
        (is_null($user)) ? ($this->createUser()) : ($this->updateUser($user));

        return true;
    }

    /**
     * Create a new user with the provided details from the Facebook user data.
     *
     * @return void
     */
    private function createUser()
    {
        User::insert([
            'email'              => 'fb.' . encrypt('hr_api') . '@gmail.com',
            'email_verified_at'  => Carbon::now(),
            'fcm_token'          => $this->user->fcm_token,
            'apple_id'           => $this->user->apple_id,
            'last_login'         => Carbon::now(),

        ]);
    }

    /**
     * Update an existing user's information with the provided Facebook user data.
     *
     * @param User $user The user object to update.
     * @return void
     */
    private function updateUser($user)
    {
        $user->update([
            'apple_id'          => $this->user->apple_id,
            'fcm_token'         => $this->user->fcm_token,
            'last_login'        => Carbon::now(),

        ]);
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
