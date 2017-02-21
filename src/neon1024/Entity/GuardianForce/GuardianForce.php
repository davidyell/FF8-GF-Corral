<?php
declare(strict_types=1);

/**
 * GuardianForce
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024\Entity\GuardianForce;

use neon1024\Entity\Character\Character;

class GuardianForce
{
    
    /**
     * The name of the GF
     *
     * @var string
     */
    private $name;
    
    /**
     * The GF's primary element or attack
     *
     * @var string
     */
    private $element;
    
    /**
     * Which character is this GF junctioned to
     *
     * @var \neon1024\Entity\Character\Character|null
     */
    private $junctionedBy = null;
    
    /**
     * Collection of available junctions for the GF
     *
     * @var array
     */
    private $statJunctions = [];
    
    /**
     * Collection of GFs abilities
     *
     * @var array
     */
    private $abilities = [];
    
    /**
     * Build a GF and assign it's data
     *
     * @param \SimpleXMLElement $data
     */
    public function __construct(\SimpleXMLElement $data)
    {
        $this->setName((string)$data->name);
        $this->setElement((string)$data->element);
        $this->setStatJunctions((array)$data->Junctions->junction);
        $this->setAbilities((array)$data->Abilities->ability);
    }
    
    /**
     * Set the name of the GF
     *
     * @param string $name
     */
    protected function setName(string $name)
    {
        $this->name = $name;
    }
    
    /**
     * Get the name of the GF
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * Set the GFs element
     *
     * @param string $element
     */
    protected function setElement(string $element)
    {
        $this->element = $element;
    }
    
    /**
     * Get the GFs element
     *
     * @return string
     */
    public function getElement(): string
    {
        return $this->element;
    }
    
    /**
     * Set all the GFs junction abilities
     *
     * @param array $statJunctions
     */
    protected function setStatJunctions(array $statJunctions)
    {
        $this->statJunctions = $statJunctions;
    }

    /**
     * Get a list of all this GFs junction abilities
     *
     * @return array
     */
    public function getStatJunctions(): array
    {
        return $this->statJunctions;
    }
    
    /**
     * Add a new junction ability to this GF
     *
     * @param string $junction
     */
    public function addJunction(string $junction)
    {
        $this->statJunctions = array_merge($this->statJunctions, [$junction]);
    }
    
    /**
     * Does this GF have a specific junction ability
     *
     * @param string $junction
     * @return boolean
     */
    public function hasJunction(string $junction): bool
    {
        if (strpos($junction, '-J') === false) {
            $junction = $junction . '-J';
        }
        if (in_array($junction, $this->statJunctions)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Get a list of the GFs abilities
     *
     * @return array
     */
    public function getAbilities(): array
    {
        return $this->abilities;
    }
    
    /**
     * Set the GFs abilities
     *
     * @param array $abilities
     */
    protected function setAbilities(array $abilities)
    {
        $this->abilities = $abilities;
    }
    
    /**
     * Set this GF as junctioned to a character
     *
     * @param \neon1024\Entity\Character\Character $character Character instance to junction to
     * @return void
     */
    public function junctionTo(Character $character): void
    {
        $this->junctionedBy = $character;
    }

    /**
     * Remove the character junctioned to this Guardian Force
     *
     * @return void
     */
    public function unjunction(): void
    {
        $this->junctionedBy = null;
    }
    
    /**
     * Find out which character this GF is junctioned to
     *
     * @return \neon1024\Entity\Character\Character|null
     */
    public function getJunctionedBy()
    {
        return $this->junctionedBy;
    }
}
