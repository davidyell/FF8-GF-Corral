<?php
/**
 * GuardianForceTest
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace tests;

use neon1024\Entity\GuardianForce\GuardianForce;
use neon1024\Entity\Character\Character;
use PHPUnit\Framework\TestCase;

class GuardianForceTest extends TestCase
{
    
    public $GuardianForce;
    
    protected function setUp()
    {
        parent::setUp();
        
        $gfData = simplexml_load_file(__DIR__ . '/Fixture/Quezacotl.xml');
        $this->GuardianForce = new GuardianForce($gfData->GuardianForce);
    }

    protected function tearDown()
    {
        parent::tearDown();
        
        unset($this->GuardianForce);
    }

    /**
     * Make sure the GF knows it's own name
     */
    public function testHasName()
    {
        $expected = 'Quezacotl';
        $result = $this->GuardianForce->getName();
        
        $this->assertEquals($expected, $result);
    }
    
    /**
     * Make sure the GF knows it's element
     */
    public function testHasElement()
    {
        $expected = 'Lightning';
        $result = $this->GuardianForce->getElement();
        
        $this->assertEquals($expected, $result);
    }
    
    /**
     * Test that the GF has some junctions
     */
    public function testHasJunctions()
    {
        $expected = ['HP-J', 'Vit-J', 'Mag-J', 'Elem-Atk-J', 'Elem-Def-J', 'Elem-Def-Jx2'];
        $result = $this->GuardianForce->getStatJunctions();
        
        $this->assertEquals($expected, $result);
    }
    
    /**
     * Provides a number of junctions for testing
     *
     * @return array
     */
    public function providerJunctions()
    {
        return [
            ['HP-J', true],
            ['Vit-J', true],
            ['Spr-J', false],
        ];
    }
    
    /**
     * Test if a specific junction can be found
     *
     * @dataProvider providerJunctions
     */
    public function testHasAJunction($junction, $expected)
    {
        $result = $this->GuardianForce->hasJunction($junction);
        
        $this->assertEquals($expected, $result);
    }

    /**
     * Ensure that the -J is appended
     */
    public function testHasAJunctionWithoutJ()
    {
        $result = $this->GuardianForce->hasJunction('Vit');

        $this->assertEquals(true, $result);
    }

    /**
     * Test that we can add a junction to the GF
     */
    public function testCanAddJunction()
    {
        $this->GuardianForce->addJunction('Spr-J');
        
        $this->assertContains('Spr-J', $this->GuardianForce->getStatJunctions());
    }
    
    /**
     * Make sure that the GF can be junctioned to a character
     */
    public function testJunctionToACharacter()
    {
        $charData = simplexml_load_file(__DIR__ . '/Fixture/Squall.xml');
        $character = new Character($charData->Character);
        $this->GuardianForce->junctionTo($character);
        
        $this->assertNotEmpty($this->GuardianForce->getJunctionedBy());
    }

    public function testHasAbilities()
    {
        $expected = ['Card'];
        $result = $this->GuardianForce->getAbilities();

        $this->assertEquals($expected, $result);
    }
}
