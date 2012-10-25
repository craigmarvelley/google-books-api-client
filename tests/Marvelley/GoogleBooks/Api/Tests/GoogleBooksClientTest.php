<?php

namespace Marvelley\GoogleBooks\Api\Tests;

use Marvelley\GoogleBooks\Api\GoogleBooksApiClient;
use Guzzle\Service\Builder\ServiceBuilder;
use Guzzle\Tests\GuzzleTestCase;

class GoogleBooksApiClientTest extends GuzzleTestCase
{
    public function testFactoryCreatesClient()
    {
        $client = GoogleBooksApiClient::factory(array('base_url' => 'https://www.googleapis.com'));
        
        $this->assertInstanceOf('Marvelley\GoogleBooks\Api\GoogleBooksApiClient', $client);
        $this->assertEquals('https://www.googleapis.com', $client->getBaseUrl());
    }
    
    public function testGetVolumeCommandReturnsVolumeData()
    {
        $client = GoogleBooksApiClient::factory(array('base_url' => 'https://www.googleapis.com'));
        $command = $client->getCommand('GetVolume', array('id' => 'zyTCAlFPjgYC'));
        
        $responseModel = $client->execute($command);
        $data = $responseModel->toArray();
        
        $this->assertEquals('zyTCAlFPjgYC', $data['id']);
        $this->assertInternalType('array', $data['volumeInfo']);
        $this->assertEquals('The Google Story', $data['volumeInfo']['title']);
        $this->assertEquals('The Google Story', $data['volumeInfo']['title']);
        $this->assertEquals('9780553804577', $data['volumeInfo']['industryIdentifiers'][1]['identifier']);
    }
    
    public function testGetMetadataMatchingISBNCommandReturnsVolumeData()
    {
        $client = GoogleBooksApiClient::factory(array('base_url' => 'https://www.googleapis.com'));
        $command = $client->getCommand('GetVolumesByIsbn', array('isbn' => '9780553804577'));
        
        $responseModel = $client->execute($command);
        $data = $responseModel->toArray();
        
        $this->assertInternalType('array', $data);
        $this->assertArrayHasKey('items', $data);
        $this->assertEquals(1, $data['totalItems']);
        $this->assertEquals('The Google story', $data['items'][0]['volumeInfo']['title']);
    }
}
