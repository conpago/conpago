<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Dao;

	use Saigon\Conpago\Core\DoctrineEntityManagerProvider;
	use Saigon\Conpago\IDbConfig;
	use Saigon\Conpago\IDoctrineConfig;

	abstract class DoctrineDao
	{

		/**
		 * @var \Saigon\Conpago\Core\DoctrineEntityManagerProvider
		 */
		private $doctrineEntityManagerProvider;
		/**
		 * @var \Saigon\Conpago\IDoctrineConfig
		 */
		private $doctrineConfig;

		/**
		 * @param \Saigon\Conpago\IDbConfig $dbConfig
		 * @param \Saigon\Conpago\IDoctrineConfig $doctrineConfig
		 * @param \Saigon\Conpago\Core\DoctrineEntityManagerProvider $doctrineEntityManagerProvider
		 */
		public function __construct(IDbConfig $dbConfig, IDoctrineConfig $doctrineConfig,
		                            DoctrineEntityManagerProvider $doctrineEntityManagerProvider)
		{
			$this->dbConfig = $dbConfig;
			$this->doctrineEntityManagerProvider = $doctrineEntityManagerProvider;
			$this->doctrineConfig = $doctrineConfig;
		}

		protected function getModelClassName($shortClassName)
		{
			return $this->doctrineConfig->getModelNamespace() . "\\" . $shortClassName;
		}

		/**
		 * @return \Doctrine\ORM\EntityManager
		 */
		public function getEntityManager()
		{
			return $this->doctrineEntityManagerProvider->getEntityManager();
		}
	}