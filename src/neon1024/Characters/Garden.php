<?php
/**
 * Garden contains a collection of Characters
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Characters;

use \Exception;
use neon1024\Characters\Character;

class Garden {

	/**
	 * Store the XML file data
	 * 
	 * @var SimpleXMLElement
	 */
	private $xml = null;
	
	/**
	 * Collection of Characters
	 * 
	 * @var array
	 */
	private $collection = [];
	
	/**
	 * Construct the collection and instantiate Characters
	 * 
	 * @param string $file Path to the Char xml data
	 * @throws Exception
	 */
	public function __construct($file) {
		if (file_exists($file)) {
			$this->xml = simplexml_load_file($file);
		} else {
			throw new Exception('No character data found');
		}
		
		foreach ($this->xml->Character as $char) {
			$this->collection[(string)$char->name] = new Character($char);
		}
	}
	
	/**
	 * Get a specific character from the collection 
	 * 
	 * @param string $name
	 * @return GuardianForce
	 */
	public function getCharacter($name) {
		return $this->collection[$name];
	}
	
	/**
	 * Return the whole collection
	 * 
	 * @return array
	 */
	public function getCollection() {
		return $this->collection;
	}
}
