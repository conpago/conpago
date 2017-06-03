<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 11.10.14
 * Time: 13:55
 */

namespace Conpago\Helpers;

use Conpago\File\Contract\IFileSystem;
use Conpago\File\Contract\IPath;
use PHPUnit\Framework\TestCase;

class AppPathTest extends TestCase
{
    const BASE_PATH = 'base_path';
    const REAL_PATH = 'realPath';


    /** @var AppPath */
    private $appPath;

    public function setUp()
    {
        $fileSystem = $this->createMock(IFileSystem::class);
        $fileSystem->method('realPath')->willReturn(self::REAL_PATH);
        $this->appPath = new AppPath($fileSystem, self::BASE_PATH);
    }

    public function testAppPathReturnsConfigPath()
    {
        $expected = 'base_path'.DIRECTORY_SEPARATOR.'config';
        $this->assertPath($expected, $this->appPath->config());
    }

    public function testAppPathReturnsCachePath()
    {
        $expected = 'base_path'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'cache';
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
         * @param IPath $path
         */
    protected function assertPath($expected, IPath $path)
    {
        $this->assertEquals(
            ['path' => $expected, self::REAL_PATH => self::REAL_PATH],
            ['path' => $path->get(), self::REAL_PATH => $path->getReal()]
        );
    }
}
