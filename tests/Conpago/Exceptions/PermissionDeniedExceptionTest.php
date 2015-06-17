<?php
	/**
	 * Created by PhpStorm.
	 * User: bg
	 * Date: 10.10.14
	 * Time: 22:53
	 */

	namespace Saigon\Conpago\Exceptions;


	class PermissionDeniedExceptionTest extends \PHPUnit_Framework_TestCase
	{
		public function testCreate(){
			$previous = new Exception();
			$ex = new PermissionDeniedException("m", 1, $previous);

			$this->assertEquals("m", $ex->getMessage());
			$this->assertEquals(1, $ex->getCode());
			$this->assertSame($previous, $ex->getPrevious());
		}
	}
 