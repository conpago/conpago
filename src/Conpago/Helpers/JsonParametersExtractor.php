<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2015-12-02
 * Time: 09:46
 *
 * @package    Conpago
 * @subpackage Helpers
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Helpers;

/**
 * Tool class for extract parameters from json object .
 */
class JsonParametersExtractor extends ParametersExtractor
{

    /**
     * Gets extracted parametrs.
     *
     * @return array Extracted parameters.
     */
    public function getParameters()
    {
        $bodyParams = json_decode($this->body, true);
        if (!$bodyParams) {
            return array();
        }

        $parameters = array();
        foreach ($bodyParams as $paramName => $paramValue) {
            $parameters[$paramName] = $paramValue;
        }

        return $parameters;
    }
}
