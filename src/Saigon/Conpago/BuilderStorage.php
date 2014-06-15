<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 13.11.13
 * Time: 20:38
 */

namespace Saigon\Conpago;

use DI\IContainerBuilderStorage;

class BuilderStorage implements IContainerBuilderStorage {

	/**
	 * @var string
	 */
	private $fileName;

	/**
	 * @param string $appRootPath
	 * @param string $contextName
	 *
	 * @internal param string $fileName
	 */
	function __construct($appRootPath, $contextName)
	{
		$this->fileName = implode(DIRECTORY_SEPARATOR, array($appRootPath, 'tmp', 'persistent', $contextName.'Container'));
	}

	function putConfiguration(array $configuration)
	{
		$results = print_r($configuration, true);

		$results = "<?php\r\nreturn ".str_replace("    ", "\t", $results);

		file_put_contents ($this->fileName, $results);
	}

	function getConfiguration()
	{
		return include $this->fileName;
	}
}