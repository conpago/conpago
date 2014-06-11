<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 29.11.13
 * Time: 00:48
 */

namespace Saigon\Conpago\AccessRight;


use string;

class Role implements IRole {

	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string[]
	 */
	private $accessRights;

	/**
	 * @param string $name
	 * @param string[] $accessRights
	 */
	function __construct($name, array $accessRights)
	{
		$this->name = $name;
		$this->accessRights = $accessRights;
	}

	/**
	 * @return string
	 */
	function getRoleName()
	{
		return $this->name;
	}

	/**
	 * @return string[]
	 */
	function getAccessRights()
	{
		return $this->accessRights;
	}
}