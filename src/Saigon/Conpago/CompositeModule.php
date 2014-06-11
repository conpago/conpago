<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago;

	use DI\IContainerBuilder;

	class CompositeModule implements IModule
	{

		/**
		 *
		 * @var array
		 */
		protected $modules;

		public function __construct(array $modules)
		{
			$this->modules = $modules;
		}

		public function build(IContainerBuilder $builder)
		{
			foreach ($this->modules as $moduleName)
			{
				/** @var \Saigon\Conpago\IModule $module */
				$module = new $moduleName();
				$module->build($builder);
			}
		}
	}
