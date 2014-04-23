<?php
/**
 * Character
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024\Entity\Character;

use neon1024\Entity\Character\CharacterInferface;
use neon1024\Entity\GuardianForce\GuardianForce;

class Character implements CharacterInferface {
	/**
	 * Name of the character
	 * 
	 * @var string
	 */
	private $name;
	
	/**
	 * Stats which this character can junction
	 * 
	 * @var array
	 */
	private $junctionable = [];
	
	/**
	 * Store a list of all this characters junctioned GFs
	 * 
	 * @var array
	 */
	private $junctioned = [];
	
	/**
	 * Collection of junctioned Guardian Forces
	 * 
	 * @var array
	 */
	private $junctionedGFs = [];
	
	/**
	 * Build the character
	 * 
	 * @param array $data
	 */
	public function __construct($data) {
		$this->setName((string)$data->name);
		$this->setJunctionableStats((array)$data->Junctions->junction);
	}

	/**
	 * Junction a GF to this character
	 * 
	 * @param GuardianForce $gf
	 * @return \neon1024\Characters\Character
	 */
	public function junction(GuardianForce $gf) {
		$this->junctionedGFs = array_merge($this->junctionedGFs, [$gf]);
		
		foreach ($gf->getJunctions() as $junction) {
			$this->statJunctioned($junction);
		}
		
		return $this;
	}

	/**
	 * Return junctioned GF's on this character
	 * 
	 * @return array
	 */
	public function getJunctioned() {
		return $this->junctioned;
	}
	
	/**
	 * Set a set as being junctioned
	 * 
	 * @param string $junction
	 * @return bool
	 */
	protected function statJunctioned($junction) {
		if (in_array($junction, $this->junctionable)) {
			unset($this->junctionable[$junction]);
			$this->junctioned[] = $junction;
			return true;
		}
		return false;
	}
	
	/**
	 * Return the name of the character
	 * 
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}
	
	/**
	 * Set the name of the character
	 * 
	 * @param string $name
	 */
	protected function setName($name) {
		$this->name = $name;
	}
	
	/**
	 * Get the list of the stats this character can junction
	 * 
	 * @return array
	 */
	public function getJunctionableStats() {
		return $this->junctionable;
	}
	
	/**
	 * Set the characters junctionable stats
	 * 
	 * @param array $stats
	 */
	protected function setJunctionableStats($stats) {
		$this->junctionable = $stats;
	}
}