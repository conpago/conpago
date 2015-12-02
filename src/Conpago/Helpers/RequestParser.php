<?php
    /**
     * Created by PhpStorm.
     * User: Bartosz Gołek
     * Date: 09.11.13
     * Time: 15:30
     */

    namespace Conpago\Helpers;

use Conpago\Core\RequestData;
    use Conpago\Helpers\Contract\IRequest;
    use Conpago\Helpers\Contract\IRequestParser;

    class RequestParser implements IRequestParser
    {
        private $contentType;

        /**
         * @var RequestData
         */
        protected $requestData;

        /**
         * @var IRequest
         */
        private $request;

        public function __construct(IRequest $request)
        {
            $this->request = $request;
        }

        /**
         * @return RequestData
         */
        public function parseRequestData()
        {
            if ($this->requestData == null) {
                $this->requestData = new RequestData();

                $this->getRequestMethod();
                $this->initializeContentType();
                $this->getUrlElements();
                $this->parseIncomingParams();

                $this->determineFormat();
            }

            return $this->requestData;
        }

        private function getRequestMethod()
        {
            $this->requestData->setRequestMethod($this->request->getRequestMethod());
        }

        private function getUrlElements()
        {
            $this->requestData->setUrlElements($this->convertPathInfoToArray($this->request->getPathInfo()));
        }

        /**
         * @param $pathInfo
         *
         * @return array
         */
        private function convertPathInfoToArray($pathInfo)
        {
            return $pathInfo != null ? explode('/', $pathInfo) : array();
        }

        private function parseIncomingParams()
        {
            $urlParameters = $this->parseQueryString();
            $bodyParameters = $this->parseBody();

            $this->requestData->setParameters($this->mergeUrlAndBodyParameters($urlParameters, $bodyParameters));
        }

        /**
         * @return array
         */
        private function parseQueryString()
        {
            $parameterTreeBuilder = new ParameterTreeBuilder();
            $queryString = $this->request->getQueryString();
            if ($queryString != null) {
                return $parameterTreeBuilder->getParams($queryString);
            }

            return array();
        }

        /**
         * @return array
         */
        private function parseBody()
        {
            return $this->extractParameters($this->request->getBody());
        }

        /**
         * @param $urlParameters
         * @param $bodyParameters
         *
         * @return array
         */
        private function mergeUrlAndBodyParameters($urlParameters, $bodyParameters)
        {
            return array_merge($urlParameters, $bodyParameters);
        }

        /**
         * @param $body
         *
         * @return mixed
         */
        private function extractParameters($body)
        {
            $parametersExtractor = $this->getExtractor($this->contentType, $body);
            return $parametersExtractor->getParameters();
        }

        public function getExtractor($contentType, $body)
        {
            switch ($contentType) {
                case "application/json": return new JsonParametersExtractor($body);
                case "application/x-www-form-urlencoded": return new FormParametersExtractor($body);
                case "": return new DummyParametersExtractor($body);
                default: throw new \BadMethodCallException();
            }
        }

        /**
         * @return mixed
         */
        private function initializeContentType()
        {
            $this->contentType = $this->request->getContentType();
        }

        private function determineFormat()
        {
            $this->requestData->setFormat($this->getRequestDataFormat());
        }

        private function getRequestDataFormat()
        {
            return $this->contentType == "application/json" ? "json" : "html";
        }
    }

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

    class ParameterTreeBuilder
    {
        public function getParams($str)
        {
            $pairs = $this->extractNameValuePairs($str);
            $flatParameterList = $this->parseNameValuePairs($pairs);
            return $this->explodeTree($flatParameterList, ".");
        }

        /**
         * @param $array
         * @param string $delimiter
         *
         * @return array|bool
         */
        private function explodeTree($array, $delimiter = '_')
        {
            if (!is_array($array)) {
                return false;
            }

            $splitRE = '/' . preg_quote($delimiter, '/') . '/';
            $returnArr = array();
            foreach ($array as $key => $val) {
                // Get parent parts and the current leaf
                $parts = preg_split($splitRE, $key, -1, PREG_SPLIT_NO_EMPTY);
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
            }

            return $returnArr;
        }

        /**
         * @param $str
         *
         * @return array
         */
        private function extractNameValuePairs($str)
        {
            # split on outer delimiter
            return explode('&', $str);
        }

        /**
         * @param $pairs
         *
         * @return array
         */
        private function parseNameValuePairs($pairs)
        {
            $nameValueCollectionBuilder = new NameValueCollectionBuilder($pairs);
            return $nameValueCollectionBuilder->build();
        }
    }

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
            } else {
                $this->addScalarValue($namedValue->name, $namedValue->value);
            }
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
