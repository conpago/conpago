<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2015-12-02
 * Time: 09:48
 *
 * @package    Conpago
 * @subpackage Helpers
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
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
