<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 2014-10-20
	 * Time: 00:14
	 */

	namespace Saigon\Conpago;

	class AppBuilderFactoryTest extends \PHPUnit_Framework_TestCase
	{
		public function testCreateAppBuilder()
		{
			$appBuilderFactory = new AppBuilderFactory();
			$appBuilder = $appBuilderFactory->createAppBuilder('x', 'y');

			$this->assertNotNull($appBuilder);
		}

		public function testCreateAppBuilderFromPersisted()
		{
			$containerBuilder = $this->getMock('Saigon\Conpago\DI\IContainerBuilder');

			$persister = $this->getMock('Saigon\Conpago\DI\IContainerBuilderPersister');
			$persister->expects($this->once())->method('loadContainerBuilder')->willReturn($containerBuilder);

			$appBuilderFactory = new AppBuilderFactory();
			$appBuilder = $appBuilderFactory->createAppBuilderFromPersisted($persister, 'x', 'y');

			$this->assertNotNull($appBuilder);
		}
	}
