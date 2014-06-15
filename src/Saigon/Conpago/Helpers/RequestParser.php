<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Helpers;

	use Saigon\Conpago\RequestData;

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

		function __construct(IRequest $request)
		{
			$this->request = $request;
		}

		/**
		 * @return RequestData
		 */
		function parseRequestData()
		{
			if ($this->requestData == null)
			{
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
		 * @param $path_info
		 *
		 * @return array
		 */
		private function convertPathInfoToArray($path_info)
		{
			return $path_info != null ? explode('/', $path_info) : array();
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
			if ($queryString != null)
				return $parameterTreeBuilder->getParams($queryString);

			return array();
		}

		/**
		 * @return array
		 */
		private function parseBody()
		{
			$body = $this->request->getBody();
			return $this->extractParameters($this->contentType, $body);
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
			$parametersExtractor = ParametersExtractor::getExtractor($this->contentType, $body);
			return $parametersExtractor->getParameters();
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
		static function getExtractor($content_type, $body)
		{
			switch ($content_type)
			{
				case "application/json":
					return new JsonParametersExtractor($body);
				case "application/x-www-form-urlencoded":
					return new FormParametersExtractor($body);
				default:
					throw new \BadMethodCallException();
			}
		}

		protected $body;

		function __construct($body){
			$this->body = $body;
		}

		/**
		 * @return array
		 */
		abstract function getParameters();
	}

	class JsonParametersExtractor extends ParametersExtractor
	{
		/**
		 * @return array
		 */
		function getParameters()
		{
			$body_params = json_decode($this->body, true);
			if (!$body_params)
				return array();

			$parameters = array();
			foreach ($body_params as $param_name => $param_value)
				$parameters[$param_name] = $param_value;

			return $parameters;
		}
	}

	class FormParametersExtractor extends ParametersExtractor
	{
		/**
		 * @return array
		 */
		function getParameters()
		{
			$parameterTreeBuilder = new ParameterTreeBuilder();
			$postvars = $parameterTreeBuilder->getParams($this->body);

			$parameters = array();
			foreach ($postvars as $field => $value)
				$parameters[$field] = $value;

			return $parameters;
		}
	}

	class ParameterTreeBuilder
	{
		function getParams($str)
		{
			$pairs = $this->extractNameValuePairs($str);
			$flatParameterList = $this->parseNameValuePairs($pairs);
			return $this->explodeTree($flatParameterList, ".");
		}

		/**
		 * @param $array
		 * @param string $delimiter
		 * @param bool $baseval
		 *
		 * @return array|bool
		 */
		private function explodeTree($array, $delimiter = '_', $baseval = false)
		{
			if (!is_array($array))
				return false;

			$splitRE = '/' . preg_quote($delimiter, '/') . '/';
			$returnArr = array();
			foreach ($array as $key => $val)
			{
				// Get parent parts and the current leaf
				$parts = preg_split($splitRE, $key, -1, PREG_SPLIT_NO_EMPTY);
				$leafPart = array_pop($parts);

				// Build parent structure
				// Might be slow for really deep and large structures
				$parentArr = & $returnArr;
				foreach ($parts as $part)
				{
					if (!isset($parentArr[$part]))
					{
						$parentArr[$part] = array();
					}
					elseif (!is_array($parentArr[$part]))
					{
						if ($baseval)
						{
							$parentArr[$part] = array('__base_val' => $parentArr[$part]);
						}
						else
						{
							$parentArr[$part] = array();
						}
					}
					$parentArr = & $parentArr[$part];
				}

				// Add the final part to the structure
				if (empty($parentArr[$leafPart]))
				{
					$parentArr[$leafPart] = $val;
				}
				elseif ($baseval && is_array($parentArr[$leafPart]))
				{
					$parentArr[$leafPart]['__base_val'] = $val;
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

		function __construct($pairs)
		{
			$this->pairs = $pairs;
		}

		function build()
		{
			$this->convertPairsToList();
			return $this->flatParameterList;
		}

		/**
		 * @param $pair
		 *
		 * @return array
		 */
		private function createNamedValueFromNameValueString($pair)
		{
			$exploded = explode('=', urldecode($pair), 2);
			return (object)array("name" => $exploded[0], "value" => $exploded[1]);
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
		private function addScalarValue($name, $value)
		{
			$this->flatParameterList[$name] = $value;
		}

		/**
		 * @param $name
		 * @param $value
		 */
		private function addArrayValue($name, $value)
		{
			if ($this->isScalarValueConversionNeeded($name))
				$this->convertScalarToArray($name);

			$this->addValueToArray($name, $value);
		}

		/**
		 * @param $name
		 * @param $value
		 */
		private function addValueToArray($name, $value)
		{
			$this->flatParameterList[$name][] = $value;
		}

		/**
		 * @param $name
		 */
		private function convertScalarToArray($name)
		{
			$this->flatParameterList[$name] = array($this->flatParameterList[$name]);
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
		 * @param $namedValue
		 *
		 */
		private function addNamedValue($namedValue)
		{
			if ($this->isNameAlreadyExists($namedValue->name))
				$this->addArrayValue($namedValue->name, $namedValue->value);
			else
				$this->addScalarValue($namedValue->name, $namedValue->value);
		}

		private function convertPairsToList()
		{
			foreach ($this->pairs as $pair)
				$this->addNamedValue($this->createNamedValueFromNameValueString($pair));
		}
	}
