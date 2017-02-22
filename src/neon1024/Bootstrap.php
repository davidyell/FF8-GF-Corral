<?php
declare(strict_types=1);

/**
 * Bootstrap
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024;

class Bootstrap
{
    /**
     * Dispatch the request to the correct controller
     *
     * @param string $url
     */
    public function dispatch($url)
    {
        switch ($url) {
            case '/':
            default:
                require 'Controller/JunctionsController.php';
                $controller = new Controller\JunctionsController();
                $controller->index();
                break;
            case '/junction':
                require 'Controller/JunctionsController.php';
                $controller = new Controller\JunctionsController();
                $controller->autoJunction();
                break;
        }
    }
}
