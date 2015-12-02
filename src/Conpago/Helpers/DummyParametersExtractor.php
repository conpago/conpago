<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2015-12-02
 * Time: 09:48
 */

namespace Conpago\Helpers;

class DummyParametersExtractor extends ParametersExtractor
{
    /**
     * @return array
     */
    public function getParameters()
    {
        return [];
    }
}
