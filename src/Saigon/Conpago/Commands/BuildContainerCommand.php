<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 13.11.13
	 * Time: 20:21
	 */

	namespace Saigon\Conpago\Commands;

	use Saigon\Conpago\AppBuilder;
	use Saigon\Conpago\Commands\Contract\ICommand;
	use Saigon\Conpago\Helpers\Contract\IAppPath;
	use Saigon\Conpago\Helpers\Contract\IArgs;

	class BuildContainerCommand implements ICommand
	{
		/**
		 * @var IArgs
		 */
		private $args;
		/**
		 * @var IAppPath
		 */
		private $appPath;

		function __construct(IArgs $args, IAppPath $appPath)
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