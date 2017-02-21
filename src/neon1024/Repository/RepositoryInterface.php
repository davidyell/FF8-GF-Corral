<?php
declare(strict_types=1);

/**
 * RepositoryInterface
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Repository;

interface RepositoryInterface
{
    /**
     * Load an XML file
     *
     * @param string $filePath Path to the XML file to load
     * @return void
     * @throws \neon1024\Exceptions\NotFoundException When the file is not found
     * @throws \neon1024\Exceptions\InvalidXmlException When the xml cannot be loaded
     */
    public function loadFromXmlFile(string $filePath): void;

    /**
     * Add an item to the Repository
     *
     * @param mixed $item The item to add to the collection
     * @return RepositoryInterface
     */
    public function addItem($item);

    /**
     * Remove an item from the collection
     *
     * @param string $item Name of the item key to remove
     * @return bool
     */
    public function removeItem(string $item): bool;

    /**
     * Get a single item from the collection
     *
     * @param string $name Item to find in the collection
     * @return object
     */
    public function getItem(string $name);
    
    /**
     * Return the whole collection
     *
     * @return array
     */
    public function getCollection(): array;
}
