<?php

namespace Pyz\Shared\ErrorHandler\ErrorRenderer;

use Pyz\Client\OpenAi\OpenAiClient;
use Pyz\Shared\OpenAi\OpenAiConstants;
use Spryker\Shared\Config\Config;
use Spryker\Shared\ErrorHandler\ErrorRenderer\ErrorRendererInterface;

class OpenAi5YearsApiDebugErrorRenderer implements ErrorRendererInterface
{
    /**
     * @param \Throwable $exception
     *
     * @return string
     */
    public function render($exception)
    {
        $errorMessage = [
            'class'=>get_class($exception),
            'message'=>$exception->getMessage(),
            'file'=>$exception->getFile(),
            'line'=>$exception->getLine(),
            'uri'=>$this->getUri(),
            'exception'=>$exception->getTraceAsString()
        ];

        try {
            $file = file_get_contents($exception->getFile());

            $pattern = '/\/\*(.*?)\*\/|\/\/(.*?)[\r\n]/s';

            $cleanedContent = preg_replace($pattern, '', $file);

            $errorPromptEvent = Config::get(OpenAiConstants::OPENAI_API_DEBUG_ERROR_RENDERER_PROMPT_NAME_5_YEARS);

            $openAiClient = new OpenAiClient();
            $openAiCreateResponseTransfer = $openAiClient->chatCreate(
                [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        ['role' => 'user', 'content' => $errorPromptEvent. ' Exception: '.json_encode($errorMessage). ' Code:' . $cleanedContent],
                    ],
                    'temperature' => 1,
                    'top_p' => 1,
                    'n' => 1,
                    'presence_penalty' => 0,
                    'frequency_penalty' => 0,
                    'user' => 'spryker-gpt',
                ],
            );

            $errorMessage['openai'] = str_replace("\n",'',$openAiCreateResponseTransfer->getChoices()[0]['message']['content']);
        } catch (\Exception $e) {

        }
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($errorMessage);
    }

    /**
     * @return string
     */
    protected function getUri(): string
    {
        $uri = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : 'n/a';

        return $uri;
    }
}
