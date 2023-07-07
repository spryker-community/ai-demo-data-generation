<?php

declare(strict_types = 1);

namespace Pyz\Zed\OpenAi\Communication\Controller;

use Generated\Shared\Transfer\OpenAiAssignEventToPromptRequestTransfer;
use Generated\Shared\Transfer\OpenAiAssignEventToPromptTransfer;
use Generated\Shared\Transfer\OpenAiExecuteRequestTransfer;
use Generated\Shared\Transfer\OpenAiPromptCriteriaTransfer;
use Generated\Shared\Transfer\OpenAiPromptTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\OpenAi\Communication\OpenAiCommunicationFactory getFactory()
 * @method \Pyz\Zed\OpenAi\Business\OpenAiFacade getFacade()
 */
class AjaxController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getOpenAiPromptCollectionAction(Request $request): JsonResponse
    {
        $data = $this->getFacade()->getOpenAiPromptCollection(new OpenAiPromptCriteriaTransfer());

        return $this->jsonResponse(array_map(
            fn (OpenAiPromptTransfer $openAiPromptTransfer) => $openAiPromptTransfer->toArray(),
            $data,
        ));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getOpenAiPromptToEventCollectionAction(Request $request): JsonResponse
    {
        $data = $this->getFacade()->getOpenAiPromptToEventCollection();

        return $this->jsonResponse(array_map(
            fn (OpenAiAssignEventToPromptTransfer $openAiPromptTransfer) => $openAiPromptTransfer->toArray(),
            $data,
        ));
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function assignEventToPromptAction(Request $request): JsonResponse
    {
        $openAiAssignEventToPrompt = (new OpenAiAssignEventToPromptRequestTransfer())->fromArray(json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR), true);
        $success = $this->getFacade()->assignEventToPrompt($openAiAssignEventToPrompt);

        return $this->jsonResponse($openAiAssignEventToPrompt, ($success) ? 200 : 500);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function executePromptAction(Request $request): JsonResponse
    {
        $openAiAssignEventToPrompt = (new OpenAiExecuteRequestTransfer())->fromArray(json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR), true);

        $success = $this->getFacade()->executePromptAction($openAiAssignEventToPrompt);

        return $this->jsonResponse($success->toArray(), 200);
    }
}
