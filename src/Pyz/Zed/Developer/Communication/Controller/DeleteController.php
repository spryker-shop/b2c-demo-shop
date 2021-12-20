<?php

namespace Pyz\Zed\Developer\Communication\Controller;

use Generated\Shared\Transfer\DeveloperTransfer;
use Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class DeleteController extends AbstractController
{
    public const PARAM_ID_DEVELOPER = 'id-cook';
    protected const ERROR_MESSAGE_DEVELOPER_NOT_EXIST = 'Developer with id \'%s\' is not exist ';
    protected const ERROR_MESSAGE_DEVELOPER_ID_NOT_PROVIDED = 'Developer id wasn\'t provided';
    protected const SUCCESSFUL_MESSAGE_DEVELOPER_DELETED = 'Developer was successfully deleted';
    protected const ERROR_MESSAGE_FORMAT_NOT_SUBMITTED = 'Form to remove cook is not submitted';
    protected const DEVELOPERS_LIST_PAGE_URL = '/cook-gui/index';
    protected const CONFIRM_DELETE_FORM_PAGE_LINK = '/cook-gui/delete';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction(Request $request)
    {

        $idDeveloper = $request->query->getInt(static::PARAM_ID_DEVELOPER);

        if (!$idDeveloper) {
            $this->addErrorMessage(static::ERROR_MESSAGE_DEVELOPER_ID_NOT_PROVIDED);

            return $this->redirectResponse(static::DEVELOPERS_LIST_PAGE_URL);
        }

        $searchDeveloperTransfer = (new DeveloperTransfer())
            ->setIdDeveloper($idDeveloper);

        $developerTransfer = $this->getFactory()->getDeveloperFacade()->findDeveloper($searchDeveloperTransfer);

        if (!$developerTransfer) {
            $this->addErrorMessage(static::ERROR_MESSAGE_DEVELOPER_NOT_EXIST, ['%s' => $idDeveloper]);

            return $this->redirectResponse(static::DEVELOPERS_LIST_PAGE_URL);
        }

        $form = $this->getFactory()->getDeveloperDeleteForm();
        $form->setData($developerTransfer);

        return $this->viewResponse([
            'form' => $form->createView(),
        ]);
    }


    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function confirmAction(Request $request)
    {

        $form = $this
            ->getFactory()
            ->getDeveloperDeleteForm()
            ->handleRequest($request);

        if (!$form->isSubmitted()) {
            $this->addErrorMessage(static::ERROR_MESSAGE_FORMAT_NOT_SUBMITTED);

            return $this->redirectResponse(static::CONFIRM_DELETE_FORM_PAGE_LINK);
        }

        if (!$form->isValid()) {

            foreach ($form->getErrors(true) as $formError) {
                /** @var FormError $formError */
                $this->addErrorMessage($formError->getMessage(), $formError->getMessageParameters());
            }

            return $this->redirectResponse(static::CONFIRM_DELETE_FORM_PAGE_LINK);
        }

        $developerTransfer = (new DeveloperTransfer());
        $developerTransfer->fromArray($form->getData(), true);

        try {
            $this->getFactory()->getDeveloperFacade()->deleteDeveloper($developerTransfer);
        } catch (RequiredTransferPropertyException $requiredTransferPropertyException) {

            $this->addErrorMessage(static::ERROR_MESSAGE_DEVELOPER_ID_NOT_PROVIDED);
            return $this->redirectResponse(static::CONFIRM_DELETE_FORM_PAGE_LINK);
        }

        $this->addSuccessMessage(static::SUCCESSFUL_MESSAGE_DEVELOPER_DELETED);

        return $this->redirectResponse(static::DEVELOPERS_LIST_PAGE_URL);

    }

}
