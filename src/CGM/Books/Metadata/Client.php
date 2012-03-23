<?php

namespace CGM\Books\Metadata;

/**
 * Interfaces with a metadata service to retrieve and parse metadata queries 
 */
interface Client
{   
    /**
     * Uses the given query to return a set of book metadata that matches the criteria
     * 
     * @param Query $query
     * 
     * @return array
     */
    public function executeQuery(Query $query);
}