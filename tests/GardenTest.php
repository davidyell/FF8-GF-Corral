<?php
/**
 * GardenTest
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace tests;

use neon1024\FF8Corral\Entity\Character\Character;
use neon1024\FF8Corral\Repository\Garden;
use PHPUnit\Framework\TestCase;

class GardenTest extends TestCase
{
    /**
     * @var \neon1024\FF8Corral\Repository\Garden
     */
    public $Garden;

    /**
     * @var \neon1024\FF8Corral\Entity\Character\Character
     */
    public $Character;
    
    public function setUp()
    {
        parent::setUp();
        
        $file = __DIR__ . '/Fixture/Squall.xml';
        $character = simplexml_load_file($file);
        $this->Character = new Character($character->Character);

        $this->Garden = new Garden();
        $this->Garden->addItem($this->Character);
    }
    
    /**
     * Test that we can return a specific object from the collection
     */
    public function testGetItem()
    {
        $expected = $this->Character;
        $result = $this->Garden->getItem('Squall');
        
        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException \neon1024\FF8Corral\Exceptions\NotFoundException
     */
    public function testGetNonExistantItem()
    {
        $this->Garden->getItem('Foo');
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testAddNonCharacterItem()
    {
        $this->Garden->addItem(['name' => 'Foo']);
    }

    /**
     * Test that we can return the whole collection
     */
    public function testGetCollection()
    {
        $result = $this->Garden->getCollection();
        
        $this->assertNotEmpty($result);
    }

    public function testRemoveAnItem()
    {
        $this->assertNotEmpty($this->Garden->getCollection());
        $this->Garden->removeItem('Squall');
        $this->assertEmpty($this->Garden->getCollection());
    }

    /**
     * @expectedException \neon1024\FF8Corral\Exceptions\NotFoundException
     */
    public function testRemovingNonExistantItem()
    {
        $this->assertNotEmpty($this->Garden->getCollection());
        $this->Garden->removeItem('Foo');
    }

    public function testBuildGardenFromXml()
    {
        $file = __DIR__ . '/Fixture/Squall.xml';
        $garden = new Garden();
        $garden->loadFromXmlFile($file);

        $this->assertNotEmpty($garden->getCollection());
        $this->assertEquals($this->Character, $garden->getItem('Squall'));
    }

    /**
     * @expectedException \neon1024\FF8Corral\Exceptions\NotFoundException
     */
    public function testBuildGardenFromXmlWithNoFile()
    {
        $file = __DIR__ . '/Fixture/Typo.xml';
        $garden = new Garden();
        $garden->loadFromXmlFile($file);
    }

    /**
     * @expectedException \neon1024\FF8Corral\Exceptions\InvalidXmlException
     */
    public function testBuildGardenFromXmlWithInvalidFile()
    {
        $file = __DIR__ . '/Fixture/Invalid.xml';
        $garden = new Garden();
        $garden->loadFromXmlFile($file);
    }
}
