<?php
	/**
	 * Created by PhpStorm.
	 * User: bg
	 * Date: 10.10.14
	 * Time: 22:47
	 */

	namespace Saigon\Conpago\Database\Exceptions;


	class ColumnUniqueConstraintExceptionTest extends \PHPUnit_Framework_TestCase
	{
		const COLUMN_NAME = 'columnName';

		public function testCreateException()
		{
			$innerException = new \Exception();
			$ex = new ColumnUniqueConstraintException(
				self::COLUMN_NAME, $innerException
			);

			$this->assertEquals(self::COLUMN_NAME, $ex->columnName);
			$this->assertSame($innerException, $ex->innerException);
		}
	}
 