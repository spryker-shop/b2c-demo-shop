<?php

namespace Pyz\Glue\FaqsRestApi\Controller;

use Generated\Shared\Transfer\FaqTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Controller\AbstractController;

/**
 * @method \Pyz\Glue\FaqsRestApi\FaqsRestApiFactory getFactory()
 */
class FaqsResourceController extends AbstractController{

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    // TODO move management packing to CRUD objects
    public function getAction(RestRequestInterface $restRequest): RestResponseInterface
    {
        $id = $restRequest->getResource()->getId();

        if($id === null) {
            return $this->getFactory()
                ->createFaqsReader()
                ->getFaqs($restRequest);
        }

        return $this
            ->getFactory()
            ->createFaqsReader()
            ->getFaq($restRequest, $id);

    }

    public function postAction(RestRequestInterface $req): RestResponseInterface {
        $data = (new FaqTransfer())
            ->fromArray(
                $req->getResource()->getAttributes()->toArray()
            );

       return $this->getFactory()->createFaqCreator()->createFaqEntity($req, $data);
    }

    public function patchAction(RestRequestInterface $req): RestResponseInterface {
        $data = (new FaqTransfer())
            ->fromArray(
                $req->getResource()->getAttributes()->toArray()
            )
            ->setIdFaq($req->getResource()->getId());

        return $this->getFactory()->createFaqUpdater()->updateFaqEntity($req, $data);
    }

    public function deleteAction(RestRequestInterface $req): RestResponseInterface {
        $data = (new FaqTransfer())
            ->setIdFaq($req->getResource()->getId());

        return $this->getFactory()->createFaqDeleter()->deleteFaqEntity($req, $data);
    }
}
