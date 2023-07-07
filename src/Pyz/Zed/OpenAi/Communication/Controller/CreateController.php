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
 */
class CreateController extends AbstractController
{
    private const SAVE_SUCCESS_MESSAGE = 'OpenAI Prompt created successfully.';
    private const URL_REDIRECT_DEFAULT = EditController::INDEX_URL;

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function indexAction(Request $request): array|RedirectResponse
    {
        $openAiFormDataProvider = $this->getFactory()
            ->createOpenAiFormDataProvider();
        $openAiTransfer = new OpenAiPromptTransfer();

        $form = $this->getFactory()
            ->getOpenAiCreateForm(
                $openAiTransfer,
                $openAiFormDataProvider->getOptions(),
            )
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $responseTransfer = $this->saveData($form);

            if ($responseTransfer) {
                return $this->handleSuccess();
            }
        }

        return $this->viewResponse([
            'OpenAiCreateForm' => $form->createView(),
        ]);
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
            ->createOpenAi($openAiTransfer);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function handleSuccess(): RedirectResponse
    {
        $this->addSuccessMessage(self::SAVE_SUCCESS_MESSAGE);

        return $this->redirectResponse(self::URL_REDIRECT_DEFAULT);
    }
}
