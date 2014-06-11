<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago;

	interface IDoctrineConfig
	{
		public function getDevMode();

		public function getModelPath();

		public function getModelNamespace();
	}
