<?php
/**
 * JunctionsController
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Controller;

use neon1024\Repository\Garden;
use neon1024\Repository\Corral;
use neon1024\Repository\Party;
use neon1024\Entity\Character\Character;

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
	 * 
	 * @return string
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
	
	/**
	 * Automatically junction gfs to characters
	 * 
	 * @return string
	 */
	public function autoJunction() {
		$file = $this->defaults['gfs'];
		if (file_exists($this->userData['gfs'])) {
			$file = $this->userData['gfs'];
		}
		$corral = new Corral($file);
		
		if (file_exists($this->userData['characters'])) {
			$characterData = simplexml_load_file($this->userData['characters']);
		} else {
			$characterData = simplexml_load_file($this->defaults['characters']);
		}
		
		$one = new Character($characterData->Character[0]);
		$two = new Character($characterData->Character[1]);
		$three = new Character($characterData->Character[2]);
		
		$party = new Party($one, $two, $three);
		
		$statPriority = ['Spd-J', 'HP-J', 'Str-J', 'Vit-J', 'Spr-J', 'Mag-J'];
		
		
		/**
		 * First parse
		 * Basic matching with no overlapping using the priority order
		 */
		foreach ($party as $character) {
			foreach ($corral->getCollection() as $gf) {
				if (!$gf->getJunctionedBy()) {
					foreach ($statPriority as $stat) {
						// Find stats this character has already junctioned, which this GF can junction
						if (empty(array_intersect($character->getJunctionedStats(), $gf->getJunctions()))) {
							
							// GF has the stat available to junction
							if ($gf->hasJunction($stat) && !empty(array_intersect($character->getJunctionableStats(), $gf->getJunctions()))) {
								$character->junction($gf);
							}
						}
					}
				}
			}
		}
		
		/**
		 * Second parse
		 * Match up characters without a full set of junctions first
		 */
		foreach ($party as $character) {
			
		}
		
		
		$this->viewVars = [
			'party' => $party,
			'corral' => $corral
		];
		
		return require('../../src/neon1024/Views/junction.php');
	}
}
