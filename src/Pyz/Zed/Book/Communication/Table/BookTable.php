<?php
namespace Pyz\Zed\Book\Communication\Table;

use DateTime;
use Exception;
use Orm\Zed\Book\Persistence\PyzBookQuery;
use Orm\Zed\Book\Persistence\Map\PyzBookTableMap;
use Propel\Runtime\Collection\ObjectCollection;
use Pyz\Zed\Book\Communication\Controller\EditController;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class BookTable extends AbstractTable
{
    /**
     * @var string
     */
    public const ACTIONS = 'Actions';

    /**
     * @var string
     */
    public const URL_BOOK_EDIT = '/book/edit';

    /**
     * @var string
     */
    public const URL_BOOK_DELETE = '/book/delete';


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
            static::ACTIONS => static::ACTIONS
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

        $config->setRawColumns([static::ACTIONS]);

        return $config;
    }

    protected function prepareData(TableConfiguration $config): array
    {
        $queryResults = $this->runQuery($this->query, $config, true);

        $results = [];
        if ($queryResults instanceof ObjectCollection) {
            // Handle ObjectCollection
            foreach ($queryResults as $item) {
                try {
                    $publicationDate = $item->getPublicationDate();
                    if (!$publicationDate instanceof DateTime) {
                        $publicationDate = new DateTime($publicationDate);
                    }

                    $bookData = [
                        PyzBookTableMap::COL_ID => $item->getId(), // Use getter methods
                        PyzBookTableMap::COL_NAME => $item->getName(),
                        PyzBookTableMap::COL_DESCRIPTION => $item->getDescription(),
                        PyzBookTableMap::COL_PUBLICATION_DATE => $publicationDate->format('Y-m-d H:i:s'),
                    ];

                    $bookData[static::ACTIONS] = implode(' ', $this->buildActionUrls($bookData));

                    $results[] = $bookData;
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

                    $bookData = [
                        PyzBookTableMap::COL_ID => $item[PyzBookTableMap::COL_ID],
                        PyzBookTableMap::COL_NAME => $item[PyzBookTableMap::COL_NAME],
                        PyzBookTableMap::COL_DESCRIPTION => $item[PyzBookTableMap::COL_DESCRIPTION],
                        PyzBookTableMap::COL_PUBLICATION_DATE => $publicationDate->format('Y-m-d H:i:s'),
                    ];

                    $bookData[static::ACTIONS] = implode(' ', $this->buildActionUrls($bookData));

                    $results[] = $bookData;
                } catch (Exception $e) {
                    // Handle exception or log error
                    // e.g., error_log($e->getMessage());
                }
            }
        }

        return $results;
    }

    /**
     * @param array $details
     *
     * @return array
     */
    protected function buildActionUrls($details)
    {
        $urls = [];

        $idBook = $details[PyzBookTableMap::COL_ID];
        $urls[] = $this->generateEditButton(
            Url::generate(static::URL_BOOK_EDIT, [
                EditController::URL_PARAMETER_ID_BOOK => $idBook,
            ]),
            'Edit',
        );

        $urls[] = $this->generateRemoveButton(
            Url::generate(static::URL_BOOK_DELETE, [
                EditController::URL_PARAMETER_ID_BOOK => $idBook,
            ]),
            'Delete',
        );

        return $urls;
    }

}
