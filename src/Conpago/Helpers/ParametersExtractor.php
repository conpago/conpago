<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2015-12-02
 * Time: 09:45
 *
 * @package    Conpago
 * @subpackage Helpers
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Helpers;

abstract class ParametersExtractor
{

    protected $body;

    public function __construct($body)
    {
        $this->body = $body;

    }

    /**
     * @return array
     */
    abstract public function getParameters();
}
