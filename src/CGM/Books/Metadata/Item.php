<?php

namespace CGM\Books\Metadata;

/**
 * A single item of book metadata
 */
class Item 
{
    /**
     * @var string 
     */
    public $id;
    
    /**
     * @var string
     */
    public $title;
    
    /**
     * @var string
     */
    public $description;
    
    /**
     * @var string
     */
    public $ISBN;
    
    /**
     * @var array
     */
    public $authors = array();
    
    /**
     * @var string
     */
    public $publisher;
    
    /**
     * @var DateTime
     */
    public $publishedDate;
    
    /**
     * @var string
     */
    public $smallThumbnail;
    
    /**
     * @var string
     */
    public $thumbnail;
}