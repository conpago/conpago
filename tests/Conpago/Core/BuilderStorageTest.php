<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2014-10-17
 * Time: 08:10
 */

namespace Conpago\Core;

class BuilderStorageTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfiguration()
    {
        $fileSystem = $this->getMock('Conpago\File\Contract\IFileSystem');
        $appPath = $this->getMock('Conpago\Helpers\Contract\IAppPath');
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
        $fileSystem = $this->getMock('Conpago\File\Contract\IFileSystem');
        $appPath = $this->getMock('Conpago\Helpers\Contract\IAppPath');
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
