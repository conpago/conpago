<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago;

	interface ISession
	{
		/**
		 * @return bool
		 */
		public function destroy();

		/**
		 * @return string
		 */
		public function getId();

		/**
		 * @param string $sessionId
		 *
		 * @return void
		 */
		public function setId($sessionId);

		/**
		 * @return string
		 */
		public function getName();

		/**
		 * @param string $name
		 *
		 * @return void
		 */
		public function setName($name);

		/**
		 * @param bool $removeOldSession
		 *
		 * @return bool
		 */
		public function regenerateId($removeOldSession = false);

		/**
		 * @return string
		 */
		public function getSavePath();

		/**
		 * @param string $path
		 *
		 * @return void
		 */
		public function setSavePath($path);

		/**
		 * @return bool
		 */
		public function start();

		/**
		 * @return int
		 */
		public function getStatus();

		/**
		 * @return void
		 */
		public function release();

		/**
		 * @return void
		 */
		public function writeClose();

		/**
		 * @param string $name
		 * @param mixed $value
		 *
		 * @return void
		 */
		public function register($name, $value);

		/**
		 * @param string $name
		 *
		 * @return bool
		 */
		public function isRegistered($name);

		/**
		 * @param string $name
		 *
		 * @return mixed
		 */
		public function getValue($name);
	}