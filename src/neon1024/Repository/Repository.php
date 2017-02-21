<?php
declare(strict_types=1);

/**
 * Repository
 *
 * @author David Yell <neon1024@gmail.com>
 */
namespace neon1024\Repository;

use \Exception;
use SimpleXMLElement;

abstract class Repository implements RepositoryInterface
{
    /**
     * Store the XML file data
     *
     * @var SimpleXMLElement
     */
    protected $xml = null;
    
    /**
     * Collection of Guardian Forces
     *
     * @var array
     */
    protected $collection = [];
    
    /**
     * Load an xml file
     *
     * @param string $filePath The file to load
     * @return bool
     * @throws \Exception
     */
    public function load(string $filePath): bool
    {
        if (file_exists($filePath)) {
            $xmlFile = file_get_contents($filePath);
            $this->xml = simplexml_load_string($xmlFile);
            
            return true;
        } else {
            throw new Exception('No data found');
        }
    }
    
    /**
     * Get a specific item from the collection
     *
     * @param string $name
     * @return object
     */
    public function getItem(string $name)
    {
        return $this->collection[$name];
    }
    
    /**
     * Return a list of all the loaded objects
     *
     * @return array
     */
    public function getCollection(): array
    {
        return $this->collection;
    }
    
    /**
     * Load objects into the collection
     */
    abstract public function populate();
}
