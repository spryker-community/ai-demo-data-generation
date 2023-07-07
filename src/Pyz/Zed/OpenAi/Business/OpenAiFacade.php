<?php

declare(strict_types = 1);

namespace Pyz\Zed\OpenAi\Business;

use Generated\Shared\Transfer\OpenAiAssignEventToPromptRequestTransfer;
use Generated\Shared\Transfer\OpenAiCreateResponseTransfer;
use Generated\Shared\Transfer\OpenAiExecuteRequestTransfer;
use Generated\Shared\Transfer\OpenAiPromptCriteriaTransfer;
use Generated\Shared\Transfer\OpenAiPromptTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\OpenAi\Business\OpenAiBusinessFactory getFactory()
 * @method \Pyz\Zed\OpenAi\Persistence\OpenAiEntityManager getEntityManager()
 * @method \Pyz\Zed\OpenAi\Persistence\OpenAiRepository getRepository()
 */
class OpenAiFacade extends AbstractFacade implements OpenAiFacadeInterface
{
    /**
     * @param int $idOpenAi
     *
     * @return \Generated\Shared\Transfer\OpenAiPromptTransfer|null
     */
    public function findByOpenAiPromptById(int $idOpenAi): ?OpenAiPromptTransfer
    {
        return $this->getRepository()->findByOpenAiPromptById($idOpenAi);
    }

    /**
     * @param \Generated\Shared\Transfer\OpenAiPromptCriteriaTransfer $openAiPromptCriteriaTransfer
     *
     * @return array|null
     */
    public function getOpenAiPromptCollection(OpenAiPromptCriteriaTransfer $openAiPromptCriteriaTransfer): ?array
    {
        return $this->getRepository()->getOpenAiPromptCollection($openAiPromptCriteriaTransfer);
    }

    /**
     * @return array|null
     */
    public function getOpenAiPromptToEventCollection(): ?array
    {
        return $this->getRepository()->getOpenAiPromptToEventCollection();
    }

    /**
     * @param \Generated\Shared\Transfer\OpenAiPromptTransfer $openAiTransfer
     *
     * @return \Generated\Shared\Transfer\OpenAiPromptTransfer|null
     */
    public function createOpenAi(OpenAiPromptTransfer $openAiTransfer): ?OpenAiPromptTransfer
    {
        return $this->getEntityManager()
            ->createOpenAi($openAiTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OpenAiPromptTransfer $openAiTransfer
     *
     * @return \Generated\Shared\Transfer\OpenAiPromptTransfer|null
     */
    public function updateOpenAi(OpenAiPromptTransfer $openAiTransfer): ?OpenAiPromptTransfer
    {
        return $this->getEntityManager()
            ->updateOpenAi($openAiTransfer);
    }

    /**
     * @param int $idOpenAi
     *
     * @return bool
     */
    public function deleteOpenAi(int $idOpenAi): bool
    {
        return $this->getEntityManager()
            ->deleteOpenAi($idOpenAi);
    }

    /**
     * @param \Generated\Shared\Transfer\OpenAiAssignEventToPromptRequestTransfer $assignEventToPromptRequestTransfer
     *
     * @return bool
     */
    public function assignEventToPrompt(OpenAiAssignEventToPromptRequestTransfer $assignEventToPromptRequestTransfer): bool
    {
        return $this->getEntityManager()->assignEventToPrompt($assignEventToPromptRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\OpenAiExecuteRequestTransfer $executeRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OpenAiCreateResponseTransfer
     */
    public function executePromptAction(OpenAiExecuteRequestTransfer $executeRequestTransfer): OpenAiCreateResponseTransfer
    {
        return $this->getFactory()->createOpenAiPromptExecuter()->executePrompt($executeRequestTransfer);
    }
}
