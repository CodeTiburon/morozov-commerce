<?php namespace App\Facade;

use Illuminate\Support\Facades\Facade;

class MyHelpers extends Facade {

    /**
     * Получить зарегистрированное имя компонента.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'myhelpers'; }

}