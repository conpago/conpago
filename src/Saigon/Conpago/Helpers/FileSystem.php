<?php
	/**
	 * Created by PhpStorm.
	 * User: bgolek
	 * Date: 2014-10-10
	 * Time: 08:10
	 */

	namespace Saigon\Conpago\Helpers;


	use Saigon\Conpago\Helpers\Contract\IFileSystem;

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
			return basename($filePath, '.php');
		}

		function loadClass($filePath)
		{
			$className = $this->getClassName($filePath);
			return new $className();
		}
	}