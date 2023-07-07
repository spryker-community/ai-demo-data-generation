<?php

declare(strict_types = 1);

namespace Pyz\Client\OpenAi;

use Generated\Shared\Transfer\OpenAiCreateResponseTransfer;
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
use Generated\Shared\Transfer\OpenAiFinetuneRetrieveResponseTransfer;
use Generated\Shared\Transfer\OpenAiImagesCreateResponseTransfer;
use Generated\Shared\Transfer\OpenAiImagesEditResponseTransfer;
use Generated\Shared\Transfer\OpenAiImagesVariationResponseTransfer;
use Generated\Shared\Transfer\OpenAiModerationsCreateResponseTransfer;
use Generated\Shared\Transfer\OpenAiTranscriptionResponseTransfer;
use Generated\Shared\Transfer\OpenAiTranslationResponseTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\OpenAi\OpenAiFactory getFactory()
 */
class OpenAiClient extends AbstractClient implements OpenAiClientInterface
{
    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiCreateResponseTransfer
     */
    public function completionsCreate(array $options = []): OpenAiCreateResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->completionsCreate($options);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiCreateResponseTransfer
     */
    public function chatCreate(array $options = []): OpenAiCreateResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->chatCreate($options);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiTranscriptionResponseTransfer
     */
    public function audioTranscribe(array $options = []): OpenAiTranscriptionResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->audioTranscribe($options);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiTranslationResponseTransfer
     */
    public function audioTranslate(array $options = []): OpenAiTranslationResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->audioTranslate($options);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiEditsCreateResponseTransfer
     */
    public function editsCreate(array $options = []): OpenAiEditsCreateResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->editsCreate($options);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiEmbeddingsCreateResponseTransfer
     */
    public function embeddingsCreate(array $options = []): OpenAiEmbeddingsCreateResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->embeddingsCreate($options);
    }

    /**
     * @return \Generated\Shared\Transfer\OpenAiFilesListResponseTransfer
     */
    public function filesList(): OpenAiFilesListResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->filesList();
    }

    /**
     * @param string $file
     *
     * @return \Generated\Shared\Transfer\OpenAiFilesDeleteResponseTransfer
     */
    public function filesDelete(string $file): OpenAiFilesDeleteResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->filesDelete($file);
    }

    /**
     * @param string $file
     *
     * @return \Generated\Shared\Transfer\OpenAiFilesRetrieveResponseTransfer
     */
    public function filesRetrieve(string $file): OpenAiFilesRetrieveResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->filesRetrieve($file);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiFilesUploadResponseTransfer
     */
    public function filesUpload(array $options = []): OpenAiFilesUploadResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->filesUpload($options);
    }

    /**
     * @param string $file
     *
     * @return string
     */
    public function filesDownload(string $file): string
    {
        return $this->getFactory()->createOpenAiClientDecorator()->filesDownload($file);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiFinetuneCreateResponseTransfer
     */
    public function fineTunesCreate(array $options = []): OpenAiFinetuneCreateResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->fineTunesCreate($options);
    }

    /**
     * @return \Generated\Shared\Transfer\OpenAiFinetuneListResponseTransfer
     */
    public function fineTunesList(): OpenAiFinetuneListResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->fineTunesList();
    }

    /**
     * @param string $fineTuneId
     *
     * @return \Generated\Shared\Transfer\OpenAiFinetuneRetrieveResponseTransfer
     */
    public function fineTunesRetrieve(string $fineTuneId): OpenAiFinetuneRetrieveResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->fineTunesRetrieve($fineTuneId);
    }

    /**
     * @param string $fineTuneId
     *
     * @return \Generated\Shared\Transfer\OpenAiFinetuneCancelResponseTransfer
     */
    public function fineTunesCancel(string $fineTuneId): OpenAiFinetuneCancelResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->fineTunesCancel($fineTuneId);
    }

    /**
     * @param string $fineTuneId
     *
     * @return \Generated\Shared\Transfer\OpenAiFinetuneListEventsResponseTransfer
     */
    public function fineTunesListEvents(string $fineTuneId): OpenAiFinetuneListEventsResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->fineTunesListEvents($fineTuneId);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiModerationsCreateResponseTransfer
     */
    public function moderationsCreate(array $options = []): OpenAiModerationsCreateResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->moderationsCreate($options);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiImagesCreateResponseTransfer
     */
    public function imagesCreate(array $options = []): OpenAiImagesCreateResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->imagesCreate($options);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiImagesEditResponseTransfer
     */
    public function imagesEdit(array $options = []): OpenAiImagesEditResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->imagesEdit($options);
    }

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiImagesVariationResponseTransfer
     */
    public function imagesVariation(array $options = []): OpenAiImagesVariationResponseTransfer
    {
        return $this->getFactory()->createOpenAiClientDecorator()->imagesVariation($options);
    }
}
