<?php

declare(strict_types = 1);

namespace Pyz\Zed\OpenAi\Business\Model;

use Generated\Shared\Transfer\OpenAiCreateResponseTransfer;
use Generated\Shared\Transfer\OpenAiExecuteRequestTransfer;
use Pyz\Client\OpenAi\OpenAiClientInterface;
use Pyz\Zed\OpenAi\Persistence\OpenAiRepository;

class OpenAiPromptExecuter
{
    /**
     * @param \Pyz\Client\OpenAi\OpenAiClientInterface $openAiClient
     * @param \Pyz\Zed\OpenAi\Persistence\OpenAiRepository $openAiRepository
     */
    public function __construct(private OpenAiClientInterface $openAiClient, private OpenAiRepository $openAiRepository)
    {
    }

    /**
     * @param \Generated\Shared\Transfer\OpenAiExecuteRequestTransfer $executeRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OpenAiCreateResponseTransfer
     */
    public function executePrompt(OpenAiExecuteRequestTransfer $executeRequestTransfer): OpenAiCreateResponseTransfer
    {
        $eventToPromptEntity = $this->openAiRepository->queryOpenAiPromptToEvent()->filterByEvent($executeRequestTransfer->getEventOrFail())->findOne();

        $prompt = $eventToPromptEntity->getVsyOpenaiPrompt();

        $preparedPrompt = $prompt->getPrompt();

        foreach ($executeRequestTransfer->getContext() as $promptKey => $promptParameter) {
            $preparedPrompt = str_replace('%' . $promptKey . '%', $promptParameter, $preparedPrompt);
        }

        return $this->openAiClient->chatCreate(
            [
                'model' => $prompt->getModel(),
                'messages' => [
                    ['role' => 'user', 'content' => $preparedPrompt],
                ],
                'max_tokens' => $prompt->getMaxTokens(),
                'temperature' => $prompt->getTemperature(),
                'top_p' => $prompt->getTopP(),
                'n' => $prompt->getNCompletions(),
                'stream' => $prompt->getStream(),
                'stop' => $prompt->getStop(),
                'presence_penalty' => $prompt->getPresencePenalty() ?? 0,
                'frequency_penalty' => $prompt->getFrequencyPenalty() ?? 0,
                'user' => $prompt->getUser(),
            ],
        );
    }
}
