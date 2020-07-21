<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2760804d7f9be95044bf9d77a408205c
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Packages\\IMEI\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Packages\\IMEI\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2760804d7f9be95044bf9d77a408205c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2760804d7f9be95044bf9d77a408205c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}