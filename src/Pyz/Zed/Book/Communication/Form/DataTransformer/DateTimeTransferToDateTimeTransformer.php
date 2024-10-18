<?php
namespace Pyz\Zed\Book\Communication\Form\DataTransformer;

use Generated\Shared\Transfer\DateTimeTransfer;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class DateTimeTransferToDateTimeTransformer implements DataTransformerInterface
{
    /**
     * Transforms a DateTimeTransfer object to a \DateTime object.
     *
     * @param DateTimeTransfer|null $dateTimeTransfer
     * @return \DateTime|null
     */
    public function transform($dateTimeTransfer)
    {
        if (null === $dateTimeTransfer) {
            return null;
        }

        try {
            return new \DateTime($dateTimeTransfer->getDate());
        } catch (\Exception $e) {
            throw new TransformationFailedException('Unable to transform DateTimeTransfer to DateTime.');
        }
    }

    /**
     * Transforms a \DateTime object to a DateTimeTransfer object.
     *
     * @param \DateTime|null $dateTime
     * @return DateTimeTransfer|null
     */
    public function reverseTransform($dateTime)
    {
        if (null === $dateTime) {
            return null;
        }

        $dateTimeTransfer = new DateTimeTransfer();
        $dateTimeTransfer->fromDateTime($dateTime);

        return $dateTimeTransfer;
    }
}
