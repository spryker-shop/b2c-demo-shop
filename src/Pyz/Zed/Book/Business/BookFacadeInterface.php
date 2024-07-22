<?php
namespace Pyz\Zed\Book\Business;

use Generated\Shared\Transfer\PyzBookEntityTransfer;

interface BookFacadeInterface
{
    /**
     * Specification:
     * - Creates a new book entity.
     * - Persists the book entity to the database.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $pyzBookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer
     */
    public function createBook(PyzBookEntityTransfer $pyzBookEntityTransfer): PyzBookEntityTransfer;

    /**
     * Specification:
     * - Updates an existing book entity.
     * - Persists the updated book entity to the database.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\PyzBookEntityTransfer $pyzBookEntityTransfer
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer
     */
    public function updateBook(PyzBookEntityTransfer $pyzBookEntityTransfer): PyzBookEntityTransfer;

    /**
     * Specification:
     * - Deletes a book entity by ID.
     *
     * @api
     *
     * @param int $idBook
     *
     * @return void
     */
    public function deleteBook(int $idBook): void;

    /**
     * Specification:
     * - Finds a book entity by ID.
     * - Returns null if the book entity does not exist.
     *
     * @api
     *
     * @param int $idBook
     *
     * @return \Generated\Shared\Transfer\PyzBookEntityTransfer|null
     */
    public function findBookById(int $idBook);

    /**
     * Specification:
     * - Retrieves a list of book entities based on criteria.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\BookCriteriaTransfer $criteriaTransfer
     *
     * @return array<\Generated\Shared\Transfer\PyzBookEntityTransfer>
     */
//    public function findBooksByCriteria(BookCriteriaTransfer $criteriaTransfer): array;

    /**
     * Specification:
     * - Retrieves a list of all book entities.
     *
     * @api
     *
     * @return array<\Generated\Shared\Transfer\PyzBookEntityTransfer>
     */
    public function findAllBooks(): array;
}
