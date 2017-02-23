<?php

/**
 * PartyTest.php
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace tests;

use neon1024\FF8Corral\Entity\Character\Character;
use neon1024\FF8Corral\Repository\Party;
use PHPUnit\Framework\TestCase;

class PartyTest extends TestCase
{
    /**
     * Setup a complete party for testing
     *
     * @return \neon1024\FF8Corral\Repository\Party
     */
    private function setupParty(): Party
    {
        $characterData = simplexml_load_file(__DIR__ . '/Fixture/Party.xml');

        $partyMembers = [];
        foreach ($characterData->Character as $character) {
            $partyMembers[] = new Character($character);
        }

        $party = new Party($partyMembers[0], $partyMembers[1], $partyMembers[2]);

        return $party;
    }

    public function testConstructor()
    {
        $party = $this->setupParty();
        $this->assertNotEmpty($party->getPartyMembers());
    }

    /**
     * @expectedException \neon1024\FF8Corral\Exceptions\CharacterAlreadyInPartyException
     */
    public function testConstructorWithDuplicateCharacter()
    {
        $characterData = simplexml_load_file(__DIR__ . '/Fixture/Squall.xml');
        $character = new Character($characterData->Character);

        $party = new Party($character, $character, $character);

        $this->assertNotEmpty($party->getPartyMembers());
    }

    public function testGetMemberByName()
    {
        $party = $this->setupParty();
        $this->assertInstanceOf(Character::class, $party->getMemberByName('Squall'));
        $this->assertEquals('Squall', $party->getMemberByName('Squall')->getName());
    }

    /**
     * @expectedException \neon1024\FF8Corral\Exceptions\NotFoundException
     */
    public function testGetMemberByNameWithInvalidName()
    {
        $party = $this->setupParty();
        $party->getMemberByName('foo');
    }
}
