<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Helpers;

	use Saigon\Conpago\Helpers\Contract\IAppPath;
	use Saigon\Conpago\Helpers\Contract\IFileSystem;

	class AppPath implements IAppPath
	{

		protected $path;
		/**
		 * @var IFileSystem
		 */
		private $fileSystem;

		public function __construct(IFileSystem $fileSystem, $path)
		{
			$this->path = $path;
			$this->fileSystem = $fileSystem;
		}

		private function getPath($real, array $elements)
		{
			$result = implode(DIRECTORY_SEPARATOR, $elements);

			if ($real)
				$result = $this->fileSystem->realPath($result);

			return $result;
		}

		private function getRealPath(array $elements)
		{
			return $this->fileSystem->realPath($$this->getPath($elements));
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

		public function realCache($real = false)
		{
			return $this->getRealPath($real, array(
				$this->path,
				"tmp",
				"cache"
			));
		}

		public function realConfig($real = false)
		{
			return $this->getRealPath($real, array(
				$this->path,
				"config"
			));
		}

		public function realRoot($real = false)
		{
			return $this->getRealPath($real, array($this->path));
		}

		public function realTemplates($real = false)
		{
			return $this->getRealPath($real, array(
				$this->path,
				"templates"
			));
		}

		public function realSource($real = false)
		{
			return $this->getRealPath($real, array(
				$this->path,
				"src"
			));
		}
	}
