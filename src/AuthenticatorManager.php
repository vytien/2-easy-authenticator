<?php namespace Bernardino\EasyAuthenticator;

use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Illuminate\Routing\Controller as BaseController;

class AuthenticatorManager extends BaseController {

    public $auth;

    public $request;

    public $authentication;

    public $socialite;

    public function __construct(Guard $auth, Request $request, Authentication $authentication, Socialite $socialite)
    {
        $this->authentication = $authentication;
        $this->auth = $auth;
        $this->request = $request;
        $this->socialite = $socialite;
    }

    public function login($provider)
    {
        return $this->authentication->execute($this->request->all(), $provider);
    }

    public function logout()
    {
        $this->auth->logout();
        return redirect(config('easyAuthenticator.logout_redirect'));
    }
}