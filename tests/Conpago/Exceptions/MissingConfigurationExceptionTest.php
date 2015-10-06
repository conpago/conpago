<?php
	/**
	 * Created by PhpStorm.
	 * User: bg
	 * Date: 06.10.15
	 * Time: 20:35
	 */

	namespace Conpago\Exceptions;


	class MissingConfigurationExceptionTest extends \PHPUnit_Framework_TestCase {
		public function testCreate(){
			$previous = new Exception();
			$ex = new MissingConfigurationException("path", "m", 1, $previous);

			$this->assertEquals("m", $ex->getMessage());
			$this->assertEquals(1, $ex->getCode());
			$this->assertSame($previous, $ex->getPrevious());
			$this->assertSame("path", $ex->getPath());
		}

	}