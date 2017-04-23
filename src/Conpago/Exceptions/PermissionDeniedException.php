<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 28.11.13
 * Time: 22:03
 *
 * @package    Conpago
 * @subpackage Base
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Exceptions;

/**
 * General exception thrown when permission to resource is not granted.
 */
class PermissionDeniedException extends Exception
{

    /**
     * Creates new PermissionDeniedException instance.
     *
     * @param string         $message  User readable exception message.
     * @param integer        $code     Internal code of exception.
     * @param Exception|null $previous Exception which causes thrown.
     */
    public function __construct($message = '', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);

    }
}
