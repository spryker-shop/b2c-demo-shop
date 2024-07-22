<?php
namespace Pyz\Zed\Book\Business;

use Pyz\Zed\Book\Business\Manager\BookManager;
use Pyz\Zed\Book\Business\Manager\BookManagerInterface;
use Pyz\Zed\Book\Business\Reader\BookReader;
use Pyz\Zed\Book\Business\Reader\BookReaderInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\Book\BookConfig getConfig()
 * @method \Pyz\Zed\Book\Persistence\BookRepositoryInterface getRepository()
 */
class BookBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\Book\Business\Manager\BookManagerInterface
     */
    public function createBookManager(): BookManagerInterface
    {
        return new BookManager(
            $this->getRepository()
        );
    }

    /**
     * @return \Pyz\Zed\Book\Business\Reader\BookReaderInterface
     */
    public function createBookReader(): BookReaderInterface
    {
        return new BookReader($this->getRepository());
    }
}
