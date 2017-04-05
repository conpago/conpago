<?php


namespace Conpago\Routing;

use Conpago\Helpers\Contract\IRequestDataReader;
use Conpago\Routing\Config\Contract\IRoutingConfig;
use Conpago\Routing\Contract\IRouter;
use Conpago\Routing\Contract\MissingRoutingException;
use Conpago\Core\ControllerFactory;


class Router implements IRouter
{
    /** @var IRoutingConfig */
    private $routingConfig;

    /** @var IRequestDataReader */
    private $requestDataReader;

    /** @var ControllerFactory */
    private $controllerFactory;

    /**
     * @param IRequestDataReader $requestDataReader   Request data access provider.
     * @param IRoutingConfig     $routingConfig       Routing configuration.
     * @param ControllerFactory  $controllerFactory   Controller factory.
     */
    public function __construct(
        IRoutingConfig $routingConfig, 
        IRequestDataReader $requestDataReader,
        ControllerFactory $controllerFactory)
    {
        $this->routingConfig = $routingConfig;
        $this->requestDataReader = $requestDataReader;
        $this->controllerFactory = $controllerFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function getController()
    {
        $requestData = $this->requestDataReader->getRequestData();
        $requestMethod = $requestData->getRequestMethod();
        $urlElements = $requestData->getUrlElements();

        $path = '/' . implode('/', $urlElements);

        $controllerName = $this->routingConfig->getRoutings($requestMethod, $path);
        if (empty($controllerName)) {
            throw new MissingRoutingException($requestMethod, $path);
        }

        return $this->controllerFactory->createController($controllerName);
    }
}