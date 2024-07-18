<?php
namespace Pyz\Zed\Book\Communication\Controller;

use Orm\Zed\Book\Persistence\PyzBook;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateController extends AbstractController
{
    public function indexAction(Request $request): Response
    {
        $formData = $request->request->all();

        $bookEntity = new PyzBook();
        $bookEntity->fromArray($formData);
        $bookEntity->save();

        $this->addSuccessMessage('Book created successfully.');

        // Redirect to a list page or any other page as needed
        return $this->redirectResponse('/book/list');
    }
}
