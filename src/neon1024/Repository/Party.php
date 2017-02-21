<?php
declare(strict_types=1);

/**
 * Party
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Repository;

use neon1024\Entity\Character\Character;

class Party extends Repository
{
    /**
     * @var \neon1024\Entity\Character\Character|null
     */
    public $characterOne = null;

    /**
     * @var \neon1024\Entity\Character\Character|null
     */
    public $characterTwo = null;

    /**
     * @var \neon1024\Entity\Character\Character|null
     */
    public $characterThree = null;

    /**
     * Party constructor.
     *
     * @param \neon1024\Entity\Character\Character $first
     * @param \neon1024\Entity\Character\Character $second
     * @param \neon1024\Entity\Character\Character $third
     */
    public function __construct(Character $first, Character $second, Character $third)
    {
        $this->characterOne = $first;
        $this->characterTwo = $second;
        $this->characterThree = $third;
        
        $this->populate();
    }
    
    /**
     * Add characters to the party
     */
    public function populate()
    {
        $this->collection = [$this->characterOne, $this->characterTwo, $this->characterThree];
    }
}
