<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Helpers;

	use Saigon\Conpago\IAppMask;

	class Config implements IConfig
	{

		/**
		 * @var array
		 */
		protected $config = array();

		/**
		 * @param \Saigon\Conpago\IAppMask $appMask
		 *
		 * @inject \Saigon\Conpago\IAppMask $appMask
		 */
		function __construct(IAppMask $appMask)
		{
			foreach (glob($appMask->configMask()) as $filePath)
			{
				$this->config = array_merge($this->config, include $filePath);
			}
		}

		function getValue($path)
		{
			$pathArray = explode('.', $path);
			$currentElement = $this->config;

			foreach ($pathArray as $curentName)
			{
				$currentElement = $currentElement[$curentName];
			}

			return $currentElement;
		}
	}