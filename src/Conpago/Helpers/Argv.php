<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2015-12-02
 * Time: 09:50
 *
 * @package    Conpago
 * @subpackage Helpers
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Helpers;

/**
 * Class Argv represents parameters given when calling script from command line
 */
class Argv
{

    /**
     * Argv constructor.
     */
    public function __construct()
    {
        $this->options   = array();
        $this->arguments = array();
    }

    /**
     * @var array key value pairs for options
     */
    public $options;

    /** @var array */
    public $arguments;

    /** @var string script name */
    public $script;
}
