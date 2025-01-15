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

    public function testConversionOfRomanNumberToIntegerSpaces(): void
    {
        // Arrange
        $romanNumber = ' M C III  ';
        $expectedInteger = 1103;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }

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

    public function testConversionOfRomanNumberToIntegerThree(): void
    {
        // Arrange
        $romanNumber = 'III';
        $expectedInteger = 3;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }

    public function testConversionOfRomanNumberToIntegerFive(): void
    {
        // Arrange
        $romanNumber = 'V';
        $expectedInteger = 5;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }

    public function testConversionOfRomanNumberToIntegerSix(): void
    {
        // Arrange
        $romanNumber = 'VI';
        $expectedInteger = 6;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }

    public function testConversionOfRomanNumberToIntegerFour(): void
    {
        // Arrange
        $romanNumber = 'IV';
        $expectedInteger = 4;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }

    public function testConversionOfRomanNumberToIntegerTen(): void
    {
        // Arrange
        $romanNumber = 'X';
        $expectedInteger = 10;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }
    public function testConversionOfRomanNumberToIntegerNine(): void
{
    // Arrange
    $romanNumber = 'IX';
    $expectedInteger = 9;

    // Act
    $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

    // Assert
    $this->assertSame($expectedInteger, $result);
}
    public function testConversionOfRomanNumberToIntegerFifty(): void
    {
        // Arrange
        $romanNumber = 'L';
        $expectedInteger = 50;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }
    public function testConversionOfRomanNumberToIntegerFourthy(): void
    {
        // Arrange
        $romanNumber = 'XL';
        $expectedInteger = 40;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }
    public function testConversionOfRomanNumberToIntegerHundred(): void
    {
        // Arrange
        $romanNumber = 'C';
        $expectedInteger = 100;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }
    public function testConversionOfRomanNumberToIntegerNinty(): void
    {
        // Arrange
        $romanNumber = 'XC';
        $expectedInteger = 90;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }
    public function testConversionOfRomanNumberToIntegerFivehundred(): void
    {
        // Arrange
        $romanNumber = 'D';
        $expectedInteger = 500;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }
    public function testConversionOfRomanNumberToIntegerFourhundredNinty(): void
    {
        // Arrange
        $romanNumber = 'XD';
        $expectedInteger = 490;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }
    public function testConversionOfRomanNumberToIntegerTausend(): void
    {
        // Arrange
        $romanNumber = 'M';
        $expectedInteger = 1000;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }
    public function testConversionOfRomanNumberToIntegerNinehundredNinty(): void
    {
        // Arrange
        $romanNumber = 'CMXC';
        $expectedInteger = 990;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }
    public function testConversionOfRomanNumberToIntegerThreetausendNintynine(): void
    {
        // Arrange
        $romanNumber = 'MMMCMXCIX';
        $expectedInteger = 3999;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }
    public function testConversionOfRomanNumberToIntegerTwotausendfourhundredfourthy(): void
    {
        // Arrange
        $romanNumber = 'MMCDXL';
        $expectedInteger = 2440;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }
    public function testConversionOfRomanNumberToIntegerFourhundred(): void
    {
        // Arrange
        $romanNumber = 'CD';
        $expectedInteger = 400;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }
    public function testConversionOfRomanNumberToIntegerNinehundred(): void
    {
        // Arrange
        $romanNumber = 'CM';
        $expectedInteger = 900;

        // Act
        $result = $this->tester->getFacade()->convertRomanToInteger($romanNumber);

        // Assert
        $this->assertSame($expectedInteger, $result);
    }
}
