<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ContactUs\Communication;

use Pyz\Zed\ContactUs\Communication\Table\ContactUsTable;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * Class ContactUsCommunicationFactory
 *
 * @package Pyz\Zed\ContactUs\Communication
 *
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsQueryContainerInterface getQueryContainer()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsRepositoryInterface getRepository()
 * @method \Pyz\Zed\ContactUs\Persistence\ContactUsEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\ContactUs\ContactUsConfig getConfig()
 * @method \Pyz\Zed\ContactUs\Business\ContactUsFacadeInterface getFacade()
 */
class ContactUsCommunicationFactory extends AbstractCommunicationFactory
{
    public function createContactUsTable()
    {
        return new ContactUsTable($this->getQueryContainer());
    }
}
