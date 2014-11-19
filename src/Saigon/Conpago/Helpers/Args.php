<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 13.11.13
	 * Time: 19:27
	 */

	namespace Saigon\Conpago\Helpers;

	use Saigon\Conpago\Helpers\Contract\IArgs;
	use Saigon\Conpago\Utils\ServerAccessor;

	class Args implements IArgs
	{
		/** @var ServerAccessor */
		private $server;

		private $argv;

		public function __construct(ServerAccessor $serverAccessor)
		{
			$this->server = $serverAccessor;

			if (!$this->server->contains('argv'))
				return;

			$this->argv = $this->parseArgv();
		}

		public function getArguments()
		{
			return $this->argv->arguments;
		}

		public function getScript()
		{
			return $this->argv->script;
		}

		/**
		 * @param string $option
		 *
		 * @return string
		 */
		public function getOption($option)
		{
			return $this->argv->options[$option];
		}

		/**
		 * @param string $option
		 *
		 * @return bool
		 */
		public function hasOption($option)
		{
			return array_key_exists($option, $this->argv->options);
		}

		protected function parseArgv()
		{
			$argv = $this->server->getValue('argv');

			$argvParser = new ArgvParser($argv);
			return $argvParser->parse();
		}
	}

	class ArgvParser
	{
		private $argv;

		function __construct(array $argv)
		{
			$this->argv = $argv;
		}

		function parse()
		{
			$result = new Argv();
			$option = null;
			$first = true;
			foreach ($this->argv as $arg) {
				if ($first == true) {
					$result->script = $arg;
					$first = false;
					continue;
				}

				if ($option != null) {
					$result->options[$option] = $arg;
					$option = null;
					continue;
				}

				if ($this->isOption($arg)) {
					$option = $this->option($arg);
					continue;
				}

				$result->arguments[] = $arg;
			}

			return $result;
		}

		private function isOption($arg)
		{
			return $arg[0] == '-';
		}

		private function option($arg)
		{
			return substr($arg, 1);
		}
	}

	class Argv
	{
		function __construct()
		{
			$this->options = array();
			$this->arguments = array();
		}

		public $options;
		public $arguments;
		public $script;
	}