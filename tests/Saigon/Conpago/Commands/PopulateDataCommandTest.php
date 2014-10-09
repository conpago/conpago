<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2014-10-09
 * Time: 12:38
 */

namespace Saigon\Conpago\Commands;


class PopulateDataCommandTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $upgrade1 = $this->getNewUpgradeMock();
        $upgrade2 = $this->getNewUpgradeMock();
        $upgrade3 = $this->getNewUpgradeMock();

        $upgrades = array ($upgrade1, $upgrade2, $upgrade3);

        $populateDataCommand = new PopulateDataCommand($upgrades);
        $populateDataCommand->execute();
    }

    public function getNewUpgradeMock()
    {
        $upgrade = $this->getMock('Saigon\Conpago\Upgrades\Contract\IUpgrade');
        $upgrade->expects($this->once())->method('run');

        return $upgrade;
    }
}
 