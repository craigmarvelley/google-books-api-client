<?php

namespace CGM\Tests\Books\Google;

use CGM\Books\Google\Parser;

require_once 'tests/bootstrap.php';

class ParserTest extends \PHPUnit_Framework_TestCase 
{
    /**
     * @dataProvider getSuccessfulResponse 
     */
    public function testParsesJsonResponse($json) 
    {
        $parser = new Parser();
        
        $items = $parser->parseMetadata($json);
        
        $this->assertInternalType('array', $items);
        
        $this->assertEquals(1, count($items));
        
        $book = $items[0];
        
        $this->assertInstanceOf("CGM\Books\Metadata\Item", $book);
        
        $this->assertEquals('FbgkkgAACAAJ', $book->id);
        
        $this->assertEquals('How to Be a Woman', $book->title);
        $this->assertEquals('I don\'t want to know', $book->description);
        $this->assertEquals('9780091940737', $book->ISBN);
        
        $this->assertInternalType('array', $book->authors);
        $this->assertEquals(1, count($book->authors));
        $this->assertEquals('Caitlin Moran', $book->authors[0]);
        
        $this->assertEquals('Ebury Press', $book->publisher);
        
        $this->assertInstanceOf("\DateTime", $book->publishedDate);
        $this->assertEquals('2011-07-15', $book->publishedDate->format('Y-m-d'));
        
        $this->assertEquals('http://bks8.books.google.com/books?id=FbgkkgAACAAJ&printsec=frontcover&img=1&zoom=1&source=gbs_api', $book->thumbnail);
    }
    
    /**
     * @return array
     */
    public function getSuccessfulResponse() 
    {
        $response = <<<EOD
{
 "kind": "books#volumes",
 "items": [
  {
   "kind": "books#volume",
   "id": "FbgkkgAACAAJ",
   "etag": "l2YZOjKPZjQ",
   "selfLink": "https://www.googleapis.com/books/v1/volumes/FbgkkgAACAAJ",
   "volumeInfo": {
    "title": "How to Be a Woman",
    "authors": [
     "Caitlin Moran"
    ],
    "publisher": "Ebury Press",
    "publishedDate": "2011-07-15",
    "description": "I don't want to know",
    "industryIdentifiers": [
     {
      "type": "ISBN_10",
      "identifier": "0091940737"
     },
     {
      "type": "ISBN_13",
      "identifier": "9780091940737"
     }
    ],
    "pageCount": 320,
    "printType": "BOOK",
    "averageRating": 5.0,
    "ratingsCount": 1,
    "contentVersion": "preview-1.0.0",
    "imageLinks": {
     "smallThumbnail": "http://bks8.books.google.com/books?id\u003dFbgkkgAACAAJ&printsec\u003dfrontcover&img\u003d1&zoom\u003d5&source\u003dgbs_api",
     "thumbnail": "http://bks8.books.google.com/books?id\u003dFbgkkgAACAAJ&printsec\u003dfrontcover&img\u003d1&zoom\u003d1&source\u003dgbs_api"
    },
    "language": "en",
    "previewLink": "http://books.google.com/books?id\u003dFbgkkgAACAAJ&dq\u003disbn:0091940737&ie\u003dISO-8859-1&cd\u003d1&source\u003dgbs_api",
    "infoLink": "http://books.google.com/books?id\u003dFbgkkgAACAAJ&dq\u003disbn:0091940737&ie\u003dISO-8859-1&source\u003dgbs_api"
   },
   "saleInfo": {
    "country": "GB",
    "saleability": "NOT_FOR_SALE",
    "isEbook": false
   },
   "accessInfo": {
    "country": "GB",
    "viewability": "NO_PAGES",
    "embeddable": false,
    "publicDomain": false,
    "accessViewStatus": "NONE"
   }
  }
 ],
 "totalItems": 1
}
EOD;
        return array(
            array($response)
        );
    }
}