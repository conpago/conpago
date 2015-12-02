<?php
    /**
     * Created by PhpStorm.
     * User: bg
     * Date: 13.05.14
     * Time: 21:57
     */

    namespace Conpago\Presentation;

use Conpago\Presentation\Contract\IPlainPresenter;
    use Symfony\Component\Config\Definition\Exception\Exception;

    class PlainPresenter implements IPlainPresenter
    {
        public function show($data)
        {
            if (is_array($data)) {
                throw new Exception('Argument $data cannot be array.');
            }

            if (is_object($data)) {
                throw new Exception('Argument $data cannot be object.');
            }

            echo $data;
        }
    }
