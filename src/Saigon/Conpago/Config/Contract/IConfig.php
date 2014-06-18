<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-06-09
	 * Time: 00:00
	 */

	namespace Saigon\Conpago\Helpers;

	interface IConfig
	{
		function getValue($path);
	}