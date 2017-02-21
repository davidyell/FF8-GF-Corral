<?php
declare(strict_types=1);

/**
 * CharacterInferface
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024\Entity\Character;

use neon1024\Entity\GuardianForce\GuardianForce;

interface CharacterInferface
{
    
    /**
     * Junction a Guardian Force to the character
     *
     * @param GuardianForce $gf The name of the Guardian Force being junctioned
     * @return \neon1024\Entity\Character\Character
     */
    public function junction(GuardianForce $gf): Character;

    /**
     * Remove a Guardian Force from this Characters junctions
     *
     * @param \neon1024\Entity\GuardianForce\GuardianForce $gf
     *
     * @return \neon1024\Entity\Character\Character
     */
    public function unjunction(GuardianForce $gf): Character;
}
