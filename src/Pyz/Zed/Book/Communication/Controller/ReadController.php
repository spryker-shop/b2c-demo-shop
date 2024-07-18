<?php
namespace Pyz\Zed\Book\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Orm\Zed\Book\Persistence\PyzBookQuery;

class ReadController extends AbstractController
{
    public function indexAction(Request $request)
    {
        $id = $request->query->getInt('id');

        $bookEntity = PyzBookQuery::create()->findOneById($id);

        // Handle rendering or JSON response for bookEntity
    }
}
