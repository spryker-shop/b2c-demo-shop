<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Service\Nlp;

use Generated\Shared\Transfer\NlpResponseTransfer;
use Spryker\Service\Kernel\AbstractService;

/**
 * @method \Spryker\Service\Nlp\NlpServiceFactory getFactory()
 */
class NlpService extends AbstractService implements NlpServiceInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $text
     * @param string|null $generatorPlugin
     *
     * @return \Generated\Shared\Transfer\NlpResponseTransfer
     */
    public function generateNlp(string $text): NlpResponseTransfer
    {
        return $this->getFactory()
            ->createNlpGenerator()
            ->generateNlp($text);
    }
}
