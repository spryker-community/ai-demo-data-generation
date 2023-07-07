<?php

declare(strict_types = 1);

namespace Pyz\Client\OpenAi;

use OpenAI;
use OpenAI\Client;
use Spryker\Client\Kernel\AbstractFactory;
use Pyz\Client\OpenAi\Decorator\OpenAiClientDecorator;

/**
 * @method \Pyz\Client\OpenAi\OpenAiConfig getConfig()
 */
class OpenAiFactory extends AbstractFactory
{
    /**
     * https://github.com/openai-php/client
     *
     * @return \OpenAI\Client
     */
    private function createOpenAiClient(): Client
    {
        return OpenAI::client($this->getConfig()->getOpenAiApiKey());
    }

    /**
     * @return \Pyz\Client\OpenAi\Decorator\OpenAiClientDecorator
     */
    public function createOpenAiClientDecorator(): OpenAiClientDecorator
    {
        return new OpenAiClientDecorator($this->createOpenAiClient());
    }
}
