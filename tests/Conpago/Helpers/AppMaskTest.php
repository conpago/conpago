<?php
/**
 * Created by PhpStorm.
 * User: bg
 * Date: 10.10.14
 * Time: 22:58
 */

namespace Conpago\Helpers;

use Conpago\File\Contract\IPath;
use Conpago\Helpers\Contract\IAppPath;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class AppMaskTest extends TestCase
{
    /** @var IAppPath */
    private $appPath;

    /** @var  IPath | MockObject */
    private $srcPath;

    /** @var  IPath | MockObject */
    private $configPath;

    /** @var AppMask */
    private $appMask;

    const SRC = 'src';
    const CONFIG = 'config';

    protected function setUp()
    {
        $this->appPath = $this->createMock(IAppPath::class);
        $this->srcPath = $this->createMock(IPath::class);
        $this->srcPath->method('get')->willReturn(self::SRC);

        $this->configPath = $this->createMock(IPath::class);
        $this->configPath->method('get')->willReturn(self::CONFIG);

        $this->appPath->method('source')->willReturn($this->srcPath);
        $this->appPath->method('config')->willReturn($this->configPath);

        $this->appMask = new AppMask($this->appPath);
    }

    public function testModuleMask()
    {
        $this->assertEquals(
            $this->buildPath(array(self::SRC, '*Module.php')),
            $this->appMask->moduleMask()
        );
    }

    public function testConfigMask()
    {
        $this->assertEquals(
            $this->buildPath(array(self::CONFIG, '*.php')),
            $this->appMask->configMask()
        );
    }

    private function buildPath(array $array)
    {
        return implode(DIRECTORY_SEPARATOR, $array);
    }
}
