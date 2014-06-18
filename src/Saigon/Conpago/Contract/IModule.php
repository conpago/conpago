<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago;

	use DI\IContainerBuilder;

	interface IModule
	{
		public function build(IContainerBuilder $builder);
	}