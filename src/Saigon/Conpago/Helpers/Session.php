<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Helpers;

	use Saigon\Conpago\ISession;

	class Session implements ISession
	{

		/**
		 * @return bool
		 */
		public function destroy()
		{
			return session_destroy();
		}

		/**
		 * @return string
		 */
		public function getId()
		{
			return session_id();
		}

		/**
		 * @param string $sessionId
		 *
		 * @return void
		 */
		public function setId($sessionId)
		{
			session_id($sessionId);
		}

		/**
		 * @return string
		 */
		public function getName()
		{
			return session_name();
		}

		/**
		 * @param string $name
		 *
		 * @return void
		 */
		public function setName($name)
		{
			session_name($name);
		}

		/**
		 * @param bool $removeOldSession
		 *
		 * @return bool
		 */
		public function regenerateId($removeOldSession = false)
		{
			return session_regenerate_id($removeOldSession);
		}

		/**
		 * @return string
		 */
		public function getSavePath()
		{
			return session_save_path();
		}

		/**
		 * @param string $path
		 *
		 * @return void
		 */
		public function setSavePath($path)
		{
			session_save_path($path);
		}

		/**
		 * @return bool
		 */
		public function start()
		{
			return session_start();
		}

		/**
		 * @return int
		 */
		public function getStatus()
		{
			return session_status();
		}

		/**
		 * @return void
		 */
		public function release()
		{
			session_unset();
		}

		/**
		 * @return void
		 */
		public function writeClose()
		{
			session_write_close();
		}

		/**
		 * @param string $name
		 * @param mixed $value
		 *
		 * @return void
		 */
		public function register($name, $value)
		{
			$_SESSION[$name] = $value;
		}

		/**
		 * @param string $name
		 *
		 * @return bool
		 */
		public function isRegistered($name)
		{
			$b = isset($_SESSION[$name]);
			return $b;
		}

		/**
		 * @param string $name
		 *
		 * @return mixed
		 */
		public function getValue($name)
		{
			return $_SESSION[$name];
		}
	}