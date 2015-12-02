<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2015-12-02
 * Time: 09:46
 */

namespace Conpago\Helpers;

class JsonParametersExtractor extends ParametersExtractor
{
    /**
     * @return array
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
