<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\Book\Dependency;

interface BookEvents
{
    /**
     * Specification:
     * - This event will be used for book entity creation.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_PYZ_BOOK_CREATE = 'Entity.pyz_book.create';

    /**
     * Specification:
     * - This event will be used for book entity update.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_PYZ_BOOK_UPDATE = 'Entity.pyz_book.update';

    /**
     * Specification:
     * - This event will be used for book entity deletion.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_PYZ_BOOK_DELETE = 'Entity.pyz_book.delete';
}
