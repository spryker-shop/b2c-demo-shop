<?php

namespace Generated\Shared\Transfer;

use DateTime;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class BookTransfer extends AbstractTransfer
{
     /**
     * @var int|null
     */
    protected $idBook;

    /**
     * @var string|null
     * @Assert\NotBlank(message="Name should not be blank.")
     * @Assert\Length(
     *     max = 10,
     *     maxMessage = "Name cannot be longer than {{ limit }} characters"
     * )
     */
    protected $name;

    /**
     * @var string|null
     * @Assert\NotBlank(message="Description should not be blank.")
     */
    protected $description;

    /**
     * @var DateTimeTransfer|null
     * @Assert\NotNull(message="Publication Date should not be null.")
     * @Assert\Type(type="Generated\Shared\Transfer\DateTimeTransfer", message="Publication Date must be a valid DateTimeTransfer object.")
     */
    protected $publicationDate;

    // Getters and Setters

    public function getIdBook(): ?int
    {
        return $this->idBook;
    }

    public function setIdBook(int $idBook): self
    {
        $this->idBook = $idBook;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPublicationDate(): ?DateTimeTransfer
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(DateTimeTransfer $publicationDate): self
    {
        $this->publicationDate = $publicationDate;
        return $this;
    }
}
