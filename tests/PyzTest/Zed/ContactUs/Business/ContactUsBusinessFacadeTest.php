<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Zed\ContactUs\Business;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\ContactUsBuilder;
use Generated\Shared\Transfer\ContactUsTransfer;
use Orm\Zed\ContactUs\Persistence\PyzContactUs;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group ContactUs
 * @group Business
 * @group Facade
 * @group ContactUsBusinessFacadeTest
 * Add your own group annotations below this line
 */
class ContactUsBusinessFacadeTest extends Unit
{
    /**
     * @var \PyzTest\Zed\ContactUs\ContactUsBusinessTester
     */
    protected $tester;

    /**
     * @var \Pyz\Zed\ContactUs\Business\ContactUsFacadeInterface
     */
    protected $facade;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->facade = $this->tester->getFacade();
    }

    /**
     * @return void
     */
    public function testGetContactUsFeedbacksReturnsList()
    {
        $contactUsFeedbacks = [];
        $contactUsFeedbacksCount = 10;

        for ($i = 0; $i < $contactUsFeedbacksCount; $i++) {
            $contactUsFeedbacks[] = $this->createAndSaveContactUs();
        }

        $contactUsTransfers = $this->facade->getContactUsMessages();

        $this->tester->assertCount($contactUsFeedbacksCount, $contactUsTransfers);
    }

    /**
     * @return void
     */
    public function testGetContactUsByIdReturnsNull()
    {
        $randomId = rand(time(), time() * 10);

        $contactUsTransfer = $this->facade->findContactUsById($randomId);

        $this->tester->assertNull($contactUsTransfer);
    }

    /**
     * @return void
     */
    public function testSaveContactUsOk()
    {
        $contactUsFeedback = $this->buildContactUs();

        $contactUsFeedback = $this->facade->saveContactUs($contactUsFeedback);

        $contactUsTransfer = $this->facade->findContactUsById($contactUsFeedback->getIdContactUs());

        $this->tester->assertEquals($contactUsFeedback->getIdContactUs(), $contactUsTransfer->getIdContactUs());
    }

    protected function createAndSaveContactUs(): PyzContactUs
    {
        $contactUsFeedback = $this->buildContactUs();

        $contactUsEntity = new PyzContactUs();
        $contactUsEntity->fromArray($contactUsFeedback->toArray());
        $contactUsEntity->save();

        return $contactUsEntity;
    }

    protected function buildContactUs(): ContactUsTransfer
    {
        return (new ContactUsBuilder())->build();
    }
}
