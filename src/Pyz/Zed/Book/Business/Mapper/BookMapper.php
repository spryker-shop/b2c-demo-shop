<?php

namespace Pyz\Zed\Book\Business\Mapper;

use Orm\Zed\Book\Persistence\PyzBook;
use Pyz\Zed\Book\BookTransfer;

class BookMapper implements BookMapperInterface
{
    public function mapEntityToTransfer(PyzBook $bookEntity): BookTransfer
    {
        $bookTransfer = new BookTransfer();

        // Assign the entity data to the transfer object
        $bookTransfer->setIdBook($bookEntity->getIdBook());
        $bookTransfer->setName($bookEntity->getName());
        $bookTransfer->setDescription($bookEntity->getDescription());
        $bookTransfer->setPublicationDate($bookEntity->getPublicationDate());
        $bookTransfer->setCreatedAt($bookEntity->getCreatedAt());
        $bookTransfer->setUpdatedAt($bookEntity->getUpdatedAt());

        return $bookTransfer;
    }

    public function mapTransferToEntity(BookTransfer $bookTransfer, PyzBook $bookEntity): PyzBook
    {
        $bookEntity->setIdBook($bookTransfer->getIdBook());
        $bookEntity->setName($bookTransfer->getName());
        $bookEntity->setDescription($bookTransfer->getDescription());
        $bookEntity->setPublicationDate($bookTransfer->getPublicationDate());
        $bookEntity->setCreatedAt($bookTransfer->getCreatedAt());
        $bookEntity->setUpdatedAt($bookTransfer->getUpdatedAt());

        return $bookEntity;
    }
}
