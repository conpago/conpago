<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 28.11.13
 * Time: 22:03
 */

namespace Saigon\Conpago\Exceptions;


class PermissionDeniedException extends Exception {
	function __construct($message = "", $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}