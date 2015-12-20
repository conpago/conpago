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

class JsonPresenter implements IJsonPresenter
{

    public function showJson($data)
    {
        echo json_encode($data, JSON_FORCE_OBJECT);

    }
}
