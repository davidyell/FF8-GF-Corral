<?php
/**
 * CorralTest
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace tests;

use neon1024\FF8Corral\Entity\GuardianForce\GuardianForce;
use neon1024\FF8Corral\Repository\Corral;
use PHPUnit\Framework\TestCase;

class CorralTest extends TestCase
{
    /**
     * @var \neon1024\FF8Corral\Repository\Corral
     */
    public $Corral;

    /**
     * @var \neon1024\FF8Corral\Entity\GuardianForce\GuardianForce
     */
    public $GuardianForce;
    
    public function setUp()
    {
        parent::setUp();
        
        $file = __DIR__ . '/Fixture/Quezacotl.xml';
        $gf = simplexml_load_file($file);
        $this->GuardianForce = new GuardianForce($gf->GuardianForce);

        $this->Corral = new Corral();
        $this->Corral->addItem($this->GuardianForce);
    }
    
    /**
     * Test that we can return a specific object from the collection
     */
    public function testGetItem()
    {
        $expected = $this->GuardianForce;
        $result = $this->Corral->getItem('Quezacotl');
        
        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException \neon1024\FF8Corral\Exceptions\NotFoundException
     */
    public function testGetNonExistantItem()
    {
        $this->Corral->getItem('Foo');
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testAddNonGuardianForceItem()
    {
        $this->Corral->addItem(['name' => 'Foo']);
    }

    /**
     * Test that we can return the whole collection
     */
    public function testGetCollection()
    {
        $result = $this->Corral->getCollection();
        
        $this->assertNotEmpty($result);
    }

    public function testRemoveAnItem()
    {
        $this->assertNotEmpty($this->Corral->getCollection());
        $this->Corral->removeItem('Quezacotl');
        $this->assertEmpty($this->Corral->getCollection());
    }

    /**
     * @expectedException \neon1024\FF8Corral\Exceptions\NotFoundException
     */
    public function testRemovingNonExistantItem()
    {
        $this->assertNotEmpty($this->Corral->getCollection());
        $this->Corral->removeItem('Foo');
    }

    public function testBuildCorralFromXml()
    {
        $file = __DIR__ . '/Fixture/Quezacotl.xml';
        $corral = new Corral();
        $corral->loadFromXmlFile($file);

        $this->assertNotEmpty($corral->getCollection());
        $this->assertEquals($this->GuardianForce, $corral->getItem('Quezacotl'));
    }

    /**
     * @expectedException \neon1024\FF8Corral\Exceptions\NotFoundException
     */
    public function testBuildGardenFromXmlWithNoFile()
    {
        $file = __DIR__ . '/Fixture/Typo.xml';
        $corral = new Corral();
        $corral->loadFromXmlFile($file);
    }

    /**
     * @expectedException \neon1024\FF8Corral\Exceptions\InvalidXmlException
     */
    public function testBuildGardenFromXmlWithInvalidFile()
    {
        $file = __DIR__ . '/Fixture/Invalid.xml';
        $corral = new Corral();
        $corral->loadFromXmlFile($file);
    }
}
