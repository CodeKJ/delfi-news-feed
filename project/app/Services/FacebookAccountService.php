<?php
namespace App\Services;
use App\FacebookAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;
class FacebookAccountService
{
    /**
     * Create or get user from FacebookAccount
     *
     * @param ProviderUser $providerUser
     * @return mixed
     */
    public function createOrGetUser(ProviderUser $providerUser)
    {
        // Get facebook account by provided id
        $account = FacebookAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        // Check if account exist and return its user object, else create new account, upload avatar and associate account with user
        if ($account) {
            return $account->user;
        } else {

            // Make new account model, set facebook account provider data
            $account = new FacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            // Get user object using facebook account email address
            $user = User::whereEmail($providerUser->getEmail())->first();

            // Check if user doesn't exist, if so then create new user
            if (!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => md5(rand(1,10000)),
                ]);

                // Upload and save avatar image file
                $user->uploadAvatar(file_get_contents($providerUser->getAvatar()));
            }

            // Save account model and associate with user
            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}
