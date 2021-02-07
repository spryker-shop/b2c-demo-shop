<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Business\Model;

use Generated\Shared\Transfer\PyzContactUsEntityTransfer;
use Pyz\Zed\HelloSpryker\Persistence\HelloSprykerQueryContainerInterface;

/**
 * Class StringReader
 *
 * @package Pyz\Zed\UserHelloWorld\Business\Model
 */
class ContactUsReader implements ContactUsReaderInterface
{
    /**
     * @var \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerQueryContainerInterface
     */
    private $queryContainer;

    /**
     * @param \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerQueryContainerInterface $queryContainer
     */
    public function __construct(HelloSprykerQueryContainerInterface $queryContainer)
    {
        $this->queryContainer = $queryContainer;
    }

    /**
     * @return \Generated\Shared\Transfer\PyzContactUsEntityTransfer
     */
    public function getContactUsData(): PyzContactUsEntityTransfer
    {
        $contactUsEntity = $this->queryContainer
            ->queryContactUs()
            ->find();

        $contactUsTransfer = new PyzContactUsEntityTransfer();
        $contactUsTransfer->fromArray($contactUsEntity->toArray(), true);

        return $contactUsTransfer;
    }
}
