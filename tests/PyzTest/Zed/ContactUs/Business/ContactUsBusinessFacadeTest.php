<?php

namespace PyzTest\Zed\ContactUs\Business;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\ContactUsBuilder;
use Generated\Shared\Transfer\ContactUsTransfer;
use Orm\Zed\ContactUs\Persistence\PyzContactUs;
use Pyz\Zed\ContactUs\Business\ContactUsFacadeInterface;
use PyzTest\Zed\ContactUs\ContactUsBusinessTester;

/**
 * Class ContactUsBusinessFacadeTest
 * @package PyzTest\Zed\ContactUs\Business
 */
class ContactUsBusinessFacadeTest extends Unit
{
    /**
     * @var ContactUsBusinessTester
     */
    protected $tester;

    /**
     * @var ContactUsFacadeInterface
     */
    protected $facade;

    protected function setUp(): void
    {
        parent::setUp();

        $this->facade = $this->tester->getFacade();
    }

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

    public function testGetContactUsByIdReturnsNull()
    {
        $randomId = rand(time(), time()*10);

        $contactUsTransfer = $this->facade->findContactUsById($randomId);

        $this->tester->assertNull($contactUsTransfer);
    }

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
