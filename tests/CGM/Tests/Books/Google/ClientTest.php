<?php

namespace CGM\Tests\Books\Google;

use CGM\Books\Google\Client;

require_once 'tests/bootstrap.php';

class ClientTest extends \PHPUnit_Framework_TestCase 
{
    public function testCanExecuteQueries() 
    {
        $query = $this->getMock('CGM\Books\Metadata\Query');
        $response = array(1, 2, 3);
        $metadata = array(4, 5, 6);
        
        $service = $this->getMock('CGM\Books\Metadata\Service');
        
        $service
            ->expects($this->once())
            ->method('getMetadataForQuery')
            ->with($query)
            ->will($this->returnValue($response))
        ;
        
        $parser = $this->getMock('CGM\Books\Metadata\Parser');
        
        $parser
            ->expects($this->once())
            ->method('parseMetadata')
            ->with($response)
            ->will($this->returnValue($metadata))
        ;
        
        $client = new Client($service, $parser);
        
        $result = $client->executeQuery($query);
        
        $this->assertSame($metadata, $result);
    }
}