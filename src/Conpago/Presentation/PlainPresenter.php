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

use Conpago\Presentation\Contract\IPlainPresenter;
use InvalidArgumentException;

/**
 * Default implementation for presenting data as is.
 */
class PlainPresenter implements IPlainPresenter
{

    /**
     * Serialize and present data as is.
     *
     * @param mixed $data Data to present.
     *
     * @return void
     *
     * @throws InvalidArgumentException If the provided argument is of type 'array' or 'object'.
     */
    public function show($data)
    {
        if (is_array($data)) {
            throw new InvalidArgumentException('Argument $data cannot be array.');
        }

        if (is_object($data)) {
            throw new InvalidArgumentException('Argument $data cannot be object.');
        }

        echo $data;

    }
}
