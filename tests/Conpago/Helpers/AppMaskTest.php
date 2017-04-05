<?php
/**
 * Created by PhpStorm.
 * User: bg
 * Date: 10.10.14
 * Time: 22:58
 */

namespace Conpago\Helpers;

use Conpago\File\Path;
use Conpago\Helpers\Contract\IAppPath;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

class AppMaskTest extends TestCase
{
    /** @var IAppPath | MockObject */
    private $appPath;

    /** @var AppMask */
    private $appMask;

    const SRC = 'src';

    const CONFIG = 'config';

    protected function setUp()
    {
        $this->appPath = $this->createMock(IAppPath::class);
        $this->appPath->expects($this->any())->method('source')->willReturn(new Path(self::SRC,self::SRC));
        $this->appPath->expects($this->any())->method('config')->willReturn(new Path(self::CONFIG,self::CONFIG));

        $this->appMask = new AppMask($this->appPath);
    }

    public function testModuleMask()
    {
        $this->assertEquals(
                $this->buildPath(array(self::SRC, '*Module.php')),
                $this->appMask->moduleMask());
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
