<?php


namespace Conpago\Http\Contract;


interface IResponseSender
{
    public function send(Response $response);
}