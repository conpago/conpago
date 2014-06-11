<?php
/**
 * Created by PhpStorm.
 * User: bartosz.golek
 * Date: 23.12.13
 * Time: 06:19
 */

namespace Saigon\Conpago\AccessRight;


interface IAccessRightChecker {
	/**
	 * @param string $accessRight
	 *
	 * @return bool
	 */
	function check($accessRight);
}