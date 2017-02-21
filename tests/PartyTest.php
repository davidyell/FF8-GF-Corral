<?php

/**
 * PartyTest.php
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace tests;

use neon1024\Entity\Character\Character;
use neon1024\Repository\Party;
use PHPUnit\Framework\TestCase;

class PartyTest extends TestCase
{
    public function testConstructor()
    {
        $characterData = simplexml_load_file(__DIR__ . '/Fixture/Party.xml');

        $partyMembers = [];
        foreach ($characterData->Character as $character) {
            $partyMembers[] = new Character($character);
        }

        $party = new Party($partyMembers[0], $partyMembers[1], $partyMembers[2]);

        $this->assertNotEmpty($party->getPartyMembers());
    }

    /**
     * @expectedException \neon1024\Exceptions\CharacterAlreadyInPartyException
     */
    public function testConstructorWithDuplicateCharacter()
    {
        $characterData = simplexml_load_file(__DIR__ . '/Fixture/Squall.xml');
        $character = new Character($characterData->Character);

        $party = new Party($character, $character, $character);

        $this->assertNotEmpty($party->getPartyMembers());
    }
}
