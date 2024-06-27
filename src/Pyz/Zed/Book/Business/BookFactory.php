<?php

namespace Pyz\Zed\Book\Business;

use Pyz\Zed\Book\Communication\Form\BookForm;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException;

class BookFactory extends AbstractBusinessFactory
{
    /**
     * @throws ContainerKeyNotFoundException
     */
    public function createBookForm(){
        return $this->getFormFactory()->create(BookForm::class);
    }

    /**
     * @throws ContainerKeyNotFoundException
     */
    public function getFormFactory(){
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }


}
