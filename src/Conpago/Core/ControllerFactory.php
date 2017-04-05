<?php


namespace Conpago\Core;


use Conpago\DI\IFactory;
use Conpago\Exceptions\ControllerNotFoundException;
use Conpago\Presentation\Contract\IController;

class ControllerFactory
{

    /** @var array|IFactory[] */
    private $controllerFactories;

    /**
     * @param IFactory[]         $controllerFactories Collection of named controller factories.
     *
     * @inject Factory <\Conpago\Presentation\Contract\IController> $controllerFactories
     */
    public function __construct(array $controllerFactories)
    {
        $this->controllerFactories = $controllerFactories;
    }

    /**
     * @param string $controllerName
     *
     * @return IController
     *
     * @throws ControllerNotFoundException
     */
    public function createController($controllerName)
    {
        if (!array_key_exists($controllerName, $this->controllerFactories)) {
            throw new ControllerNotFoundException($controllerName);
        }

        return $this->controllerFactories[$controllerName]->createInstance();
    }

}