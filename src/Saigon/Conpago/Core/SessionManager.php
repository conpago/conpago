<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Core;

	use Saigon\Conpago\IAuthModel;
	use Saigon\Conpago\ISession;
	use Saigon\Conpago\ISessionManager;

	class SessionManager implements ISessionManager
	{
		const USER_LOGIN = 'userLogin';
		const USER = 'user';
		const SESSIONS_ARE_DISABLED = 'Sessions are disabled!';

		/**
		 * @var ISession
		 */
		private $session;

		function __construct(ISession $session)
		{

			$this->session = $session;
		}

		/**
		 * @param IAuthModel $authModel
		 */
		function login(IAuthModel $authModel)
		{
			$this->initialize();

			$this->session->register(self::USER_LOGIN, $authModel->getLogin());
			$this->session->register(self::USER, $authModel);
		}

		/**
		 * @return bool
		 */
		function isLoggedIn()
		{
			$this->initialize();

			return $this->session->isRegistered(self::USER_LOGIN);
		}

		/**
		 * @return IAuthModel
		 */
		function getCurrentUser()
		{
			$this->initialize();

			if (!$this->isLoggedIn())
			{
				return null;
			}

			return $this->session->getValue(self::USER);
		}

		private function initialize()
		{
			$sessionStatus = $this->session->getStatus();
			switch ($sessionStatus)
			{
				case PHP_SESSION_DISABLED :
					throw new \Exception(self::SESSIONS_ARE_DISABLED);
				case PHP_SESSION_ACTIVE :
					return;
				case PHP_SESSION_NONE :
					$this->session->start();
			}
		}

		/**
		 * @return void
		 */
		public function logout()
		{
			$this->initialize();

			$this->session->destroy();
		}
	}