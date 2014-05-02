<?php
/**
 * Party
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Repository;

use neon1024\Entity\Character\Character;

class Party extends Repository {
	
	/**
	 * Add characters to the party
	 * 
	 * @param \neon1024\Entity\Character\Character $first
	 * @param \neon1024\Entity\Character\Character $second
	 * @param \neon1024\Entity\Character\Character $third
	 */
	public function populate(Character $first, Character $second, Character $third) {
		$this->collection = [$first, $second, $third];
	}	
}

