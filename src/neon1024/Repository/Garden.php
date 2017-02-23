<?php
declare(strict_types=1);

/**
 * Garden contains a collection of Characters
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\FF8Corral\Repository;

use neon1024\FF8Corral\Entity\Character\Character;
use neon1024\FF8Corral\Exceptions\InvalidXmlException;
use neon1024\FF8Corral\Exceptions\NotFoundException;

class Garden implements RepositoryInterface
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
            throw new NotFoundException("The file `{$filePath}` could not be found or could not be read.");
        }

        try {
            $this->xml = simplexml_load_file($filePath);
        } catch (\Exception $e) {
            throw new InvalidXmlException("XML file `{$filePath}` is invalid and could not be parsed.");
        }

        foreach ($this->xml->Character as $char) {
            $this->addItem(new Character($char));
        }
    }

    /**
     * Add an item to the Repository
     *
     * @param \neon1024\FF8Corral\Entity\Character\Character $character The item to add to the collection
     * @return \neon1024\FF8Corral\Repository\Garden
     * @throws \BadMethodCallException
     */
    public function addItem($character): Garden
    {
        if (!$character instanceof Character) {
            throw new \BadMethodCallException('Can only add Characters to a Garden.');
        }

        $this->collection[$character->getName()] = $character;

        return $this;
    }

    /**
     * Remove an item from the collection
     *
     * @param string $item Name of the item key to remove
     * @return bool
     * @throws \neon1024\FF8Corral\Exceptions\NotFoundException
     */
    public function removeItem(string $item): bool
    {
        try {
            $this->getItem($item);
            unset($this->collection[$item]);

            return true;
        } catch (NotFoundException $e) {
            throw $e;
        }
    }

    /**
     * Get a single item from the collection
     *
     * @param string $name Item to find in the collection
     * @return \neon1024\FF8Corral\Entity\Character\Character
     * @throws \neon1024\FF8Corral\Exceptions\NotFoundException
     */
    public function getItem(string $name): Character
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
