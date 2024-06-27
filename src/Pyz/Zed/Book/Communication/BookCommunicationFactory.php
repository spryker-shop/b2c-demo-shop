<?php

namespace Pyz\Zed\Book\Communication;

use Pyz\Zed\Book\BookDependencyProvider;
use Pyz\Zed\Book\Communication\Form\BookForm;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException;
use Symfony\Component\Form\FormInterface;

class BookCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @throws ContainerKeyNotFoundException
     */
    public function createBookForm($data = null, array $options = []): FormInterface
    {
        return $this->getFormFactory()->create(BookForm::class, $data, $options);
    }

    /**
     * @throws ContainerKeyNotFoundException
     */
    public function getFormFactory()
    {
        return $this->getProvidedDependency(BookDependencyProvider::FORM_FACTORY);
    }
}
