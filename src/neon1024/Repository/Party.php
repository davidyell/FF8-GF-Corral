<?php
declare(strict_types=1);

/**
 * Party contains the three characters currently in the party
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Repository;

use neon1024\Entity\Character\Character;
use neon1024\Exceptions\CharacterAlreadyInPartyException;
use neon1024\Exceptions\NotFoundException;

class Party
{
    /**
     * @var array Collection of items
     */
    private $partyMembers = [];

    /**
     * Party constructor.
     *
     * @param \neon1024\Entity\Character\Character $first
     * @param \neon1024\Entity\Character\Character $second
     * @param \neon1024\Entity\Character\Character $third
     */
    public function __construct(Character $first, Character $second, Character $third)
    {
        $this->addCharacter($first)
            ->addCharacter($second)
            ->addCharacter($third);
    }

    /**
     * Return an array of the party character instances
     *
     * @return array
     */
    public function getPartyMembers(): array
    {
        return $this->partyMembers;
    }

    /**
     * Get a specific Character from the Party
     *
     * @param string $name
     * @return \neon1024\Entity\Character\Character
     * @throws \neon1024\Exceptions\NotFoundException
     */
    public function getMemberByName(string $name): Character
    {
        if (isset($this->partyMembers[$name])) {
            return $this->partyMembers[$name];
        }

        throw new NotFoundException("A character named `{$name}` isn't in the party.");
    }

    /**
     * Add a character to the party
     *
     * @param \neon1024\Entity\Character\Character $character Character instance to add to the party
     * @return \neon1024\Repository\Party
     * @throws \neon1024\Exceptions\CharacterAlreadyInPartyException
     */
    public function addCharacter(Character $character): Party
    {
        if (isset($this->partyMembers[$character->getName()])) {
            throw new CharacterAlreadyInPartyException("{$character->getName()} is already a member of this party.");
        }

        $this->partyMembers[$character->getName()] = $character;

        return $this;
    }
}
