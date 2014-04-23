<?php
/**
 * Bootstrap
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024;

use neon1024\Entity\Character\Garden;
use neon1024\Entity\GuardianForce\Corral;

class Bootstrap {
	
	/**
	 * List of all junctionable stats
	 * 
	 * @var array
	 */
	public $junctions = [
		'HP',
		'Str',
		'Vit',
		'Mag',
		'Spr',
		'Spd', 
		'Eva',
		'Hit',
		'Luck'
	];
	
	/**
	 * Default data file locations
	 * 
	 * @var array 
	 */
	private $defaults = [
		'characters' => '../../src/neon1024/Entity/Character/Characters.xml',
		'gfs' => '../../src/neon1024/Entity/GuardianForce/GFs.xml'
	];
	
	/**
	 * User data file locations
	 * 
	 * @var array
	 */
	private $userData = [
		'characters' => '../../config/Characters.xml',
		'gfs' => '../../config/GFs.xml'
	];
	
	/**
	 * Array of variables for the view
	 * 
	 * @var array
	 */
	public $viewVars = [];
	
	/**
	 * Bootstrap the application
	 * 
	 * @return array
	 */
	public function __construct() {
		$file = $this->defaults['gfs'];
		if (file_exists($this->userData['gfs'])) {
			$file = $this->userData['gfs'];
		}
		
		$this->viewVars['gfs'] = new Corral($file);
		
		$file = $this->defaults['characters'];
		if (file_exists($this->userData['characters'])) {
			$file = $this->userData['characters'];
		}
		
		$this->viewVars['chars'] = new Garden($file);
	}
	
	/**
	 * Render a view
	 * 
	 * @param string $url
	 */
	public function render($url) {
		ob_start();
		
		switch($url) {
			case '/':
			default:
				require 'Views/index.php';
				break;
			case '/junction':
				require 'Views/junction.php';
				break;
		}
		
		ob_flush();
	}
}
