<?php
namespace Pyz\Zed\Book\Communication\Table;

use Propel\Runtime\ActiveQuery\ModelCriteria;
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

    protected function configure(TableConfiguration $config): void
    {
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
    }

    protected function prepareData(TableConfiguration $config): array
    {
        $queryResults = $this->runQuery($this->query, $config);

        $results = [];
        foreach ($queryResults as $book) {
            $results[] = [
                'id' => $book->getId(),
                'name' => $book->getName(),
                'description' => $book->getDescription(),
                'publication_date' => $book->getPublicationDate()->format('Y-m-d H:i:s'),
            ];
        }

        return $results;
    }

    protected function runQuery(ModelCriteria $query, TableConfiguration $config, $returnRawResults = false)
    {
        return $returnRawResults ? $query->find()->getData() : $query->find();
    }
}
