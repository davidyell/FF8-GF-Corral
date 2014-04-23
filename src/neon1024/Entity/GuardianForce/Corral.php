<?php
/**
 * Corral contains a collection of GuardianForces
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Entity\GuardianForce;

use \Exception;
use neon1024\Entity\GuardianForce\GuardianForce;

class Corral {

	/**
	 * Store the XML file data
	 * 
	 * @var SimpleXMLElement
	 */
	private $xml = null;
	
	/**
	 * Collection of Guardian Forces
	 * 
	 * @var array
	 */
	private $collection = [];
	
	/**
	 * Construct the collection and instantiate GFs
	 * 
	 * @param string $file Path to the GF xml data
	 * @throws Exception
	 */
	public function __construct($file) {
		if (file_exists($file)) {
			$this->xml = simplexml_load_file($file);
		} else {
			throw new Exception('No GF data found');
		}
		
		foreach ($this->xml->GuardianForce as $gf) {
			$this->collection[(string)$gf->name] = new GuardianForce($gf);
		}
	}
	
	/**
	 * Get a specific GF from the collection 
	 * 
	 * @param string $name
	 * @return GuardianForce
	 */
	public function getGF($name) {
		return $this->collection[$name];
	}
	
	/**
	 * Return a list of all the loaded GFs
	 * 
	 * @return array
	 */
	public function getCollection() {
		return $this->collection;
	}
}
