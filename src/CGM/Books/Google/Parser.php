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
     * Converts a JSON response from the Google Books service into an array of metadata items.
     *
     * @param string $metadata
     * 
     * @return array
     */
    public function parseMetadata($metadata) 
    {
        $items = array();
        
        $data = json_decode($metadata);
        
        if(! $data instanceof stdClass || ! $data->totalItems) {
            return $items;
        }
        
        foreach($data->items as $item) {
            $items[] = $this->createItem($item);
        }
        
        return $items;
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