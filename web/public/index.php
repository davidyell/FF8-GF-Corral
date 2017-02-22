<?php
/**
 * Bootstrap the application
 * 
 * @author David Yell <neon1024@gmail.com>
 */
use neon1024\Bootstrap;

require dirname(dirname(__DIR__)) . '/vendor/autoload.php';

$request = Zend\Diactoros\ServerRequestFactory::fromGlobals(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$site = new Bootstrap();
$site->dispatch($request);
