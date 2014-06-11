<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago;

	class RequestData
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
		function getUrlElements()
		{
			return $this->urlElements;
		}

		/**
		 * @param $value
		 */
		function setUrlElements($value)
		{
			$this->urlElements = $value;
		}

		/**
		 * @return string
		 */
		function getRequestMethod()
		{
			return $this->requestMethod;
		}

		/**
		 * @param $value
		 */
		function setRequestMethod($value)
		{
			$this->requestMethod = $value;
		}

		/**
		 * @return array
		 */
		function getParameters()
		{
			return $this->parameters;
		}

		/**
		 * @param $value
		 */
		function setParameters($value)
		{
			$this->parameters = $value;
		}

		/**
		 * @return string
		 */
		function getFormat()
		{
			return $this->format;
		}

		/**
		 * @param $value
		 */
		function setFormat($value)
		{
			$this->format = $value;
		}
	}
