<?php

namespace Pyz\Zed\Book\Communication;

use Pyz\Zed\Book\Business\Mapper\BookMapper;
use Pyz\Zed\Book\Business\Mapper\BookMapperInterface;
use Pyz\Zed\Book\Communication\Form\BookForm;
use Pyz\Zed\Book\BookTransfer;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;

class BookCommunicationFactory extends AbstractCommunicationFactory
{
    public function createBookForm(BookTransfer $bookTransfer): FormInterface
    {
        return $this->getFormFactory()->create(BookForm::class, $bookTransfer);
    }

    public function createBookMapper(): BookMapperInterface
    {
        // Instantiate the mapper directly
        return new BookMapper();
    }
}
