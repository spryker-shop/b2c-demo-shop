<?php

namespace Pyz\Yves\Faq\Controller;

use Generated\Shared\Transfer\PaginationTransfer;
use Pyz\Client\Faq\FaqClientInterface;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Spryker\Yves\Kernel\View\View;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method FaqClientInterface getClient()
 */
class IndexController extends AbstractController {

    public function indexAction(Request $req): View {

        $limit = intval($req->query->get('items-per-page') ?? 10);
        $page  = intval($req->query->get('page') ?? 1);

        var_dump($limit);
        var_dump($page);

        $questions = [];

        $data = $this->getClient()->getAllFaqs(
            (new PaginationTransfer())
                ->setLimit($limit)
                ->setPage($page)
        );

        foreach($data->getFaqs() as $faq) {
            $questions[] = $faq->toArray();
        }


        return $this->view(
            [
                'questions' => $questions,
                'itemsPerPage' => $limit,
                'page' => $page,
                'nextPage' => $page + 1,
                'prevPage' => $page > 1 ? $page - 1 : 1,
            ],
            [],
            '@Faq/views/index/index.twig'
        );
    }
}
