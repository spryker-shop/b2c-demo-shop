<?php

namespace Pyz\Yves\CarbonEmissionWidget\Widget;

use Generated\Shared\Transfer\ProductViewTransfer;
use Spryker\Yves\Kernel\Widget\AbstractWidget;

class CarbonEmissionWidget extends AbstractWidget
{

    protected const PARAMETER_PRODUCT = 'product';

     /**
     * @param \Generated\Shared\Transfer\ProductViewTransfer $productViewTransfer
     */
    public function __construct(ProductViewTransfer $productViewTransfer)
    {
       $this->addParameter(static::PARAMETER_PRODUCT ,$productViewTransfer);
        
    }

    /**
     * @return string
     */
    public static function getName(): string
    {
        return 'CarbonEmissionWidget';
    }

    /**
     * @return string
     */
    public static function getTemplate(): string
    {
        return '@CarbonEmissionWidget/views/carbon-emission-widget/carbon-emission-widget.twig';
    }


}