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
     * add new contact to list
     * @param $data data array
     * @return mixed
     */
    public function add($data)
    {
        return $this->master->call('POST', $this->uri_v2, $data);
    }
}
