<?php

declare(strict_types = 1);

namespace Pyz\Zed\OpenAi\Communication;

use Generated\Shared\Transfer\OpenAiPromptTransfer;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Locale\Business\LocaleFacadeInterface;
use Symfony\Component\Form\FormInterface;
use Pyz\Zed\OpenAi\Communication\Form\DataProvider\OpenAiDataFormProvider;
use Pyz\Zed\OpenAi\Communication\Form\OpenAiCreateForm;
use Pyz\Zed\OpenAi\Communication\Form\OpenAiDeleteForm;
use Pyz\Zed\OpenAi\Communication\Table\OpenAiTable;
use Pyz\Zed\OpenAi\OpenAiDependencyProvider;

/**
 * @method \Pyz\Zed\OpenAi\Business\OpenAiFacade getFacade()
 * @method \Pyz\Zed\OpenAi\Persistence\OpenAiEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\OpenAi\Persistence\OpenAiRepository getRepository()
 */
class OpenAiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @param \Generated\Shared\Transfer\OpenAiPromptTransfer $openAiTransfer
     * @param array $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getOpenAiCreateForm(OpenAiPromptTransfer $openAiTransfer, array $options = []): FormInterface
    {
        return $this->getFormFactory()
            ->create(OpenAiCreateForm::class, $openAiTransfer, $options);
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getOpenAiDeleteForm(): FormInterface
    {
        return $this->getFormFactory()
            ->create(OpenAiDeleteForm::class);
    }

    /**
     * @return \Pyz\Zed\OpenAi\Communication\Form\DataProvider\OpenAiDataFormProvider
     */
    public function createOpenAiFormDataProvider(): OpenAiDataFormProvider
    {
        return new OpenAiDataFormProvider(
            $this->getLocaleFacade(),
        );
    }

    /**
     * @return \Pyz\Zed\OpenAi\Communication\Table\OpenAiTable
     */
    public function createOpenAiTable(): OpenAiTable
    {
        return new OpenAiTable($this->getRepository());
    }

    /**
     * @return \Spryker\Zed\Locale\Business\LocaleFacadeInterface
     */
    public function getLocaleFacade(): LocaleFacadeInterface
    {
        return $this->getProvidedDependency(OpenAiDependencyProvider::FACADE_LOCALE);
    }
}
