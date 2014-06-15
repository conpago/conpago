<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 28.11.13
 * Time: 22:10
 */

namespace Saigon\Conpago;


use Saigon\Conpago\AccessRight\Contract\IRole;

interface IRolesConfig {
	/**
	 * @return IRole[];
	 */
	function getRoles();
}