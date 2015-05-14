<?php namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {


        View::composer('app', function($view)
        {
            dd(1);
            $view->with('mini_cart', ['cart_count' => 1, 'cart_price' => 5]);
        });
    }

    /**
     * Register
     *
     * @return void
     */
    public function register()
    {
        //
    }

}