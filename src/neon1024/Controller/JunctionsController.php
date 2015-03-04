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
			$characterDataFile = file_get_contents($this->userData['characters']);
			$characterData = simplexml_load_string($characterDataFile);
		} else {
			$characterDataFile = file_get_contents($this->defaults['characters']);
			$characterData = simplexml_load_string($characterDataFile);
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
						// To elimiate the GF allowing prioritised junctioning
						$intersection = array_intersect($character->getJunctionedStats(), $gf->getJunctions()));
						if (empty($intersection) {
							
							// GF has the stat available to junction
							$intersection = array_intersect($character->getJunctionableStats(), $gf->getJunctions());
							if ($gf->hasJunction($stat) && !empty($intersection)) {
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
		$team = $party->getCollection();
		usort($team, [$this, 'sortByJunctionable']);
		
		foreach ($team as $character) {
			foreach ($corral->getCollection() as $gf) {
				if (!$gf->getJunctionedBy()) {
					$intersection = array_intersect($character->getJunctionableStats(), $gf->getJunctions());
					if (!empty($intersection)) {
						$character->junction($gf);
					}
				}
			}
		}
		
		$this->viewVars = [
			'party' => $party,
			'corral' => $corral
		];
		
		return require('../../src/neon1024/Views/junction.php');
	}
	
	/**
	 * Sort characters by the number of available junctions
	 * 
	 * @param \neon1024\Entity\Character\Character $a
	 * @param \neon1024\Entity\Character\Character $b
	 * @return int
	 */
	private function sortByJunctionable(Character $a, Character $b) {
		return (count($a->getJunctionableStats()) < count($b->getJunctionableStats())) ? 1 : -1;
	}
}
