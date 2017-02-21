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
     * @var \neon1024\Entity\Character\Character
     */
    private $junctionedBy = null;
    
    /**
     * Collection of available junctions for the GF
     *
     * @var array
     */
    private $junctions = [];
    
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
        $this->setJunctions((array)$data->Junctions->junction);
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
     * @param array $junctions
     */
    protected function setJunctions(array $junctions)
    {
        $this->junctions = $junctions;
    }
    
    /**
     * Add a new junction ability to this GF
     *
     * @param string $junction
     */
    public function addJunction(string $junction)
    {
        $this->junctions = array_merge($this->junctions, [$junction]);
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
        if (in_array($junction, $this->junctions)) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Get a list of all this GFs junction abilities
     *
     * @return array
     */
    public function getJunctions(): array
    {
        return $this->junctions;
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
     * @param \neon1024\Entity\Character\Character $character
     */
    public function setJunctionTo(Character $character)
    {
        $this->junctionedBy = $character;
    }
    
    /**
     * Find out which character this GF is junctioned to
     *
     * @return \neon1024\Entity\Character\Character
     */
    public function getJunctionedBy(): Character
    {
        return $this->junctionedBy;
    }
}
