<?php
/**
 * Repository
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Repository;

use \Exception;

class Repository {
	/**
	 * Store the XML file data
	 * 
	 * @var SimpleXMLElement
	 */
	protected $xml = null;
	
	/**
	 * Collection of Guardian Forces
	 * 
	 * @var array
	 */
	protected $collection = [];
	
	/**
	 * Load an xml file
	 * 
	 * @param type $file
	 * @throws Exception
	 */
	public function load($file) {
		if (file_exists($file)) {
			$this->xml = simplexml_load_file($file);
		} else {
			throw new Exception('No data found');
		}
	}
	
	/**
	 * Get a specific item from the collection 
	 * 
	 * @param string $name
	 * @return object
	 */
	public function getItem($name) {
		return $this->collection[$name];
	}
	
	/**
	 * Return a list of all the loaded classes
	 * 
	 * @return array
	 */
	public function getCollection() {
		return $this->collection;
	}
}