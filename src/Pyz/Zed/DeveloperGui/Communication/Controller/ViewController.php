<?php

namespace Pyz\Zed\DeveloperGui\Communication\Controller;

use Generated\Shared\Transfer\DeveloperTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ViewController extends AbstractController
{

    public const PARAM_ID_DEVELOPER = 'id-developer';
    protected const ERROR_MESSAGE_DEVELOPER_ID_NOT_PROVIDED = 'Developer id wasn\'t provided';
    protected const ERROR_MESSAGE_DEVELOPER_NOT_EXIST = 'Developer with id \'%s\' is not exist ';
    protected const EXCEPTION_DEFAULT_REDIRECT_URL = '/developer-gui/index';


    /**
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function indexAction(Request $request)
    {
        $idDeveloper = $request->query->getInt(static::PARAM_ID_DEVELOPER);

        if (!$idDeveloper) {
            $this->addErrorMessage(static::ERROR_MESSAGE_DEVELOPER_ID_NOT_PROVIDED);

            return $this->redirectResponse(static::EXCEPTION_DEFAULT_REDIRECT_URL);
        }

        $searchDeveloperTransfer = (new DeveloperTransfer())
            ->setIdDeveloper($idDeveloper);

        $developerTransfer = $this->getFactory()->getDeveloperFacade()->findDeveloper($searchDeveloperTransfer);

        if (!$developerTransfer) {
            $this->addErrorMessage(static::ERROR_MESSAGE_DEVELOPER_NOT_EXIST, ['%s' => $idDeveloper]);

            return $this->redirectResponse(static::EXCEPTION_DEFAULT_REDIRECT_URL);
        }

        $glossaryFacade = $this->getFactory()->getGlossaryFacade();

        $key = 'developer.status.' . $developerTransfer->getStatus();


        $translatedStatus = $glossaryFacade->hasTranslation($key)
            ? $glossaryFacade->translate($key)
            : $developerTransfer->getStatus();

        return $this->viewResponse([
            'developer' => $developerTransfer,
            'translatedStatus' => $translatedStatus,
        ]);
    }

}
