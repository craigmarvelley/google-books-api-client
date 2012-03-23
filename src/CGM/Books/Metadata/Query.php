<?php

namespace CGM\Books\Metadata;

/**
 * Contains query data for a book metadata look-up
 */
class Query 
{
    /**
     * @var array
     */
    private $queryParts = array();
    
    /**
     * @param string $name
     * @param mixed $value 
     */
    public function addQueryPart($name, $value) 
    {
        $this->queryParts[$name] = $value;
    }

    /**
     * @return array
     */
    public function getQueryParts() 
    {
        return $this->queryParts;
    }
}