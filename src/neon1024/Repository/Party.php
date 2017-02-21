<?php
/**
 * Party
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Repository;

use neon1024\Entity\Character\Character;

class Party extends Repository
{
    
    public $characterOne = null;
    public $characterTwo = null;
    public $characterThree = null;
    
    public function __construct(Character $first, Character $second, Character $third)
    {
        $this->characterOne = $first;
        $this->characterTwo = $second;
        $this->characterThree = $third;
        
        $this->populate();
    }
    
    /**
     * Add characters to the party
     *
     * @param \neon1024\Entity\Character\Character $first
     * @param \neon1024\Entity\Character\Character $second
     * @param \neon1024\Entity\Character\Character $third
     */
    public function populate()
    {
        $this->collection = [$this->characterOne, $this->characterTwo, $this->characterThree];
    }
}
