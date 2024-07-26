<?php

namespace Pyz\Zed\Book\Communication\Form\DataTransformer;

use Generated\Shared\Transfer\PyzBookEntityTransfer;
use Symfony\Component\Form\DataTransformerInterface;

class BookDataTransformer implements DataTransformerInterface
{
    /**
     * @var \Pyz\Zed\Book\Persistence\BookQueryContainerInterface
     */
    private $queryContainer;

    public function __construct($queryContainer)
    {
        $this->queryContainer = $queryContainer;
    }

    /**
     * Transforms a PyzBookEntityTransfer object to an array.
     *
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer|null $book
     * @return array
     */
    public function transform($book): array
    {
        if (null === $book) {
            return [];
        }

        return [
            'name' => $book->getName(),
            'description' => $book->getDescription(),
            'publication_date' => $book->getPublicationDate() ? $book->getPublicationDate()->format('Y-m-d H:i:s') : null,
        ];
    }

    /**
     * Transforms an array to a PyzBookEntityTransfer object.
     *
     * @param array $data
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer
     */
    public function reverseTransform($data): ?PyzBookEntityTransfer
    {
        if (empty($data)) {
            return null;
        }

        $bookTransfer = new PyzBookEntityTransfer();
        $bookTransfer->setName($data['name'] ?? null);
        $bookTransfer->setDescription($data['description'] ?? null);
        $bookTransfer->setPublicationDate(isset($data['publication_date']) ? new \DateTime($data['publication_date']) : null);

        return $bookTransfer;
    }
}
