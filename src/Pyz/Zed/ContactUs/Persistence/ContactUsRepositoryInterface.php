<?php

namespace Pyz\Zed\ContactUs\Persistence;

interface ContactUsRepositoryInterface
{
    /**
     *
     * @return \Orm\Zed\ContactUs\Persistence\PyzContactUs[]
     */
    public function findPyzContactUs(): array;

}
