<?php
namespace Pyz\Zed\Book\Communication\Table;

use DateTime;
use Exception;
use Orm\Zed\Book\Persistence\PyzBookQuery;
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
        // To do: Change hardcoded strings to reflect the example given in docs at https://docs.spryker.com/docs/dg/dev/backend-development/zed-ui-tables/create-and-configure-zed-tables.html#configure-the-table
        $config->setHeader([
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'publication_date' => 'Publication Date',
        ]);

        $config->setSortable([
            'id',
            'name',
            'publication_date',
        ]);

        $config->setSearchable([
            'name',
            'description',
        ]);

        $config->setDefaultSortField('publication_date', TableConfiguration::SORT_DESC);

        $config->setSearchableColumns([
            'id' => 'id',
            'name' => 'name',
            'description' => 'description',
            'publication_date' => 'publication_date',
        ]);
        // addRawColumn doesn't seem to apply
        return $config;
    }

    protected function prepareData(TableConfiguration $config): array
    {
        $queryResults = $this->runQuery($this->query, $config, true);

        $results = [];
        foreach ($queryResults as $item) {
            try {
                $results[] = [
                    'id' => $item['Id'],
                    'name' => $item['Name'],
                    'description' => $item['Description'],
                    'publication_date' => (new DateTime($item['PublicationDate']))->format('Y-m-d H:i:s'),
                ];
            } catch (Exception $e) {
            }
        }
        return $results;
    }
}
