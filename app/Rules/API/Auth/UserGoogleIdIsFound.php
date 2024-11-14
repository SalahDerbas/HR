<?php

namespace App\Rules\API\Auth;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Carbon;

class UserGoogleIdIsFound implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     * @author Salah Derbas
     */
    protected $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Validate and manage the user based on the provided Google ID or email.
     * Creates a new user if neither exists, or updates the existing user if found.
     *
     * @param string $attribute The attribute being validated (not used here).
     * @param mixed $value The value being validated (not used here).
     * @return bool Always returns true.
     * @author Salah Derbas
     */
    public function passes($attribute, $value)
    {
        $existingUser = $this->findUserByGoogleId() ?: $this->findUserByEmail();

        (is_null($existingUser)) ? ($this->createUser())  : ( $this->updateUser($existingUser));

        return true;
    }

    /**
     * Find a user by their Google ID.
     *
     * @return User|null The user object if found, or null if not.
     * @author Salah Derbas
     */
    private function findUserByGoogleId()
    {
        return User::where('google_id', $this->user['google_id'])->first();
    }

    /**
     * Find a user by their email address.
     *
     * @return User|null The user object if found, or null if not.
     * @author Salah Derbas
     */
    private function findUserByEmail()
    {
        return User::where('email', $this->user['email'])->first();
    }

    /**
     * Create a new user with the provided details.
     *
     * @return void
     * @author Salah Derbas
     */
    private function createUser()
    {
        User::insert([
            'email'             => $this->user['email'],
            'email_verified_at' => Carbon::now(),
            'fcm_token'         => $this->user['fcm_token'],
            'google_id'         => $this->user['google_id'],
            'last_login'        => Carbon::now(),
        ]);
    }

    /**
     * Update an existing user's Google ID and FCM token.
     *
     * @param User $user The user object to update.
     * @return void
     * @author Salah Derbas
     */
    private function updateUser($user)
    {
        $user->update([
            'google_id'         => $this->user['google_id'],
            'fcm_token'         => $this->user['fcm_token'],
            'last_login'        => Carbon::now(),
        ]);
    }


    public function message()
    {
        return 'User_Not_Registered';
    }
}
