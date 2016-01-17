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
use Conpago\Contract\IApp;
use Conpago\Helpers\Contract\IRequestData;
use Conpago\Helpers\Contract\IRequestDataReader;
use Conpago\Helpers\Contract\IResponse;
use Conpago\Logging\Contract\ILogger;
use Conpago\Presentation\Contract\IController;

/**
 * Represents web application which handle Http requests.
 */
class WebApp implements IApp
{

    /**
     * Controller which handle request.
     *
     * @var IController
     */
    private $controller;

    /**
     * Provides access to request data.
     *
     * @var IRequestDataReader
     */
    private $requestDataReader;

    /**
     * Provides ability to set response http specific data.
     *
     * @var IResponse
     */
    private $response;

    /**
     * Provides ability for logging.
     *
     * @var ILogger
     */
    private $logger;

    /**
     * Application configuration provider.
     *
     * @var IAppConfig
     */
    private $appConfig;

    /**
     * Creates new instance of web application.
     *
     * @param IRequestDataReader $requestDataReader Provides access to request data.
     * @param IController        $controller        Controller which handle request.
     * @param IResponse          $response          Provides ability to set response http specific data.
     * @param ILogger            $logger            Provides ability for logging.
     * @param IAppConfig         $appConfig         Application configuration provider.
     */
    public function __construct(
        IRequestDataReader $requestDataReader,
        IController $controller,
        IResponse $response,
        ILogger $logger,
        IAppConfig $appConfig
    ) {
        $this->requestDataReader = $requestDataReader;
        $this->controller        = $controller;
        $this->response          = $response;
        $this->logger            = $logger;
        $this->appConfig         = $appConfig;

    }

    /**
     * Process the request, and generate output.
     *
     * @return void
     */
    public function run()
    {
        try {
            $this->init();
            $this->executeController();
        } catch (\Exception $e) {
            $this->logger->addCritical('Exception caught', array('exception' => $e));
            $this->response->setHttpResponseCode(500);
        }

    }

    /**
     * Gets request data from request data reader.
     *
     * @return IRequestData Current request data.
     */
    private function getRequestData()
    {
        return $this->requestDataReader->getRequestData();

    }

    /**
     * Executes controller with request data as parameter.
     *
     * @return void
     */
    private function executeController()
    {
        $this->controller->execute($this->getRequestData());

    }

    /**
     * Initialize application using config data.
     *
     * @return void
     */
    private function init()
    {
        $timeZone = $this->appConfig->getTimeZone();
        if ($timeZone != null) {
            date_default_timezone_set($timeZone);
        }

    }
}
