<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2014-06-15
 * Time: 10:38
 */

namespace Conpago\Presentation;

use Exception;

class PlainPresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testGeneratesNullPlain()
    {
        $this->expectOutputString(null);

        $plainPresenter = new PlainPresenter();
        $plainPresenter->show(null);
    }

    public function test_GeneratesEmptyPlain()
    {
        $this->expectOutputString('');

        $plainPresenter = new PlainPresenter();
        $plainPresenter->show('');
    }

    public function test_ShowNumberAsString()
    {
        $this->expectOutputString(10);

        $plainPresenter = new PlainPresenter();
        $plainPresenter->show(10);
    }

    public function test_GeneratesErrorForArray()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Argument $data cannot be array.');

        $plainPresenter = new PlainPresenter();
        $plainPresenter->show(array('test' => 'a'));
    }

    public function test_GeneratesErrorForObject()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Argument $data cannot be object.');

        $plainPresenter = new PlainPresenter();
        $plainPresenter->show((object)array('test' => 'a'));
    }
}
