<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 28.11.13
 * Time: 22:08
 */

namespace Saigon\Conpago\AccessRight\Contract;


interface IAccessRightRequester {
	/**
	 * @return string[]
	 */
	function getRoles();
}