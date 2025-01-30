<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace PyzTest\Zed\LeapYear\Business;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group LeapYear
 * @group Business
 * @group Facade
 * @group LeapYearFacadeTest
 * Add your own group annotations below this line
 */
class LeapYearFacadeTest extends Unit
{
    /**
     * @var \PyzTest\Zed\LeapYear\LeapYearBusinessTester
     */
    protected $tester;

    public function testTwothousandIsLeapYear(): void
    {
        // Arrange
        $year = 2000;

        // Act
        $result = $this->tester->getFacade()->checkLeapYear($year);

        // Assert
        $this->assertTrue($result);
    }

    public function testTwothousendTwentyFourIsLeapYear(): void
    {
        // Arrange
        $year = 2024;

        // Act
        $result = $this->tester->getFacade()->checkLeapYear($year);

        // Assert
        $this->assertTrue($result);
    }

    public function testTwothousandTwentyThreeIsLeapYear(): void
    {
        // Arrange
        $year = 2023;

        // Act
        $result = $this->tester->getFacade()->checkLeapYear($year);

        // Assert
        $this->assertFalse($result);
    }

    public function testOnethousandNineHundredIsLeapYear(): void
    {
        // Arrange
        $year = 1900;

        // Act
        $result = $this->tester->getFacade()->checkLeapYear($year);

        // Assert
        $this->assertFalse($result);
    }

    public function testFourHundredIsLeapYear(): void
    {
        // Arrange
        $year = 400;

        // Act
        $result = $this->tester->getFacade()->checkLeapYear($year);

        // Assert
        $this->assertTrue($result);
    }

    public function testEightHundredIsLeapYear(): void
    {
        // Arrange
        $year = 800;

        // Act
        $result = $this->tester->getFacade()->checkLeapYear($year);

        // Assert
        $this->assertTrue($result);
    }

    public function testZeroIsLeapYear(): void
    {
        // Arrange
        $year = 0;

        // Act
        $result = $this->tester->getFacade()->checkLeapYear($year);

        // Assert
        $this->assertFalse($result);
    }

    public function testFourIsLeapYear(): void
    {
        // Arrange
        $year = 4;

        // Act
        $result = $this->tester->getFacade()->checkLeapYear($year);

        // Assert
        $this->assertTrue($result);
    }

    public function testOneHundredIsLeapYear(): void
    {
        // Arrange
        $year = 100;

        // Act
        $result = $this->tester->getFacade()->checkLeapYear($year);

        // Assert
        $this->assertFalse($result);
    }
}
//todo Testcases hinzufügen
