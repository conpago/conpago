<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-05
 * Time: 10:36
 */

namespace Saigon\Conpago\Accessor;


class ServerAccessorTest extends \PHPUnit_Framework_TestCase {
	const KEY_NAME = 'xxx';

	const KEY_VALUE = 'a';

	public function testContains()
	{
		$serverAccessor = new ServerAccessor();
		$this->assertEquals(false, $serverAccessor->contains(self::KEY_NAME));
		$_SERVER = array(self::KEY_NAME => self::KEY_VALUE);
		$this->assertEquals(true, $serverAccessor->contains(self::KEY_NAME));
	}

	public function testGetValue()
	{
		$_SERVER = array(self::KEY_NAME => self::KEY_VALUE);
		$serverAccessor = new ServerAccessor();
		$this->assertEquals(self::KEY_VALUE, $serverAccessor->getValue(self::KEY_NAME));
	}
}
