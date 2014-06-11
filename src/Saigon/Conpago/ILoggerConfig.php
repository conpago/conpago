<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 27.11.13
 * Time: 19:24
 */

namespace Saigon\Conpago;


interface ILoggerConfig
{
	function getLogLevel();
	function getLogFilePath();
}