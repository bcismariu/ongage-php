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
     * set the list id
     * if a list id is declared in the data array we use that one
     * if not we use the master list id
     * @param $data data array
     * @return mixed
     */
    private function setListId($data)
    {
        if (isset($data['list_id'])) {
            return $data;
        }
        if (isset($this->master->list_id)&&$this->master->list_id) {
            $data['list_id'] = $this->master->list_id;
            return $data;
        }
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
        $data = $this->setListId($data);
        return $this->master->call($method, $url, $data);
    }

    /**
     * add new contact to list
     * @param $data data array
     * @return mixed
     */
    public function addContact($data)
    {
        return $this->ongageRequest($data, $this->uri_v2);
    }
}
