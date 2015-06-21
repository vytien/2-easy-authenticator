<?php namespace Bernardino\EasyAuthenticator;

use Illuminate\Support\ServiceProvider;

class EasyAuthenticatorServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'easyAuthenticator');

        $this->publishes([
            __DIR__.'/Config/EasyAuthenticator.php' => config_path('easyAuthenticator.php'),
            __DIR__.'/Views' => base_path('resources/views/bernardino/easyAuthenticator'),
            __DIR__.'/Migrations' => base_path('database/migrations'),
        ]);

        $this->app->config->set('auth.model', $this->app->config->get('easyAuthenticator.model'));

        include __DIR__.'/routes.php';
    }

    public function register()
    {
        $this->app->bind('authenticator', function($app)
        {
            return $app->make('Bernardino\EasyAuthenticator\AuthenticatorManager');
        });
        $this->registerSocialite();
        $this->registerUserModel();
    }

    public function registerSocialite()
    {
        $this->app->register('\Laravel\Socialite\SocialiteServiceProvider');
    }

    public function registerUserModel()
    {
        $this->app->make('Bernardino\EasyAuthenticator\Models\User');
    }

    public function provides()
    {
        return [
            'Bernardino\EasyAuthenticator\AuthenticatorManager',
            '\Laravel\Socialite\SocialiteServiceProvider',
        ];
    }
}