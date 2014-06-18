<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-03-31
	 * Time: 22:25
	 */

	namespace Saigon\Conpago\Presentation\Contract;

	use Saigon\Conpago\Helpers\Contract\IRequestData;

	interface IController
	{
		function execute(IRequestData $data);
	}