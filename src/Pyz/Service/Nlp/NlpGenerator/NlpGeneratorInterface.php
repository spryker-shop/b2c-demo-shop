<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Service\Nlp\NlpGenerator;

use Generated\Shared\Transfer\NlpResponseTransfer;

interface NlpGeneratorInterface
{
    /**
     * @param string $text
     * @param string|null $generatorPlugin
     */
    public function generateNlp(string $text);
}
