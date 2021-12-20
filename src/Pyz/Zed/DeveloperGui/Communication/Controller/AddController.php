<?php

namespace Pyz\Zed\DeveloperGui\Communication\Controller;

use Generated\Shared\Transfer\DeveloperTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Spryker\Service\UtilText\Model\Url\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddController extends AbstractController
{

    protected const DEVELOPER_CREATED_SUCCESSFULLY_MESSAGE = 'Developer created successfully';

    /**
     * @param Request $request
     *
     * @return array|Response
     */
    public function indexAction(Request $request)
    {
        $developerFormAdd = $this
            ->getFactory()
            ->getDeveloperAddForm()
            ->handleRequest($request);

        if ($developerFormAdd->isSubmitted() && $developerFormAdd->isValid()) {

            $developerTransfer = new DeveloperTransfer();
            $developerTransfer->fromArray($developerFormAdd->getData(), true);

            $this->getFactory()->getDeveloperFacade()->createDeveloper($developerTransfer);

            $this->addSuccessMessage(static::DEVELOPER_CREATED_SUCCESSFULLY_MESSAGE);

            return $this->generateBaseRedirectUrl($developerTransfer);

        }

        return $this->viewResponse([

            'cartAddForm' => $developerFormAdd->createView(),

        ]);
    }

    /**
     * @param DeveloperTransfer $developerTransfer
     *
     * @return RedirectResponse
     */
    protected function generateBaseRedirectUrl(DeveloperTransfer $developerTransfer): RedirectResponse
    {

        $developerTransfer->requireIdDeveloper();

        $url = Url::generate('/developer-gui/view', [

            ViewController::PARAM_ID_DEVELOPER => $developerTransfer->getIdDeveloper(),

        ]);

        return $this->redirectResponse($url->build());

    }

}
