<?php

declare(strict_types = 1);

namespace Pyz\Client\OpenAi\Decorator;

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

interface OpenAiClientDecoratorInterface
{
    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiCreateResponseTransfer
     */
    public function completionsCreate(array $options = []): OpenAiCreateResponseTransfer;

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiCreateResponseTransfer
     */
    public function chatCreate(array $options = []): OpenAiCreateResponseTransfer;

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiTranscriptionResponseTransfer
     */
    public function audioTranscribe(array $options = []): OpenAiTranscriptionResponseTransfer;

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiTranslationResponseTransfer
     */
    public function audioTranslate(array $options = []): OpenAiTranslationResponseTransfer;

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiEditsCreateResponseTransfer
     */
    public function editsCreate(array $options = []): OpenAiEditsCreateResponseTransfer;

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiEmbeddingsCreateResponseTransfer
     */
    public function embeddingsCreate(array $options = []): OpenAiEmbeddingsCreateResponseTransfer;

    /**
     * @return \Generated\Shared\Transfer\OpenAiFilesListResponseTransfer
     */
    public function filesList(): OpenAiFilesListResponseTransfer;

    /**
     * @param string $file
     *
     * @return \Generated\Shared\Transfer\OpenAiFilesDeleteResponseTransfer
     */
    public function filesDelete(string $file): OpenAiFilesDeleteResponseTransfer;

    /**
     * @param string $file
     *
     * @return \Generated\Shared\Transfer\OpenAiFilesRetrieveResponseTransfer
     */
    public function filesRetrieve(string $file): OpenAiFilesRetrieveResponseTransfer;

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiFilesUploadResponseTransfer
     */
    public function filesUpload(array $options = []): OpenAiFilesUploadResponseTransfer;

    /**
     * @param string $file
     *
     * @return string
     */
    public function filesDownload(string $file): string;

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiFinetuneCreateResponseTransfer
     */
    public function fineTunesCreate(array $options = []): OpenAiFinetuneCreateResponseTransfer;

    /**
     * @return \Generated\Shared\Transfer\OpenAiFinetuneListResponseTransfer
     */
    public function fineTunesList(): OpenAiFinetuneListResponseTransfer;

    /**
     * @param string $fineTuneId
     *
     * @return \Generated\Shared\Transfer\OpenAiFinetuneRetrieveResponseTransfer
     */
    public function fineTunesRetrieve(string $fineTuneId): OpenAiFinetuneRetrieveResponseTransfer;

    /**
     * @param string $fineTuneId
     *
     * @return \Generated\Shared\Transfer\OpenAiFinetuneCancelResponseTransfer
     */
    public function fineTunesCancel(string $fineTuneId): OpenAiFinetuneCancelResponseTransfer;

    /**
     * @param string $fineTuneId
     *
     * @return \Generated\Shared\Transfer\OpenAiFinetuneListEventsResponseTransfer
     */
    public function fineTunesListEvents(string $fineTuneId): OpenAiFinetuneListEventsResponseTransfer;

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiModerationsCreateResponseTransfer
     */
    public function moderationsCreate(array $options = []): OpenAiModerationsCreateResponseTransfer;

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiImagesCreateResponseTransfer
     */
    public function imagesCreate(array $options = []): OpenAiImagesCreateResponseTransfer;

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiImagesEditResponseTransfer
     */
    public function imagesEdit(array $options = []): OpenAiImagesEditResponseTransfer;

    /**
     * @param array $options
     *
     * @return \Generated\Shared\Transfer\OpenAiImagesVariationResponseTransfer
     */
    public function imagesVariation(array $options = []): OpenAiImagesVariationResponseTransfer;
}
