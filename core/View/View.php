<?php
namespace Core\View;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class View
{
    private static $twig;

    public static function init()
    {
        $loader = new FilesystemLoader('/var/www/html/app/views');
        self::$twig = new Environment($loader, [
            'cache' => false, 
        ]);
    }

    public static function render($template, $data = [])
    {
        if (!self::$twig) {
            self::init();
        }

        echo self::$twig->render($template, $data); 
    }
}
