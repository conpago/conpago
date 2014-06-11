<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Helpers;

	use Saigon\Conpago\IAppMask, Saigon\Conpago\IAppPath;

	class AppMask implements IAppMask
	{

		protected $appPath;

		public function __construct(IAppPath $appPath)
		{
			$this->appPath = $appPath;
		}

		public function moduleMask()
		{
			return implode(DIRECTORY_SEPARATOR, array(
				$this->appPath->source(),
				"*Module.php"
			));
		}

		public function configMask()
		{
			return implode(DIRECTORY_SEPARATOR, array(
				$this->appPath->config(),
				"*.php"
			));
		}
	}
