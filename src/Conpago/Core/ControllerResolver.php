<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 09.11.13
 * Time: 15:30
 *
 * @package    Conpago
 * @subpackage Core
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Core;

use Conpago\Config\Contract\IAppConfig;
use Conpago\DI\IFactory;
use Conpago\Exceptions\ControllerNotFoundException;
use Conpago\Helpers\Contract\IRequestDataReader;
use Conpago\Presentation\Contract\IController;
use Conpago\Presentation\Contract\IControllerResolver;

/**
 * Class resolves controller based on request and configuration.
 */
class ControllerResolver implements IControllerResolver
{

    /**
     * Application configuration.
     *
     * @var \Conpago\Config\Contract\IAppConfig
     */
    private $appConfig;

    /**
     * Creates new instance of controller resolver.
     *
     * @param IRequestDataReader $requestDataReader   Request data access provider.
     * @param IAppConfig         $appConfig           Application configuration.
     * @param IFactory[]         $controllerFactories Collection of named controller factories.
     *
     * @inject Factory <\Conpago\Presentation\Contract\IController> $controllerFactories
     */
    public function __construct(
        IRequestDataReader $requestDataReader,
        IAppConfig $appConfig,
        array $controllerFactories
    ) {
        $this->controllerFactories = $controllerFactories;
        $this->requestDataReader   = $requestDataReader;
        $this->appConfig           = $appConfig;
    }

    /**
     * Gets controller instance.
     * Controller instance is produced with factory of name from request or default name from configuration.
     *
     * @return IController Instance of produced controller.
     *
     * @throws ControllerNotFoundException If factory with given name does not exists.
     */
    public function getController()
    {
        $params         = $this->requestDataReader->getRequestData()->getParameters();
        $controllerName = $this->appConfig->getDefaultInteractor();

        if (isset($params['interactor'])) {
            $controllerName = $params['interactor'];
        };

        $controllerArrayKey = $controllerName.'Controller';

        if (!array_key_exists($controllerArrayKey, $this->controllerFactories)) {
            throw new ControllerNotFoundException('Controller \''.$controllerName.'\' not found.');
        }

        return $this->controllerFactories[$controllerArrayKey]->createInstance();
    }

    /**
     *  Collection of named controller factories.
     *
     * @var IFactory[]
     */
    protected $controllerFactories;

    /**
     * Request data access provider.
     *
     * @var IRequestDataReader
     */
    private $requestDataReader;
}
