<?php namespace Bernardino\EasyAuthenticator;

use Bernardino\EasyAuthenticator\Repositories\UserRepository as Users;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Contracts\Auth\Guard;
use Request;
use Session;

class Authentication extends AuthenticatorManager {

    public $socialite;

    public $auth;

    public $users;

    public function __construct(Socialite $socialite, Guard $auth, Users $users) {
        $this->socialite = $socialite;
        $this->users = $users;
        $this->auth = $auth;
    }

    public function execute($request = null, $provider) {
        if (!$request) return $this->getAuthorizationFirst($provider);
        $user = $this->users->findByUserNameOrCreate($this->getSocialUser($provider), $provider);

        var_dump($user);
        return;
        if(!$user) {
            return redirect(config('easyAuthenticator.login_page'))->with('session', 'Email is already in use');
        }

        (config('easyAuthenticator.flash_session')) ?:
            Session::flash(
                config('easyAuthenticator.flash_session_key'),
                config('easyAuthenticator.flash_session_login')
            );

//         var_dump($user);
//         $this->auth->login($user, true);

//         return $this->userHasLoggedIn($user);
    }

    private function getAuthorizationFirst($provider) {
        return $this->socialite->driver($provider)->redirect();
    }

    private function getSocialUser($provider) {
        return $this->socialite->driver($provider)->user();
    }

    public function userHasLoggedIn($user) {
        return redirect(config('easyAuthenticator.login_redirect'));
    }
}