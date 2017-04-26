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
use Conpago\Time\Contract\ITimeZone;

/**
 * Represents web application which handle Http requests.
 */
class WebApp implements IApp
{

    /** @var IController */
    private $controller;

    /** @var IRequestDataReader */
    private $requestDataReader;

    /** @var IResponse */
    private $response;

    /** @var ILogger */
    private $logger;

    /** @var IAppConfig */
    private $appConfig;

    /** @var ITimeZone */
    private $timeZone;

    /**
     * Creates new instance of web application.
     *
     * @param IRequestDataReader $requestDataReader Provides access to request data.
     * @param IController $controller Controller which handle request.
     * @param IResponse $response Provides ability to set response http specific data.
     * @param ILogger $logger Provides ability for logging.
     * @param ITimeZone $timeZone Provides wrapper for PHP timezone utilities.
     * @param IAppConfig $appConfig Application configuration provider.
     */
    public function __construct(
        IRequestDataReader $requestDataReader,
        IController $controller,
        IResponse $response,
        ILogger $logger,
        ITimeZone $timeZone,
        IAppConfig $appConfig
    ) {
        $this->requestDataReader = $requestDataReader;
        $this->controller        = $controller;
        $this->response          = $response;
        $this->logger            = $logger;
        $this->timeZone          = $timeZone;
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
        if (!empty($timeZone)) {
            $this->timeZone->setDefaultTimeZone($timeZone);
        }

    }
}
