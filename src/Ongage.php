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


	public function useList($list_id) 
	{
		$this->list_id = $list_id;
		return $this;
	}

	public function addContact($contact_data)
	{
		$contact_data = $this->setListId($contact_data);
		if (!isset($contact_data['email'])) {
			throw new OngageException('No email found for contact');
		}
		$post_data = [
			'email' => $contact_data['email'],
			'list_id' => $contact_data['list_id'],
			'overwrite'	=> true,
			'fields' => $contact_data
		];
		return $this->json('POST', 'v2/contacts', $post_data);
	}

	public function findEmail($email)
	{
		$data = [
			'user_type'	=> 'active',
			'offset'	=> 0,
			'list_id'	=> 0,
			'limit'		=> 20,
			'sort'		=> [
					'field'	=> 'name',
					'order'	=> 'asc'
				],
			'criteria'	=> [[
				'field_name'	=> 'email',
				'type'			=> 'email',
				'operator'		=> 'LIKE',
				'operand'		=> [$email],
				'case_sensitive'	=> 0,
				'condition'		=> 'and'
			]]
		];
		return $this->json('post', 'contacts/lookup', $data);
	}

	private function json($method, $url, $data)
	{
		$response = $this->request($method, $url, $data);
		return json_decode($response->getBody()->getContents());
	}

	private function request($method, $url, $data)
	{
		return $this->client->request($method, $url, [
				'base_uri'	=> $this->base_uri,
				'headers' 	=> $this->getAuthHeaders(),
				'json'		=> $data,
			]);
	}

	private function getAuthHeaders()
	{
		return [
			'X_USERNAME' 		=> $this->auth['username'],
			'X_PASSWORD'		=> $this->auth['password'],
			'X_ACCOUNT_CODE'	=> $this->auth['account_code'],
		];
	}

	private function setListId($data)
	{
		if (isset($data['list_id'])) {
			return $data;
		}
		if (isset($this->list_id)) {
			$data['list_id'] = $this->list_id;
			return $data;
		}
		throw new OngageException('No list id found');
	}
}
