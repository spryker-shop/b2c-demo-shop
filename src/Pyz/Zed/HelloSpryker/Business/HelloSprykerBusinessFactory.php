<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Business;

use Pyz\Zed\HelloSpryker\Business\Model\ContactUsReader;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\HelloSpryker\HelloSprykerConfig getConfig()
 * @method \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerRepositoryInterface getRepository()
 * @method \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerQueryContainerInterface getQueryContainer()
 */
class HelloSprykerBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\HelloSpryker\Business\Model\ContactUsReader
     */
    public function createContactUsReader(): ContactUsReader
    {
        return new ContactUsReader($this->getRepository());
    }
}
