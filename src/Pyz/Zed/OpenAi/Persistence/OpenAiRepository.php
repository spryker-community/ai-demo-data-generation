<?php

declare(strict_types = 1);

namespace Pyz\Zed\OpenAi\Persistence;

use Generated\Shared\Transfer\OpenAiAssignEventToPromptTransfer;
use Generated\Shared\Transfer\OpenAiPromptCriteriaTransfer;
use Generated\Shared\Transfer\OpenAiPromptTransfer;
use Orm\Zed\OpenAi\Persistence\VsyOpenaiPrompt;
use Orm\Zed\OpenAi\Persistence\VsyOpenaiPromptQuery;
use Orm\Zed\OpenAi\Persistence\VsyOpenaiPromptToEvent;
use Orm\Zed\OpenAi\Persistence\VsyOpenaiPromptToEventQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\OpenAi\Persistence\OpenAiPersistenceFactory getFactory()
 */
class OpenAiRepository extends AbstractRepository
{
    /**
     * @param int $idOpenAi
     *
     * @return \Generated\Shared\Transfer\OpenAiPromptTransfer|null
     */
    public function findByOpenAiPromptById(int $idOpenAi): ?OpenAiPromptTransfer
    {
        $openAiEntity = $this->getFactory()->createVsyOpenaiPromptQuery()
            ->findOneByIdOpenaiPrompt($idOpenAi);

        if (!$openAiEntity) {
            return null;
        }

        return $this->mapEntityToTransfer($openAiEntity);
    }

    /**
     * @return \Orm\Zed\OpenAi\Persistence\VsyOpenaiPromptQuery
     */
    public function queryOpenAiPrompts(): VsyOpenaiPromptQuery
    {
        return $this->getFactory()->createVsyOpenaiPromptQuery();
    }

    /**
     * @return \Orm\Zed\OpenAi\Persistence\VsyOpenaiPromptToEventQuery
     */
    public function queryOpenAiPromptToEvent(): VsyOpenaiPromptToEventQuery
    {
        return $this->getFactory()->createVsyOpenaiPromptToEventQuery();
    }

    /**
     * @param \Orm\Zed\OpenAi\Persistence\VsyOpenaiPrompt $openAiEntity
     *
     * @return \Generated\Shared\Transfer\OpenAiPromptTransfer
     */
    private function mapEntityToTransfer(VsyOpenaiPrompt $openAiEntity): OpenAiPromptTransfer
    {
        $openAiTransfer = new OpenAiPromptTransfer();
        $openAiTransfer->fromArray($openAiEntity->toArray(), true);

        return $openAiTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\OpenAiPromptCriteriaTransfer $openAiPromptCriteriaTransfer
     *
     * @return array|null
     */
    public function getOpenAiPromptCollection(OpenAiPromptCriteriaTransfer $openAiPromptCriteriaTransfer): ?array
    {
        $vsyOpenaiPromptQuery = $this->queryOpenAiPrompts();
        if ($openAiPromptCriteriaTransfer->getIdOpenaiPrompt()) {
            $vsyOpenaiPromptQuery->filterByIdOpenaiPrompt($openAiPromptCriteriaTransfer->getIdOpenaiPrompt());
        }
        $vsyOpenaiPromptEntities = $vsyOpenaiPromptQuery->find();

        return array_map(
            fn (VsyOpenaiPrompt $vsyOpenaiPrompt) => (new OpenAiPromptTransfer())->fromArray($vsyOpenaiPrompt->toArray()),
            $vsyOpenaiPromptEntities->getData(),
        );
    }

    /**
     * @return array|null
     */
    public function getOpenAiPromptToEventCollection(): ?array
    {
        $vsyOpenaiPromptToEventQuery = $this->queryOpenAiPromptToEvent();

        $vsyOpenaiPromptToEventEntities = $vsyOpenaiPromptToEventQuery->joinVsyOpenaiPrompt()->find();

        return array_map(
            fn (VsyOpenaiPromptToEvent $vsyOpenaiPromptToEvent) => (new OpenAiAssignEventToPromptTransfer())->setEvent($vsyOpenaiPromptToEvent->getEvent())->setOpenAiPrompt($this->mapEntityToTransfer($vsyOpenaiPromptToEvent->getVsyOpenaiPrompt())),
            $vsyOpenaiPromptToEventEntities->getData(),
        );
    }
}
