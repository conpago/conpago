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
	}