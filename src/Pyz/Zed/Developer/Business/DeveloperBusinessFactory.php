<?php

namespace Pyz\Zed\Developer\Business;

use Pyz\Zed\Developer\Business\Model\Reader\DeveloperReader;
use Pyz\Zed\Developer\Business\Model\Writer\DeveloperWriter;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

class DeveloperBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return DeveloperReader
     */
    public function createDeveloperReader(): DeveloperReader
    {
        return new DeveloperReader($this->getRepository());
    }


    /**
     * @return DeveloperWriter
     */
    public function createDeveloperWriter(): DeveloperWriter
    {
        return new DeveloperWriter($this->getEntityManager());
    }

}
