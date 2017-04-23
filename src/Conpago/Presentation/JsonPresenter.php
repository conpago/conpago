<?php
/**
 * Created by PhpStorm.
 * User: bg
 * Date: 13.05.14
 * Time: 21:57
 *
 * @package    Conpago
 * @subpackage Presentation
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Presentation;

use Conpago\Helpers\Contract\IResponse;
use Conpago\Presentation\Contract\IJsonPresenter;

/**
 * Default implementation for presenting data as JSON.
 */
class JsonPresenter implements IJsonPresenter
{
    /** @var IResponse */
    private $response;

    /**
     * JsonPresenter constructor.
     *
     * @param IResponse $response
     */
    public function __construct(IResponse $response)
    {
        $this->response = $response;
    }

    /**
     * Serialize and present data as JSON.
     *
     * @param array $data Data to serialize.
     *
     * @return void
     */
    public function showJson(array $data)
    {
        $this->response->setContentType('application/json');

        echo json_encode($data, JSON_FORCE_OBJECT);
    }
}
