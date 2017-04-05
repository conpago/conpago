<?php


namespace Conpago\Routing\Config;


use Conpago\Config\ConfigBase;
use Conpago\Routing\Config\Contract\IRoutingConfig;

class RoutingConfig extends ConfigBase implements IRoutingConfig
{
    function getRoutings($requestMethod, $path)
    {
        $routes = $this->config->getValue('routing.'.$requestMethod);

        if (!empty($routes)) {
            foreach ($routes as $routing => $class) {
                $routingPattern = $this->createRegexPattern($routing);

                if (!preg_match("`${routingPattern}`", $path)) {
                    unset($routes[$routing]);
                }
            }
        }
        
        return $routes;
    }

    /**
     * @param $routing
     *
     * @return mixed|string
     */
    protected function createRegexPattern($routing)
    {
        $routingRegex = $routing;
        foreach (['\\', '/', '.', '*', '+', '?', '|', '(', ')', '[', ']'] as $ch) {
            $routingRegex = str_replace($ch, '\\'.$ch, $routingRegex);
        }
        $routingRegex = '^'.preg_replace('`{[^}]+}`', '[^/]+', $routingRegex).'$';
        foreach (['{', '}'] as $ch) {
            $routingRegex = str_replace($ch, '\\'.$ch, $routingRegex);
        }

        return $routingRegex;
    }
}