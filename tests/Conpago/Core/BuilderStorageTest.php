<?php
	/**
	 * Created by PhpStorm.
	 * User: bgolek
	 * Date: 2014-10-17
	 * Time: 08:10
	 */

	namespace Saigon\Conpago\Core;


	class BuilderStorageTest extends \PHPUnit_Framework_TestCase
	{
		function testGetConfiguration()
		{
			$fileSystem = $this->getMock('Saigon\Conpago\Helpers\Contract\IFileSystem');
			$appPath = $this->getMock('Saigon\Conpago\Helpers\Contract\IAppPath');
			$appPath->expects($this->any())->method('root')->willReturn('root');

			$builderStorage = new BuilderStorage($fileSystem, $appPath, 'context');

			$fileSystem
				->expects($this->once())
				->method('includeFile')
				->with('root'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'persistent'.DIRECTORY_SEPARATOR.'contextContainer');

			$builderStorage->getConfiguration();
		}

		function testSetConfiguration()
		{
			$fileSystem = $this->getMock('Saigon\Conpago\Helpers\Contract\IFileSystem');
			$appPath = $this->getMock('Saigon\Conpago\Helpers\Contract\IAppPath');
			$appPath->expects($this->any())->method('root')->willReturn('root');

			$builderStorage = new BuilderStorage($fileSystem, $appPath, 'context');

			$results = print_r(array('a' => 'a'), true);
			$results = "<?php".PHP_EOL."return " . str_replace("    ", "\t", $results);
			$fileSystem
				->expects($this->once())
				->method('setFileContent')
				->with(
					'root'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'persistent'.DIRECTORY_SEPARATOR.'contextContainer',
					$results
				);

			$builderStorage->putConfiguration(array('a' => 'a'));
		}
	}
 