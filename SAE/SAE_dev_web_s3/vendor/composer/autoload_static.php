<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit641dc9f76e73ecf5a7092aa0550729dd
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tayko\\SaeDevWebS3\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tayko\\SaeDevWebS3\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit641dc9f76e73ecf5a7092aa0550729dd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit641dc9f76e73ecf5a7092aa0550729dd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit641dc9f76e73ecf5a7092aa0550729dd::$classMap;

        }, null, ClassLoader::class);
    }
}