<?php

/**
 * JunctionerTest.php
 *
 * @author David Yell <neon1024@gmail.com>
 */

namespace tests;

use neon1024\FF8Corral\Entity\Character\Character;
use neon1024\FF8Corral\Lib\Junctioner;
use neon1024\FF8Corral\Repository\Corral;
use neon1024\FF8Corral\Repository\Party;
use PHPUnit\Framework\TestCase;

class JunctionerTest extends TestCase
{
    /**
     * @var \neon1024\FF8Corral\Repository\Party
     */
    public $party;

    /**
     * @var \neon1024\FF8Corral\Repository\Corral
     */
    public $corral;

    protected function setUp()
    {
        parent::setUp();

        $characterData = simplexml_load_file(__DIR__ . '/Fixture/Party.xml');
        $partyMembers = [];
        foreach ($characterData->Character as $character) {
            $partyMembers[] = new Character($character);
        }
        $this->party = new Party($partyMembers[0], $partyMembers[1], $partyMembers[2]);

        $gfXmlFilePath = dirname(__DIR__) . '/src/neon1024/Entity/GuardianForce/GFs.xml';
        $this->corral = new Corral();
        $this->corral->loadFromXmlFile($gfXmlFilePath);
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->party = null;
        $this->corral = null;
    }

    public function testJunctionerConstructor()
    {
        $junctioner = new Junctioner($this->party, $this->corral);

        $this->assertInstanceOf(Party::class, $junctioner->party);
        $this->assertInstanceOf(Corral::class, $junctioner->corral);
    }

    /**
     * @expectedException \TypeError
     */
    public function testJunctionerConstructorWithInvalidClasses()
    {
        $junctioner = new Junctioner('Foo', 'Bar');
    }

    public function testAutojunction()
    {
        $junctioner = new Junctioner($this->party, $this->corral);
        $junctioner->autojunction();
        $junctioner->autojunction(false);

        $this->assertNotEmpty($this->party->getMemberByName('Squall')->getJunctionedGFs());
        $this->assertNotEmpty($this->party->getMemberByName('Rinoa')->getJunctionedGFs());
        $this->assertNotEmpty($this->party->getMemberByName('Quistis')->getJunctionedGFs());

        $this->assertNotEmpty($this->party->getMemberByName('Squall')->getJunctionedStats());
        $this->assertNotEmpty($this->party->getMemberByName('Rinoa')->getJunctionedStats());
        $this->assertNotEmpty($this->party->getMemberByName('Quistis')->getJunctionedStats());
    }
}
