<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\OpenAi;

use Orm\Zed\OpenAi\Persistence\VsyOpenaiPromptQuery;
use Orm\Zed\OpenAi\Persistence\VsyOpenaiPromptToEventQuery;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class OpenAiWriterStep implements DataImportStepInterface
{
    /**
     * @var string
     */
    public const COL_NAME = 'name';
    public const COL_EVENT = 'event';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $vsyOpenAiPromptEntity = VsyOpenaiPromptQuery::create()
            ->filterByName($dataSet[self::COL_NAME])
            ->findOneOrCreate();

        $event = $dataSet[self::COL_EVENT];
        unset($dataSet[self::COL_EVENT]);


        $vsyOpenAiPromptEntity->fromArray($dataSet->getArrayCopy());
        $vsyOpenAiPromptEntity->save();


        if (!empty($event)) {
            $openAiEventEntity = VsyOpenaiPromptToEventQuery::create()
                ->filterByEvent($event)
                ->findOneOrCreate();

            $openAiEventEntity->setEvent($event);
            $vsyOpenAiPromptEntity->reload();
            $openAiEventEntity->setFkOpenaiPrompt($vsyOpenAiPromptEntity->getIdOpenaiPrompt());
            $openAiEventEntity->save();
        }
    }
}
