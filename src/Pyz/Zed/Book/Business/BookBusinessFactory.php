<?php
namespace Pyz\Zed\Book\Business;

use Pyz\Zed\Book\Business\BookManager;
use Pyz\Zed\Book\Business\BookManagerInterface;
use Pyz\Zed\Book\Persistence\BookRepository;
use Pyz\Zed\Book\Persistence\BookRepositoryInterface;
use Pyz\Zed\Book\Persistence\BookEntityManager;
use Pyz\Zed\Book\Persistence\BookEntityManagerInterface;
use Pyz\Zed\Book\BookDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;


class BookBusinessFactory extends AbstractBusinessFactory
{
   
    // public function createBookManager(): BookManagerInterface
    public function createBookManager(): BookManager
    {
        return new BookManager(
            $this->getEntityManager(),
            $this->getRepository()
        );
    }

    // public function getEntityManager(): BookEntityManagerInterface
    public function getEntityManager(): BookEntityManager
    {
        return $this->getProvidedDependency(BookDependencyProvider::ENTITY_MANAGER_BOOK);
    }

    // public function getRepository(): BookRepositoryInterface
    public function getRepository(): BookRepository
    {
        return $this->getProvidedDependency(BookDependencyProvider::REPOSITORY_BOOK);
    }
}
