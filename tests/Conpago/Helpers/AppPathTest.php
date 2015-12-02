<?php
    /**
     * Created by PhpStorm.
     * User: bg
     * Date: 11.10.14
     * Time: 13:55
     */

    namespace Conpago\Helpers;

use Conpago\File\Contract\IFileSystem;

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
            $this->assertEquals('base_path'.DIRECTORY_SEPARATOR.'config', $this->appPath->config());
        }

        public function testAppPathReturnsRealConfigPath()
        {
            $this->assertEquals('real'.DIRECTORY_SEPARATOR.'base_path'.DIRECTORY_SEPARATOR.'config', $this->appPath->realConfig());
        }

        public function testAppPathReturnsCachePath()
        {
            $this->assertEquals('base_path'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'cache', $this->appPath->cache());
        }

        public function testAppPathReturnsRealCachePath()
        {
            $this->assertEquals('real'.DIRECTORY_SEPARATOR.'base_path'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'cache', $this->appPath->realCache());
        }

        public function testAppPathReturnsSessionsPath()
        {
            $this->assertEquals('base_path'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'sessions', $this->appPath->sessions());
        }

        public function testAppPathReturnsRealSessionsPath()
        {
            $this->assertEquals('real'.DIRECTORY_SEPARATOR.'base_path'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'sessions', $this->appPath->realSessions());
        }

        public function testAppPathReturnsRootPath()
        {
            $this->assertEquals('base_path', $this->appPath->root());
        }

        public function testAppPathReturnsRealRootPath()
        {
            $this->assertEquals('real'.DIRECTORY_SEPARATOR.'base_path', $this->appPath->realRoot());
        }

        public function testAppPathReturnsSourcePath()
        {
            $this->assertEquals('base_path'.DIRECTORY_SEPARATOR.'src', $this->appPath->source());
        }

        public function testAppPathReturnsRealSourcePath()
        {
            $this->assertEquals('real'.DIRECTORY_SEPARATOR.'base_path'.DIRECTORY_SEPARATOR.'src', $this->appPath->realSource());
        }

        public function testAppPathReturnsTemplatesPath()
        {
            $this->assertEquals('base_path'.DIRECTORY_SEPARATOR.'templates', $this->appPath->templates());
        }

        public function testAppPathReturnsTemplatesSourcePath()
        {
            $this->assertEquals('real'.DIRECTORY_SEPARATOR.'base_path'.DIRECTORY_SEPARATOR.'templates', $this->appPath->realTemplates());
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
