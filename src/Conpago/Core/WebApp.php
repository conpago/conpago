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
use Conpago\Helpers\Contract\IRequestDataReader;
use Conpago\Helpers\Contract\IResponse;
use Conpago\Logging\Contract\ILogger;
use Conpago\Presentation\Contract\IController;

class WebApp implements IApp
{

    /**
     * @var IController
     */
    private $controller;

    /**
     * @var IRequestDataReader
     */
    private $requestDataReader;

    /**
     * @var IResponse
     */
    private $response;

    /**
     * @var ILogger
     */
    private $logger;

    /**
     * @var IAppConfig
     */
    private $appConfig;

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
     * Process the request, and generate output
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

    private function getRequestData()
    {
        return $this->requestDataReader->getRequestData();

    }

    private function executeController()
    {
        $this->controller->execute($this->getRequestData());

    }

    private function init()
    {
        $timeZone = $this->appConfig->getTimeZone();
        if ($timeZone != null) {
            date_default_timezone_set($timeZone);
        }

    }
}
