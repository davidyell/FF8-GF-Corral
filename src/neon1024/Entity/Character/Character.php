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
use neon1024\Repository\Corral;

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
    private $junctionableStats = [];
    
    /**
     * Store a list of all stats this character has junctioned
     *
     * @var array
     */
    private $junctionedStats = [];
    
    /**
     * Collection of junctioned Guardian Force instances, keyed by their name
     *
     * @var \neon1024\Repository\Corral
     */
    private $junctionedGFs;
    
    /**
     * Build the character
     *
     * @param \SimpleXMLElement $data
     */
    public function __construct(\SimpleXMLElement $data)
    {
        $this->setName((string)$data->name);
        $this->setJunctionableStats((array)$data->Junctions->junction);
        $this->junctionedGFs = new Corral();
    }

    /**
     * Junction a GF to this character
     *
     * @param GuardianForce $gf
     * @return \neon1024\Entity\Character\Character
     */
    public function junction(GuardianForce $gf): Character
    {
        $this->junctionedGFs->addItem($gf);
        $gf->junctionTo($this);
        
        foreach ($gf->getStatJunctions() as $junction) {
            $this->setStatJunctioned($junction);
        }
        
        return $this;
    }

    /**
     * Remove a juncitoned Guardian Force from this character
     *
     * @param \neon1024\Entity\GuardianForce\GuardianForce $gf Guardian force to unjunction
     * @return \neon1024\Entity\Character\Character
     */
    public function unjunction(GuardianForce $gf): Character
    {
        $this->junctionedGFs->removeItem($gf->getName());
        $gf->unjunction();

        foreach ($gf->getStatJunctions() as $junction) {
            $this->resetStatJunction($junction);
        }

        return $this;
    }
    
    /**
     * Get a collection of the Guardian Forces which have been junctioned to this character
     *
     * @return array
     */
    public function getJunctionedGFs(): array
    {
        return $this->junctionedGFs->getCollection();
    }

    /**
     * Return junctioned stats on this character
     *
     * @return array
     */
    public function getJunctionedStats(): array
    {
        return $this->junctionedStats;
    }
    
    /**
     * Set a stat as being junctioned
     *
     * @param string $stat Name of the stat to junction
     *
     * @return bool
     */
    protected function setStatJunctioned(string $stat): bool
    {
        if (in_array($stat, $this->junctionableStats)) {
            $this->junctionableStats = array_diff($this->junctionableStats, [$stat]);
            $this->junctionedStats[] = $stat;

            return true;
        }

        return false;
    }

    /**
     * Remove a junctioned stat and allow it to be junctioned again
     *
     * @param string $stat Name of the stat to unjunction
     *
     * @return bool
     */
    protected function resetStatJunction(string $stat): bool
    {
        $key = array_search($stat, $this->junctionedStats);
        if ($key !== false) {
            unset($this->junctionedStats[$key]);
            $this->junctionableStats[] = $stat;

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
    protected function setName(string $name): void
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
        return $this->junctionableStats;
    }
    
    /**
     * Set the characters junctionable stats
     *
     * @param array $stats
     */
    protected function setJunctionableStats(array $stats): void
    {
        $this->junctionableStats = $stats;
    }

    /**
     * How many GFs does this character have junctioned
     *
     * @return int
     */
    public function getNumberOfGFsJunctioned(): int
    {
        return count($this->junctionedGFs->getCollection());
    }
}
