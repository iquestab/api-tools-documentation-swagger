<?php

namespace Laminas\ApiTools\Documentation\Swagger;

use Laminas\EventManager\EventManagerInterface;
use Laminas\EventManager\ListenerAggregateInterface;
use Laminas\EventManager\ListenerAggregateTrait;
use Laminas\View\Renderer\JsonRenderer;
use Laminas\View\ViewEvent;

use function method_exists;

class SwaggerViewStrategy implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    /** @var ViewModel */
    protected $model;

    /** @var JsonRenderer */
    protected $renderer;

    /** @var array $swaggerExtraConfig */
    private array $swaggerExtraConfig = [];


    public function __construct(JsonRenderer $renderer, array $swaggerExtraConfig = [])
    {
        $this->renderer = $renderer;
        $this->swaggerExtraConfig = $swaggerExtraConfig;
    }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events, $priority = 200)
    {
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RENDERER, [$this, 'selectRenderer'], $priority);
        $this->listeners[] = $events->attach(ViewEvent::EVENT_RESPONSE, [$this, 'injectResponse'], $priority);
    }

    /**
     * @return null|JsonRenderer
     */
    public function selectRenderer(ViewEvent $e)
    {
        $model = $e->getModel();
        if (! $model instanceof ViewModel) {
            return;
        }
        $model->setVariable('swagger_extra_config', $this->swaggerExtraConfig);
        $this->model = $model;
        return $this->renderer;
    }

    /**
     * @return void
     */
    public function injectResponse(ViewEvent $e)
    {
        if (! $this->model instanceof ViewModel) {
            return;
        }

        $response = $e->getResponse();
        if (! method_exists($response, 'getHeaders')) {
            return;
        }

        $headers = $response->getHeaders();
        $headers->addHeaderLine('Content-Type', 'application/vnd.swagger+json');
    }
}
