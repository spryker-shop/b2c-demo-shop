<?php

namespace Pyz\Zed\ContactUs\Communication;

use Pyz\Zed\ContactUs\Communication\Table\ContactUsTable;
use Pyz\Zed\ContactUs\Persistence\ContactUsQueryContainerInterface;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * Class ContactUsCommunicationFactory
 * @package Pyz\Zed\ContactUs\Communication
 *
 * @method ContactUsQueryContainerInterface getQueryContainer()
 */
class ContactUsCommunicationFactory extends AbstractCommunicationFactory
{
    public function createContactUsTable()
    {
        return new ContactUsTable($this->getQueryContainer());
    }
}
