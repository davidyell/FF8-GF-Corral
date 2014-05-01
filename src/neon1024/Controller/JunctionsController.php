<?php
/**
 * JunctionsController
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Controller;

use neon1024\Repository\Garden;
use neon1024\Repository\Corral;

class JunctionsController {
	
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
	 * Array of variables for the view
	 * 
	 * @var array
	 */
	public $viewVars = [];
	
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
	 * Index action
	 */
	public function index() {
		$file = $this->defaults['gfs'];
		if (file_exists($this->userData['gfs'])) {
			$file = $this->userData['gfs'];
		}
		$corral = new Corral($file);
		
		$file = $this->defaults['characters'];
		if (file_exists($this->userData['characters'])) {
			$file = $this->userData['characters'];
		}
		$garden = new Garden($file);
		
		$this->viewVars = [
			'chars' => $garden,
			'gfs' => $corral
		];
		
		return require('../../src/neon1024/Views/index.php');
	}
	
	public function autoJunction() {
		$file = $this->defaults['gfs'];
		if (file_exists($this->userData['gfs'])) {
			$file = $this->userData['gfs'];
		}
		$corral = new Corral($file);
		
		$file = $this->defaults['characters'];
		if (file_exists($this->userData['characters'])) {
			$file = $this->userData['characters'];
		}
		$garden = new Garden($file);
		
		$firstCharacter = $garden->getItem('Squall');
		$secondCharacter = $garden->getItem('Zell');
		$thirdCharacter = $garden->getItem('Selphie');
		
		var_dump($firstCharacter);
		// TODO: Start trying to junction GF's until a characters junctionable 
		// array is empty, then try the next character.
		
		// TODO: Advance to shuffling the GF's to prioritise certain junctions
		// such as HP, Str, Vit, Spr, Mag, Hit, Eva, Luck
		
		
		$this->viewVars = [
			'firstCharacter' => $firstCharacter,
			'secondCharacter' => $secondCharacter,
			'thirdCharacter' => $thirdCharacter
		];
		
		return require('../../src/neon1024/Views/junction.php');
	}
}
