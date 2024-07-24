<?php
namespace Pyz\Zed\Book\Communication\Table;

use DateTime;
use Exception;
use Orm\Zed\Book\Persistence\PyzBookQuery;
use Orm\Zed\Book\Persistence\Map\PyzBookTableMap;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class BookTable extends AbstractTable
{
    protected $query;

    public function __construct(PyzBookQuery $query)
    {
        $this->query = $query;
    }

    protected function configure(TableConfiguration $config)
    {
        // Using constants from PyzBookTableMap
        $config->setHeader([
            PyzBookTableMap::COL_ID => 'ID',
            PyzBookTableMap::COL_NAME => 'Name',
            PyzBookTableMap::COL_DESCRIPTION => 'Description',
            PyzBookTableMap::COL_PUBLICATION_DATE => 'Publication Date',
        ]);

        $config->setSortable([
            PyzBookTableMap::COL_ID,
            PyzBookTableMap::COL_NAME,
            PyzBookTableMap::COL_PUBLICATION_DATE,
        ]);

        $config->setSearchable([
            PyzBookTableMap::COL_NAME,
            PyzBookTableMap::COL_DESCRIPTION,
        ]);

        $config->setDefaultSortField(PyzBookTableMap::COL_PUBLICATION_DATE, TableConfiguration::SORT_DESC);

        $config->setSearchableColumns([
            PyzBookTableMap::COL_ID => 'id',
            PyzBookTableMap::COL_NAME => 'name',
            PyzBookTableMap::COL_DESCRIPTION => 'description',
            PyzBookTableMap::COL_PUBLICATION_DATE => 'publication_date',
        ]);

        // Return the configuration object
        return $config;
    }

    protected function prepareData(TableConfiguration $config): array
    {
        $queryResults = $this->runQuery($this->query, $config, true);

        $results = [];
        if ($queryResults instanceof \Propel\Runtime\Collection\ObjectCollection) {
            // Handle ObjectCollection
            foreach ($queryResults as $item) {
                try {
                    $publicationDate = $item->getPublicationDate();
                    if (!$publicationDate instanceof DateTime) {
                        $publicationDate = new DateTime($publicationDate);
                    }

                    $results[] = [
                        PyzBookTableMap::COL_ID => $item->getId(), // Use getter methods
                        PyzBookTableMap::COL_NAME => $item->getName(),
                        PyzBookTableMap::COL_DESCRIPTION => $item->getDescription(),
                        PyzBookTableMap::COL_PUBLICATION_DATE => $publicationDate->format('Y-m-d H:i:s'),
                    ];
                } catch (Exception $e) {
                    // Handle exception or log error
                    // e.g., error_log($e->getMessage());
                }
            }
        } elseif (is_array($queryResults)) {
            // Handle array of arrays
            foreach ($queryResults as $item) {
                try {
                    $publicationDate = $item[PyzBookTableMap::COL_PUBLICATION_DATE];
                    if (!$publicationDate instanceof DateTime) {
                        $publicationDate = new DateTime($publicationDate);
                    }

                    $results[] = [
                        'id_' => $item[PyzBookTableMap::COL_ID],
                        'name' => $item[PyzBookTableMap::COL_NAME],
                        'description' => $item[PyzBookTableMap::COL_DESCRIPTION],
                        'publication_date' => $publicationDate->format('Y-m-d H:i:s'),
                    ];
                } catch (Exception $e) {
                    // Handle exception or log error
                    // e.g., error_log($e->getMessage());
                }
            }
        }

        return $results;
    }


}
