<?php
	/**
	 * Created by PhpStorm.
	 * User: Bartosz Gołek
	 * Date: 09.11.13
	 * Time: 15:30
	 */

	namespace Saigon\Conpago\Core;

	use Doctrine\ORM\Tools\Setup, Doctrine\ORM\EntityManager;
	use Saigon\Conpago\IDbConfig, Saigon\Conpago\IDoctrineConfig;

	class DoctrineEntityManagerProvider
	{
		/**
		 * @var \Saigon\Conpago\IDbConfig
		 */
		private $dbConfig;

		/**
		 * @var \Saigon\Conpago\IDoctrineConfig
		 */
		private $doctrineConfig;

		/**
		 * @var \Doctrine\ORM\EntityManager
		 */
		private $entityManager;

		/**
		 * @var array
		 */
		private $dbParams = null;

		/**
		 * @param \Saigon\Conpago\IDbConfig $dbConfig
		 * @param \Saigon\Conpago\IDoctrineConfig $doctrineConfig
		 *
		 * @inject \Saigon\Conpago\IDbConfig $dbConfig
		 * @inject \Saigon\Conpago\IDoctrineConfig $doctrineConfig
		 */
		public function __construct(IDBConfig $dbConfig, IDoctrineConfig $doctrineConfig)
		{
			$this->dbConfig = $dbConfig;
			$this->doctrineConfig = $doctrineConfig;

			$paths = array($this->doctrineConfig->getModelPath());

			$this->setDbParams();
			$config = Setup::createAnnotationMetadataConfiguration($paths, $this->doctrineConfig->getDevMode());
			$this->entityManager = EntityManager::create($this->dbParams, $config);
		}

		private function setDbParams()
		{
			$this->dbParams = array(
				'driver' => $this->dbConfig->getDriver(),
				'user' => $this->dbConfig->getUser(),
				'password' => $this->dbConfig->getPassword(),
				'dbname' => $this->dbConfig->getDbName()
			);
		}

		/**
		 * @return \Doctrine\ORM\EntityManager
		 */
		public function getEntityManager()
		{
			return $this->entityManager;
		}
	}