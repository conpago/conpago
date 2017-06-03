<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 2015-12-02
 * Time: 09:49
 *
 * @package    Conpago
 * @subpackage Helpers
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Helpers;

/**
 * Provides tool to build associative array from array of strings separated by equals sign.
 * This is ObjectMethod and every instance should be used once.
 */
class NameValueCollectionBuilder
{

    private $pairs;

    private $flatParameterList = array();

    /**
     * NameValueCollectionBuilder constructor.
     *
     * @param string[] $pairs Collection of strings containing name=value scheme.
     */
    public function __construct(array $pairs)
    {
        $this->pairs = $pairs;
    }

    /**
     * Build associative array from pairs passed by constructor.
     * If name exists multiple times in collection, values will be grouped into array and
     * returned as value of name key.
     *
     * @return array Associative array with key => value pairs
     */
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
     * @param string $pair
     *
     * @return array
     */
    private function createNamedValueFromNameValueString($pair)
    {
        $exploded = explode('=', urldecode($pair), 2);
        if (count($exploded) < 2) {
            return null;
        }

        return (object) array(
                         'name'  => $exploded[0],
                         'value' => $exploded[1],
                        );
    }

    /**
     * @param string $namedValue
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
     * @param string $name
     *
     * @return boolean
     */
    private function isNameAlreadyExists($name)
    {
        return isset($this->flatParameterList[$name]);
    }

    /**
     * @param string $name
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
     * @param string $name
     *
     * @return boolean
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
