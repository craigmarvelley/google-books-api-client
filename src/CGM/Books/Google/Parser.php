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
     * @param stdClass $item 
     */
    private function createItem(stdClass $item) 
    {
        $volumeInfo = $item->volumeInfo;
        
        $metadataItem = new Item;
        
        if(isset($volumeInfo->title)) {
            $metadataItem->title = $volumeInfo->title;
        }
        
        if(isset($volumeInfo->description)) {
            $metadataItem->description = $volumeInfo->description;
        }
        
        if(isset($volumeInfo->industryIdentifiers)) {
            $ISBN = array_pop($volumeInfo->industryIdentifiers);
            $metadataItem->ISBN = $ISBN->identifier;
        }
        
        if(isset($volumeInfo->publisher)) {
            $metadataItem->publisher = $volumeInfo->publisher;
        }
        
        if(isset($volumeInfo->publishedDate)) {
            $metadataItem->publishedDate = new DateTime($volumeInfo->publishedDate);
        }
        
        if(isset($volumeInfo->authors)) {
            $metadataItem->authors = $volumeInfo->authors;
        }
        
        if(isset($volumeInfo->imageLinks)) {
            if(isset($volumeInfo->imageLinks->smallThumbnail)) {
                $metadataItem->smallThumbnail = $volumeInfo->imageLinks->smallThumbnail;
            }
            if(isset($volumeInfo->imageLinks->thumbnail)) {
                $metadataItem->thumbnail = $volumeInfo->imageLinks->thumbnail;
            }
        }
        
        return $metadataItem;
    }
    
}