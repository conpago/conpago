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

class ParameterTreeBuilder
{

    public function getParams($str)
    {
        $pairs             = $this->extractNameValuePairs($str);
        $flatParameterList = $this->parseNameValuePairs($pairs);
        return $this->explodeTree($flatParameterList, '.');

    }

    /**
     * @param array  $array
     * @param string $delimiter
     *
     * @return array|boolean
     */
    private function explodeTree(array $array, $delimiter = '_')
    {
        $splitRE   = '/'.preg_quote($delimiter, '/').'/';
        $returnArr = array();
        foreach ($array as $key => $val) {
            // Get parent parts and the current leaf
            $parts    = preg_split($splitRE, $key, -1, PREG_SPLIT_NO_EMPTY);
            $leafPart = array_pop($parts);

            // Build parent structure
            // Might be slow for really deep and large structures
            $parentArr = & $returnArr;
            foreach ($parts as $part) {
                if (!isset($parentArr[$part])) {
                    $parentArr[$part] = array();
                }

                $parentArr = & $parentArr[$part];
            }

            // Add the final part to the structure
            if (empty($parentArr[$leafPart])) {
                $parentArr[$leafPart] = $val;
            }
        }//end foreach

        return $returnArr;

    }

    /**
     * @param $str
     *
     * @return array
     */
    private function extractNameValuePairs($str)
    {
        // split on outer delimiter
        return explode('&', $str);

    }

    /**
     * @param $pairs
     *
     * @return array
     */
    private function parseNameValuePairs($pairs)
    {
        $builder = new NameValueCollectionBuilder($pairs);
        return $builder->build();

    }
}
