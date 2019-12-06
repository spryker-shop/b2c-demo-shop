<?php
/**
 * Created by PhpStorm.
 * User: kravchenko
 * Date: 2019-12-06
 * Time: 12:04
 */

namespace Pyz\Zed\DataImport\Business\Model\ProductStock\Writer\Sql;


class ProductStockSql implements ProductStockSqlInterface
{
    /**
     * @return string
     */
    public function createStockSQL(): string
    {
        $sql = "WITH records AS (
    SELECT
      input.name as inputName,
      id_stock as idStock,
      spy_stock.name as spyStockName
    FROM (
           SELECT
             unnest(? :: VARCHAR []) AS name
         ) input
    LEFT JOIN spy_stock ON spy_stock.name = input.name
),
    updated AS (
    UPDATE spy_stock
    SET
      name = records.inputName
    FROM records
    WHERE idStock is not null and spyStockName is null
    RETURNING idStock
  ),
    inserted AS(
    INSERT INTO spy_stock (
      id_stock,
      name
    ) (
      SELECT
        nextval('spy_stock_pk_seq'),
        inputName
      FROM records
      WHERE idStock is null AND inputName <> ''
    ) RETURNING id_stock
  )
SELECT updated.idStock FROM updated UNION ALL SELECT inserted.id_stock FROM inserted;";
        return $sql;
    }

    /**
     * @return string
     */
    public function createStockProductSQL(): string
    {
        $sql = "WITH records AS (
    SELECT
      input.sku,
      input.stockName,
      input.quantity,
      input.is_never_out_of_stock,
      id_stock_product as idStockProduct,
      id_stock as fkStock,
      id_product
    FROM (
           SELECT
             unnest(? :: VARCHAR []) AS sku,
             unnest(? :: VARCHAR []) AS stockName,
             unnest(? :: INTEGER []) AS quantity,
             unnest(? :: BOOLEAN []) AS is_never_out_of_stock
         ) input
      INNER JOIN spy_stock on spy_stock.name = stockName
      INNER JOIN spy_product on spy_product.sku = input.sku
      LEFT JOIN spy_stock_product ON spy_stock_product.fk_product = id_product
       AND spy_stock_product.fk_stock = spy_stock.id_stock
),
    updated AS (
    UPDATE spy_stock_product
    SET
      fk_product = records.id_product,
      fk_stock = records.fkStock,
      quantity = records.quantity,
      is_never_out_of_stock = records.is_never_out_of_stock
    FROM records
    WHERE spy_stock_product.fk_product = records.id_product AND fk_stock = records.fkStock
    RETURNING idStockProduct
  ),
    inserted AS(
    INSERT INTO spy_stock_product (
      id_stock_product,
      fk_product,
      fk_stock,
      quantity,
      is_never_out_of_stock
    ) (
      SELECT
        nextval('spy_stock_product_pk_seq'),
        id_product,
        fkStock,
        quantity,
        is_never_out_of_stock
      FROM records
      WHERE idStockProduct is null
    ) RETURNING id_stock_product
  )
SELECT updated.idStockProduct FROM updated UNION ALL SELECT inserted.id_stock_product FROM inserted;";
        return $sql;
    }

    /**
     * @return string
     */
    public function createAbstractAvailabilitySQL(): string
    {
        $sql = "WITH records AS (
    SELECT
      input.sku,
      input.qty,
      input.store,
      spy_availability_abstract.id_availability_abstract as idAvailabilityAbstract
    FROM (
           SELECT
             unnest(? :: VARCHAR []) AS sku,
             unnest(? :: NUMERIC []) AS qty,
             unnest(? :: INTEGER []) AS store
         ) input
    LEFT JOIN spy_availability_abstract ON spy_availability_abstract.abstract_sku = input.sku AND spy_availability_abstract.fk_store = input.store
 ),
    updated AS (
    UPDATE spy_availability_abstract
    SET
      abstract_sku = records.sku,
      quantity = records.qty
    FROM records
    WHERE spy_availability_abstract.id_availability_abstract = idAvailabilityAbstract
    RETURNING idAvailabilityAbstract
  ),
    inserted AS(
    INSERT INTO spy_availability_abstract (
      id_availability_abstract,
      abstract_sku,
      quantity,
      fk_store
    ) (
      SELECT
        nextval('spy_availability_abstract_pk_seq'),
        records.sku,
        records.qty,
        records.store
      FROM records
      WHERE idAvailabilityAbstract is null
    ) RETURNING id_availability_abstract
  )
SELECT updated.idAvailabilityAbstract FROM updated UNION ALL SELECT inserted.id_availability_abstract FROM inserted;";
        return $sql;
    }

    /**
     * @return string
     */
    public function createAvailabilitySQL(): string
    {
        $sql = "WITH records AS (
    SELECT
      input.sku,
      input.qty,
      input.is_never_out_of_stock,
      input.store,
      id_availability as idAvailability,
      id_availability_abstract as idAvailabilityAbstract
    FROM (
           SELECT
             unnest(? :: VARCHAR []) AS sku,
             unnest(? :: NUMERIC []) AS qty,
             unnest(? :: BOOLEAN []) AS is_never_out_of_stock,
             unnest(? :: INTEGER []) AS store
         ) input
    INNER JOIN spy_product ON spy_product.sku = input.sku
    INNER JOIN spy_product_abstract ON spy_product_abstract.id_product_abstract = spy_product.fk_product_abstract
    INNER JOIN spy_availability_abstract ON spy_availability_abstract.abstract_sku = spy_product_abstract.sku AND spy_availability_abstract.fk_store = input.store
    LEFT JOIN spy_availability ON spy_availability.sku = input.sku AND spy_availability.fk_store = input.store
 ),
    updated AS (
    UPDATE spy_availability
    SET
      sku = records.sku,
      quantity = records.qty,
      is_never_out_of_stock = records.is_never_out_of_stock
    FROM records
    WHERE spy_availability.id_availability = records.idAvailability
    RETURNING idAvailability
  ),
    inserted AS(
    INSERT INTO spy_availability (
      id_availability,
      sku,
      quantity,
      is_never_out_of_stock,
      fk_availability_abstract,
      fk_store
    ) (
      SELECT
        nextval('spy_availability_pk_seq'),
        records.sku,
        records.qty,
        records.is_never_out_of_stock,
        records.idAvailabilityAbstract,
        records.store
      FROM records
      WHERE records.idAvailability is null
    ) RETURNING id_availability
  )
SELECT updated.idAvailability FROM updated UNION ALL SELECT inserted.id_availability FROM inserted;";
        return $sql;
    }
}
