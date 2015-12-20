<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 09.11.13
 * Time: 15:30
 *
 * @package    Conpago
 * @subpackage Helpers
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
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
            case "application/json":
                return new JsonParametersExtractor($body);
            case "application/x-www-form-urlencoded":
                return new FormParametersExtractor($body);
            case "":
                return new DummyParametersExtractor($body);
            default:
                throw new \BadMethodCallException();
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
