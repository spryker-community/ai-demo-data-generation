<?php

declare(strict_types = 1);

namespace Pyz\Client\OpenAi\Decorator;

use Generated\Shared\Transfer\OpenAiCreateResponseTransfer;
use Generated\Shared\Transfer\OpenAiCreateResponseUsageTransfer;
use Generated\Shared\Transfer\OpenAiEditsCreateResponseTransfer;
use Generated\Shared\Transfer\OpenAiEmbeddingsCreateResponseTransfer;
use Generated\Shared\Transfer\OpenAiFilesDeleteResponseTransfer;
use Generated\Shared\Transfer\OpenAiFilesListResponseTransfer;
use Generated\Shared\Transfer\OpenAiFilesRetrieveResponseTransfer;
use Generated\Shared\Transfer\OpenAiFilesUploadResponseTransfer;
use Generated\Shared\Transfer\OpenAiFinetuneCancelResponseTransfer;
use Generated\Shared\Transfer\OpenAiFinetuneCreateResponseTransfer;
use Generated\Shared\Transfer\OpenAiFinetuneListEventsResponseTransfer;
use Generated\Shared\Transfer\OpenAiFinetuneListResponseTransfer;
use Generated\Shared\Transfer\OpenAiFinetuneRetrieveResponseHyperparamsTransfer;
use Generated\Shared\Transfer\OpenAiFinetuneRetrieveResponseTransfer;
use Generated\Shared\Transfer\OpenAiImagesCreateResponseTransfer;
use Generated\Shared\Transfer\OpenAiImagesEditResponseTransfer;
use Generated\Shared\Transfer\OpenAiImagesVariationResponseTransfer;
use Generated\Shared\Transfer\OpenAiModerationsCreateResponseTransfer;
use Generated\Shared\Transfer\OpenAiTranscriptionResponseTransfer;
use Generated\Shared\Transfer\OpenAiTranslationResponseTransfer;
use OpenAI\Client;

