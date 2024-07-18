<?php
namespace Pyz\Zed\Book\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Orm\Zed\Book\Persistence\PyzBookQuery;

class UpdateController extends AbstractController
{
    public function indexAction(Request $request)
    {
        $id = $request->request->getInt('id');
        $formData = $request->request->all();

        $bookEntity = PyzBookQuery::create()->findOneById($id);

        if (!$bookEntity) {
            $this->addErrorMessage("Book with ID %s not found.", ['%s' => $id]);
            return $this->redirectResponse('/books');
        }

        $bookEntity->fromArray($formData);
        $bookEntity->save();

        $this->addSuccessMessage("Book with ID %s updated successfully.", ['%s' => $id]);
        return $this->redirectResponse('/books');
    }
}
