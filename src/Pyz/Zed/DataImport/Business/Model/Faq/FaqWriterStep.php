<?php

namespace Pyz\Zed\DataImport\Business\Model\Faq;

use Orm\Zed\Planet\Persistence\PyzFaqQuery;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\PublishAwareStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class FaqWriterStep extends PublishAwareStep implements DataImportStepInterface {

    public const KEY_QUESTION = 'question';
    public const KEY_ANSWER   = 'answer';
    public const KEY_ENABLED  = 'enabled';

    public function execute(DataSetInterface $dataSet) {
        $faq = PyzFaqQuery::create()
            ->filterByQuestion($dataSet[static::KEY_QUESTION])
            ->findOneOrCreate();

        $faq->setAnswer($dataSet[static::KEY_ANSWER]);
        $faq->setEnabled($dataSet[static::KEY_ENABLED]);

        if ($faq->isNew() || $faq->isModified()) {
            $faq->save();
        }

    }
}
