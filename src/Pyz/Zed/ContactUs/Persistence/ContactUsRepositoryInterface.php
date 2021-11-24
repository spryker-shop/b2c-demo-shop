<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ContactUs\Persistence;

use Orm\Zed\ContactUs\Persistence\PyzContactUs;

interface ContactUsRepositoryInterface
{
    /**
     * @return \Orm\Zed\ContactUs\Persistence\PyzContactUs[]
     */
    public function getContactUsMessages(): array;

    /**
     * @param int $contactUsId
     *
     * @return \Orm\Zed\ContactUs\Persistence\PyzContactUs|null
     */
    public function findContactUsById(int $contactUsId): ?PyzContactUs;
}
