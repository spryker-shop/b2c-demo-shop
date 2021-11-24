<?php


namespace Pyz\Zed\ContactUs\Persistence;


use Orm\Zed\ContactUs\Persistence\PyzContactUsQuery;

interface ContactUsQueryContainerInterface
{
    public function queryContactUs(): PyzContactUsQuery;
}
