<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-10-17
 * Time: 08:10
 */

namespace Conpago\Core;

use Conpago\File\Contract\IFileSystem;
use Conpago\Helpers\Contract\IAppPath;
use PHPUnit\Framework\TestCase;

class BuilderStorageTest extends TestCase
{
    const CONTEXT_CONTAINER_PATH =
        'root' . DIRECTORY_SEPARATOR.
        'tmp' . DIRECTORY_SEPARATOR.
        'persistent' . DIRECTORY_SEPARATOR.
        'contextContainer';

    public function testGetConfiguration()
    {
        $fileSystem = $this->createMock(IFileSystem::class);
        $appPath = $this->createMock(IAppPath::class);
        $appPath->expects($this->any())->method('root')->willReturn('root');

        $builderStorage = new BuilderStorage($fileSystem, $appPath, 'context');

        $fileSystem
                ->expects($this->once())
                ->method('getFileContent')
                ->with(self::CONTEXT_CONTAINER_PATH);

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
                    self::CONTEXT_CONTAINER_PATH,
                    $results
                );

        $builderStorage->putConfiguration(array('a' => 'a'));
    }
}
