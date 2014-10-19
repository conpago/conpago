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
	}
