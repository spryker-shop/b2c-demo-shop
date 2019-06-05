<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Content\Business\Model;

use Orm\Zed\Content\Persistence\SpyContentQuery;

trait ReplacerContentKeyToContentIdTrait
{
    protected function replaceContentItemId(string $value)
    {
        preg_match_all("~{{ content_.+?\('(.+?)', '(.+?)'\) }}~", $value, $matches);

        foreach ($matches[0] as $key => $contentWidgetFunction) {

            $contentEntity = SpyContentQuery::create()->findOneByKey($matches[1][$key]);
            if ($contentEntity === null) {
                continue;
            }
            $newContentWidgetFunction = str_replace("'" . $matches[1][$key] . "'", $contentEntity->getIdContent(), $contentWidgetFunction);

            $value = str_replace($contentWidgetFunction, $newContentWidgetFunction, $value);
        }

        return $value;
    }
}
