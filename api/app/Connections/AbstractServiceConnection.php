<?php

namespace App\Connections;

use GuzzleHttp\Client;

abstract class AbstractServiceConnection
{
    /**
     * @var object
     */
    protected $config;

    /**
     * AbstractServiceConnection constructor.
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->config = (object) $config;
        $this->http = new Client($this->getHttpClientConfig());
    }

    /**
     * @return array
     */
    public function getHttpClientConfig()
    {
        return [];
    }

    /**
     * @param $method
     * @param $path
     * @param array $query
     * @param array $options
     *
     * @return object
     */
    public function request($method, $path, $query = [], $options = [])
    {
        if (in_array(strtolower($method), ['get', 'options'])) {
            $options['query'] = $query;
        } else {
            $options['json'] = $query;
        }

        $req = $this->http->request($method, $path, $options);

        return json_decode((string) $req->getBody());
    }
}
