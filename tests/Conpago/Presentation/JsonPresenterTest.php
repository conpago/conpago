<?php
    /**
     * Created by PhpStorm.
     * User: Bartosz Gołek
     * Date: 2014-06-15
     * Time: 10:38
     */

    namespace Conpago\Presentation;

class JsonPresenterTest extends \PHPUnit_Framework_TestCase
{
    public function testGeneratesNullJson()
    {
        $this->expectOutputString(null);

        $jsonPresenter = new JsonPresenter();
        $jsonPresenter->showJson(null);
    }

    public function test_GeneratesEmptyJson()
    {
        $this->expectOutputString('""');

        $jsonPresenter = new JsonPresenter();
        $jsonPresenter->showJson('');
    }

    public function test_GeneratesArrayJson()
    {
        $this->expectOutputString('{"test":"a"}');

        $jsonPresenter = new JsonPresenter();
        $jsonPresenter->showJson(array('test' => 'a'));
    }
}
