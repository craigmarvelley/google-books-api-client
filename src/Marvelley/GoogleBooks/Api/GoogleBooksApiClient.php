<?php

namespace Marvelley\GoogleBooks\Api;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

class GoogleBooksApiClient extends Client
{
    /**
     * Factory method to create a new GoogleBooksApiClient
     *
     * @param array|Collection $config Configuration data. Array keys:
     *    base_url - Base URL of web service
     *
     * @return GoogleBooksApiClient
     */
    public static function factory($config = array())
    {
        $default = array(
            'base_url' => '{scheme}://www.googleapis.com',
            'scheme'   => 'https'
        );
        $required = array('base_url');
        $config = Collection::fromConfig($config, $default, $required);

        $client = new self($config->get('base_url'), $config);
        $client->setDescription(ServiceDescription::factory(__DIR__ . DIRECTORY_SEPARATOR . 'client.json'));

        return $client;
    }
}
