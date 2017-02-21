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
     * @return bool
     * @throws \Exception When the file is not found or cannot be loaded
     */
    public function load(string $filePath): bool;
    
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
    
    /**
     * Populate the collection using the loaded xml data
     */
    public function populate();
}
