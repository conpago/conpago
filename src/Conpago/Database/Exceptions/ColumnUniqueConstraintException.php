<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 09.11.13
 * Time: 15:30
 *
 * @package    Conpago
 * @subpackage Database
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Database\Exceptions;

use Conpago\Exceptions\Exception;

class ColumnUniqueConstraintException extends Exception
{

    /**
     * @param null       $columnName
     * @param \Exception $innerException
     */
    public function __construct($columnName = null, \Exception $innerException = null)
    {
        $this->columnName     = $columnName;
        $this->innerException = $innerException;

    }

    /**
     * @var string
     */
    public $columnName;

    /**
     * @var \Exception
     */
    public $innerException;
}
