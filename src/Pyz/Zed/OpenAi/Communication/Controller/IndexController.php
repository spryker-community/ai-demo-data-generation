<?php

declare(strict_types = 1);

namespace Pyz\Zed\OpenAi\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\OpenAi\Communication\OpenAiCommunicationFactory getFactory()
 * @method \Pyz\Zed\OpenAi\Business\OpenAiFacadeInterface getFacade()
 * @method \Pyz\Zed\OpenAi\Persistence\OpenAiRepositoryInterface getRepository()
 */
class IndexController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    public function indexAction(Request $request): array
    {
        $openAis = $this->getFactory()->createOpenAiTable()
            ->render();

        return $this->viewResponse([
            'OpenAis' => $openAis,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tableAction(): JsonResponse
    {
        $table = $this->getFactory()
            ->createOpenAiTable();

        return $this->jsonResponse(
            $table->fetchData(),
        );
    }
}
