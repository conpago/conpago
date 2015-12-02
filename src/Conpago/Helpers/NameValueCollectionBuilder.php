<?php
/**
 * Created by PhpStorm.
 * User: bgolek
 * Date: 2015-12-02
 * Time: 09:49
 */

namespace Conpago\Helpers;

class NameValueCollectionBuilder
{
    private $pairs;
    private $flatParameterList = array();

    public function __construct($pairs)
    {
        $this->pairs = $pairs;
    }

    public function build()
    {
        $this->convertPairsToList();
        return $this->flatParameterList;
    }

    private function convertPairsToList()
    {
        foreach ($this->pairs as $pair) {
            $this->addNamedValue($this->createNamedValueFromNameValueString($pair));
        }
    }

    /**
     * @param $pair
     *
     * @return array
     */
    private function createNamedValueFromNameValueString($pair)
    {
        $exploded = explode('=', urldecode($pair), 2);
        if (count($exploded) < 2) {
            return null;
        }

        return (object)array("name" => $exploded[0], "value" => $exploded[1]);
    }

    /**
     * @param $namedValue
     *
     */
    private function addNamedValue($namedValue)
    {
        if ($namedValue == null) {
            return;
        }

        if ($this->isNameAlreadyExists($namedValue->name)) {
            $this->addArrayValue($namedValue->name, $namedValue->value);
            return;
        }

        $this->addScalarValue($namedValue->name, $namedValue->value);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    private function isNameAlreadyExists($name)
    {
        return isset($this->flatParameterList[$name]);
    }

    /**
     * @param $name
     * @param $value
     */
    private function addArrayValue($name, $value)
    {
        if ($this->isScalarValueConversionNeeded($name)) {
            $this->flatParameterList[$name] = array($this->flatParameterList[$name]);
        }

        $this->flatParameterList[$name][] = $value;
    }

    /**
     * @param $name
     *
     * @return bool
     */
    private function isScalarValueConversionNeeded($name)
    {
        return !is_array($this->flatParameterList[$name]);
    }

    /**
     * @param $name
     * @param $value
     */
    private function addScalarValue($name, $value)
    {
        $this->flatParameterList[$name] = $value;
    }
}
