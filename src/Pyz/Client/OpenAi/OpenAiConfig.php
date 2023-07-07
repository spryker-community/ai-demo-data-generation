<?php

declare(strict_types = 1);

namespace Pyz\Client\OpenAi;

use Spryker\Client\Kernel\AbstractBundleConfig;
use Pyz\Shared\OpenAi\OpenAiConstants;

class OpenAiConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getOpenAiApiKey(): string
    {
        return $this->get(OpenAiConstants::OPENAI_API_KEY, 'MISSING_OPENAI_API_KEY');
    }
}
