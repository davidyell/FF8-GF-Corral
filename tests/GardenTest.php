<?php
/**
 * GardenTest
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace tests;

use neon1024\Entity\Character\Garden;
use neon1024\Entity\Character\Character;

class GardenTest extends \PHPUnit_Framework_TestCase {
	
	public $Garden;
	public $Character;
	
	public function setUp() {
		parent::setUp();
		
		$file = __DIR__ . '/Fixture/Squall.xml';
		$this->Garden = new Garden($file);
		
		$character = simplexml_load_file($file);
		$this->Character = new Character($character->Character);
	}

	/**
	 * Test that the collection can be populated
	 */
	public function testCanPopulateCollection() {
		$this->Garden->populate();
		
		$this->assertNotEmpty($this->Garden->getCollection());
	}
	
	/**
	 * Test that we can return a specific object from the collection
	 */
	public function testGetItem() {
		$expected = $this->Character;
		$result = $this->Garden->getItem('Squall');
		
		$this->assertEquals($expected, $result);
	}
	
	/**
	 * Test that we can return the whole collection
	 */
	public function testGetCollection() {
		$result = $this->Garden->getCollection();
		
		$this->assertNotEmpty($result);
	}
}

