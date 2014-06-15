<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 23.12.13
 * Time: 06:19
 */

namespace Saigon\Conpago\AccessRight\Contract;


interface IAccessRightChecker {
	/**
	 * @param string $accessRight
	 *
	 * @return bool
	 */
	function check($accessRight);
}