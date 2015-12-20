<?php
/**
 * Created by PhpStorm.
 * User: Bartosz Gołek
 * Date: 09.11.13
 * Time: 15:30
 *
 * @package    Conpago
 * @subpackage Helpers
 * @author     Bartosz Gołek <bartosz.golek@gmail.com>
 * @copyright  Copyright (c) 2015, Bartosz Gołek
 */

namespace Conpago\Helpers;

use Conpago\Helpers\Contract\IAppMask;
use Conpago\Helpers\Contract\IAppPath;

class AppMask implements IAppMask
{

    protected $appPath;

    public function __construct(IAppPath $appPath)
    {
        $this->appPath = $appPath;

    }

    public function moduleMask()
    {
        return implode(
            DIRECTORY_SEPARATOR,
            array(
             $this->appPath->source(),
             '*Module.php',
            )
        );

    }

    public function configMask()
    {
        return implode(
            DIRECTORY_SEPARATOR,
            array(
             $this->appPath->config(),
             '*.php',
            )
        );

    }
}
