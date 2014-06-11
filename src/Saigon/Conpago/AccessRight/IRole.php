<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 28.11.13
 * Time: 22:12
 */

namespace Saigon\Conpago\AccessRight;


interface IRole {
	/**
	 * @return string
	 */
	function getRoleName();
	/**
	 * @return string[]
	 */
	function getAccessRights();
}