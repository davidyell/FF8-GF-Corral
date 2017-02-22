<?php
declare(strict_types=1);

/**
 * Bootstrap
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024;

use neon1024\Controller\JunctionsController;

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
                $controller = new JunctionsController();
                $controller->index();
                break;
            case '/junction':
                $controller = new JunctionsController();
                $controller->autoJunction();
                break;
        }
    }
}
