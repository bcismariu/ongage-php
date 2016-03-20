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

	public function latest()
	{
		return $this->master->call('GET', $this->uri, $data);
	}
}