class OpenAiClientDecorator implements OpenAiClientDecoratorInterface
{
    /**
     * @param \OpenAI\Client $client
     */
    public function __construct(private Client $client)
    {
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiCreateResponseTransfer
     */
    public function completionsCreate(array $options = []): OpenAiCreateResponseTransfer
    {
        $createResponse = $this->client->completions()->create($options);

        return (new OpenAiCreateResponseTransfer())
            ->fromArray($createResponse->toArray(), true)
            ->setCreateResponseUsage(
                (new OpenAiCreateResponseUsageTransfer())
                ->fromArray($createResponse->usage->toArray(), true),
            );
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiCreateResponseTransfer
     */
    public function chatCreate(array $options = []): OpenAiCreateResponseTransfer
    {
        $createResponse = $this->client->chat()->create($options);

        return (new OpenAiCreateResponseTransfer())
            ->fromArray($createResponse->toArray(), true)
            ->setCreateResponseUsage(
                (new OpenAiCreateResponseUsageTransfer())
                ->fromArray($createResponse->usage->toArray(), true),
            );
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiTranscriptionResponseTransfer
     */
    public function audioTranscribe(array $options = []): OpenAiTranscriptionResponseTransfer
    {
        $transcriptionResponse = $this->client->audio()->transcribe($options);

        return (new OpenAiTranscriptionResponseTransfer())
            ->fromArray($transcriptionResponse->toArray(), true);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiTranslationResponseTransfer
     */
    public function audioTranslate(array $options = []): OpenAiTranslationResponseTransfer
    {
        $translationResponse = $this->client->audio()->translate($options);

        return (new OpenAiTranslationResponseTransfer())
            ->fromArray($translationResponse->toArray(), true);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiEditsCreateResponseTransfer
     */
    public function editsCreate(array $options = []): OpenAiEditsCreateResponseTransfer
    {
        $createResponse = $this->client->edits()->create($options);

        return (new OpenAiEditsCreateResponseTransfer())
            ->fromArray($createResponse->toArray(), true)
            ->setCreateResponseUsage(
                (new OpenAiCreateResponseUsageTransfer())
                ->fromArray($createResponse->usage->toArray(), true),
            );
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiEmbeddingsCreateResponseTransfer
     */
    public function embeddingsCreate(array $options = []): OpenAiEmbeddingsCreateResponseTransfer
    {
        $createResponse = $this->client->embeddings()->create($options);

        return (new OpenAiEmbeddingsCreateResponseTransfer())
            ->fromArray($createResponse->toArray(), true)
            ->setCreateResponseUsage(
                (new OpenAiCreateResponseUsageTransfer())
                ->fromArray($createResponse->usage->toArray(), true),
            );
    }

    /**
     * @return \Generated\Shared\Transfer\OpenAiFilesListResponseTransfer
     */
    public function filesList(): OpenAiFilesListResponseTransfer
    {
        $listResponse = $this->client->files()->list();

        return (new OpenAiFilesListResponseTransfer())
            ->fromArray($listResponse->toArray(), true);
    }

    /**
     * @param string $file
     *
     * @return \Generated\Shared\Transfer\OpenAiFilesDeleteResponseTransfer
     */
    public function filesDelete(string $file): OpenAiFilesDeleteResponseTransfer
    {
        $deleteResponse = $this->client->files()->delete($file);

        return (new OpenAiFilesDeleteResponseTransfer())
            ->fromArray($deleteResponse->toArray(), true);
    }

    /**
     * @param string $file
     *
     * @return \Generated\Shared\Transfer\OpenAiFilesRetrieveResponseTransfer
     */
    public function filesRetrieve(string $file): OpenAiFilesRetrieveResponseTransfer
    {
        $retrieveResponse = $this->client->files()->retrieve($file);

        return (new OpenAiFilesRetrieveResponseTransfer())
            ->fromArray($retrieveResponse->toArray(), true)
            ->setStatusDetailsArray($retrieveResponse->statusDetails ?? null)
            ->setStatusDetails($retrieveResponse->statusDetails ?? null);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiFilesUploadResponseTransfer
     */
    public function filesUpload(array $options = []): OpenAiFilesUploadResponseTransfer
    {
        $createResponse = $this->client->files()->upload($options);

        return (new OpenAiFilesUploadResponseTransfer())
            ->fromArray($createResponse->toArray(), true)
            ->setStatusDetailsArray($createResponse->statusDetails ?? null)
            ->setStatusDetails($createResponse->statusDetails ?? null);
    }

    /**
     * @param string $file
     *
     * @return string
     */
    public function filesDownload(string $file): string
    {
        return $this->client->files()->download($file);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiFinetuneCreateResponseTransfer
     */
    public function fineTunesCreate(array $options = []): OpenAiFinetuneCreateResponseTransfer
    {
        $createResponse = $this->client->fineTunes()->create($options);

        return (new OpenAiFinetuneCreateResponseTransfer())
            ->fromArray($createResponse->toArray(), true)
            ->setHyperparams(
                (new OpenAiFinetuneRetrieveResponseHyperparamsTransfer())
                ->fromArray($createResponse->hyperparams->toArray(), true),
            );
    }

    /**
     * @return \Generated\Shared\Transfer\OpenAiFinetuneListResponseTransfer
     */
    public function fineTunesList(): OpenAiFinetuneListResponseTransfer
    {
        $listResponse = $this->client->fineTunes()->list();

        return (new OpenAiFinetuneListResponseTransfer())
            ->fromArray($listResponse->toArray(), true);
    }

    /**
     * @param string $fineTuneId
     *
     * @return \Generated\Shared\Transfer\OpenAiFinetuneRetrieveResponseTransfer
     */
    public function fineTunesRetrieve(string $fineTuneId): OpenAiFinetuneRetrieveResponseTransfer
    {
        $retrieveResponse = $this->client->fineTunes()->retrieve($fineTuneId);

        return (new OpenAiFinetuneRetrieveResponseTransfer())
            ->fromArray($retrieveResponse->toArray(), true)
            ->setHyperparams(
                (new OpenAiFinetuneRetrieveResponseHyperparamsTransfer())
                ->fromArray($retrieveResponse->hyperparams->toArray(), true),
            );
    }

    /**
     * @param string $fineTuneId
     *
     * @return \Generated\Shared\Transfer\OpenAiFinetuneCancelResponseTransfer
     */
    public function fineTunesCancel(string $fineTuneId): OpenAiFinetuneCancelResponseTransfer
    {
        $cancelResponse = $this->client->fineTunes()->cancel($fineTuneId);

        return (new OpenAiFinetuneCancelResponseTransfer())
            ->fromArray($cancelResponse->toArray(), true)
            ->setHyperparams(
                (new OpenAiFinetuneRetrieveResponseHyperparamsTransfer())
                ->fromArray($cancelResponse->hyperparams->toArray(), true),
            );
    }

    /**
     * @param string $fineTuneId
     *
     * @return \Generated\Shared\Transfer\OpenAiFinetuneListEventsResponseTransfer
     */
    public function fineTunesListEvents(string $fineTuneId): OpenAiFinetuneListEventsResponseTransfer
    {
        $listResponse = $this->client->fineTunes()->listEvents($fineTuneId);

        return (new OpenAiFinetuneListEventsResponseTransfer())
            ->fromArray($listResponse->toArray(), true);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiModerationsCreateResponseTransfer
     */
    public function moderationsCreate(array $options = []): OpenAiModerationsCreateResponseTransfer
    {
        $createResponse = $this->client->moderations()->create($options);

        return (new OpenAiModerationsCreateResponseTransfer())
            ->fromArray($createResponse->toArray(), true);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiImagesCreateResponseTransfer
     */
    public function imagesCreate(array $options = []): OpenAiImagesCreateResponseTransfer
    {
        $createResponse = $this->client->images()->create($options);

        return (new OpenAiImagesCreateResponseTransfer())
            ->fromArray($createResponse->toArray(), true);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiImagesEditResponseTransfer
     */
    public function imagesEdit(array $options = []): OpenAiImagesEditResponseTransfer
    {
        $editResponse = $this->client->images()->edit($options);

        return (new OpenAiImagesEditResponseTransfer())
            ->fromArray($editResponse->toArray(), true);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiImagesVariationResponseTransfer
     */
    public function imagesVariation(array $options = []): OpenAiImagesVariationResponseTransfer
    {
        $variationResponse = $this->client->images()->variation($options);

        return (new OpenAiImagesVariationResponseTransfer())
            ->fromArray($variationResponse->toArray(), true);
    }
}
