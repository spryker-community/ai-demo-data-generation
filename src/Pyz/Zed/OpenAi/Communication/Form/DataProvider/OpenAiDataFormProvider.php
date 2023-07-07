<?php

declare(strict_types = 1);

namespace Pyz\Zed\OpenAi\Communication\Form\DataProvider;

use Spryker\Zed\Locale\Business\LocaleFacadeInterface;
use Pyz\Zed\OpenAi\Communication\Form\OpenAiCreateForm;

class OpenAiDataFormProvider
{
    /**
     * @param \Spryker\Zed\Locale\Business\LocaleFacadeInterface $localeFacade
     */
    public function __construct(private LocaleFacadeInterface $localeFacade)
    {
    }

    /**
     * @return array<array>
     */
    public function getOptions(): array
    {
        return [
            OpenAiCreateForm::OPTION_LOCALE_CHOICES => $this->getLocaleChoices(),
        ];
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return [];
    }

    /**
     * @return array
     */
    protected function getLocaleChoices(): array
    {
        $result = [];

        foreach ($this->localeFacade->getLocaleCollection() as $localeTransfer) {
            $result[$localeTransfer->getIdLocaleOrFail()] = $localeTransfer->getLocaleNameOrFail();
        }

        return $result;
    }
}
