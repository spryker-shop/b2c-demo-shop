<?php
namespace Pyz\Zed\Book\Communication;

use Pyz\Zed\Book\Communication\Form\BookForm;
use Pyz\Zed\Book\Communication\Table\BookTable;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class BookCommunicationFactory extends AbstractCommunicationFactory
{
    public const ROUTER = 'BOOK_ROUTER';
    
    // Create a form for adding book records
    public function createBookForm(Request $request = null): FormInterface
    {
        return $this->getFormFactory()->create(BookForm::class, null, ['method' => 'POST']);
    }

    // Create a form for Editing book records
    public function editBookForm(Request $request = null): FormInterface
    {
        return $this->getFormFactory()->create(BookForm::class, null, ['method' => 'PUT']);
    }
}
