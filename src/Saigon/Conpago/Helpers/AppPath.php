<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Helpers;

	use Saigon\Conpago\IAppPath;

	class AppPath implements IAppPath
	{

		protected $path;

		public function __construct($path)
		{
			$this->path = $path;
		}

		private function getPath($real, array $elements)
		{
			$result = implode(DIRECTORY_SEPARATOR, $elements);

			if ($real)
			{
				$result = realpath($result);
			}

			return $result;
		}

		public function cache($real = false)
		{
			return $this->getPath($real, array(
				$this->path,
				"tmp",
				"cache"
			));
		}

		public function config($real = false)
		{
			return $this->getPath($real, array(
				$this->path,
				"config"
			));
		}

		public function root($real = false)
		{
			return $this->getPath($real, array($this->path));
		}

		public function templates($real = false)
		{
			return $this->getPath($real, array(
				$this->path,
				"templates"
			));
		}

		public function source($real = false)
		{
			return $this->getPath($real, array(
				$this->path,
				"src"
			));
		}

	}
