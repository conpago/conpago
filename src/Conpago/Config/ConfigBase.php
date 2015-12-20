<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 09.11.13
 * Time: 15:30
 *
 * @package    Conpago
 * @subpackage Config
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Config;

use Conpago\Config\Contract\IConfig;

/**
 * Base class for all key/value configuration access implementastions.
 */
abstract class ConfigBase
{

    /**
     * Provider for key/value settings.
     *
     * @var IConfig
     */
    protected $config;

    /**
     * Create new instance of BaseConfig.
     *
     * @param IConfig $config Provider for key/value settings.
     */
    public function __construct(IConfig $config)
    {
        $this->config = $config;

    }
}
