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
        $config = $container->get('Config');
        $swaggerExtraConfig = $config['swagger']['extra'] ?? [];
        return new SwaggerViewStrategy($container->get('ViewJsonRenderer'), $swaggerExtraConfig);
    }
}