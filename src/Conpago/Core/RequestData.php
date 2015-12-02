<?php
    /**
     * Created by PhpStorm.
     * User: Bartosz Gołek
     * Date: 09.11.13
     * Time: 15:30
     */

    namespace Conpago\Core;

use Conpago\Helpers\Contract\IRequestData;

    class RequestData implements IRequestData
    {
        /** @var array */
        private $urlElements;

        /** @var string */
        private $requestMethod;

        /** @var string */
        private $format;

        /** @var array */
        private $parameters;

        /**
         * @return array
         */
        public function getUrlElements()
        {
            return $this->urlElements;
        }

        /**
         * @param $value
         */
        public function setUrlElements($value)
        {
            $this->urlElements = $value;
        }

        /**
         * @return string
         */
        public function getRequestMethod()
        {
            return $this->requestMethod;
        }

        /**
         * @param $value
         */
        public function setRequestMethod($value)
        {
            $this->requestMethod = $value;
        }

        /**
         * @return array
         */
        public function getParameters()
        {
            return $this->parameters;
        }

        /**
         * @param $value
         */
        public function setParameters($value)
        {
            $this->parameters = $value;
        }

        /**
         * @return string
         */
        public function getFormat()
        {
            return $this->format;
        }

        /**
         * @param $value
         */
        public function setFormat($value)
        {
            $this->format = $value;
        }
    }
