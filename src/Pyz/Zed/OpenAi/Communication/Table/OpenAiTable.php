<?php

declare(strict_types = 1);

namespace Pyz\Zed\OpenAi\Communication\Table;

use Orm\Zed\OpenAi\Persistence\Map\VsyOpenaiPromptTableMap;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;
use Pyz\Zed\OpenAi\Persistence\OpenAiRepository;

class OpenAiTable extends AbstractTable
{
    private const COL_NAME = 'Name';
    private const COL_MODEL = 'Model';
    private const COL_ACTIONS = 'Actions';

    private const TABLE_IDENTIFIER = 'openai_prompt_index_table';

    private const REMOVE_URL = '/open-ai/remove/remove';
    private const EDIT_URL = '/open-ai/edit/edit';

    /**
     * @param \Pyz\Zed\OpenAi\Persistence\OpenAiRepository $openAiRepository
     */
    public function __construct(private OpenAiRepository $openAiRepository)
    {
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config
            ->setHeader([
                VsyOpenaiPromptTableMap::COL_NAME => self::COL_NAME,
                VsyOpenaiPromptTableMap::COL_MODEL => self::COL_MODEL,
                self::COL_ACTIONS => self::COL_ACTIONS,
        ]);

        $config->setRawColumns([
            self::COL_ACTIONS,
        ]);

        $config->setSearchable([
            VsyOpenaiPromptTableMap::COL_NAME => self::COL_NAME,
        ]);

        $this->setTableIdentifier(self::TABLE_IDENTIFIER);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Propel\Runtime\Collection\ObjectCollection|array
     */
    protected function prepareData(TableConfiguration $config)
    {
        $query = $this->openAiRepository->queryOpenAiPrompts();
        $queryResults = $this->runQuery($query, $config, true);

        if ($queryResults->count() < 1) {
            return [];
        }

        $resultArray = [];

        /** @var \Orm\Zed\OpenAi\Persistence\Base\VsyOpenaiPrompt $queryResult */
        foreach ($queryResults as $queryResult) {
            $resultArray[] = [
                VsyOpenaiPromptTableMap::COL_NAME => $queryResult->getName(),
                VsyOpenaiPromptTableMap::COL_MODEL => $queryResult->getModel(),
                self::COL_ACTIONS => implode('', $this->createActionColumnsButtons($queryResult->getIdOpenaiPrompt())),
            ];
        }

        return $resultArray;
    }

    /**
     * @param int $idOpenAi
     *
     * @return array
     */
    private function createActionColumnsButtons(int $idOpenAi): array
    {
        return [
            $this->generateOpenAiEditButton($idOpenAi),
            $this->generateOpenAiDeleteButton($idOpenAi),
        ];
    }

    /**
     * @param int $idOpenAi
     *
     * @return string
     */
    private function generateOpenAiEditButton(int $idOpenAi): string
    {
        return $this->generateEditButton(
            Url::generate(
                self::EDIT_URL,
                ['id-openai-prompt' => $idOpenAi],
            )->build(),
            'Edit',
        );
    }

    /**
     * @param int $idOpenAi
     *
     * @return string
     */
    private function generateOpenAiDeleteButton(int $idOpenAi): string
    {
        return $this->generateRemoveButton(
            Url::generate(
                self::REMOVE_URL,
                ['id-openai-prompt' => $idOpenAi],
            )->build(),
            'Delete',
        );
    }
}
