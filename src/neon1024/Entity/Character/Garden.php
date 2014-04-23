<?php
/**
 * Garden contains a collection of Characters
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Entity\Character;

use neon1024\Repository\Repository;
use neon1024\Entity\Character\Character;

class Garden extends Repository {
	/**
	 * Construct the collection and instantiate classes
	 * 
	 * @param string $file Path to the xml data
	 * @throws Exception
	 */
	public function __construct($file) {
		$this->load($file);
		
		foreach ($this->xml->Character as $char) {
			$this->collection[(string)$char->name] = new Character($char);
		}
	}
}
