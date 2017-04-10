<?php


namespace Conpago\Http;


use Conpago\Http\Contract\IResponseSender;
use Conpago\Http\Contract\Response;

class ResponseSender implements IResponseSender
{
    public function send(Response $response)
    {
        http_response_code($response->getStatusCode());

        if (!empty($response->getContentType())) {
            $contentTypeHeader = 'Content-Type: '.$response->getContentType();
            if (!empty($response->getCharset())) {
                $contentTypeHeader .= ';charset='.$response->getCharset();
            }
            header($contentTypeHeader);
        }

        foreach ($response->getHeaders() as $header => $value)
            header($header);

        $content = $response->getContent();
        if (!empty($content)) {
            header('Content-Length: '.strlen($content));

            echo $response->getContent();
        }
    }
}