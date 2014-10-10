<?php
	/**
	 * Created by PhpStorm.
	 * User: bgolek
	 * Date: 2014-10-10
	 * Time: 08:23
	 */

	namespace Saigon\Conpago\Config;


	use Saigon\Conpago\Config\Contract\IConfig;

	class ConfigTest extends \PHPUnit_Framework_TestCase
	{
		const SIMPLE_VALUE = 1;
		const NESTED_VALUE = 2;
		const SIMPLE_KEY = 'simple';
		const NESTING_KEY = 'nesting';
		const NESTED_KEY = 'nested';
		/**
		 * @var IConfig
		 */
		private $config;

		protected function setUp()
		{
			$appMask = $this->getMock('Saigon\Conpago\Helpers\Contract\IAppMask');
			$fileSystem = $this->getFileSystemMock();

			$this->config = new Config($appMask, $fileSystem);
		}

		public function testGetSimpleValue()
		{
			$this->assertEquals(self::SIMPLE_VALUE, $this->config->getValue(self::SIMPLE_KEY));
		}

		public function testGetNestedValue()
		{
			$result = $this->config->getValue($this->buildNestedPath(array(self::NESTING_KEY, self::NESTED_KEY)));
			$this->assertEquals(self::NESTED_VALUE, $result);
		}

		/**
		 * @param array $elements
		 * @return string
		 */
		private function buildNestedPath(array $elements)
		{
			return implode('.', $elements);
		}

		/**
		 * @return \PHPUnit_Framework_MockObject_MockObject
		 */
		protected function getFileSystemMock()
		{
			$fileSystem = $this->getMock('Saigon\Conpago\Helpers\Contract\IFileSystem');

			$fileSystem->expects($this->any())->method('glob')->willReturn(array('fakePath1'));

			$fileSystem->expects($this->any())->method('includeFile')->willReturn(
				array(
					self::SIMPLE_KEY => self::SIMPLE_VALUE,
					self::NESTING_KEY => array(
						self::NESTED_KEY => self::NESTED_VALUE
					)
				)
			);

			return $fileSystem;
		}
	}
 