<?php
	/**
	 * Created by PhpStorm.
	 * User: bgolek
	 * Date: 2014-10-08
	 * Time: 14:05
	 */

	namespace Saigon\Conpago\Accessor;

	class SessionAccessorTest extends \PHPUnit_Framework_TestCase
	{
		const KEY_NAME = 'xxx';

		const KEY_VALUE = 'a';

		protected function setUp()
		{
			$GLOBALS['_SESSION'] = array();
		}

		public function testContains()
		{
			$sessionAccessor = new SessionAccessor();
			$this->assertEquals(false, $sessionAccessor->contains(self::KEY_NAME));
			$_SESSION = array(self::KEY_NAME => self::KEY_VALUE);
			$this->assertEquals(true, $sessionAccessor->contains(self::KEY_NAME));
		}

		public function testGetValue()
		{
			$_SESSION = array(self::KEY_NAME => self::KEY_VALUE);
			$sessionAccessor = new SessionAccessor();
			$this->assertEquals(self::KEY_VALUE, $sessionAccessor->getValue(self::KEY_NAME));
		}

		public function testSetValue()
		{
			$_SESSION = array();
			$sessionAccessor = new SessionAccessor();
			$sessionAccessor->setValue(self::KEY_NAME, self::KEY_VALUE);

			$this->assertEquals(array(self::KEY_NAME => self::KEY_VALUE), $_SESSION);
		}
	}
