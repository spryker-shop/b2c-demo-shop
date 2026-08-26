<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Pyz\Zed\ExampleChart\Plugin;

use Generated\Shared\Transfer\ChartDataTraceTransfer;
use Generated\Shared\Transfer\ChartDataTransfer;
use Generated\Shared\Transfer\ChartLayoutTransfer;
use Spryker\Shared\Chart\Dependency\Plugin\ChartLayoutablePluginInterface;
use Spryker\Shared\Chart\Dependency\Plugin\ChartPluginInterface;

class ExampleChartPlugin implements ChartPluginInterface, ChartLayoutablePluginInterface
{
    /**
     * @var string
     */
    public const TEST_CHART = 'testChart';

    public function getName(): string
    {
        return static::TEST_CHART;
    }

    /**
     * @param string|null $dataIdentifier
     */
    public function getChartData($dataIdentifier = null): ChartDataTransfer // phpcs:ignore
    {
        $data = new ChartDataTransfer();
        $data->setTitle('test');
        $data->setKey('test');
        $data->addTrace($this->getTrace());

        return $data;
    }

    public function getChartLayout(): ChartLayoutTransfer
    {
        return new ChartLayoutTransfer();
    }

    protected function getTrace(): ChartDataTraceTransfer
    {
        $trace = new ChartDataTraceTransfer();
        $trace->setValues([11, 23, 31]);
        $trace->setLabels(['one', 'two', 'three']);
        $trace->setType('pie');

        return $trace;
    }
}
