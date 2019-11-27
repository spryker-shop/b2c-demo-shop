<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\ZedNavigation\Business\Model\Formatter;

use Spryker\Zed\ZedNavigation\Business\Model\Formatter\MenuFormatter as SprykerMenuFormatter;

class MenuFormatter extends SprykerMenuFormatter
{
    /**
     * @param string|null $label
     * @param string|null $title
     *
     * @return array
     */
    protected function formatTitleAndLabel($label, $title)
    {
        return [
            self::LABEL => $label !== null ? $label : $title,
            self::TITLE => $title !== null ? $title : $label,
        ];
    }
}
