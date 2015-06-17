<?php
	/**
	 * Created by PhpStorm.
	 * User: bgolek
	 * Date: 2014-10-14
	 * Time: 07:53
	 */

	namespace Saigon\Conpago\Helpers;


	class PathTest extends \PHPUnit_Framework_TestCase
	{
		function testCreatePath()
		{
			$path = new Path();
			$this->assertEquals('a'.DIRECTORY_SEPARATOR.'b', $path->createPath('a', 'b'));
		}

		function testFileNameWithSlash()
		{
			$path = new Path();
			$this->assertEquals('a.txt', $path->fileName('b/a.txt'));
		}

		function testFileNameWithBackslash()
		{
			$path = new Path();
			$this->assertEquals('a.txt', $path->fileName('b\a.txt'));
		}
	}
 