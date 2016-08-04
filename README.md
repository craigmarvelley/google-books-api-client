Google Books API Client
=======================

About
-----
A PHP client for the Google Books API. Based on the [Guzzle](http://guzzlephp.org/) library

Installation
------------

### Installing via Composer

The recommended way to install the library is via [Composer](http://getcomposer.org).

1. Add ``marvelley/google-books-api-client`` as a dependency in your project's ``composer.json`` file:

        {
            "require": {
                "marvelley/google-books-api-client": "*"
            }
        }

    Consider tightening your dependencies to a known version when deploying mission critical applications (e.g. ``2.8.*``).

2. Download and install Composer:

        curl -s http://getcomposer.org/installer | php

3. Install your dependencies:

        php composer.phar install

4. Require Composer's autoloader

    Composer also prepares an autoload file that's capable of autoloading all of the classes in any of the libraries that it downloads. To use it, just add the following line to your code's bootstrap process:

        require 'vendor/autoload.php';

You can find out more on how to install Composer, configure autoloading, and other best-practices for defining dependencies at [getcomposer.org](http://getcomposer.org).


Using the client
----------------

```php
<?php

$client = GoogleBooksApiClient::factory(array('base_url' => 'https://www.googleapis.com'));
$command = $client->getCommand('GetVolume', array('id' => 'zyTCAlFPjgYC'));

$responseModel = $client->execute($command);
$data = $responseModel->toArray();

echo $data['id']; // prints 'zyTCAlFPjgYC'
```

Running the unit tests
----------------------

```
vendor/bin/phpunit 
```