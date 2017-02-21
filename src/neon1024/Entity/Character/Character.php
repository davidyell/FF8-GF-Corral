<?php
declare(strict_types=1);

/**
 * Character
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace neon1024\Entity\Character;

use neon1024\Entity\Character\CharacterInferface;
use neon1024\Entity\GuardianForce\GuardianForce;

class Character implements CharacterInferface
{
    /**
     * Name of the character
     *
     * @var string
     */
    private $name;
    
    /**
     * Stats which this character can junction
     *
     * @var array
     */
    private $junctionable = [];
    
    /**
     * Store a list of all stats this character has junctioned
     *
     * @var array
     */
    private $junctioned = [];
    
    /**
     * Collection of junctioned Guardian Forces
     *
     * @var array
     */
    private $junctionedGFs = [];
    
    /**
     * Build the character
     *
     * @param \SimpleXMLElement $data
     */
    public function __construct(\SimpleXMLElement $data)
    {
        $this->setName((string)$data->name);
        $this->setJunctionableStats((array)$data->Junctions->junction);
    }

    /**
     * Junction a GF to this character
     *
     * @param GuardianForce $gf
     * @return \neon1024\Entity\Character\Character
     */
    public function junction(GuardianForce $gf): Character
    {
        $this->junctionedGFs = array_merge($this->junctionedGFs, [$gf]);
        $gf->setJunctionTo($this);
        
        foreach ($gf->getJunctions() as $junction) {
            $this->setStatJunctioned($junction);
        }
        
        return $this;
    }
    
    /**
     * Get a list of the Guardian Forces which have been junctioned to this
     * character
     *
     * @return array
     */
    public function getJunctionedGFs(): array
    {
        return $this->junctionedGFs;
    }

    /**
     * Return junctioned stats on this character
     *
     * @return array
     */
    public function getJunctionedStats(): array
    {
        return $this->junctioned;
    }
    
    /**
     * Set a stat as being junctioned
     *
     * @param string $junction
     * @return bool
     */
    protected function setStatJunctioned(string $junction): bool
    {
        if (in_array($junction, $this->junctionable)) {
            $this->junctionable = array_diff($this->junctionable, [$junction]);
            $this->junctioned[] = $junction;
            return true;
        }
        return false;
    }
    
    /**
     * Return the name of the character
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    
    /**
     * Set the name of the character
     *
     * @param string $name
     */
    protected function setName(string $name)
    {
        $this->name = $name;
    }
    
    /**
     * Get the list of the stats this character can junction
     *
     * @return array
     */
    public function getJunctionableStats(): array
    {
        return $this->junctionable;
    }
    
    /**
     * Set the characters junctionable stats
     *
     * @param array $stats
     */
    protected function setJunctionableStats(array $stats)
    {
        $this->junctionable = $stats;
    }
    
    /**
     * How many GFs does this character have junctioned
     *
     * @return int
     */
    public function getNumberOfGFsJunctioned(): int
    {
        return count($this->junctionedGFs);
    }
}
