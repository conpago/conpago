<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\AccessRight;

	use Saigon\Conpago\AccessRight\Contract\IAccessRightChecker;
	use Saigon\Conpago\AccessRight\Contract\IAccessRightRequester;
	use Saigon\Conpago\IRolesConfig;
	use Saigon\Conpago\ISessionManager;

	class AccessRightChecker implements IAccessRightChecker
	{
		const USER_IS_NOT_A_CORRECT_ACCESS_RIGHT_REQUESTER = 'User is not a correct AccessRight requester.';
		/**
		 * @var \Saigon\Conpago\ISessionManager
		 */
		private $sessionManager;
		/**
		 * @var \Saigon\Conpago\IRolesConfig
		 */
		private $rolesConfig;

		/**
		 * @param ISessionManager $sessionManager
		 * @param IRolesConfig $rolesConfig
		 */
		function __construct(
			ISessionManager $sessionManager,
			IRolesConfig $rolesConfig)
		{
			$this->sessionManager = $sessionManager;
			$this->rolesConfig = $rolesConfig;
		}

		/**
		 * @param string $accessRight
		 *
		 * @return bool
		 * @throws \Exception
		 */
		public function check($accessRight)
		{
			if (!$this->sessionManager->isLoggedIn())
				return false;

			if (!$this->sessionManager->getCurrentUser() instanceof IAccessRightRequester)
				throw new \Exception(self::USER_IS_NOT_A_CORRECT_ACCESS_RIGHT_REQUESTER);

			$userRoles = $this->sessionManager->getCurrentUser()->getRoles();
			foreach($userRoles as $roleName)
			{
				$roles = $this->rolesConfig->getRoles();
				$role = $roles[$roleName];

				$roleAccessRights = $role->getAccessRights();
				$in_array = in_array('*', $roleAccessRights);
				if ($in_array)
					return true;

				if (in_array($accessRight, $role->getAccessRights()))
					return true;
			}
			return false;
		}
	}