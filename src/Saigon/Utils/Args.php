<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 13.11.13
 * Time: 19:27
 */

namespace Saigon\Utils;


class Args {
	private $options;
	private $arguments;
	private $script;

	public function __construct(){
		$this->options = array();
		$this->arguments = array();

		if (!isset($_SERVER['argv']))
			return;

		$option = null;
		$first = true;
		foreach($_SERVER['argv'] as $arg)
		{
			if ($first == true)
			{
				$this->script = $arg;
				$first = false;
			}
			elseif ($option != null)
			{
				$this->options[$option] = $arg;
				$option = null;
			}
			elseif ($this->isOption($arg))
			{
				$option = $this->option($arg);
			}
			else
			{
				$this->arguments[] = $arg;
			}
		}
	}

	public function getArguments()
	{
		return $this->arguments;
	}

	public function getScript()
	{
		return $this->script;
	}

	/**
	 * @param string $option
	 *
	 * @return string
	 */
	public function getOption($option)
	{
		return $this->options[$option];
	}

	/**
	 * @param string $option
	 *
	 * @return bool
	 */
	public function hasOption($option)
	{
		return array_key_exists($option, $this->options);
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