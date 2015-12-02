<?php
    /**
     * Created by PhpStorm.
     * User: bg
     * Date: 11.10.14
     * Time: 13:55
     */

    namespace Conpago\Helpers;

use Conpago\File\Contract\IFileSystem;
use Conpago\File\Contract\IPath;

class AppPathTest extends \PHPUnit_Framework_TestCase
    {
        const BASE_PATH = 'base_path';
        const REAL_PATH = 'real';

        private $fileSystem;

        /**
         * @var AppPath
         */
        private $appPath;

        public function setUp()
        {
            $this->appPath = new AppPath(new TestFileSystem(), self::BASE_PATH);
        }

        public function testAppPathReturnsConfigPath()
        {
            $expected = 'base_path'.DIRECTORY_SEPARATOR.'config';
            $this->assertPath($expected, $this->appPath->config());
        }

        public function testAppPathReturnsCachePath()
        {
            $expected = 'base_path'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'cache';
            $expectedReal = 'real'.DIRECTORY_SEPARATOR.$expected;
            $this->assertPath($expected, $this->appPath->cache());
        }

        public function testAppPathReturnsSessionsPath()
        {
            $expected = 'base_path'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'sessions';
            $this->assertPath($expected, $this->appPath->sessions());
        }

        public function testAppPathReturnsRootPath()
        {
            $expected = 'base_path';
            $this->assertPath($expected, $this->appPath->root());
        }

        public function testAppPathReturnsSourcePath()
        {
            $expected = 'base_path'.DIRECTORY_SEPARATOR.'src';
            $this->assertPath($expected, $this->appPath->source());
        }

        public function testAppPathReturnsTemplatesPath()
        {
            $expected = 'base_path'.DIRECTORY_SEPARATOR.'templates';
            $this->assertPath($expected, $this->appPath->templates());
        }

        /**
         * @param string $expected
         * @param string $expectedReal
         * @param IPath $path
         */
        protected function assertPath($expected, IPath $path)
        {
            $expectedReal = 'real'.DIRECTORY_SEPARATOR.$expected;;
            $this->assertEquals(
                ['path' => $expected, 'realPath' => $expectedReal],
                ['path' => $path->get(), 'realPath' => $path->getReal()]
            );
        }
    }

    class TestFileSystem implements IFileSystem
    {

        public function includeFile($filePath)
        {
            throw new \Exception('Not implemented!');
        }

        public function glob($pattern)
        {
            throw new \Exception('Not implemented!');
        }

        public function realPath($path)
        {
            return AppPathTest::REAL_PATH.DIRECTORY_SEPARATOR.$path;
        }

        public function getFileContent($filename)
        {
            throw new \Exception('Not implemented!');
        }

        public function setFileContent($filename, $content)
        {
            throw new \Exception('Not implemented!');
        }

        public function requireOnce($filePath)
        {
            throw new \Exception('Not implemented!');
        }

        public function requireFile($filePath)
        {
            throw new \Exception('Not implemented!');
        }

        public function loadClass($className)
        {
            throw new \Exception('Not implemented!');
        }
    }
