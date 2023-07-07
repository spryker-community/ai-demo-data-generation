<?php

declare(strict_types = 1);

namespace Pyz\Zed\OpenAi\Persistence;

use Generated\Shared\Transfer\OpenAiAssignEventToPromptRequestTransfer;
use Generated\Shared\Transfer\OpenAiPromptTransfer;
use Orm\Zed\OpenAi\Persistence\VsyOpenaiPrompt;
use Orm\Zed\OpenAi\Persistence\VsyOpenaiPromptQuery;
use Orm\Zed\OpenAi\Persistence\VsyOpenaiPromptToEventQuery;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

class OpenAiEntityManager extends AbstractEntityManager
{
    /**
     * @param \Generated\Shared\Transfer\OpenAiPromptTransfer $openAiTransfer
     *
     * @return \Generated\Shared\Transfer\OpenAiPromptTransfer|null
     */
    public function createOpenAi(OpenAiPromptTransfer $openAiTransfer): ?OpenAiPromptTransfer
    {
        $openAiEntity = new VsyOpenaiPrompt();
        $openAiEntity->fromArray($openAiTransfer->toArray());
        $openAiEntity->save();

        return $this->mapEntityToTransfer($openAiEntity);
    }

    /**
     * @param \Generated\Shared\Transfer\OpenAiPromptTransfer $openAiTransfer
     *
     * @return \Generated\Shared\Transfer\OpenAiPromptTransfer|null
     */
    public function updateOpenAi(OpenAiPromptTransfer $openAiTransfer): ?OpenAiPromptTransfer
    {
//        $openAiTransfer->requireIdOpenAi();

        $openAiEntity = VsyOpenaiPromptQuery::create()
            ->filterByIdOpenaiPrompt($openAiTransfer->getIdOpenaiPrompt())
            ->findOne();

        $openAiEntity->fromArray($openAiTransfer->toArray());
        $openAiEntity->save();

        return $openAiTransfer;
    }

    /**
     * @param int $idOpenAi
     *
     * @return bool
     */
    public function deleteOpenAi(int $idOpenAi): bool
    {
        $openAiQueryPrompt = VsyOpenaiPromptQuery::create()
            ->filterByIdOpenaiPrompt($idOpenAi)
            ->findOne();

        if (!$openAiQueryPrompt) {
            return false;
        }

        $openAiQueryPrompt->delete();

        return true;
    }

    /**
     * @param \Generated\Shared\Transfer\OpenAiAssignEventToPromptRequestTransfer $assignEventToPromptRequestTransfer
     *
     * @return bool
     */
    public function assignEventToPrompt(OpenAiAssignEventToPromptRequestTransfer $assignEventToPromptRequestTransfer): bool
    {
        $openAiQueryPrompt = VsyOpenaiPromptToEventQuery::create()
            ->filterByEvent($assignEventToPromptRequestTransfer->getEvent())
            ->findOneOrCreate()
            ->setFkOpenaiPrompt(($assignEventToPromptRequestTransfer->getPrompt()));
        $updatedRows = $openAiQueryPrompt
            ->save();

        return true;
    }

    /**
     * @param \Orm\Zed\OpenAi\Persistence\VsyOpenaiPrompt $openAiEntity
     *
     * @return \Generated\Shared\Transfer\OpenAiPromptTransfer
     */
    private function mapEntityToTransfer(VsyOpenaiPrompt $openAiEntity): OpenAiPromptTransfer
    {
        return (new OpenAiPromptTransfer())
            ->fromArray($openAiEntity->toArray(), true);
    }
}
