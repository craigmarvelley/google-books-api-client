<?php

namespace CGM\Books\Metadata;

/**
 * A class that is able to parse the response from a metadata query into a defined object representation
 */
interface Parser 
{
    /**
     * @param mixed $metadata
     * 
     * @return array
     */
    public function parseMetadata($metadata);
    
}