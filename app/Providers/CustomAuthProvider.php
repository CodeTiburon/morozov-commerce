<?php namespace App\Providers;

use App\User;
use App;
use App\AuthCustom\CustomUserProvider;
use Illuminate\Support\ServiceProvider;


class CustomAuthProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
/*        $this->app['auth']->extend('eloquent',function()
        {
            return new CustomUserProvider(new User);
        });*/
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->Singleton('myauth', function()
        {
            return new App\Services\MyAuth;
        });
    }

}