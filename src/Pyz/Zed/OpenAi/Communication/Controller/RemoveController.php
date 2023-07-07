<?php

declare(strict_types = 1);

namespace Pyz\Zed\OpenAi\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\OpenAi\Communication\OpenAiCommunicationFactory getFactory()
 * @method \Pyz\Zed\OpenAi\Business\OpenAiFacadeInterface getFacade()
 * @method \Pyz\Zed\OpenAi\Persistence\OpenAiRepository getRepository()
 */
class RemoveController extends AbstractController
{
    private const OPENAI_PROMPT_NOT_FOUND_MESSAGE = EditController::OPENAI_PROMPT_NOT_FOUND_MESSAGE;
    private const OPENAI_DELETE_SUCCESS_MESSAGE = 'OpeNAI Prompt was deleted successfully';

    private const ID_OPENAI_PROMPT = EditController::ID_OPENAI_PROMPT;

    private const INDEX_URL = EditController::INDEX_URL;

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function removeAction(Request $request): array|RedirectResponse
    {
        $idOpenAi = $this->castId($request->get(self::ID_OPENAI_PROMPT));

        $openAiTransfer = $this->getRepository()
            ->findByOpenAiPromptById($idOpenAi);

        if (!$openAiTransfer) {
            return $this->handleNotFound();
        }

        $deleteForm = $this->getFactory()
            ->getOpenAiDeleteForm()
            ->handleRequest($request);

        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            return $this->handleDeleteForm($idOpenAi);
        }

        return $this->viewResponse([
            'openAi' => $openAiTransfer,
            'openAiForm' => $deleteForm->createView(),
        ]);
    }

    /**
     * @param int $idOpenAi
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function handleDeleteForm(int $idOpenAi): RedirectResponse
    {
        $this->getFacade()->deleteOpenAi($idOpenAi);

        $this->addSuccessMessage(self::OPENAI_DELETE_SUCCESS_MESSAGE);

        return $this->redirectResponse(self::INDEX_URL);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function handleNotFound(): RedirectResponse
    {
        $this->addErrorMessage(self::OPENAI_PROMPT_NOT_FOUND_MESSAGE);

        return $this->redirectResponse(self::INDEX_URL);
    }
}
