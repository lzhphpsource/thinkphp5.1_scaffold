<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitbc5b5135634b31df55509f2a78c07b8c
{
    public static $files = array (
        '9b552a3cc426e3287cc811caefa3cf53' => __DIR__ . '/..' . '/topthink/think-helper/src/helper.php',
        '79b90a0dd21b055393825089c746fe2c' => __DIR__ . '/..' . '/liaozh/api-doc/src/helper.php',
        '1cfd2761b63b0a29ed23657ea394cb2d' => __DIR__ . '/..' . '/topthink/think-captcha/src/helper.php',
        'ddc3cd2a04224f9638c5d0de6a69c7e3' => __DIR__ . '/..' . '/topthink/think-migration/src/config.php',
        '644e9cafc67b331e17cc7661548f33d0' => __DIR__ . '/..' . '/weiwei/api-doc/src/helper.php',
    );

    public static $prefixLengthsPsr4 = array (
        't' => 
        array (
            'think\\migration\\' => 16,
            'think\\composer\\' => 15,
            'think\\captcha\\' => 14,
            'think\\' => 6,
        ),
        'a' => 
        array (
            'app\\' => 4,
            'api\\doc\\' => 8,
        ),
        'P' => 
        array (
            'Phinx\\' => 6,
        ),
        'A' => 
        array (
            'Api\\Doc\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'think\\migration\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-migration/src',
        ),
        'think\\composer\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-installer/src',
        ),
        'think\\captcha\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-captcha/src',
        ),
        'think\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-helper/src',
        ),
        'app\\' => 
        array (
            0 => __DIR__ . '/../..' . '/application',
        ),
        'api\\doc\\' => 
        array (
            0 => __DIR__ . '/..' . '/liaozh/api-doc/src',
        ),
        'Phinx\\' => 
        array (
            0 => __DIR__ . '/..' . '/topthink/think-migration/phinx/src/Phinx',
        ),
        'Api\\Doc\\' => 
        array (
            0 => __DIR__ . '/..' . '/weiwei/api-doc/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitbc5b5135634b31df55509f2a78c07b8c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitbc5b5135634b31df55509f2a78c07b8c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
