<?php

namespace CGM\Books\Google;

use CGM\Books\Metadata\Service as ServiceInterface;
use CGM\Books\Metadata\Query;
use CGM\Books\Metadata\Service\Exception as ServiceException;

class Service implements ServiceInterface 
{
    /**
     * Base URL to the service
     *
     * @var string
     */
    private $serviceUrl;
    
    /**
     * Creates a new instance of this class
     * 
     * @var string $serviceURL
     */
    public function __construct($serviceUrl) 
    {
        $this->serviceUrl = $serviceUrl;
    }
    
    /**
     * Queries the service for metadata matching the given query, returning a JSON string.
     * 
     * @param Query $query 
     * 
     * @return string
     */
    public function getMetadataForQuery(Query $query) 
    {
        $queryURL = $this->getQueryURL($query);
        
        return $this->execute($queryURL);
    }
    
    /**
     * @param Query $query 
     */
    private function getQueryURL(Query $query) 
    {
        $url = $this->serviceUrl;
        $parts = $query->getQueryParts();
        
        foreach($parts as $key => $value) {
            $url .= urlencode("{$key}:{$value}");
        }
        
        return $url;
    }
    
    /**
     * @param string $queryUrl
     * 
     * @return array
     * 
     * @throws ServiceException if unable to retrieve metadata
     */
    private function execute($queryUrl) 
    {
        $response = $this->makeRequest($queryUrl);
        
        if(! $response) {
            throw new ServiceException("Unable to retrieve metadata");
        }
        
        return $response;
    }
    
    /**
     * @param string $queryUrl
     * 
     * @return string
     */
    private function makeRequest($queryUrl) 
    {
        return file_get_contents($queryUrl);
    }
}