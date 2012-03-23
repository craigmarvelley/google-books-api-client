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
    private $baseUrl;
    
    /**
     * Creates a new instance of this class
     * 
     * @var string $serviceURL
     */
    public function __construct($baseUrl) 
    {
        $this->baseUrl = $baseUrl;
    }
    
    /**
     * Queries the service for data relating to the given volume
     * 
     * @param string $id 
     */
    public function getMetadataForVolumeId($id)
    {
        $url = $this->getVolumeUrl($id);
        
        return $this->execute($url);
    }
    
    /**
     * @param string $id
     * 
     * @return string 
     */
    private function getVolumeUrl($id)
    {
        $volumeUrl = $this->baseUrl . '/' . $id;
        
        return $volumeUrl;
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
        $url = $this->getQueryUrl($query);
        
        return $this->execute($url);
    }
    
    /**
     * @param Query $query 
     */
    private function getQueryUrl(Query $query) 
    {
        $url = $this->baseUrl . '?q=';
        
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