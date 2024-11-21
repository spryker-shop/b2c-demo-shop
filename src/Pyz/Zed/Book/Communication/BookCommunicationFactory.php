<?php

namespace Pyz\Zed\Book\Communication;

use Pyz\Zed\Book\Communication\Form\BookForm;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Symfony\Component\Form\FormFactoryInterface;



class BookCommunicationFactory extends AbstractCommunicationFactory
{
    public function createBookForm($data = null, array $options = []){
        return $this->getFormFactory()->create(BookForm::class, $data, $options);
    }

    public function getFormFactory(){
        return $this->getProvidedDependency(BookDependencyProvider::FORM_FACTORY);
    }


    
}
