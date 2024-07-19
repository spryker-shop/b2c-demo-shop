<?php
namespace Pyz\Zed\Book\Communication\Controller;

use Orm\Zed\Book\Persistence\PyzBookQuery;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    // Todo: Refactor to adhere to SOLID design principles
    public function indexAction(Request $request)
    {
        $table = $this->getFactory()->createBookTable();

        return [
            'bookTable' => $table->render(),
        ];
    }
}
