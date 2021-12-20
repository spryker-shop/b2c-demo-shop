<?php
namespace Pyz\Zed\Developer\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class IndexController extends AbstractController
{
    /**
     * @param Request $request
     * @return string[]
     */
    public function indexAction(Request $request): array
    {
        return ['string' => 'Hello developers'];
    }

}
