<?php

namespace CGM\Books\Google;

use CGM\Books\Metadata\Parser as ParserInterface;
use CGM\Books\Metadata\Item;
use \stdClass;
use \DateTime;

/**
 * Parses the JSON response from a Google Books API request
 */
class Parser implements ParserInterface 
{   
    /**
     * Converts a JSON response from the Google Books service into one or more metadata objects, depending on the
     * request
     *
     * @param string $metadata
     * 
     * @return mixed
     */
    public function parseMetadata($metadata) 
    {
        $data = json_decode($metadata);
        
        if(! $data instanceof stdClass) {
            return null;
        }
        
        $kind = $data->kind;
        
        if($kind == 'books#volumes') {
            return $this->parseMultiVolumeData($data);
        }
        
        return $this->parseSingleVolumeData($data);
    }
    
    /**
     * @param stdClass $data
     * 
     * @return array 
     */
    private function parseMultiVolumeData(stdClass $data)
    {
        $items = array();
        
        if(! $data->totalItems) {
            return $items;
        }
        
        foreach($data->items as $item) {
            $items[] = $this->createItem($item);
        }
        
        return $items;
    }
    
    /**
     * @param stdClass $data
     * 
     * @return Item
     */
    private function parseSingleVolumeData(stdClass $data)
    {
        return $this->createItem($data);
    }
    
    /**
     * Creates a metadata item instance from the metadata for a single book.
     *
     * @param stdClass $data 
     */
    private function createItem(stdClass $data) 
    {
        $item = new Item;
        
        $item->id = $data->id;
        
        $volumeInfo = $data->volumeInfo;
        
        if(isset($volumeInfo->title)) {
            $item->title = $volumeInfo->title;
        }
        
        if(isset($volumeInfo->description)) {
            $item->description = $volumeInfo->description;
        }
        
        if(isset($volumeInfo->industryIdentifiers)) {
            $ISBN = array_pop($volumeInfo->industryIdentifiers);
            $item->ISBN = $ISBN->identifier;
        }
        
        if(isset($volumeInfo->publisher)) {
            $item->publisher = $volumeInfo->publisher;
        }
        
        if(isset($volumeInfo->publishedDate)) {
            $item->publishedDate = new DateTime($volumeInfo->publishedDate);
        }
        
        if(isset($volumeInfo->authors)) {
            $item->authors = $volumeInfo->authors;
        }
        
        if(isset($volumeInfo->imageLinks)) {
            if(isset($volumeInfo->imageLinks->smallThumbnail)) {
                $item->smallThumbnail = $volumeInfo->imageLinks->smallThumbnail;
            }
            if(isset($volumeInfo->imageLinks->thumbnail)) {
                $item->thumbnail = $volumeInfo->imageLinks->thumbnail;
            }
        }
        
        return $item;
    }
    
}