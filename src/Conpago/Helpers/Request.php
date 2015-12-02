<?php
    /**
     * Created by PhpStorm.
     * User: Bartosz Gołek
     * Date: 09.11.13
     * Time: 15:30
     */

    namespace Conpago\Helpers;

use Conpago\File\Contract\IFileSystem;
    use Conpago\Helpers\Contract\IRequest;
    use Conpago\Utils\ServerAccessor;

    class Request implements IRequest
    {
        private $server;
        /**
         * @var IFileSystem
         */
        private $fileSystem;

        /**
         * @param ServerAccessor $serverAccessor
         * @param IFileSystem $fileSystem
         */
        public function __construct(ServerAccessor $serverAccessor, IFileSystem $fileSystem)
        {
            $this->server = $serverAccessor;
            $this->fileSystem = $fileSystem;
        }

        private function getValue($name)
        {
            if (!$this->server->contains($name)) {
                return null;
            }

            return $this->server->getValue($name);
        }

        public function getRequestMethod()
        {
            return $this->getValue('REQUEST_METHOD');
        }

        public function getPathInfo()
        {
            return $this->getValue('PATH_INFO');
        }

        public function getQueryString()
        {
            return $this->getValue('QUERY_STRING');
        }

        public function getContentType()
        {
            return $this->getValue('CONTENT_TYPE');
        }

        public function getBody()
        {
            return $this->fileSystem->getFileContent("php://input");
        }
    }
