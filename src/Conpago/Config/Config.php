<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Conpago\Config;

	use Conpago\Config\Contract\IConfig;
	use Conpago\Exceptions\MissingConfigurationException;
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
		 * @param IFileSystem $fileSystem
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
				if (!array_key_exists($currentName, $currentElement))
					throw new MissingConfigurationException($path);

				$currentElement = $currentElement[$currentName];
			}

			return $currentElement;
		}

		/**
		 * @param $path
		 *
		 * @return bool
		 */
		function hasValue( $path ) {
			$pathArray = explode('.', $path);
			$currentElement = $this->config;

			foreach ($pathArray as $currentName)
			{
				if (!array_key_exists($currentName, $currentElement))
					return false;

				$currentElement = $currentElement[$currentName];
			}

			return true;
		}
	}
