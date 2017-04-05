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

use Conpago\Presentation\Contract\IJsonPresenter;

/**
 * Default implementation for presenting data as JSON.
 */
class JsonPresenter implements IJsonPresenter
{

    /**
     * Serialize and present data as JSON.
     *
     * @param array $data Data to serialize.
     *
     * @return void
     */
    public function showJson(array $data = null)
    {
        if (!headers_sent()) {
            header('Content-Type: application/json');
        }

        if ($data == null) {
            echo '""';
        } else {
            echo json_encode($data, JSON_FORCE_OBJECT);
        }
    }
}
