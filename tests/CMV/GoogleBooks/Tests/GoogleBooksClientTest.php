<?php

namespace CMV\GoogleBooks\Tests;

use CMV\GoogleBooks\GoogleBooksClient;
use Guzzle\Service\Builder\ServiceBuilder;

class GoogleBooksClientTest extends \Guzzle\Tests\GuzzleTestCase
{
    public function testFactoryCreatesClient()
    {
        $client = GoogleBooksClient::factory(array('base_url' => 'https://www.googleapis.com'));
        
        $this->assertInstanceOf('CMV\GoogleBooks\GoogleBooksClient', $client);
        $this->assertEquals('https://www.googleapis.com', $client->getBaseUrl());
    }
    
    public function testGetVolumeCommandReturnsVolumeData()
    {
        $client = GoogleBooksClient::factory(array('base_url' => 'https://www.googleapis.com'));
        $command = $client->getCommand('get_volume', array('id' => 'zyTCAlFPjgYC'));
        
        $response = $client->execute($command);
        
        $this->assertInternalType('array', $response);
    }
    
    public function testGetMetadataMatchingISBNCommandReturnsVolumeData()
    {
        $client = GoogleBooksClient::factory(array('base_url' => 'https://www.googleapis.com'));
        $command = $client->getCommand('get_metadata_matching_isbn', array('isbn' => '9780553804577'));
        
        $response = $client->execute($command);
        
        $this->assertInternalType('array', $response);
    }
}
