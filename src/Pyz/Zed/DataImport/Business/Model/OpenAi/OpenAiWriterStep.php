<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\DataImport\Business\Model\OpenAi;

use Orm\Zed\OpenAi\Persistence\VsyOpenaiPromptQuery;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class OpenAiWriterStep implements DataImportStepInterface
{
    /**
     * @var string
     */
    public const COL_NAME = 'name';
    public const COL_PROMPT = 'prompt';
    public const COL_MODEL = 'model';
    public const COL_SUFFIX = 'suffix';
    public const COL_MAX_TOKENS = 'max_tokens';
    public const COL_TEMPERATURE = 'temperature';
    public const COL_TOPP = 'topp';
    public const COL_NCOMPLETIONS = 'ncompletions';
    public const COL_LOG_PROBS = 'log_probs';
    public const COL_STOP = 'stop';
    public const COL_PRESENCEPENALITY = 'presencepenality';
    public const COL_FREQUENCYPENALTY = 'frequencypenalty';
    public const COL_BESTOF = 'bestof';
    public const COL_USER = 'user';
    public const COL_ECHO = 'echo';
    public const COL_STREAM = 'stream';

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $customerEntity = VsyOpenaiPromptQuery::create()
            ->filterByName($dataSet[self::COL_NAME])
            ->findOneOrCreate();

        $customerEntity->fromArray($dataSet->getArrayCopy());
        $customerEntity->save();
    }
}
