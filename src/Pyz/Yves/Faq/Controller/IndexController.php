<?php

namespace Pyz\Yves\Faq\Controller;

use Spryker\Yves\Kernel\Controller\AbstractController;
use Spryker\Yves\Kernel\View\View;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController {

    public function indexAction(Request $req): View {

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
