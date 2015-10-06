<?php
	/**
	 * Created by PhpStorm.
	 * User: bg
	 * Date: 06.10.15
	 * Time: 20:35
	 */

	namespace Conpago\Exceptions;


	class MissingConfigurationException extends Exception {
		/**
		 * @var string
		 */
		protected $path;

		public function getPath(){
			return $this->path;
		}

		function __construct($path, $message = "", $code = 0, Exception $previous = null ) {
			parent::__construct( $message, $code, $previous );
			$this->path = $path;
		}
	}