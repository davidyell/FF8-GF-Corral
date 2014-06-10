<?php
/**
 * Bootstrap the application
 * 
 * @author David Yell <neon1024@gmail.com>
 */

/**
 * Composer auto-loader
 */
require '../../vendor/autoload.php';

/**
 * Bootstrap
 */
require '../../src/neon1024/Bootstrap.php';
$site = new \neon1024\Bootstrap();
$site->dispatch($_SERVER['REQUEST_URI']);