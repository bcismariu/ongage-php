<?php

namespace Bcismariu\Ongage\Api;

class Reports
{
	protected $master;

	protected $uri = 'reports';

	public function __construct($master)
	{
		$this->master = $master;
	}

	public function query($filters)
	{
		return $this->master->call('POST', $this->uri, $filters);
	}

}
