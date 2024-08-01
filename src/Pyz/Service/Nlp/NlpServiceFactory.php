<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Service\Nlp;

use Pyz\Service\Nlp\NlpGenerator\NlpGenerator;
use Pyz\Service\Nlp\NlpGenerator\NlpGeneratorInterface;
use Spryker\Service\Kernel\AbstractServiceFactory;

class NlpServiceFactory extends AbstractServiceFactory
{
    /**
     * @return \Pyz\Service\Nlp\NlpGenerator\NlpGeneratorInterface
     */
    public function createNlpGenerator(): NlpGeneratorInterface
    {
        return new NlpGenerator();
    }

    
}
