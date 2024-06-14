<?php

namespace Pyz\Zed\Book\Communication;

use Pyz\Zed\Book\Communication\Form\BookForm;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;


class BookCommunicationFactory extends AbstractCommunicationFactory
{
    public function createBookForm($data = null, array $options = [])
    {
        return $this->getFormFactory()->create(BookForm::class, $data, $options);
    }

    /**
     * @return \Symfony\Component\Form\FormFactoryInterface
     */
    public function getFormFactory(): FormFactoryInterface
    {
        return $this->getProvidedDependency(BookDependencyProvider::FORM_FACTORY);
    }

    public function createRoutes(): RouteCollection
    {
        $collection = new RouteCollection();

        $collection->add('book_index', new Route('/book', [
            '_controller' => 'Pyz\\Zed\\Book\\Communication\\Controller\\BookController::indexAction'
        ]));

        $collection->add('book_create', new Route('/book/create', [
            '_controller' => 'Pyz\\Zed\\Book\\Communication\\Controller\\BookController::createAction'
        ]));

        $collection->add('book_update', new Route('/book/update/{id}', [
            '_controller' => 'Pyz\\Zed\\Book\\Communication\\Controller\\BookController::updateAction'
        ]));

        $collection->add('book_delete', new Route('/book/delete/{id}', [
            '_controller' => 'Pyz\\Zed\\Book\\Communication\\Controller\\BookController::deleteAction'
        ]));

        return $collection;
    }

    
}
