<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Conpago\Config;

	use Conpago\Config\Contract\IConfig;
	use Conpago\Helpers\Contract\IAppMask;
	use Conpago\Helpers\Contract\IFileSystem;

	class Config implements IConfig
	{

		/**
		 * @var array
		 */
		protected $config = array();

		/**
		 * @param IAppMask $appMask
		 *
		 * @inject \Conpago\IAppMask $appMask
		 */
		function __construct(IAppMask $appMask, IFileSystem $fileSystem)
		{
			foreach ($fileSystem->glob($appMask->configMask()) as $filePath)
			{
				$this->config = array_merge($this->config, $fileSystem->includeFile($filePath));
			}
		}

		function getValue($path)
		{
			$pathArray = explode('.', $path);
			$currentElement = $this->config;

			foreach ($pathArray as $currentName)
			{
				$currentElement = $currentElement[$currentName];
			}

			return $currentElement;
		}
	}
