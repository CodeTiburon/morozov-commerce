<?php namespace App\Facade;

use Illuminate\Support\Facades\Facade;

class RenderView extends Facade {

    /**
     * Получить зарегистрированное имя компонента.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'renderview'; }

}