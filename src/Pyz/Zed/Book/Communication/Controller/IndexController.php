<?php
namespace Pyz\Zed\Book\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method \Pyz\Zed\HelloWorld\Business\HelloWorldFacadeInterface getFacade()
 */
class IndexController extends AbstractController
{
    // For retrieving all books
    public function indexAction()
    {
        $books = $this->getFacade()->findAllBooks();
        return [ 'books' => $books ];
    }
}
