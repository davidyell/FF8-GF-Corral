<?php
declare(strict_types=1);

/**
 * Corral contains a collection of GuardianForces
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\FF8Corral\Repository;

use neon1024\FF8Corral\Entity\GuardianForce\GuardianForce;
use neon1024\FF8Corral\Exceptions\InvalidXmlException;
use neon1024\FF8Corral\Exceptions\NotFoundException;

class Corral implements RepositoryInterface
{
    /**
     * @var \SimpleXMLElement $xml Loaded xml file
     */
    private $xml;

    /**
     * @var array Collection of items
     */
    private $collection = [];

    /**
     * Load an XML file
     *
     * @param string $filePath Path to the XML file to load
     * @return void
     * @throws \neon1024\FF8Corral\Exceptions\NotFoundException When the file is not found
     * @throws \neon1024\FF8Corral\Exceptions\InvalidXmlException When the xml cannot be loaded
     */
    public function loadFromXmlFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new NotFoundException("The file `{$filePath}` could not be found.");
        }

        try {
            $this->xml = simplexml_load_file($filePath);
        } catch (\Exception $e) {
            throw new InvalidXmlException("The XML file `{$filePath}` could not be loaded.");
        }

        foreach ($this->xml->GuardianForce as $gf) {
            $this->addItem(new GuardianForce($gf));
        }
    }

    /**
     * Add an item to the Repository
     *
     * @param \neon1024\FF8Corral\Entity\GuardianForce\GuardianForce $gf The item to add to the collection
     * @return Corral
     */
    public function addItem($gf): Corral
    {
        if (!$gf instanceof GuardianForce) {
            throw new \BadMethodCallException('Can only add Guardian Forces to a Corral.');
        }

        $this->collection[$gf->getName()] = $gf;

        return $this;
    }

    /**
     * Remove an item from the collection
     *
     * @param string $gf Name of the item key to remove
     * @return bool
     * @throws \neon1024\FF8Corral\Exceptions\NotFoundException When the item isn't in the collection
     */
    public function removeItem(string $gf): bool
    {
        try {
            $this->getItem($gf);
            unset($this->collection[$gf]);

            return true;
        } catch (NotFoundException $e) {
            throw $e;
        }
    }

    /**
     * Get a single item from the collection
     *
     * @param string $name Item to find in the collection
     * @return \neon1024\FF8Corral\Entity\GuardianForce\GuardianForce
     * @throws \neon1024\FF8Corral\Exceptions\NotFoundException When the item isn't in the collection
     */
    public function getItem(string $name): GuardianForce
    {
        if (!isset($this->collection[$name])) {
            throw new NotFoundException("The item `{$name}` is not in the collection.");
        }

        return $this->collection[$name];
    }

    /**
     * Return the whole collection
     *
     * @return array
     */
    public function getCollection(): array
    {
        return $this->collection;
    }
}
