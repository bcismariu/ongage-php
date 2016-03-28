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

	/**
	 * make the query from reports
	 * @param $data data array
	 * @return mixed
	 */
	public function query($data)
	{
		return $this->master->call('POST', $this->uri . '/query', $data);
	}
}
