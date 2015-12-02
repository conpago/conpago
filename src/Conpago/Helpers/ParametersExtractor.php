<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2015-12-02
 * Time: 09:45
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
