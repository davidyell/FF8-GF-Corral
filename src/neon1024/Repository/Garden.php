<?php
/**
 * Garden contains a collection of Characters
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Repository;

use neon1024\Repository\Repository;
use neon1024\Entity\Character\Character;

class Garden extends Repository {
	
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
		foreach ($this->xml->Character as $char) {
			$this->collection[(string)$char->name] = new Character($char);
		}	
	}
}
