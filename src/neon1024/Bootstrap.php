<?php
/**
 * Bootstrap
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024;

class Bootstrap {
	
	/**
	 * Bootstrap the application
	 * 
	 * @return array
	 */
	public function __construct() {
		
	}
	
	/**
	 * Dispatch the request to the correct controller
	 * 
	 * @param string $url
	 */
	public function dispatch($url) {
		ob_start();
		
		switch($url) {
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
		
		ob_flush();
	}
}
