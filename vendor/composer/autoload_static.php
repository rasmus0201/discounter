<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitcd08dd16f437824ed107003e2675b407
{
    public static $prefixLengthsPsr4 = array (
        'D' => 
        array (
            'Discounter\\' => 11,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Discounter\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Discounter',
        ),
    );

    public static $classMap = array (
        'Discounter\\BaseDiscounter' => __DIR__ . '/../..' . '/Discounter/BaseDiscounter.php',
        'Discounter\\Contracts\\Discountable' => __DIR__ . '/../..' . '/Discounter/Contracts/Discountable.php',
        'Discounter\\Discounter' => __DIR__ . '/../..' . '/Discounter/Discounter.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitcd08dd16f437824ed107003e2675b407::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitcd08dd16f437824ed107003e2675b407::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitcd08dd16f437824ed107003e2675b407::$classMap;

        }, null, ClassLoader::class);
    }
}
