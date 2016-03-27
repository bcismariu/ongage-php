<?php

namespace Bcismariu\Ongage\Api;

class Contacts
{
    protected $master;
    protected $uri = 'contacts';
    protected $uri_v2 = 'v2/contacts';

    public function __construct($master)
    {
        $this->master = $master;
    }

    /**
     * make the ongage request
     * @param $data data array
     * @param string $url ongage package method url
     * @param string $method  method type(POST, GET, PUT)
     * @return mixed
     */
    private function ongageRequest($data, $url = '', $method = 'POST')
    {
        return $this->master->call($method, $url, $data);
    }

    /**
     * add new contact to list
     * @param $data data array
     * @return mixed
     */
    public function add($data)
    {
        return $this->ongageRequest($data, $this->uri_v2);
    }
}
