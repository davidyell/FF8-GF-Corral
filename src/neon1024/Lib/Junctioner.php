<?php

/**
 * Junctioner.php
 *
 * @author David Yell <dyell@ukwebmedia.com>
 * @copyright 2017 UK Web Media Ltd
 */

namespace neon1024\Lib;

use neon1024\Entity\Character\Character;
use neon1024\Entity\GuardianForce\GuardianForce;
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
        'Mag-J',
        'Luck-J',
        'Eva-J',
    ];

    /**
     * @var \neon1024\Repository\Party $party Party of Character instances
     */
    public $party;

    /**
     * @var \neon1024\Repository\Corral $corral Corral of Guardian Force instances
     */
    public $corral;

    /**
     * Junctioner constructor.
     *
     * @param \neon1024\Repository\Party $party Party of Character instances
     * @param \neon1024\Repository\Corral $corral Corral of Guardian Force instances
     * @throws \BadMethodCallException
     */
    public function __construct(Party $party, Corral $corral)
    {
        $this->party = $party;
        $this->corral = $corral;
    }

    /**
     * Automatically junction the available Guardian Forces to the Characters in the Party.
     *
     * @param bool $priority Should GFs be junctioned prioritising the configured stats ordering
     */
    public function autojunction($priority = true)
    {
        $this->sortPartyByLeastJunctions();

        foreach ($this->party->getPartyMembers() as $character) {
            foreach ($this->corral->getCollection() as $gf) {
                if ($gf->getJunctionedBy() === null) {
                    if ($priority) {
                        foreach ($this->statPriority as $stat) {
                            if ($this->characterSharesJunctionStatWithGuardianForce($character, $gf, $stat)
                                && $this->characterStatAlreadyJunctioned($character, $stat) === false) {
                                $character->junction($gf);
                            }
                        }
                    } else {
                        if ($this->characterSharesJunctionStatWithGuardianForce($character, $gf, null)) {
                            $character->junction($gf);
                        }
                    }
                }
            }
        }
    }

    /**
     * Does the Character have a junctionable stat which the Guardian Force also has, but has not already
     * been junctioned
     *
     * Can look for both any stat or a specific stat.
     *
     * @param \neon1024\Entity\Character\Character $character
     * @param \neon1024\Entity\GuardianForce\GuardianForce $guardianForce
     * @param string|null $stat
     *
     * @return bool
     */
    protected function characterSharesJunctionStatWithGuardianForce(
        Character $character,
        GuardianForce $guardianForce,
        ?string $stat
    ): bool {
        $sharesJunctionableStat = array_intersect(
            $character->getJunctionableStats(),
            $guardianForce->getStatJunctions()
        );

        if ($stat !== null && $guardianForce->hasJunction($stat) && !empty($sharesJunctionableStat)) {
            return true;
        }

        return false;
    }

    /**
     * Does a Character already have a specific stat junctioned
     *
     * @param \neon1024\Entity\Character\Character $character
     * @param string $stat
     *
     * @return bool
     */
    protected function characterStatAlreadyJunctioned(Character $character, string $stat): bool
    {
        return in_array($stat, $character->getJunctionedStats());
    }

    /**
     * Create a new Party instance with Characters with the least number of junctions are higher in the ordering.
     *
     * @return void
     */
    protected function sortPartyByLeastJunctions(): void
    {
        $team = $this->party->getPartyMembers();
        usort($team, function (Character $a, Character $b): int {
            return (count($a->getJunctionableStats()) < count($b->getJunctionableStats())) ? 1 : -1;
        });

        $this->party = new Party($team[0], $team[1], $team[2]);
    }
}
