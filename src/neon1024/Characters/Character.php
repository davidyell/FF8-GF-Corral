<?php
/**
 * Character
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024\Characters;

use neon1024\Characters\CharacterInferface;
use neon1024\GuardianForces\GuardianForce;

class Character implements CharacterInferface {
	
	/**
	 * Store a list of all this characters junctioned GFs
	 * 
	 * @var array
	 */
	private $junctioned = [];
	
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
	 * Return the name of the character
	 * 
	 * @return type
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