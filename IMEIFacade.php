<?php


namespace Packages\IMEI;


use Illuminate\Support\Facades\Facade;

class IMEIFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "IMEI";
    }
}
