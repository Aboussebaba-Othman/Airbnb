<?php
namespace Core;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class Twig {
    private static $twig = null;

    public static function getTwig() {
        if (self::$twig === null) {
            $loader = new FilesystemLoader(__DIR__ . '/../views');
            self::$twig = new Environment($loader, [
                'cache' => __DIR__ . '/../cache',
                'auto_reload' => true,
            ]);
        }
        return self::$twig;
    }
}
