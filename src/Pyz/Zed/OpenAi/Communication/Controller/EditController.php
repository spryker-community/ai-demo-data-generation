<?php

declare(strict_types = 1);

namespace Pyz\Zed\OpenAi\Communication\Controller;

use Generated\Shared\Transfer\OpenAiPromptTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\OpenAi\Communication\OpenAiCommunicationFactory getFactory()
 * @method \Pyz\Zed\OpenAi\Business\OpenAiFacade getFacade()
 * @method \Pyz\Zed\OpenAi\Persistence\OpenAiRepository getRepository()
 */
class EditController extends AbstractController
{
    public const ID_OPENAI_PROMPT = 'id-openai-prompt';

    public const OPENAI_PROMPT_NOT_FOUND_MESSAGE = 'OpenAI Prompt not found';
    public const OPENAI_UPDATE_SUCCESS_MESSAGE = 'OpenAI Prompt was successfully updated.';

    public const INDEX_URL = '/open-ai';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function editAction(Request $request): array|RedirectResponse
    {
        $idOpenAi = $this->castId($request->get(self::ID_OPENAI_PROMPT));

        $openAiTransfer = $this->getFacade()->findByOpenAiPromptById($idOpenAi);

        if (!$openAiTransfer) {
            return $this->handleNotFound();
        }

        $openAiFormDataProvider = $this->getFactory()
            ->createOpenAiFormDataProvider();

        $form = $this->getFactory()->getOpenAiCreateForm(
            $openAiTransfer,
            $openAiFormDataProvider->getOptions(),
        )->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $response = $this->saveData($form);

            if ($response) {
                $this->addSuccessMessage(self::OPENAI_UPDATE_SUCCESS_MESSAGE);

                return $this->redirectResponse(self::INDEX_URL);
            }
        }

        return $this->viewResponse([
            'OpenAi' => $openAiTransfer,
            'OpenAiCreateForm' => $form->createView(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function handleNotFound(): RedirectResponse
    {
        $this->addErrorMessage(self::OPENAI_PROMPT_NOT_FOUND_MESSAGE);

        return $this->redirectResponse(self::INDEX_URL);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     *
     * @return \Generated\Shared\Transfer\OpenAiPromptTransfer|null
     */
    private function saveData(FormInterface $form): ?OpenAiPromptTransfer
    {
        $openAiTransfer = $form->getData();
        if ($openAiTransfer->getLocale()) {
            $openAiTransfer->setFkLocale($openAiTransfer->getLocale()->getIdLocale());
        }

        return $this->getFacade()
            ->updateOpenAi($openAiTransfer);
    }
}
