<?php
    /**
     * Created by PhpStorm.
     * User: Bartosz Gołek
     * Date: 09.11.13
     * Time: 15:30
     */

    namespace Conpago\Config;

use Conpago\Config\Contract\IConfig;

    abstract class ConfigBase
    {
        /**
         * @var IConfig
         */
        protected $config;

        /**
         * @param IConfig $config
         */
        public function __construct(IConfig $config)
        {
            $this->config = $config;
        }
    }
