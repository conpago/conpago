<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Database\Exceptions;

	use Saigon\Conpago\Exceptions\Exception;

	class ColumnUniqueConstraintException extends Exception
	{

		function __construct($columnName = null, \Exception $innerException)
		{

			$this->columnName = $columnName;
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