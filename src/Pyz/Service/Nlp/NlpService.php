<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Service\Nlp;

use Spryker\Service\Kernel\AbstractService;

/**
 * @method \Pyz\Service\Nlp\NlpServiceFactory getFactory()
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
     */
    public function generateNlp(string $text): array
    {
        return $this->getFactory()
            ->createNlpGenerator()
            ->generateNlp($text);
    }
}
