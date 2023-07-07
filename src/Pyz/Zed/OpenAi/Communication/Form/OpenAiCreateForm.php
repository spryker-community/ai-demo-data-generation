<?php

declare(strict_types = 1);

namespace Pyz\Zed\OpenAi\Communication\Form;

use Generated\Shared\Transfer\OpenAiPromptTransfer;
use Orm\Zed\OpenAi\Persistence\VsyOpenaiPrompt;
use ReflectionClass;
use ReflectionException;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \Pyz\Zed\OpenAi\Communication\OpenAiCommunicationFactory getFactory()
 * @method \Pyz\Zed\OpenAi\Business\OpenAiFacadeInterface getFacade()
 * @method \Pyz\Zed\OpenAi\Persistence\OpenAiRepositoryInterface getRepository()
 */
class OpenAiCreateForm extends AbstractType
{
    public const NAME_FIELD_NAME = 'name';
    public const MODEL_FIELD_NAME = 'model';
    public const OPTION_LOCALE_CHOICES = 'locale';

    private const BLOCK_PREFIX = 'openai_prompt';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setRequired(static::OPTION_LOCALE_CHOICES);
        $resolver->setDefaults([
            'data_class' => OpenAiPromptTransfer::class,
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return self::BLOCK_PREFIX;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this
//            ->addLocaleField($builder, $options[static::OPTION_LOCALE_CHOICES])
            ->addTextField($builder, OpenAiPromptTransfer::NAME, 'your-prompt-name')
            ->addTextField($builder, OpenAiPromptTransfer::PROMPT, 'Please acknowledge my following request. Please respond to me as a product manager. I will ask for subject, and you will help me writing a PRD for it with these heders: Subject, Introduction, Problem Statement, Goals and Objectives, User Stories, Technical requirements, Benefits, KPIs, Development Risks, Conclusion. Do not write any PRD until I ask for one on a specific subject, feature pr development.', true)
            ->addTextField($builder, OpenAiPromptTransfer::MODEL, 'text-davinci-003')
            ->addTextField($builder, OpenAiPromptTransfer::SUFFIX, 'The suffix that comes after a completion of inserted text.', false)
            ->addTextField($builder, OpenAiPromptTransfer::MAX_TOKENS, '16')
            ->addTextField($builder, OpenAiPromptTransfer::TEMPERATURE, '1')
            ->addTextField($builder, OpenAiPromptTransfer::TOP_P, '1')
            ->addTextField($builder, OpenAiPromptTransfer::N_COMPLETIONS, '1')
            ->addTextField($builder, OpenAiPromptTransfer::LOGPROBS, 'null', false)
            ->addTextField($builder, OpenAiPromptTransfer::STOP, 'null', false)
            ->addTextField($builder, OpenAiPromptTransfer::PRESENCE_PENALTY, '0')
            ->addTextField($builder, OpenAiPromptTransfer::FREQUENCY_PENALTY, '0')
            ->addTextField($builder, OpenAiPromptTransfer::BEST_OF, '1')
            ->addTextField($builder, OpenAiPromptTransfer::USER, 'spryker-gpt')
            ->addCheckboxField($builder, OpenAiPromptTransfer::ECHO)
            ->addCheckboxField($builder, OpenAiPromptTransfer::STREAM);
        $builder->add('Save', SubmitType::class);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $choices
     *
     * @return $this
     */
    protected function addLocaleField(FormBuilderInterface $builder, array $choices): self
    {
        $builder->add(OpenAiPromptTransfer::LOCALE, ChoiceType::class, [
            'label' => OpenAiPromptTransfer::LOCALE,
            'placeholder' => 'Select one',
            'choices' => array_flip($choices),
        ]);

        $builder->get(OpenAiPromptTransfer::LOCALE)->addModelTransformer($this->createLocaleModelTransformer());

        return $this;
    }

    /**
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param string $name
     * @param string $placeholder
     * @param bool $required
     *
     * @return $this
     */
    private function addTextField(FormBuilderInterface $builder, string $name, string $placeholder = '', bool $required = true): self
    {
        $builder->add($name, TextType::class, [
            'label' => $name,
            'attr' => [
                'placeholder' => $placeholder,
                'data-description' => $name,
                'title' => $this->getDescription($name),
            ],
            'required' => $required,
        ]);

        return $this;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function getDescription(string $name): string
    {
        try {
            $description = (new ReflectionClass(VsyOpenaiPrompt::class))->getProperty(strtolower($name))->getDocComment();
        } catch (ReflectionException $e) {
            $description = $this->getDescription(preg_replace('/\B([A-Z])/', '_$1', $name));
        }

        return $description;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param string $name
     *
     * @return $this
     */
    private function addCheckboxField(FormBuilderInterface $builder, string $name): self
    {
        $builder->add($name, CheckboxType::class, [
            'label' => $name,
            'required' => false,
            'attr' => [
                'title' => $this->getDescription($name),
            ],
        ]);

        return $this;
    }

    /**
     * @return \Symfony\Component\Form\CallbackTransformer
     */
    protected function createLocaleModelTransformer(): CallbackTransformer
    {
        return new CallbackTransformer(
            function ($localeAsObject) {
                if ($localeAsObject !== null) {
                    return $localeAsObject->getIdLocale();
                }
            },
            function ($localeAsInt) {
                if ($localeAsInt !== null) {
                    return $this->getFactory()->getLocaleFacade()->getLocaleById($localeAsInt);
                }
            },
        );
    }
}
