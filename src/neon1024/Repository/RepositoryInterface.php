<?php
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
     */
    public function load($file);
    
    /**
     * Get a single item from the collection
     */
    public function getItem($name);
    
    /**
     * Return the whole collection
     */
    public function getCollection();
    
    /**
     * Populate the collection using the loaded xml data
     */
    public function populate();
}
