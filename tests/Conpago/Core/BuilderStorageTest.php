<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2014-10-17
 * Time: 08:10
 */

namespace Conpago\Core;

use Conpago\File\Contract\IFileSystem;
use Conpago\Helpers\Contract\IAppPath;

class BuilderStorageTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfiguration()
    {
        $fileSystem = $this->createMock(IFileSystem::class);
        $appPath = $this->createMock(IAppPath::class);
        $appPath->expects($this->any())->method('root')->willReturn('root');

        $builderStorage = new BuilderStorage($fileSystem, $appPath, 'context');

        $fileSystem
                ->expects($this->once())
                ->method('getFileContent')
                ->with('root'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'persistent'.DIRECTORY_SEPARATOR.'contextContainer');

        $builderStorage->getConfiguration();
    }

    public function testSetConfiguration()
    {
        $fileSystem = $this->createMock(IFileSystem::class);
        $appPath = $this->createMock(IAppPath::class);
        $appPath->expects($this->any())->method('root')->willReturn('root');

        $builderStorage = new BuilderStorage($fileSystem, $appPath, 'context');

        $results = serialize(array('a' => 'a'));
        $fileSystem
                ->expects($this->once())
                ->method('setFileContent')
                ->with(
                    'root'.DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'persistent'.DIRECTORY_SEPARATOR.'contextContainer',
                    $results
                );

        $builderStorage->putConfiguration(array('a' => 'a'));
    }
}
