<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Business\Model;

use Generated\Shared\Transfer\PyzContactUsEntityTransfer;
use Pyz\Zed\HelloSpryker\Persistence\HelloSprykerEntityManagerInterface;

class ContactUsWriter implements ContactUsWriterInterface
{
    /**
     * @var \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerEntityManagerInterface
     */
    protected $helloSprykerEntityManager;

    /**
     * @var \Pyz\Zed\HelloSpryker\Business\Model\ContactUsReaderInterface
     */
    protected $contactUsReader;

    /**
     * @param \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerEntityManagerInterface $helloSprykerEntityManager
     * @param \Pyz\Zed\HelloSpryker\Business\Model\ContactUsReaderInterface $contactUsReader
     */
    public function __construct(
        HelloSprykerEntityManagerInterface $helloSprykerEntityManager,
        ContactUsReaderInterface $contactUsReader
    ) {
        $this->helloSprykerEntityManager = $helloSprykerEntityManager;
        $this->contactUsReader = $contactUsReader;
    }

    /**
     * @param \Generated\Shared\Transfer\PyzContactUsEntityTransfer|null $contactUsTransfer
     */
    public function save(?PyzContactUsEntityTransfer $contactUsTransfer = null)
    {
        if ($contactUsTransfer === null) {
            return;
        }
        $contactUsTransfer->requireMessage()
            ->requireName();

        $this->helloSprykerEntityManager->saveContactUsData($contactUsTransfer);

        return $contactUsTransfer;
    }
}
