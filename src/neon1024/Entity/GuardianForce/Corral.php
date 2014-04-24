<?php
/**
 * Corral contains a collection of GuardianForces
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Entity\GuardianForce;

use neon1024\Repository\Repository;
use neon1024\Repository\RepositoryInterface;

class Corral extends Repository {
	
	/**
	 * Construct the collection and instantiate classes
	 * 
	 * @param string $file Path to the xml data
	 */
	public function __construct($file) {
		$this->load($file);
		$this->populate();
	}
	
	/**
	 * Add the data to the collection
	 */
	public function populate() {
		foreach ($this->xml->GuardianForce as $gf) {
			$this->collection[(string)$gf->name] = new GuardianForce($gf);
		}
	}

}
