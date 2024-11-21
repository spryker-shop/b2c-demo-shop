<?php
namespace Pyz\Zed\Book\Persistence;

// use Orm\Zed\Book\Persistence\PyzBookQuery;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;
use Propel\Runtime\Collection\ObjectCollection;
use Orm\Zed\Book\Persistence\PyzBook;

// This class handles fetching data from the database.
class BookRepository extends AbstractRepository implements BookRepositoryInterface
{
    // For retrieving all book records
    public function findAllBooks(): ObjectCollection
    {
        // return PyzBookQuery::create()->find()->toArray();   // Also Works
        return $this->getFactory()->getBookQuery()->find();
    }

    
    // Find a book record by Id
    public function findBookById(int $idBook): PyzBook
    {
        // return PyzBookQuery::create()->findPk($idBook)->toArray();   // Also works
        return $this->getFactory()->getBookQuery()->findPk($idBook);
    }
}
