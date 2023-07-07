<?php

declare(strict_types = 1);

namespace Pyz\Zed\OpenAi\Persistence;

use Orm\Zed\OpenAi\Persistence\VsyOpenaiPromptQuery;
use Orm\Zed\OpenAi\Persistence\VsyOpenaiPromptToEventQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\OpenAi\OpenAiConfig getConfig()
 */
class OpenAiPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\OpenAi\Persistence\VsyOpenaiPromptQuery
     */
    public function createVsyOpenaiPromptQuery(): VsyOpenaiPromptQuery
    {
        return VsyOpenaiPromptQuery::create();
    }

    /**
     * @return \Orm\Zed\OpenAi\Persistence\VsyOpenaiPromptToEventQuery
     */
    public function createVsyOpenaiPromptToEventQuery(): VsyOpenaiPromptToEventQuery
    {
        return VsyOpenaiPromptToEventQuery::create();
    }
}
