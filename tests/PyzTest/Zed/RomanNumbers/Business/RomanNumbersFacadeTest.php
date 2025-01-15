<?php
declare(strict_types = 1);

namespace PyzTest\Zed\RomanNumbers\Business;

use Codeception\Test\Unit;

/**
 * @group PyzTest
 * @group Zed
 * @group StringReverser
 * @group Business
 * @group Facade
 * @group RomanNumbersFacadeTest
 * Add your own group annotations below this line
 */
class RomanNumbersFacadeTest extends Unit
{
    /**
     * @var \PyzTest\Zed\RomanNumbers\RomanNumbersBusinessTester
     */
    protected $tester;

    public function testConversionOfRomanNumberToIntegerOne(): void
    {
        // Arrange
        $romanNumber = 'I';
        $expectedInteger = 1;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }

    public function testConversionOfRomanNumberToIntegerTwo(): void
    {
        // Arrange
        $romanNumber = 'II';
        $expectedInteger = 2;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }
}
