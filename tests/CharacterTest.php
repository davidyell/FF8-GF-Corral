<?php
/**
 * CharacterTest
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace tests;

use \neon1024\Entity\Character\Character;
use \neon1024\Entity\GuardianForce\GuardianForce;

class CharacterTest extends \PHPUnit_Framework_TestCase {
	
	public $Character;
	public $GuardianForce;
	
	protected function setUp() {
		parent::setUp();
		
		$characterData = simplexml_load_file(__DIR__ . '/Fixture/Squall.xml');
		$this->Character = new Character($characterData->Character);
		
		$gfData = simplexml_load_file(__DIR__ . '/Fixture/Quezacotl.xml');
		$this->GuardianForce = new GuardianForce($gfData->GuardianForce);
	}

	protected function tearDown() {
		parent::tearDown();
		unset($this->Character);
		unset($this->GuardianForce);
	}

	/**
	 * Ensure that a character can properly junction a GF
	 */
	public function testCanJunction() {
		$this->Character->junction($this->GuardianForce);
		
		$this->assertNotEmpty($this->Character->getJunctionedStats(), 'No stats have been junctioned');
		$this->assertNotEmpty($this->Character->getJunctionedGFs(), 'No GF has been junctioned');
	}
	
	/**
	 * Test if the character knows their own name
	 */
	public function testHasName() {
		$expected = 'Squall';
		$result = $this->Character->getName();
		
		$this->assertEquals($expected, $result);
	}
	
	/**
	 * Ensure that a character has some stats which can be junctioned
	 */
	public function testHasJunctionableStats() {
		$expected = ['HP-J', 'Str-J', 'Vit-J', 'Mag-J', 'Spr-J', 'Spd-J', 'Eva-J', 'Hit-J', 'Luck-J'];
		$result = $this->Character->getJunctionableStats();
		
		$this->assertEquals($expected, $result);
	}
}
