<?php

namespace CGM\Books\Metadata;

/**
 * Implements common client functionality
 */
abstract class AbstractClient implements Client
{
    /**
     * @var Service
     */
    private $service;
    
    /**
     * @var Parser
     */
    private $parser;
    
    /**
     * Creates a new instance of this class
     * 
     * @param Service $service
     * @param Parser $parser 
     */
    public function __construct(Service $service, Parser $parser) 
    {
        $this->service = $service;
        $this->parser = $parser;
    }
    
    /**
     * @see Client::executeQuery
     * 
     * @param Query $query
     * 
     * @return array
     */
    public function executeQuery(Query $query) 
    {
        $serviceResponse = $this->service->getMetadataForQuery($query);
        
        $parsedResult = $this->parser->parseMetadata($serviceResponse);
        
        return $parsedResult;
    }
}