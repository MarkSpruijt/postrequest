<?php

namespace dkesberg\Facades;

use Illuminate\Support\Facades\Facade;

class CiconiaFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'markdown';
    }
}