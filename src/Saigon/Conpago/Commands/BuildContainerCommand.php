<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 13.11.13
	 * Time: 20:21
	 */

	namespace Saigon\Conpago\Commands;

	use Saigon\Conpago\AppBuilder;
	use Saigon\Conpago\IAppPath;
	use Saigon\Conpago\ICommand;
	use Saigon\Conpago\Helpers\Args;

	class BuildContainerCommand implements ICommand
	{
		/**
		 * @var Args
		 */
		private $args;
		/**
		 * @var IAppPath
		 */
		private $appPath;

		function __construct(Args $args, IAppPath $appPath)
		{
			$this->args = $args;
			$this->appPath = $appPath;
		}

		function execute()
		{
			$arguments = $this->args->getArguments();
			$appBuilder = new AppBuilder($arguments[1], $this->appPath->root());
			$appBuilder->buildApp();
			$appBuilder->persistApp();
		}
	}