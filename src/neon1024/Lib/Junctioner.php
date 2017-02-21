<?php

/**
 * Junctioner.php
 *
 * @author David Yell <dyell@ukwebmedia.com>
 * @copyright 2017 UK Web Media Ltd
 */

namespace neon1024\Lib;

use neon1024\Entity\Character\Character;
use neon1024\Repository\Corral;
use neon1024\Repository\Party;

class Junctioner
{
    /**
     * In which order should the stats be junctioned
     *
     * @var array
     */
    public $statPriority = [
        'Spd-J',
        'HP-J',
        'Str-J',
        'Vit-J',
        'Spr-J',
        'Mag-J'
    ];

    /**
     * Junction a Corral of Guardian Forces to a Party of Characters
     *
     * @param \neon1024\Repository\Party $party Party of Character instances
     * @param \neon1024\Repository\Corral $corral Corral of Guardian Force instances
     *
     * @return array Array of resulting party and corral
     */
    public function party(Party $party, Corral $corral)
    {
        /**
         * First parse
         * Basic matching with no overlapping using the priority order
         */
        foreach ($party->getPartyMembers() as $character) {
            foreach ($corral->getCollection() as $gf) {
                if (!$gf->getJunctionedBy()) {
                    foreach ($this->statPriority as $stat) {
                        // Find stats this character has already junctioned, which this GF can junction
                        // To eliminate the GF allowing prioritised junctioning
                        $intersection = array_intersect($character->getJunctionedStats(), $gf->getStatJunctions());
                        if (empty($intersection)) {
                            // GF has the stat available to junction
                            $intersection = array_intersect($character->getJunctionableStats(), $gf->getStatJunctions());
                            if ($gf->hasJunction($stat) && !empty($intersection)) {
                                $character->junction($gf);
                            }
                        }
                    }
                }
            }
        }

        /**
         * Second parse
         * Match up characters without a full set of junctions first
         */
        $team = $party->getPartyMembers();
        usort($team, [$this, 'sortByJunctionable']);

        foreach ($team as $character) {
            foreach ($corral->getCollection() as $gf) {
                if (!$gf->getJunctionedBy()) {
                    $intersection = array_intersect($character->getJunctionableStats(), $gf->getStatJunctions());
                    if (!empty($intersection)) {
                        $character->junction($gf);
                    }
                }
            }
        }

        return [
            'party' => $party,
            'corral' => $corral
        ];
    }

    /**
     * Sort characters by the number of available junctions
     *
     * @param \neon1024\Entity\Character\Character $a
     * @param \neon1024\Entity\Character\Character $b
     * @return int
     */
    private function sortByJunctionable(Character $a, Character $b): int
    {
        return (count($a->getJunctionableStats()) < count($b->getJunctionableStats())) ? 1 : -1;
    }

}