<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 13.11.13
 * Time: 19:27
 *
 * @package    Conpago
 * @subpackage Helpers
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Helpers;

use Conpago\Helpers\Contract\IArgs;
use Conpago\Utils\ServerAccessor;

class Args implements IArgs
{

    /**
     * @var ServerAccessor
     */
    private $server;

    private $argv;

    public function __construct(ServerAccessor $serverAccessor)
    {
        $this->server = $serverAccessor;

        if (!$this->server->contains('argv')) {
            return;
        }

        $this->argv = $this->parseArgv();
    }

    public function getArguments()
    {
        return $this->argv->arguments;
    }

    public function getScript()
    {
        return $this->argv->script;
    }

    /**
     * @param string $option
     *
     * @return string
     */
    public function getOption($option)
    {
        return $this->argv->options[$option];
    }

    /**
     * @param string $option
     *
     * @return boolean
     */
    public function hasOption($option)
    {
        return array_key_exists($option, $this->argv->options);
    }

    protected function parseArgv()
    {
        $argv = $this->server->getValue('argv');

        $argvParser = new ArgvParser($argv);
        return $argvParser->parse();
    }
}
