<?php
/**
 * Bootstrap the application
 * 
 * @author David Yell <neon1024@gmail.com>
 */
use neon1024\Bootstrap;

require dirname(dirname(__DIR__)) . '/vendor/autoload.php';

$site = new Bootstrap();
$site->dispatch($_SERVER['REQUEST_URI']);
