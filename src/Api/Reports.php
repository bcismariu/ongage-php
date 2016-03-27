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
	 * set the list ids
	 * if a list id is declared in the data array we use that one
	 * if not we use the master list id
	 * @param $data data array
	 * @return mixed
	 */
	private function setListId($data)
	{
		if (isset($data['list_ids'])) {
			return $data;
		}
		if (isset($this->master->list_id)&&$this->master->list_id) {
			if(strtolower($this->master->list_id) !== 'all'){
				$list_ids = explode(',', $this->master->list_id);
				$data['list_ids'] = array();
				foreach($list_ids as $list_id){
					$data['list_ids'][] = $list_id;
				}
			}
			else{
				$data['list_ids'] = $this->master->list_id;
			}

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
	 * make the query from reports
	 * @param $data data array
	 * @return mixed
	 */
	public function query($data)
	{
		return $this->ongageRequest($data, $this->uri.'/query');
	}
}
