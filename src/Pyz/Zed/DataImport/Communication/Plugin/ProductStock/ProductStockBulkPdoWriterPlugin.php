<?php
/**
 * Created by PhpStorm.
 * User: kravchenko
 * Date: 2019-12-06
 * Time: 12:53
 */

namespace Pyz\Zed\DataImport\Communication\Plugin\ProductStock;


use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImportExtension\Dependency\Plugin\DataSetWriterPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pyz\Zed\DataImport\Business\DataImportFacadeInterface getFacade()
 * @method \Pyz\Zed\DataImport\DataImportConfig getConfig()
 */
class ProductStockBulkPdoWriterPlugin extends AbstractPlugin implements DataSetWriterPluginInterface
{
    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function write(DataSetInterface $dataSet): void
    {
        $this->getFacade()->writeProductStockPdoDataSet($dataSet);
    }

    /**
     * @return void
     */
    public function flush(): void
    {
        $this->getFacade()->flushProductStockPdoDataImporter();
    }
}
