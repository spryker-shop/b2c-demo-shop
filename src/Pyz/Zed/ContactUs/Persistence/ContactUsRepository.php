<?php


namespace Pyz\Zed\ContactUs\Persistence;


use Generated\Shared\Transfer\ContactUsTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * Class ContactUsRepository
 *
 * @method ContactUsPersistenceFactory getFactory()
 */
class ContactUsRepository extends AbstractRepository implements ContactUsRepositoryInterface
{
    /**
     * @param int $idContact
     *
     * @return ContactUsTransfer|null
     */
    public function findContactById(int $idContact): ?ContactUsTransfer
    {
        $contactEntity = $this->getFactory()
            ->createPyzContactUsQuery()
            ->findOneByIdContactUs($idContact);
        if($contactEntity === null){
            return null;
        }
        $contactUsTransfer = new ContactUsTransfer();

        return $contactUsTransfer->fromArray($contactEntity->toArray());
    }
}
