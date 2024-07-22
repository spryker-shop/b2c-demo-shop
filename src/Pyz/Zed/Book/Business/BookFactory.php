<?php

namespace Pyz\Zed\Book\Business;

use Pyz\Yves\Newsletter\Form\BookForm;
use Spryker\Zed\Kernel\Business\AbstractFactory;
use Spryker\Shared\Application\ApplicationConstants;

class BookFactory extends AbstractFactory
{
    public function createBookForm(){
        return $this->getFormFactory()->create(BookForm::class);
    }

    public function getFormFactory(){
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }
}