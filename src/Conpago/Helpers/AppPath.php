<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Conpago\Helpers;

	use Conpago\Helpers\Contract\IAppPath;
	use Conpago\Helpers\Contract\IFileSystem;

	class AppPath implements IAppPath
	{

		protected $cachePathElements;
		protected $configPathElements;
		protected $rootPathElements;
		protected $templatesPathElements;
		protected $sourcePathElements;
		protected $sessionsPathElements;

		/**
		 * @var IFileSystem
		 */
		private $fileSystem;

		public function __construct(IFileSystem $fileSystem, $path)
		{
			$this->fileSystem = $fileSystem;

			$this->sourcePathElements    = array($path, "src");
			$this->templatesPathElements = array($path, "templates");
			$this->rootPathElements      = array($path);
			$this->configPathElements    = array($path, "config" );
			$this->cachePathElements     = array($path, "tmp", "cache");
			$this->sessionsPathElements     = array($path, "tmp", "sessions");
		}

		private function getPath(array $elements)
		{
			return implode(DIRECTORY_SEPARATOR, $elements);
		}

		private function getRealPath(array $elements)
		{
			return $this->fileSystem->realPath($this->getPath($elements));
		}

		public function cache()
		{
			return $this->getPath($this->cachePathElements);
		}

		public function sessions() {
			return $this->getPath($this->sessionsPathElements);
		}

		public function config()
		{
			return $this->getPath($this->configPathElements);
		}

		public function root()
		{
			return $this->getPath($this->rootPathElements);
		}

		public function templates()
		{
			return $this->getPath($this->templatesPathElements);
		}

		public function source()
		{
			return $this->getPath($this->sourcePathElements);
		}

		public function realCache()
		{
			return $this->getRealPath($this->cachePathElements);
		}

		public function realSessions() {
			return $this->getRealPath($this->sessionsPathElements);
		}

		public function realConfig()
		{
			return $this->getRealPath($this->configPathElements);
		}

		public function realRoot()
		{
			return $this->getRealPath($this->rootPathElements);
		}

		public function realTemplates()
		{
			return $this->getRealPath($this->templatesPathElements);
		}

		public function realSource()
		{
			return $this->getRealPath($this->sourcePathElements);
		}
	}
