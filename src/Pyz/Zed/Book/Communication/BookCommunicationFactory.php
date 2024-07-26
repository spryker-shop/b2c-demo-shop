<?php

namespace Pyz\Zed\Book\Communication;

use Pyz\Zed\Book\Communication\Form\DataProvider\BookFormDataProvider;
use Pyz\Zed\Book\Communication\Form\BookForm;
use Pyz\Zed\Book\Communication\Form\UpdateBookForm;
use Pyz\Zed\Book\Communication\Table\BookTable;
use Pyz\Zed\Book\BookDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Pyz\Zed\Book\Persistence\BookQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\Book\BookConfig getConfig()
 * @method \Pyz\Zed\Book\Business\BookFacadeInterface getFacade()
 * @method \Pyz\Zed\Book\Persistence\BookRepositoryInterface getRepository()
 */
class BookCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Pyz\Zed\Book\Dependency\Facade\BookToLocaleInterface
     */
    protected function getLocaleFacade()
    {
        return $this->getProvidedDependency(BookDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @return array
     */
    public function getEnabledLocales()
    {
        return $this->getLocaleFacade()->getAvailableLocales();
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createBookAddForm()
    {
        return $this->getFormFactory()->create(BookForm::class);
    }

    /**
     * @param array $formData
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createBookUpdateForm($formData)
    {
        return $this->getFormFactory()->create(UpdateBookForm::class, $formData);
    }

    /**
     * @return \Pyz\Zed\Book\Communication\Form\DataProvider\BookFormDataProvider
     */
    public function createBookFormDataProvider()
    {
        return new BookFormDataProvider($this->getQueryContainer());
    }

    /**
     * @param array $locales
     *
     * @return \Pyz\Zed\Book\Communication\Table\BookTable
     */
    public function createBookTable(array $locales)
    {
        $bookQuery = $this->getQueryContainer()->queryBooks();

        return new BookTable($bookQuery, $locales);
    }

    /**
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getBookCreateForm()
    {
        return $this->createBookAddForm();
    }

    /**
     * @param array $formData
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getBookUpdateForm($formData)
    {
        return $this->createBookUpdateForm($formData);
    }
}
