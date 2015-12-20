<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2015-12-02
 * Time: 09:50
 *
 * @package    Conpago
 * @subpackage Helpers
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Helpers;

class ArgvParser
{

    private $argv;

    public function __construct(array $argv)
    {
        $this->argv = $argv;

    }

    public function parse()
    {
        $result = new Argv();
        $option = null;
        $first  = true;
        foreach ($this->argv as $arg) {
            if ($first == true) {
                $result->script = $arg;
                $first          = false;
                continue;
            }

            if ($option != null) {
                $result->options[$option] = $arg;
                $option                   = null;
                continue;
            }

            if ($this->isOption($arg)) {
                $option = $this->option($arg);
                continue;
            }

            $result->arguments[] = $arg;
        }

        return $result;

    }

    private function isOption($arg)
    {
        return $arg[0] == '-';

    }

    private function option($arg)
    {
        return substr($arg, 1);

    }
}
