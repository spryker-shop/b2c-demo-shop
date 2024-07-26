<?php

namespace Pyz\Zed\Book\Communication\Form\DataProvider;

use Orm\Zed\Book\Persistence\PyzBook;
use Pyz\Zed\Book\Persistence\BookQueryContainerInterface;
use Pyz\Zed\Book\Communication\Form\BookForm;

class BookFormDataProvider
{
    /**
     * @var \Pyz\Zed\Book\Persistence\BookQueryContainerInterface
     */
    protected $bookQueryContainer;

    /**
     * @param \Pyz\Zed\Book\Persistence\BookQueryContainerInterface $bookQueryContainer
     */
    public function __construct(BookQueryContainerInterface $bookQueryContainer)
    {
        $this->bookQueryContainer = $bookQueryContainer;
    }

    /**
     * @param int $idBook
     *
     * @return array
     */
    public function getData($idBook)
    {
        $data = [];

        $bookEntity = $this->findBook($idBook);

        if ($bookEntity === null) {
            return $data;
        }

        $data[BookForm::FIELD_NAME] = $bookEntity->getName();
        $data[BookForm::FIELD_DESCRIPTION] = $bookEntity->getDescription();
        $publicationDate = $bookEntity->getPublicationDate();

        // Ensure publication_date is a \DateTime object
//        $data[BookForm::FIELD_PUBLICATION_DATE] = $bookEntity->getPublicationDate() ? $bookEntity->getPublicationDate()->format('Y-m-d H:i:s') : null;
        $data[BookForm::FIELD_PUBLICATION_DATE] = $publicationDate instanceof \DateTime ? $publicationDate : new \DateTime($publicationDate);

        return $data;
    }

    /**
     * @param int $idBook
     *
     * @return \Orm\Zed\Book\Persistence\PyzBook|null
     */
    protected function findBook($idBook): ?PyzBook
    {
        return $this->bookQueryContainer
            ->queryBooks()
            ->findOneById($idBook);
    }
}
