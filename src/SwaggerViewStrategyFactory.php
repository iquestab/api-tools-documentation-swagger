<?php

namespace Laminas\ApiTools\Documentation\Swagger;

use Interop\Container\ContainerInterface;

class SwaggerViewStrategyFactory
{
    /**
     * @return SwaggerViewStrategy
     */
    public function __invoke(ContainerInterface $container)
    {
        $swaggerExtraConfig = [];
        $config = $container->get('Config');
        if (isset($config['swagger_extra'])) {
            $swaggerExtraConfig = $config['swagger_extra'];
        }
        return new SwaggerViewStrategy($container->get('ViewJsonRenderer'), $swaggerExtraConfig);
    }
}