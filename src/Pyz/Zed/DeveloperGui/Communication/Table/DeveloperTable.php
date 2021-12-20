<?php

namespace Pyz\Zed\DeveloperGui\Communication\Table;

use Orm\Zed\Developer\Persistence\Map\PyzDeveloperTableMap;
use Orm\Zed\Developer\Persistence\PyzDeveloper;
use Pyz\Zed\Developer\Persistence\DeveloperQueryContainerInterface;
use Spryker\Zed\Glossary\Business\GlossaryFacadeInterface;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class DeveloperTable extends AbstractTable
{
    public const COL_NAME = 'name';
    public const COL_SURNAME = 'surname';
    public const COL_PROFESSION = 'profession';
    public const COL_STATUS = 'status';
    public const COL_ACTIONS = 'actions';

    protected const STATUS_TRANSLATION_TEMPLATE = 'developer.status.%s';

    /**
     * @var DeveloperQueryContainerInterface
     */
    private $developerQueryContainer;

    /**
     * @var GlossaryFacadeInterface
     */
    private $glossaryFacade;

    /**
     * @var array
     */
    protected $statusTranslationsCache;

    /**
     * @param DeveloperQueryContainerInterface $developerQueryContainer
     * @param GlossaryFacadeInterface $glossaryFacade
     */
    public function __construct(
        DeveloperQueryContainerInterface $developerQueryContainer,
        GlossaryFacadeInterface $glossaryFacade
    ) {
        $this->developerQueryContainer = $developerQueryContainer;
        $this->glossaryFacade = $glossaryFacade;
    }

    /**
     * @return array
     */
    protected function getStatusTranslations(): array
    {
        if (!$this->statusTranslationsCache) {
            $statuses = PyzDeveloperTableMap::getValueSet(PyzDeveloperTableMap::COL_STATUS);
            $translationMap = [];

            foreach ($statuses as $status) {
                $key = sprintf(static::STATUS_TRANSLATION_TEMPLATE, $status);

                if ($this->glossaryFacade->hasTranslation($key)) {
                    $translationMap[$status] = $this->glossaryFacade->translate($key);
                }
            }

            $this->statusTranslationsCache = $translationMap;
        }

        return $this->statusTranslationsCache;
    }

    /**
     * @param TableConfiguration $config
     *
     * @return TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config->setHeader([
            static::COL_NAME => 'Name',
            static::COL_SURNAME => 'Surname',
            static::COL_PROFESSION => 'Profession',
            static::COL_STATUS => 'Status',
            static::COL_ACTIONS => 'Actions',
        ]);

        $config->setRawColumns([
            static::COL_NAME,
            static::COL_SURNAME,
            static::COL_PROFESSION,
            static::COL_STATUS,
            static::COL_ACTIONS,
        ]);

        $config->setSearchable([
            PyzDeveloperTableMap::COL_NAME,
            PyzDeveloperTableMap::COL_SURNAME,
            PyzDeveloperTableMap::COL_PROFESSION,
        ]);

        $config->setSortable([
            static::COL_NAME,
            static::COL_SURNAME,
            static::COL_PROFESSION,
            static::COL_STATUS,
        ]);

        return $config;
    }

    /**
     * @param TableConfiguration $config
     *
     * @return array|void
     */
    protected function prepareData(TableConfiguration $config)
    {
        $query = $this
            ->developerQueryContainer
            ->queryDeveloper();

        $queryResults = $this->runQuery($query, $config, true);

        $developersCollection = [];
        foreach ($queryResults as $queryResult) {
            $developersCollection[] = $this->generateItem($queryResult);
        }

        return $developersCollection;
    }

    /**
     * @param PyzDeveloper $pyzDeveloper
     *
     * @return array
     */
    protected function generateItem(PyzDeveloper $pyzDeveloper): array
    {
        return [
            static::COL_NAME => $pyzDeveloper->getName(),
            static::COL_SURNAME => $pyzDeveloper->getSurname(),
            static::COL_PROFESSION => $pyzDeveloper->getProfession(),
            static::COL_STATUS => $this->translateStatus($pyzDeveloper->getStatus()),
            static::COL_ACTIONS => implode(' ', $this->createActionColumn($pyzDeveloper)),
        ];
    }

    /**
     * @param string $status
     *
     * @return string
     */
    protected function translateStatus(string $status)
    {
        return $this->getStatusTranslations()[$status] ?? $status;
    }

    /**
     * @param PyzDeveloper $pyzDeveloper
     *
     * @return array
     */
    protected function createActionColumn(PyzDeveloper $pyzDeveloper): array
    {
        $buttons = [];
        $buttons[] = $this->generateViewButton('/developer-gui/view?id-developer=' . $pyzDeveloper->getIdDeveloper(), 'View');
        $buttons[] = $this->generateEditButton('/developer-gui/edit?id-developer=' . $pyzDeveloper->getIdDeveloper(), 'Edit');
        $buttons[] = $this->generateRemoveButton('/developer-gui/delete?id-developer=' . $pyzDeveloper->getIdDeveloper(), 'Delete');

        return $buttons;
    }

}
