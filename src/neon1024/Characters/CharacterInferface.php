<?php
/**
 * CharacterInferface
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024\Characters;

interface CharacterInferface {
	
	/**
	 * Junction a Guardian Force to the character
	 * 
	 * @param GuardianForce $gf The name of the Guardian Force being junctioned
	 */
	public function junction(\neon1024\GuardianForces\GuardianForce $gf);
	
}