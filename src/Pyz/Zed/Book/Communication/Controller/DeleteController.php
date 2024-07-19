<?php
namespace Pyz\Zed\Book\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Orm\Zed\Book\Persistence\PyzBookQuery;

class DeleteController extends AbstractController
{
    // Todo: Refactor to adhere to SOLID design principles
    public function indexAction(Request $request)
    {
        $id = $request->request->getInt('id');

        $bookEntity = PyzBookQuery::create()->findOneById($id);
        $bookEntity->delete();

        // Redirect or return response
    }
}
