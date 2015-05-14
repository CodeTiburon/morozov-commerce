<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use Illuminate\Support\Facades\View;
use App\Services\MyHelpers;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
        //view()->share('mini_cart', ['cart_count' => 1, 'cart_price' => 5]);
        View::composer('app', function($view)
        {
            $view->with('mini_cart', ['cart_count' => \MyHelpers::cartTotalItems(), 'cart_price' => \MyHelpers::cartTotalSum()]);
        });
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);

        $this->app->Singleton('renderview', function()
        {
            return new App\Services\RenderView;
        });

        $this->app->Singleton('myhelpers', function()
        {
            return new App\Services\MyHelpers;
        });

	}

}
