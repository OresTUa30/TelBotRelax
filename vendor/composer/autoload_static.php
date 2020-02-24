<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit009fc899058025d4d85e5ff627b9c1b1
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'TelegramBot\\Api\\' => 16,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'TelegramBot\\Api\\' => 
        array (
            0 => __DIR__ . '/..' . '/telegram-bot/api/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit009fc899058025d4d85e5ff627b9c1b1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit009fc899058025d4d85e5ff627b9c1b1::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}