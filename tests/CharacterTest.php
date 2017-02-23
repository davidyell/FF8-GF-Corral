<?php
/**
 * CharacterTest
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace tests;

use \neon1024\FF8Corral\Entity\Character\Character;
use \neon1024\FF8Corral\Entity\GuardianForce\GuardianForce;
use \PHPUnit\Framework\TestCase;

class CharacterTest extends TestCase
{
    /**
     * @var \neon1024\FF8Corral\Entity\Character\Character
     */
    public $Character;

    /**
     * @var \neon1024\FF8Corral\Entity\GuardianForce\GuardianForce
     */
    public $GuardianForce;
    
    protected function setUp()
    {
        parent::setUp();
        
        $characterData = simplexml_load_file(__DIR__ . '/Fixture/Squall.xml');
        $this->Character = new Character($characterData->Character);
        
        $gfData = simplexml_load_file(__DIR__ . '/Fixture/Quezacotl.xml');
        $this->GuardianForce = new GuardianForce($gfData->GuardianForce);
    }

    protected function tearDown()
    {
        parent::tearDown();
        unset($this->Character);
        unset($this->GuardianForce);
    }

    public function testConstructor()
    {
        $this->assertEquals('Squall', $this->Character->getName());
        
        $expectedStatJunctions = [
            'HP-J',
            'Str-J',
            'Vit-J',
            'Mag-J',
            'Spr-J',
            'Spd-J',
            'Eva-J',
            'Hit-J',
            'Luck-J',
        ];
        $this->assertEquals($expectedStatJunctions, $this->Character->getJunctionableStats());
    }

    /**
     * Ensure that a character can properly junction a GF
     */
    public function testCanJunction()
    {
        $this->Character->junction($this->GuardianForce);
        
        $this->assertNotEmpty($this->Character->getJunctionedStats(), 'No stats have been junctioned');
        $this->assertNotEmpty($this->Character->getJunctionedGFs(), 'No GF has been junctioned');
    }
    
    /**
     * Test if the character knows their own name
     */
    public function testHasName()
    {
        $expected = 'Squall';
        $result = $this->Character->getName();
        
        $this->assertEquals($expected, $result);
    }
    
    /**
     * Ensure that a character has some stats which can be junctioned
     */
    public function testHasJunctionableStats()
    {
        $expected = ['HP-J', 'Str-J', 'Vit-J', 'Mag-J', 'Spr-J', 'Spd-J', 'Eva-J', 'Hit-J', 'Luck-J'];
        $result = $this->Character->getJunctionableStats();
        
        $this->assertEquals($expected, $result);
    }

    /**
     * Make sure we can find out how many GF's are already junctioned
     */
    public function testHowManyGfsJunctioned()
    {
        $this->Character->junction($this->GuardianForce);

        $expected = 1;
        $result = $this->Character->getNumberOfGFsJunctioned();

        $this->assertEquals($expected, $result);
    }

    public function testUnjunctioningGf()
    {
        $this->Character->junction($this->GuardianForce);
        $this->assertEquals(['HP-J', 'Vit-J', 'Mag-J'], $this->Character->getJunctionedStats());
        $this->assertNotEmpty($this->Character->getJunctionedStats(), 'No stats have been junctioned');
        $this->assertArrayHasKey('Quezacotl', $this->Character->getJunctionedGFs());
        $this->assertNotEmpty($this->Character->getJunctionedGFs(), 'No GF has been junctioned');

        $this->Character->unjunction($this->GuardianForce);

        $this->assertEmpty($this->Character->getJunctionedStats());
        $this->assertEmpty($this->Character->getJunctionedGFs());
    }
}
