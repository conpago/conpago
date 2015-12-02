<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2015-12-02
 * Time: 09:50
 */

namespace Conpago\Helpers;

class Argv
{
    public function __construct()
    {
        $this->options = array();
        $this->arguments = array();
    }

    public $options;
    public $arguments;
    public $script;
}
