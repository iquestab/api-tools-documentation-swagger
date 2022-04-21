<?php

namespace Laminas\ApiTools\Documentation\Swagger;

use Laminas\ApiTools\Documentation\ApiFactory;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class SwaggerUiController extends AbstractActionController
{
    private $clientId;
    private $appName;

    /** @var ApiFactory */
    protected $apiFactory;

    public function __construct(ApiFactory $apiFactory)
    {
        $this->apiFactory = $apiFactory;
    }

    /**
     * List available APIs
     *
     * @return ViewModel
     */
    public function listAction()
    {
        $apis = $this->apiFactory->createApiList();

        $viewModel = new ViewModel(['apis' => $apis]);
        $viewModel->setTemplate('api-tools-documentation-swagger/list');
        return $viewModel;
    }

    /**
     * Show the Swagger UI for a given API
     *
     * @return ViewModel
     */
    public function showAction()
    {
        $api = $this->params()->fromRoute('api');

        $viewModel = new ViewModel([
            'api' => $api,
            'clientId' => $this->clientId,
            'appName' => $this->appName
        ]);
        $viewModel->setTemplate('api-tools-documentation-swagger/show');
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    /**
     * Redirect for Oauth2 solution
     *
     * @return ViewModel
     */
    public function showO2cAction()
    {
        $viewModel = new ViewModel();
        $viewModel->setTemplate('api-tools-documentation-swagger/o2c');
        $viewModel->setTerminal(true);
        return $viewModel;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param mixed $clientId
     */
    public function setClientId($clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return mixed
     */
    public function getAppName()
    {
        return $this->appName;
    }

    /**
     * @param mixed $appName
     */
    public function setAppName($appName): void
    {
        $this->appName = $appName;
    }


}
