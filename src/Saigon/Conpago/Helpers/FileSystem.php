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

		/**
		 * @param string $filename
		 * @return string
		 */
		function getFileContent($filename)
		{
			return file_get_contents($filename);
		}
	}