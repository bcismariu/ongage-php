<?php

namespace Bcismariu\Ongage;
use GuzzleHttp;

class Ongage
{
	private $auth = [
		'username'		=> null,
		'password'		=> null,
		'account_code'	=> null,
	];

	protected $base_uri = 'https://api.ongage.net/api/';

	protected $list_id;

	/**
	 * Http Client
	 */
	protected $client;

	/**
	 * property to API class maps
	 * @var [type]
	 */
	protected $mappings = [
		'contacts'	=>	'Api\Contacts',
		'reports'	=>	'Api\Reports',
	];

	/**
	 * stores Api instances for singleton behaviour
	 * @var array
	 */
	protected $instances = [];

	public function __construct($username = null, $password = null, $account_code = null)
	{
		$this->auth = [
			'username'		=> $username,
			'password'		=> $password,
			'account_code'	=> $account_code,
		];
		$this->client = new GuzzleHttp\Client();
	}

	/**
	 * magic loading of API module
	 * @param  string $property see mappings
	 * @return instance of api module
	 */
	public function __get($property)
	{
		if (!array_key_exists($property, $this->mappings)) {
			throw new OngageException("Unknown API module: $property");
		}
		return $this->getInstance($property);
	}

	/**
	 * get a singleton instance for the required module
	 * @param  string $property see mappings
	 * @return instance of api module
	 */
	protected function getInstance($property)
	{
		if (isset($this->instances[$property])) {
			return $this->instances[$property];
		}
		$module = __NAMESPACE__ . '\\' . $this->mappings[$property];
		$this->instances[$property] = new $module($this);
		return $this->instances[$property];
	}

	/**
	 * set current list id
	 * @param $list_id the list id
	 * @return mixed
	 */
	public function useList($list_id)
	{
		$this->list_id = $list_id;
		return $this->list_id;
	}

	/**
	 * this method is called from each api component
	 * @param $method method type(POST, GET, PUT)
	 * @param $url ongage package method url
	 * @param $data data array
	 * @return mixed
	 */
	public function call($method, $url, $data)
	{
		return $this->json($method, $url, $data);
	}

	/**
	 * decode the json response from ongage server
	 * @param $method method type(POST, GET, PUT)
	 * @param $url ongage package method url
	 * @param $data data array
	 * @return mixed
	 */
	private function json($method, $url, $data)
	{
		$response = $this->request($method, $url, $data);
		return json_decode($response->getBody()->getContents());
	}

	/**
	 * make the request to ongage server
	 * @param $method method type(POST, GET, PUT)
	 * @param $url ongage package method url
	 * @param $data data array
	 * @return mixed|\Psr\Http\Message\ResponseInterface
	 */
	private function request($method, $url, $data)
	{
		return $this->client->request($method, $url, [
				'base_uri'	=> $this->getBaseUri(),
				'headers' 	=> $this->getAuthHeaders(),
				'json'		=> $data
			]);
	}

	/**
	 * builds the request base URI
	 * @return string
	 */
	private function getBaseUri()
	{
		if(isset($this->list_id)){
			return str_replace('api/', $this->list_id . '/api/' , $this->base_uri);
		}
		return $this->base_uri;
	}

	/**
	 * set authentification headers
	 * @return array
	 */
	private function getAuthHeaders()
	{
		return [
			'X_USERNAME' 		=> $this->auth['username'],
			'X_PASSWORD'		=> $this->auth['password'],
			'X_ACCOUNT_CODE'	=> $this->auth['account_code']
		];
	}
}
