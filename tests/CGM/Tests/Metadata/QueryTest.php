<?php

namespace CGM\Tests\Books\Metadata;

use CGM\Books\Metadata\Query;

require_once 'tests/bootstrap.php';

class QueryTest extends \PHPUnit_Framework_TestCase 
{
    public function testQueryPartsAreInitiallyEmpty()
    {
        $query = new Query;
        
        $parts = $query->getQueryParts();
        
        $this->assertTrue(empty($parts));
    }

    public function testCanAddQueryParts() 
    {
        $query = new Query;
        
        $query->addQueryPart('foo', 'bar');
        
        $parts = $query->getQueryParts();
        
        $this->assertEquals(1, count($parts));
        $this->assertArrayHasKey('foo', $parts);
        $this->assertEquals($parts['foo'], 'bar');
    }
}