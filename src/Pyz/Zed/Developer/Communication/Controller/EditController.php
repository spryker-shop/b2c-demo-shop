<?php

namespace Pyz\Zed\Developer\Communication\Controller;

use Exception;
use Generated\Shared\Transfer\DeveloperTransfer;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class EditController extends AbstractController
{
    public const PARAM_ID_DEVELOPER = 'id-cook';
    protected const ERROR_MESSAGE_DEVELOPER_NOT_EXIST = 'Developer with id \'%s\' is not exist ';
    protected const SUCCESSFUL_MESSAGE_DEVELOPER_CREATED = 'Developer successfully updated';
    protected const ERROR_MESSAGE_DEVELOPER_CREATED = 'Developer wasn\'t updated due to error';
    protected const EXCEPTION_DEFAULT_REDIRECT_URL = '/cook-gui/index';


    /**
     * @param Request $request
     *
     * @return array|RedirectResponse
     */
    public function indexAction(Request $request)
    {

        $idDeveloper = $request->query->getInt(static::PARAM_ID_DEVELOPER);

        $developerEditFormDataProvider = $this->getFactory()->createDeveloperEditFormDataProvider();
        $formData = $developerEditFormDataProvider->getData($idDeveloper);

        if ($formData === [] || $idDeveloper === 0) {

            $this->addErrorMessage(static::ERROR_MESSAGE_DEVELOPER_NOT_EXIST, ['%s' => $idDeveloper]);

            return $this->redirectResponse(static::EXCEPTION_DEFAULT_REDIRECT_URL);

        }

        $developerForm = $this
            ->getFactory()
            ->getDeveloperEditForm(
                $formData,
                $developerEditFormDataProvider->getOptions()
            )
            ->handleRequest($request);

        if ($developerForm->isSubmitted() && $developerForm->isValid()) {

            $developerTransfer = new DeveloperTransfer();
            $developerTransfer->fromArray($developerForm->getData(), true);

            try {
                $this->getFactory()->getDeveloperFacade()->saveDeveloper($developerTransfer);
            } catch (Exception $e) {
                $this->addErrorMessage(static::ERROR_MESSAGE_DEVELOPER_CREATED);

                return $this->redirectResponse(static::EXCEPTION_DEFAULT_REDIRECT_URL);
            }

            $this->addSuccessMessage(static::SUCCESSFUL_MESSAGE_DEVELOPER_CREATED);

            return $this->redirectToView($idDeveloper);

        }


        return $this->viewResponse([
            'cookFormTabs' => $this->getFactory()->createDeveloperFormTabs()->createView(),
            'cookForm' => $developerForm->createView(),
            'idDeveloper' => $idDeveloper,
        ]);

    }


    /**
     * @param int $idDeveloper
     *
     * @return RedirectResponse
     */
    protected function redirectToView(int $idDeveloper): RedirectResponse
    {

        $url = Url::generate('/cook-gui/view', [
            ViewController::PARAM_ID_DEVELOPER => $idDeveloper,
        ]);

        return $this->redirectResponse($url->build());
    }

}
