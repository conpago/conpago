<?php
	/**
	 * Created by PhpStorm.
	 * User: bgolek
	 * Date: 2014-10-10
	 * Time: 08:10
	 */

	namespace Conpago\Helpers;


	use Conpago\Helpers\Contract\IFileSystem;

	class FileSystem implements IFileSystem
	{

		function includeFile($filePath)
		{
			return include $filePath;
		}

		function glob($pattern, $flags = null)
		{
			return glob($pattern, $flags);
		}

		function realPath($path)
		{
			return realpath($path);
		}

		function getFileContent($filename)
		{
			return file_get_contents($filename);
		}

		function setFileContent($filename, $data)
		{
			file_put_contents($filename, $data);
		}

		function requireOnce($filePath)
		{
			require_once $filePath;
		}

		function requireFile($filePath)
		{
			require $filePath;
		}

		private function getClassName($filePath)
		{
			$className = basename($filePath, '.php');
			$namespace = $this->getNameSpace($filePath);

			$classFullName = strlen($namespace) > 0
				? '\\'.$namespace.'\\'.$className
				: '\\'.$className;

			return $classFullName;
		}

		private function getNameSpace($filePath)
		{
			$matches = array();
			if (preg_match('/namespace (.+) *[\{;]{1}/', file_get_contents($filePath), $matches))
				return $matches[1];

			return '';
		}

		function loadClass($filePath)
		{
			$className = $this->getClassName($filePath);
			$this->requireOnce($filePath);

			return new $className();
		}
	}
