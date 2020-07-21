<?php


namespace IMEI;


use Illuminate\Support\ServiceProvider;

class IMEIProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('IMEI', function (){
            return $this->app->make(IMEI::class);
        });
    }
}
