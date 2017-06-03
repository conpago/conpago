<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-06-15
 * Time: 10:38
 */

namespace Conpago\Presentation;

use Exception;
use PHPUnit\Framework\TestCase;

class PlainPresenterTest extends TestCase
{
    public function testShowShouldPrintNothingIfDataIsEmpty()
    {
        $this->expectOutputString('');

        $plainPresenter = new PlainPresenter();
        $plainPresenter->show('');
    }

    public function testShowShouldPrintNumbersAsString()
    {
        $this->expectOutputString('10');

        $plainPresenter = new PlainPresenter();
        $plainPresenter->show(10);
    }

    public function testShowShouldThrowExceptionIfArrayIsPassed()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Argument $data cannot be array.');

        $plainPresenter = new PlainPresenter();
        $plainPresenter->show(array('test' => 'a'));
    }

    public function testShowShouldThrowExceptionIfObjectIsPassed()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Argument $data cannot be object.');

        $plainPresenter = new PlainPresenter();
        $plainPresenter->show((object)array('test' => 'a'));
    }
}
