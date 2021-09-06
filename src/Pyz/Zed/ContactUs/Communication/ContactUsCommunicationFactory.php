<?php

namespace Pyz\Zed\ContactUs\Communication;

use Pyz\Zed\ContactUs\Communication\Table\ContactUsTable;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsQueryContainer getQueryContainer()
 * @method \Pyz\Zed\ContactUs\ContactUsConfig getConfig()
 */
class ContactUsCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return ContactUsTable
     */
    public function createContactUsTable()
    {
        return new ContactUsTable(
            $this->getQueryContainer()
        );
    }
}
