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

/**
 * General exception for broken unique constraint.
 */
class ColumnUniqueConstraintException extends Exception
{

    /**
     * Creates exception instance.
     *
     * @param string|null $columnName     Name of not unique column.
     * @param \Exception  $innerException Base exception thrown from database access package.
     */
    public function __construct($columnName = null, \Exception $innerException = null)
    {
        $this->columnName     = $columnName;
        $this->innerException = $innerException;

    }

    /**
     * Name of not unique column.
     *
     * @var string
     */
    public $columnName;

    /**
     * Base exception thrown from database access package.
     *
     * @var \Exception
     */
    public $innerException;
}
