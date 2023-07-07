<?php

declare(strict_types = 1);

namespace Pyz\Zed\OpenAi\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Pyz\Client\OpenAi\OpenAiClientInterface;
use Pyz\Zed\OpenAi\Business\Model\OpenAiPromptExecuter;
use Pyz\Zed\OpenAi\OpenAiDependencyProvider;

/**
 * @method \Pyz\Zed\OpenAi\Persistence\OpenAiEntityManager getEntityManager()
 * @method \Pyz\Zed\OpenAi\Persistence\OpenAiRepository getRepository()
 */
class OpenAiBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Client\OpenAi\OpenAiClientInterface
     */
    public function getOpenAiClient(): OpenAiClientInterface
    {
        return $this->getProvidedDependency(OpenAiDependencyProvider::CLIENT_OPENAI);
    }

    /**
     * @return \Pyz\Zed\OpenAi\Business\Model\OpenAiPromptExecuter
     */
    public function createOpenAiPromptExecuter(): OpenAiPromptExecuter
    {
        return new OpenAiPromptExecuter($this->getOpenAiClient(), $this->getRepository());
    }
}
