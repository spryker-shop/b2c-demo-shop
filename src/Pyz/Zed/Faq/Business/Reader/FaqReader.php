<?php

namespace Pyz\Zed\Faq\Business\Reader;

use Generated\Shared\Transfer\FaqCollectionTransfer;
use Generated\Shared\Transfer\FaqTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Pyz\Zed\Faq\Persistence\FaqRepositoryInterface;

class FaqReader implements FaqReaderInterface {

    protected FaqRepositoryInterface $repo;

    public function __construct(FaqRepositoryInterface $repo) {
        $this->repo = $repo;
    }

    public function findFaqEntityById(int $id): ?FaqTransfer {

        return $this->repo->findFaqEntityById($id);
    }

    public function getFaqCollection(FaqCollectionTransfer $trans): FaqCollectionTransfer {

        return $this->repo->getFaqCollection($trans);
    }

    public function getFaqCollectionPaginated(PaginationTransfer $trans): FaqCollectionTransfer {

        return $this->repo->getFaqCollectionPaginated(
            $trans->getLimit(),
            $trans->getPage(),
        );
    }
}
