<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\HelloSpryker\Business\Model;

use Pyz\Zed\HelloSpryker\Persistence\HelloSprykerRepositoryInterface;

/**
 * Class StringReader
 *
 * @package Pyz\Zed\UserHelloWorld\Business\Model
 */
class ContactUsReader implements ContactUsReaderInterface
{
    /**
     * @var \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerRepositoryInterface
     */
    protected $repository;

    /**
     * @param \Pyz\Zed\HelloSpryker\Persistence\HelloSprykerRepositoryInterface $repository
     */
    public function __construct(HelloSprykerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return \Generated\Shared\Transfer\ContactUsTransfer[]
     */
    public function getContactUsData(): array
    {
        return $this->repository
            ->getContactUsDataSet();
    }
}
