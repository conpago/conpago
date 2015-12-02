<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2015-12-02
 * Time: 09:47
 */

namespace Conpago\Helpers;

class FormParametersExtractor extends ParametersExtractor
{
    /**
     * @return array
     */
    public function getParameters()
    {
        $parameterTreeBuilder = new ParameterTreeBuilder();
        $postVars = $parameterTreeBuilder->getParams($this->body);

        $parameters = array();
        foreach ($postVars as $field => $value) {
            $parameters[$field] = $value;
        }

        return $parameters;
    }
}
