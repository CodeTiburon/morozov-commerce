<?php namespace App\Facade;

use Illuminate\Support\Facades\Facade;

class MyAuth extends Facade {

    /**
     * Получить зарегистрированное имя компонента.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'myauth'; }

}