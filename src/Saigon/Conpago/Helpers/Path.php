<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Helpers;

	use Saigon\Conpago\Helpers\Contract\IPath;

	class Path implements IPath
	{
		public function createPath($elements)
		{
			$elements = func_get_args();

			return implode(DIRECTORY_SEPARATOR, $elements);
		}

		public function fileName($filePath)
		{
			return basename(str_replace('\\', '/', $filePath));
		}
	}