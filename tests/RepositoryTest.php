<?php
/**
 * RepositoryTest
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace tests;

class RepositoryTest extends \PHPUnit_Framework_Testcase {
	
	public $Repository;
	
	protected function setUp() {
		parent::setUp();
		
		$this->Repository = $this->getMockForAbstractClass('neon1024\Repository\Repository');
	}

	protected function tearDown() {
		parent::tearDown();
		unset($this->Repository);
	}

	/**
	 * Test that an xml file can be loaded
	 */
	public function testLoadFile() {
		$file = __DIR__ . '/Fixture/Squall.xml';
		$result = $this->Repository->load($file);
		$expected = true;
		
		$this->assertEquals($expected, $result);
	}
	
	/**
	 * Test that a bad file throws an exception
	 * 
	 * @expectedException Exception
	 */
	public function testBadFileLoad() {
		$file = 'badfile.xml';
		$result = $this->Repository->load($file);
		$expected = false;
		
		$this->assertEquals($expected, $result);
	}
}