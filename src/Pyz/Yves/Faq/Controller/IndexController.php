<?php

namespace Pyz\Yves\Faq\Controller;

use Pyz\Client\Faq\FaqClientInterface;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Spryker\Yves\Kernel\View\View;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method FaqClientInterface getClient()
 */
class IndexController extends AbstractController {

    public function indexAction(Request $req): View {

        $data = $this->getClient()->getFaqCollection()->toArray();

        $data = [
            'questions' => [
                [
                    'question' => 'you?',
                    'answer' => 'yes',
                ],
                [
                    'question' => 'you?',
                    'answer' => 'yes',
                ],
                [
                    'question' => 'you?',
                    'answer' => 'yes',
                ],
            ]
        ];

        return $this->view(
            $data,
            [],
            '@Faq/views/index/index.twig'
        );
    }
}
