<?php
	/**
	 * Created by PhpStorm.
	 * User: bgolek
	 * Date: 2014-10-10
	 * Time: 07:57
	 */

	namespace Saigon\Conpago\Helpers\Contract;


	interface IFileSystem
	{
		function includeFile($filePath);
		function glob($pattern);
		function realPath($path);
		function requireOnce($filePath);
		function loadClass($filePath);
		function requireFile($filePath);

		/**
		 * @param string $filename
		 * @return string
		 */
		function getFileContent($filename);

		function setFileContent($filename, $content);
	}