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
	 * make the query from reports
	 * @param $data data array
	 * @return mixed
	 */
	public function query($data)
	{
		return $this->ongageRequest($data, $this->uri.'/query');
	}
}
