<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6a7056907783a0822950b36db12de7c8
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'OSS\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'OSS\\' => 
        array (
            0 => __DIR__ . '/..' . '/aliyuncs/oss-sdk-php/src/OSS',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6a7056907783a0822950b36db12de7c8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6a7056907783a0822950b36db12de7c8::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
