<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago;

	use Saigon\Conpago\Helpers\IConfig;

	abstract class ConfigBase
	{
		/**
		 * @var IConfig
		 */
		protected $config;

		/**
		 * @param Helpers\IConfig $config
		 */
		function __construct(IConfig $config)
		{
			$this->config = $config;
		}
	}
