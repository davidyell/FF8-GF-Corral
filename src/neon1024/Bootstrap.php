<?php
declare(strict_types=1);

/**
 * Bootstrap
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024\FF8Corral;

use neon1024\FF8Corral\Controller\JunctionsController;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

class Bootstrap
{
    /**
     * Dispatch the request to the correct controller
     *
     * @param \Zend\Diactoros\ServerRequest $request
     * @return \Zend\Diactoros\Response
     */
    public function dispatch(ServerRequest $request): Response
    {
        switch ($request->getUri()->getPath()) {
            case '/':
            default:
                $controller = new JunctionsController();
                return $controller->index();
            case '/junction':
                $controller = new JunctionsController();
                return $controller->autoJunction();
        }
    }
}
