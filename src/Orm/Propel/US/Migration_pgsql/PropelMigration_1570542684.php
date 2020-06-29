<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1570542684.
 * Generated on 2019-10-08 13:51:24 by vagrant
 */
class PropelMigration_1570542684
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'zed' => '
BEGIN;

CREATE SEQUENCE "spy_acl_role_pk_seq";

CREATE TABLE "spy_acl_role"
(
    "id_acl_role" INTEGER NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_acl_role"),
    CONSTRAINT "spy_acl_role-name" UNIQUE ("name")
);

CREATE SEQUENCE "spy_acl_rule_pk_seq";

CREATE TABLE "spy_acl_rule"
(
    "id_acl_rule" INTEGER NOT NULL,
    "fk_acl_role" INTEGER NOT NULL,
    "bundle" VARCHAR(45) NOT NULL,
    "controller" VARCHAR(45) NOT NULL,
    "action" VARCHAR(45) NOT NULL,
    "type" INT2 NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_acl_rule")
);

CREATE SEQUENCE "spy_acl_group_pk_seq";

CREATE TABLE "spy_acl_group"
(
    "id_acl_group" INTEGER NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_acl_group"),
    CONSTRAINT "spy_acl_group-name" UNIQUE ("name")
);

CREATE TABLE "spy_acl_user_has_group"
(
    "fk_user" INTEGER NOT NULL,
    "fk_acl_group" INTEGER NOT NULL,
    PRIMARY KEY ("fk_user","fk_acl_group")
);

CREATE TABLE "spy_acl_groups_has_roles"
(
    "fk_acl_role" INTEGER NOT NULL,
    "fk_acl_group" INTEGER NOT NULL,
    PRIMARY KEY ("fk_acl_role","fk_acl_group")
);

CREATE SEQUENCE "spy_auth_reset_password_pk_seq";

CREATE TABLE "spy_auth_reset_password"
(
    "id_auth_reset_password" INTEGER NOT NULL,
    "fk_user" INTEGER NOT NULL,
    "code" VARCHAR(35) NOT NULL,
    "status" INT2 NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_auth_reset_password","fk_user"),
    CONSTRAINT "spy_auth_reset_password-code" UNIQUE ("code")
);

CREATE SEQUENCE "spy_availability_abstract_pk_seq";

CREATE TABLE "spy_availability_abstract"
(
    "id_availability_abstract" INTEGER NOT NULL,
    "fk_store" INTEGER,
    "abstract_sku" VARCHAR(255) NOT NULL,
    "quantity" INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY ("id_availability_abstract"),
    CONSTRAINT "spy_availability_abstract-sku" UNIQUE ("abstract_sku","fk_store")
);

CREATE INDEX "index-spy_availability_abstract-fk_store" ON "spy_availability_abstract" ("fk_store");

CREATE SEQUENCE "spy_availability_pk_seq";

CREATE TABLE "spy_availability"
(
    "id_availability" INTEGER NOT NULL,
    "fk_availability_abstract" INTEGER NOT NULL,
    "fk_store" INTEGER,
    "is_never_out_of_stock" BOOLEAN DEFAULT \'f\',
    "quantity" INTEGER NOT NULL,
    "sku" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id_availability"),
    CONSTRAINT "spy_availability-sku" UNIQUE ("sku","fk_store")
);

CREATE INDEX "index-spy_availability-fk_availability_abstract" ON "spy_availability" ("fk_availability_abstract");

CREATE INDEX "index-spy_availability-fk_store" ON "spy_availability" ("fk_store");

CREATE SEQUENCE "spy_availability_storage_pk_seq";

CREATE TABLE "spy_availability_storage"
(
    "id_availability_storage" INT8 NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "fk_availability_abstract" INTEGER NOT NULL,
    "data" TEXT,
    "store" VARCHAR(128),
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_availability_storage"),
    CONSTRAINT "spy_availability_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_availability_storage-fk_product_abstract" ON "spy_availability_storage" ("fk_product_abstract");

CREATE INDEX "spy_availability_storage-fk_availability_abstract" ON "spy_availability_storage" ("fk_availability_abstract");

CREATE SEQUENCE "id_availability_notification_subscription_pk_seq";

CREATE TABLE "spy_availability_notification_subscription"
(
    "id_availability_notification_subscription" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "fk_store" INTEGER NOT NULL,
    "customer_reference" VARCHAR(255),
    "email" VARCHAR(255) NOT NULL,
    "sku" VARCHAR(255) NOT NULL,
    "subscription_key" VARCHAR(150) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_availability_notification_subscription"),
    CONSTRAINT "spy_availability_notification_subscription-sku-email-store" UNIQUE ("email","sku","fk_store"),
    CONSTRAINT "spy_availability_notification_subscription-unq-subscription_key" UNIQUE ("subscription_key")
);

CREATE INDEX "spy_availability_notification_subscription-subscription_key" ON "spy_availability_notification_subscription" ("subscription_key");

CREATE INDEX "spy_availability_notification_subscription-sku" ON "spy_availability_notification_subscription" ("email","sku","fk_store");

CREATE INDEX "index-spy_availability_notification_subscription-fk_locale" ON "spy_availability_notification_subscription" ("fk_locale");

CREATE SEQUENCE "spy_category_pk_seq";

CREATE TABLE "spy_category"
(
    "id_category" INTEGER NOT NULL,
    "fk_category_template" INTEGER,
    "category_key" VARCHAR(255) NOT NULL,
    "is_active" BOOLEAN DEFAULT \'t\',
    "is_clickable" BOOLEAN DEFAULT \'t\',
    "is_in_menu" BOOLEAN DEFAULT \'t\',
    "is_searchable" BOOLEAN DEFAULT \'t\',
    PRIMARY KEY ("id_category"),
    CONSTRAINT "spy_category-category_key" UNIQUE ("category_key")
);

CREATE INDEX "index-spy_category-fk_category_template" ON "spy_category" ("fk_category_template");

CREATE SEQUENCE "spy_category_attribute_pk_seq";

CREATE TABLE "spy_category_attribute"
(
    "id_category_attribute" INTEGER NOT NULL,
    "fk_category" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "category_image_name" VARCHAR(255),
    "meta_description" TEXT,
    "meta_keywords" TEXT,
    "meta_title" TEXT,
    "name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_category_attribute")
);

CREATE INDEX "index-spy_category_attribute-fk_locale" ON "spy_category_attribute" ("fk_locale");

CREATE INDEX "index-spy_category_attribute-fk_category" ON "spy_category_attribute" ("fk_category");

CREATE SEQUENCE "spy_category_node_pk_seq";

CREATE TABLE "spy_category_node"
(
    "id_category_node" INTEGER NOT NULL,
    "fk_category" INTEGER NOT NULL,
    "fk_parent_category_node" INTEGER,
    "is_main" BOOLEAN DEFAULT \'f\',
    "is_root" BOOLEAN DEFAULT \'f\',
    "node_order" INTEGER DEFAULT 0,
    PRIMARY KEY ("id_category_node")
);

CREATE INDEX "spy_category_node_i_8f153e" ON "spy_category_node" ("node_order");

CREATE INDEX "index-spy_category_node-fk_parent_category_node" ON "spy_category_node" ("fk_parent_category_node");

CREATE INDEX "index-spy_category_node-fk_category" ON "spy_category_node" ("fk_category");

CREATE SEQUENCE "spy_category_closure_table_pk_seq";

CREATE TABLE "spy_category_closure_table"
(
    "id_category_closure_table" INTEGER NOT NULL,
    "fk_category_node" INTEGER NOT NULL,
    "fk_category_node_descendant" INTEGER NOT NULL,
    "depth" INTEGER NOT NULL,
    PRIMARY KEY ("id_category_closure_table")
);

CREATE INDEX "index-spy_category_closure_table-fk_category_node" ON "spy_category_closure_table" ("fk_category_node");

CREATE INDEX "index-spy_category_closure_table-fk_category_node_descendant" ON "spy_category_closure_table" ("fk_category_node_descendant");

CREATE SEQUENCE "spy_category_image_set_pk_seq";

CREATE TABLE "spy_category_image_set"
(
    "id_category_image_set" INTEGER NOT NULL,
    "fk_category" INTEGER,
    "fk_locale" INTEGER,
    "name" VARCHAR(255),
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_category_image_set")
);

CREATE INDEX "spy_category_image_set-index-fk_category" ON "spy_category_image_set" ("fk_category");

CREATE INDEX "index-spy_category_image_set-fk_locale" ON "spy_category_image_set" ("fk_locale");

CREATE SEQUENCE "spy_category_image_pk_seq";

CREATE TABLE "spy_category_image"
(
    "id_category_image" INTEGER NOT NULL,
    "external_url_large" VARCHAR(2048),
    "external_url_small" VARCHAR(2048),
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_category_image")
);

CREATE SEQUENCE "spy_category_image_set_to_category_image_pk_seq";

CREATE TABLE "spy_category_image_set_to_category_image"
(
    "id_category_image_set_to_category_image" INTEGER NOT NULL,
    "fk_category_image" INTEGER NOT NULL,
    "fk_category_image_set" INTEGER NOT NULL,
    "sort_order" INTEGER NOT NULL,
    PRIMARY KEY ("id_category_image_set_to_category_image"),
    CONSTRAINT "fk_category_image_set-fk_category_image" UNIQUE ("fk_category_image_set","fk_category_image")
);

CREATE INDEX "index-spy_category_image_set_to_category_image-fk_-85872f21dafe" ON "spy_category_image_set_to_category_image" ("fk_category_image_set");

CREATE INDEX "index-spy_category_image_set_to_category_image-fk_-7c0ba662126c" ON "spy_category_image_set_to_category_image" ("fk_category_image");

CREATE SEQUENCE "spy_category_image_storage_pk_seq";

CREATE TABLE "spy_category_image_storage"
(
    "id_category_image_storage" INT8 NOT NULL,
    "fk_category" INTEGER NOT NULL,
    "data" TEXT,
    "key" VARCHAR NOT NULL,
    "locale" VARCHAR NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_category_image_storage")
);

CREATE INDEX "spy_category_image_storage-fk_category" ON "spy_category_image_storage" ("fk_category");

CREATE SEQUENCE "spy_category_node_page_search_pk_seq";

CREATE TABLE "spy_category_node_page_search"
(
    "id_category_node_page_search" INT8 NOT NULL,
    "fk_category_node" INTEGER NOT NULL,
    "structured_data" TEXT NOT NULL,
    "data" TEXT,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_category_node_page_search"),
    CONSTRAINT "spy_category_node_page_search-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_category_node_page_search-fk_category_node" ON "spy_category_node_page_search" ("fk_category_node");

CREATE SEQUENCE "spy_category_tree_storage_pk_seq";

CREATE TABLE "spy_category_tree_storage"
(
    "id_category_tree_storage" INT8 NOT NULL,
    "data" TEXT,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_category_tree_storage"),
    CONSTRAINT "spy_category_tree_storage-unique-key" UNIQUE ("key")
);

CREATE SEQUENCE "spy_category_node_storage_pk_seq";

CREATE TABLE "spy_category_node_storage"
(
    "id_category_node_storage" INT8 NOT NULL,
    "fk_category_node" INTEGER NOT NULL,
    "data" TEXT,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_category_node_storage"),
    CONSTRAINT "spy_category_node_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_category_node_storage-fk_category_node" ON "spy_category_node_storage" ("fk_category_node");

CREATE SEQUENCE "spy_category_template_pk_seq";

CREATE TABLE "spy_category_template"
(
    "id_category_template" INTEGER NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "template_path" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id_category_template"),
    CONSTRAINT "spy_category_template-template_path" UNIQUE ("template_path")
);

CREATE SEQUENCE "spy_cms_template_pk_seq";

CREATE TABLE "spy_cms_template"
(
    "id_cms_template" INTEGER NOT NULL,
    "template_name" VARCHAR(255) NOT NULL,
    "template_path" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id_cms_template"),
    CONSTRAINT "spy_cms_template-unique-template_path" UNIQUE ("template_path")
);

CREATE INDEX "spy_cms_template-template_path" ON "spy_cms_template" ("template_path");

CREATE SEQUENCE "spy_cms_page_pk_seq";

CREATE TABLE "spy_cms_page"
(
    "id_cms_page" INTEGER NOT NULL,
    "fk_template" INTEGER NOT NULL,
    "is_active" BOOLEAN DEFAULT \'f\' NOT NULL,
    "is_searchable" BOOLEAN DEFAULT \'f\' NOT NULL,
    "page_key" VARCHAR(32),
    "valid_from" TIMESTAMP,
    "valid_to" TIMESTAMP,
    PRIMARY KEY ("id_cms_page")
);

CREATE INDEX "spy_cms_page_i_615cb5" ON "spy_cms_page" ("page_key");

CREATE INDEX "index-spy_cms_page-fk_template" ON "spy_cms_page" ("fk_template");

CREATE SEQUENCE "spy_cms_page_localized_attributes_pk_seq";

CREATE TABLE "spy_cms_page_localized_attributes"
(
    "id_cms_page_localized_attributes" INTEGER NOT NULL,
    "fk_cms_page" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "meta_description" TEXT,
    "meta_keywords" TEXT,
    "meta_title" VARCHAR(255),
    "name" VARCHAR NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_cms_page_localized_attributes"),
    CONSTRAINT "spy_cms_page_localized_attributes-unique-fk_cms_page" UNIQUE ("fk_cms_page","fk_locale")
);

CREATE INDEX "index-spy_cms_page_localized_attributes-fk_cms_page" ON "spy_cms_page_localized_attributes" ("fk_cms_page");

CREATE INDEX "index-spy_cms_page_localized_attributes-fk_locale" ON "spy_cms_page_localized_attributes" ("fk_locale");

CREATE SEQUENCE "spy_cms_glossary_key_mapping_pk_seq";

CREATE TABLE "spy_cms_glossary_key_mapping"
(
    "id_cms_glossary_key_mapping" INTEGER NOT NULL,
    "fk_glossary_key" INTEGER NOT NULL,
    "fk_page" INTEGER NOT NULL,
    "placeholder" VARCHAR NOT NULL,
    PRIMARY KEY ("id_cms_glossary_key_mapping"),
    CONSTRAINT "spy_cms_glossary_key_mapping-unique-fk_page" UNIQUE ("fk_page","placeholder")
);

CREATE INDEX "spy_cms_glossary_key_mapping-fk_page" ON "spy_cms_glossary_key_mapping" ("fk_page","placeholder");

CREATE INDEX "index-spy_cms_glossary_key_mapping-fk_glossary_key" ON "spy_cms_glossary_key_mapping" ("fk_glossary_key");

CREATE SEQUENCE "spy_cms_version_pk_seq";

CREATE TABLE "spy_cms_version"
(
    "id_cms_version" INTEGER NOT NULL,
    "fk_cms_page" INTEGER NOT NULL,
    "fk_user" INTEGER,
    "data" TEXT,
    "version" INTEGER NOT NULL,
    "version_name" VARCHAR(255),
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_cms_version")
);

CREATE INDEX "spy_cms_version-index-fk_cms_page_version" ON "spy_cms_version" ("fk_cms_page","version");

CREATE INDEX "index-spy_cms_version-fk_user" ON "spy_cms_version" ("fk_user");

CREATE SEQUENCE "id_cms_page_store_pk_seq";

CREATE TABLE "spy_cms_page_store"
(
    "id_cms_page_store" INTEGER NOT NULL,
    "fk_cms_page" INTEGER NOT NULL,
    "fk_store" INTEGER NOT NULL,
    PRIMARY KEY ("id_cms_page_store"),
    CONSTRAINT "spy_cms_page_store-fk_cms_page-fk_store" UNIQUE ("fk_cms_page","fk_store")
);

CREATE INDEX "index-spy_cms_page_store-fk_cms_page" ON "spy_cms_page_store" ("fk_cms_page");

CREATE INDEX "index-spy_cms_page_store-fk_store" ON "spy_cms_page_store" ("fk_store");

CREATE SEQUENCE "spy_cms_block_template_pk_seq";

CREATE TABLE "spy_cms_block_template"
(
    "id_cms_block_template" INTEGER NOT NULL,
    "template_name" VARCHAR(255) NOT NULL,
    "template_path" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id_cms_block_template"),
    CONSTRAINT "spy_cms_block_template-unique-template_path" UNIQUE ("template_path")
);

CREATE SEQUENCE "spy_cms_block_glossary_key_mapping_pk_seq";

CREATE TABLE "spy_cms_block_glossary_key_mapping"
(
    "id_cms_block_glossary_key_mapping" INTEGER NOT NULL,
    "fk_cms_block" INTEGER NOT NULL,
    "fk_glossary_key" INTEGER NOT NULL,
    "placeholder" VARCHAR NOT NULL,
    PRIMARY KEY ("id_cms_block_glossary_key_mapping"),
    CONSTRAINT "spy_cms_block_glossary_key_mapping-unique-fk_cms_block" UNIQUE ("fk_cms_block","placeholder")
);

CREATE INDEX "index-spy_cms_block_glossary_key_mapping-fk_cms_block" ON "spy_cms_block_glossary_key_mapping" ("fk_cms_block");

CREATE INDEX "index-spy_cms_block_glossary_key_mapping-fk_glossary_key" ON "spy_cms_block_glossary_key_mapping" ("fk_glossary_key");

CREATE SEQUENCE "spy_cms_block_pk_seq";

CREATE TABLE "spy_cms_block"
(
    "id_cms_block" INTEGER NOT NULL,
    "fk_page" INTEGER,
    "fk_template" INTEGER,
    "is_active" BOOLEAN DEFAULT \'f\' NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "type" VARCHAR(255),
    "valid_from" TIMESTAMP,
    "valid_to" TIMESTAMP,
    "value" INTEGER,
    PRIMARY KEY ("id_cms_block"),
    CONSTRAINT "spy_cms_block-name-uq" UNIQUE ("name")
);

COMMENT ON COLUMN "spy_cms_block"."fk_page" IS \'Deprecated\';

COMMENT ON COLUMN "spy_cms_block"."type" IS \'Deprecated\';

COMMENT ON COLUMN "spy_cms_block"."value" IS \'Deprecated\';

CREATE INDEX "index-spy_cms_block-fk_template" ON "spy_cms_block" ("fk_template");

CREATE SEQUENCE "id_cms_block_store_pk_seq";

CREATE TABLE "spy_cms_block_store"
(
    "id_cms_block_store" INTEGER NOT NULL,
    "fk_cms_block" INTEGER NOT NULL,
    "fk_store" INTEGER NOT NULL,
    PRIMARY KEY ("id_cms_block_store"),
    CONSTRAINT "spy_cms_block_store-fk_cms_block-fk_store" UNIQUE ("fk_cms_block","fk_store")
);

CREATE INDEX "index-spy_cms_block_store-fk_cms_block" ON "spy_cms_block_store" ("fk_cms_block");

CREATE INDEX "index-spy_cms_block_store-fk_store" ON "spy_cms_block_store" ("fk_store");

CREATE SEQUENCE "spy_cms_block_category_connector_pk_seq";

CREATE TABLE "spy_cms_block_category_connector"
(
    "id_cms_block_category_connector" INTEGER NOT NULL,
    "fk_category" INTEGER NOT NULL,
    "fk_category_template" INTEGER NOT NULL,
    "fk_cms_block" INTEGER NOT NULL,
    "fk_cms_block_category_position" INTEGER,
    PRIMARY KEY ("id_cms_block_category_connector")
);

CREATE INDEX "spy_cms_block_category-connector-fk_cms_block" ON "spy_cms_block_category_connector" ("fk_cms_block");

CREATE INDEX "spy_cms_block_category-connector-fk_category" ON "spy_cms_block_category_connector" ("fk_category");

CREATE INDEX "index-spy_cms_block_category_connector-fk_category_template" ON "spy_cms_block_category_connector" ("fk_category_template");

CREATE INDEX "index-spy_cms_block_category_connector-fk_cms_bloc-c9abf4e4f9b3" ON "spy_cms_block_category_connector" ("fk_cms_block_category_position");

CREATE SEQUENCE "spy_cms_block_category_position_pk_seq";

CREATE TABLE "spy_cms_block_category_position"
(
    "id_cms_block_category_position" INTEGER NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id_cms_block_category_position")
);

CREATE SEQUENCE "spy_cms_block_category_storage_pk_seq";

CREATE TABLE "spy_cms_block_category_storage"
(
    "id_cms_block_category_storage" INT8 NOT NULL,
    "fk_category" INTEGER NOT NULL,
    "data" TEXT,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_cms_block_category_storage"),
    CONSTRAINT "spy_cms_block_category_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_cms_block_category_storage-fk_category" ON "spy_cms_block_category_storage" ("fk_category");

CREATE SEQUENCE "spy_cms_block_product_connector_pk_seq";

CREATE TABLE "spy_cms_block_product_connector"
(
    "id_cms_block_product_connector" INTEGER NOT NULL,
    "fk_cms_block" INTEGER NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    PRIMARY KEY ("id_cms_block_product_connector")
);

CREATE INDEX "spy_cms_block_product_connector-fk_cms_block" ON "spy_cms_block_product_connector" ("fk_cms_block");

CREATE INDEX "spy_cms_block_product_connector-fk_product_abstract" ON "spy_cms_block_product_connector" ("fk_product_abstract");

CREATE SEQUENCE "spy_cms_block_product_storage_pk_seq";

CREATE TABLE "spy_cms_block_product_storage"
(
    "id_cms_block_product_storage" INT8 NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "data" TEXT,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_cms_block_product_storage"),
    CONSTRAINT "spy_cms_block_product_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_cms_block_product_storage-fk_product_abstract" ON "spy_cms_block_product_storage" ("fk_product_abstract");

CREATE SEQUENCE "spy_cms_block_storage_pk_seq";

CREATE TABLE "spy_cms_block_storage"
(
    "id_cms_block_storage" INT8 NOT NULL,
    "fk_cms_block" INTEGER NOT NULL,
    "name" VARCHAR NOT NULL,
    "data" TEXT,
    "store" VARCHAR(128),
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_cms_block_storage"),
    CONSTRAINT "spy_cms_block_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_cms_block_storage-fk_cms_block" ON "spy_cms_block_storage" ("fk_cms_block");

CREATE SEQUENCE "spy_cms_page_search_pk_seq";

CREATE TABLE "spy_cms_page_search"
(
    "id_cms_page_search" INT8 NOT NULL,
    "fk_cms_page" INTEGER NOT NULL,
    "structured_data" TEXT NOT NULL,
    "data" TEXT,
    "store" VARCHAR(128),
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_cms_page_search"),
    CONSTRAINT "spy_cms_page_search-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_cms_page_search-fk_cms_page" ON "spy_cms_page_search" ("fk_cms_page");

CREATE SEQUENCE "spy_cms_page_storage_pk_seq";

CREATE TABLE "spy_cms_page_storage"
(
    "id_cms_page_storage" INT8 NOT NULL,
    "fk_cms_page" INTEGER NOT NULL,
    "data" TEXT,
    "store" VARCHAR(128),
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_cms_page_storage"),
    CONSTRAINT "spy_cms_page_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_cms_page_storage-fk_cms_page" ON "spy_cms_page_storage" ("fk_cms_page");

CREATE SEQUENCE "spy_content_pk_seq";

CREATE TABLE "spy_content"
(
    "id_content" INTEGER NOT NULL,
    "content_term_key" VARCHAR(255) NOT NULL,
    "content_type_key" VARCHAR(255) NOT NULL,
    "description" TEXT,
    "key" VARCHAR(255) NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_content"),
    CONSTRAINT "spy_content-key" UNIQUE ("key")
);

COMMENT ON COLUMN "spy_content"."key" IS \'Identifier for existing entities. It should never be changed.\';

CREATE SEQUENCE "spy_content_localized_pk_seq";

CREATE TABLE "spy_content_localized"
(
    "id_content_localized" INTEGER NOT NULL,
    "fk_content" INTEGER NOT NULL,
    "fk_locale" INTEGER,
    "parameters" TEXT NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_content_localized"),
    CONSTRAINT "fk_content_unique_fk_locale_unique" UNIQUE ("fk_content","fk_locale")
);

CREATE INDEX "index-spy_content_localized-fk_content" ON "spy_content_localized" ("fk_content");

CREATE INDEX "index-spy_content_localized-fk_locale" ON "spy_content_localized" ("fk_locale");

CREATE SEQUENCE "spy_content_storage_pk_seq";

CREATE TABLE "spy_content_storage"
(
    "id_content_storage" INTEGER NOT NULL,
    "fk_content" INTEGER NOT NULL,
    "content_key" VARCHAR(255) NOT NULL,
    "data" TEXT,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_content_storage"),
    CONSTRAINT "spy_content_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_content_storage-content_key" ON "spy_content_storage" ("content_key");

CREATE INDEX "spy_content_storage-fk_content" ON "spy_content_storage" ("fk_content");

CREATE SEQUENCE "spy_country_pk_seq";

CREATE TABLE "spy_country"
(
    "id_country" INTEGER NOT NULL,
    "iso2_code" VARCHAR(2) NOT NULL,
    "iso3_code" VARCHAR(3),
    "name" VARCHAR(255),
    "postal_code_mandatory" BOOLEAN DEFAULT \'f\',
    "postal_code_regex" VARCHAR(500),
    PRIMARY KEY ("id_country"),
    CONSTRAINT "spy_country-iso2_code" UNIQUE ("iso2_code"),
    CONSTRAINT "spy_country-iso3_code" UNIQUE ("iso3_code")
);

CREATE SEQUENCE "spy_region_pk_seq";

CREATE TABLE "spy_region"
(
    "id_region" INTEGER NOT NULL,
    "fk_country" INTEGER,
    "iso2_code" VARCHAR(6) NOT NULL,
    "name" VARCHAR(100) NOT NULL,
    PRIMARY KEY ("id_region"),
    CONSTRAINT "spy_region-iso2_code" UNIQUE ("iso2_code")
);

CREATE INDEX "index-spy_region-fk_country" ON "spy_region" ("fk_country");

CREATE SEQUENCE "spy_currency_pk_seq";

CREATE TABLE "spy_currency"
(
    "id_currency" INTEGER NOT NULL,
    "name" VARCHAR(255),
    "code" VARCHAR(5),
    "symbol" VARCHAR(255),
    PRIMARY KEY ("id_currency")
);

CREATE SEQUENCE "spy_customer_pk_seq";

CREATE TABLE "spy_customer"
(
    "id_customer" INTEGER NOT NULL,
    "fk_locale" INTEGER,
    "fk_user" INTEGER,
    "anonymized_at" TIMESTAMP,
    "company" VARCHAR(100),
    "customer_reference" VARCHAR(255) NOT NULL,
    "date_of_birth" DATE,
    "default_billing_address" INTEGER,
    "default_shipping_address" INTEGER,
    "email" VARCHAR(255) NOT NULL,
    "first_name" VARCHAR(100),
    "gender" INT2,
    "last_name" VARCHAR(100),
    "password" VARCHAR(255),
    "phone" VARCHAR(255),
    "registered" DATE,
    "registration_key" VARCHAR(150),
    "restore_password_date" TIMESTAMP,
    "restore_password_key" VARCHAR(150),
    "salutation" INT2,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_customer"),
    CONSTRAINT "spy_customer-email" UNIQUE ("email"),
    CONSTRAINT "spy_customer-customer_reference" UNIQUE ("customer_reference")
);

CREATE INDEX "index-spy_customer-default_billing_address" ON "spy_customer" ("default_billing_address");

CREATE INDEX "index-spy_customer-default_shipping_address" ON "spy_customer" ("default_shipping_address");

CREATE INDEX "index-spy_customer-fk_locale" ON "spy_customer" ("fk_locale");

CREATE INDEX "index-spy_customer-fk_user" ON "spy_customer" ("fk_user");

CREATE SEQUENCE "spy_customer_address_pk_seq";

CREATE TABLE "spy_customer_address"
(
    "id_customer_address" INTEGER NOT NULL,
    "fk_country" INTEGER NOT NULL,
    "fk_customer" INTEGER NOT NULL,
    "fk_region" INTEGER,
    "address1" VARCHAR(255),
    "address2" VARCHAR(255),
    "address3" VARCHAR(255),
    "anonymized_at" TIMESTAMP,
    "city" VARCHAR(255),
    "comment" VARCHAR(255),
    "company" VARCHAR(255),
    "deleted_at" TIMESTAMP,
    "first_name" VARCHAR(100) NOT NULL,
    "last_name" VARCHAR(100) NOT NULL,
    "phone" VARCHAR(255),
    "salutation" INT2,
    "uuid" VARCHAR(255),
    "zip_code" VARCHAR(15),
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_customer_address"),
    CONSTRAINT "spy_customer_address-unique-uuid" UNIQUE ("uuid")
);

CREATE INDEX "spy_customer_address-fk_customer" ON "spy_customer_address" ("fk_customer");

CREATE INDEX "index-spy_customer_address-fk_region" ON "spy_customer_address" ("fk_region");

CREATE INDEX "index-spy_customer_address-fk_country" ON "spy_customer_address" ("fk_country");

CREATE SEQUENCE "spy_customer_group_pk_seq";

CREATE TABLE "spy_customer_group"
(
    "id_customer_group" INTEGER NOT NULL,
    "description" VARCHAR(255),
    "name" VARCHAR(70) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_customer_group"),
    CONSTRAINT "spy_customer-name" UNIQUE ("name")
);

CREATE SEQUENCE "spy_customer_group_to_customer_pk_seq";

CREATE TABLE "spy_customer_group_to_customer"
(
    "id_customer_group_to_customer" INTEGER NOT NULL,
    "fk_customer" INTEGER NOT NULL,
    "fk_customer_group" INTEGER NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_customer_group_to_customer"),
    CONSTRAINT "fk_customer_group-fk_customer" UNIQUE ("fk_customer_group","fk_customer")
);

CREATE INDEX "index-spy_customer_group_to_customer-fk_customer_group" ON "spy_customer_group_to_customer" ("fk_customer_group");

CREATE INDEX "index-spy_customer_group_to_customer-fk_customer" ON "spy_customer_group_to_customer" ("fk_customer");

CREATE SEQUENCE "spy_customer_note_pk_seq";

CREATE TABLE "spy_customer_note"
(
    "id_customer_note" INTEGER NOT NULL,
    "fk_customer" INTEGER NOT NULL,
    "fk_user" INTEGER NOT NULL,
    "created_at" TIMESTAMP,
    "message" TEXT NOT NULL,
    "updated_at" TIMESTAMP,
    "username" VARCHAR,
    PRIMARY KEY ("id_customer_note")
);

CREATE INDEX "index-spy_customer_note-fk_customer" ON "spy_customer_note" ("fk_customer");

CREATE INDEX "index-spy_customer_note-fk_user" ON "spy_customer_note" ("fk_user");

CREATE SEQUENCE "spy_discount_pk_seq";

CREATE TABLE "spy_discount"
(
    "id_discount" INTEGER NOT NULL,
    "fk_discount_voucher_pool" INTEGER,
    "fk_store" INTEGER,
    "amount" INTEGER NOT NULL,
    "calculator_plugin" VARCHAR(255),
    "collector_query_string" VARCHAR,
    "decision_rule_query_string" VARCHAR,
    "description" VARCHAR(1024),
    "discount_key" VARCHAR(32),
    "discount_type" VARCHAR(255),
    "display_name" VARCHAR(255) NOT NULL,
    "is_active" BOOLEAN DEFAULT \'f\',
    "is_exclusive" BOOLEAN DEFAULT \'f\',
    "minimum_item_amount" INTEGER DEFAULT 1 NOT NULL,
    "valid_from" TIMESTAMP,
    "valid_to" TIMESTAMP,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_discount"),
    CONSTRAINT "spy_discount-unique-fk_discount_voucher_pool" UNIQUE ("fk_discount_voucher_pool"),
    CONSTRAINT "spy_discount-unique-display_name" UNIQUE ("display_name")
);

CREATE INDEX "spy_discount-index-discount_type" ON "spy_discount" ("discount_type");

CREATE INDEX "spy_discount_i_862ce6" ON "spy_discount" ("discount_key");

CREATE INDEX "index-spy_discount-fk_discount_voucher_pool" ON "spy_discount" ("fk_discount_voucher_pool");

CREATE INDEX "index-spy_discount-fk_store" ON "spy_discount" ("fk_store");

CREATE SEQUENCE "id_discount_store_pk_seq";

CREATE TABLE "spy_discount_store"
(
    "id_discount_store" INTEGER NOT NULL,
    "fk_discount" INTEGER NOT NULL,
    "fk_store" INTEGER NOT NULL,
    PRIMARY KEY ("id_discount_store"),
    CONSTRAINT "spy_discount_store-fk_discount-fk_store" UNIQUE ("fk_discount","fk_store")
);

CREATE INDEX "index-spy_discount_store-fk_discount" ON "spy_discount_store" ("fk_discount");

CREATE INDEX "index-spy_discount_store-fk_store" ON "spy_discount_store" ("fk_store");

CREATE SEQUENCE "spy_discount_voucher_pool_pk_seq";

CREATE TABLE "spy_discount_voucher_pool"
(
    "id_discount_voucher_pool" INTEGER NOT NULL,
    "is_active" BOOLEAN DEFAULT \'f\',
    "name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_discount_voucher_pool")
);

CREATE SEQUENCE "spy_discount_voucher_pk_seq";

CREATE TABLE "spy_discount_voucher"
(
    "id_discount_voucher" INTEGER NOT NULL,
    "fk_discount_voucher_pool" INTEGER,
    "code" VARCHAR(255) NOT NULL,
    "is_active" BOOLEAN DEFAULT \'f\',
    "max_number_of_uses" INTEGER,
    "number_of_uses" INTEGER,
    "voucher_batch" INTEGER DEFAULT 0,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_discount_voucher"),
    CONSTRAINT "spy_discount_voucher-code" UNIQUE ("code")
);

CREATE INDEX "index-spy_discount_voucher-fk_discount_voucher_pool" ON "spy_discount_voucher" ("fk_discount_voucher_pool");

CREATE SEQUENCE "spy_discount_amount_pk_seq";

CREATE TABLE "spy_discount_amount"
(
    "id_discount_amount" INTEGER NOT NULL,
    "fk_currency" INTEGER NOT NULL,
    "fk_discount" INTEGER NOT NULL,
    "gross_amount" INTEGER,
    "net_amount" INTEGER,
    PRIMARY KEY ("id_discount_amount"),
    CONSTRAINT "spy_discount_amount-unique-currency-discount" UNIQUE ("fk_currency","fk_discount")
);

CREATE INDEX "index-spy_discount_amount-fk_currency" ON "spy_discount_amount" ("fk_currency");

CREATE INDEX "index-spy_discount_amount-fk_discount" ON "spy_discount_amount" ("fk_discount");

CREATE SEQUENCE "spy_discount_promotion_pk_seq";

CREATE TABLE "spy_discount_promotion"
(
    "id_discount_promotion" INTEGER NOT NULL,
    "fk_discount" INTEGER NOT NULL,
    "abstract_sku" VARCHAR(255) NOT NULL,
    "quantity" INTEGER NOT NULL,
    PRIMARY KEY ("id_discount_promotion")
);

CREATE INDEX "index-spy_discount_promotion-fk_discount" ON "spy_discount_promotion" ("fk_discount");

CREATE SEQUENCE "spy_event_behavior_entity_change_pk_seq";

CREATE TABLE "spy_event_behavior_entity_change"
(
    "id_event_behavior_entity_change" INT8 NOT NULL,
    "data" TEXT,
    "process_id" VARCHAR,
    "created_at" TIMESTAMP,
    PRIMARY KEY ("id_event_behavior_entity_change")
);

CREATE SEQUENCE "pyz_example_state_machine_item_pk_seq";

CREATE TABLE "pyz_example_state_machine_item"
(
    "id_example_state_machine_item" INTEGER NOT NULL,
    "fk_state_machine_item_state" INTEGER,
    "name" VARCHAR,
    PRIMARY KEY ("id_example_state_machine_item")
);

CREATE INDEX "index-pyz_example_state_machine_item-fk_state_mach-bdf22e713652" ON "pyz_example_state_machine_item" ("fk_state_machine_item_state");

CREATE SEQUENCE "spy_file_pk_seq";

CREATE TABLE "spy_file"
(
    "id_file" INTEGER NOT NULL,
    "fk_file_directory" INTEGER,
    "file_name" VARCHAR(500) NOT NULL,
    PRIMARY KEY ("id_file")
);

CREATE INDEX "index-spy_file-fk_file_directory" ON "spy_file" ("fk_file_directory");

CREATE SEQUENCE "spy_file_info_pk_seq";

CREATE TABLE "spy_file_info"
(
    "id_file_info" INTEGER NOT NULL,
    "fk_file" INTEGER NOT NULL,
    "extension" VARCHAR(255) NOT NULL,
    "size" INTEGER NOT NULL,
    "storage_file_name" VARCHAR(255),
    "storage_name" VARCHAR(255),
    "type" VARCHAR(255) NOT NULL,
    "version" INTEGER NOT NULL,
    "version_name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_file_info")
);

CREATE INDEX "index-spy_file_info-fk_file" ON "spy_file_info" ("fk_file");

CREATE SEQUENCE "spy_file_localized_attributes_pk_seq";

CREATE TABLE "spy_file_localized_attributes"
(
    "id_file_localized_attributes" INTEGER NOT NULL,
    "fk_file" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "alt" TEXT,
    "title" VARCHAR(255),
    PRIMARY KEY ("id_file_localized_attributes"),
    CONSTRAINT "spy_file_localized_attributes-unique-fk_file" UNIQUE ("fk_file","fk_locale")
);

CREATE INDEX "index-spy_file_localized_attributes-fk_file" ON "spy_file_localized_attributes" ("fk_file");

CREATE INDEX "index-spy_file_localized_attributes-fk_locale" ON "spy_file_localized_attributes" ("fk_locale");

CREATE SEQUENCE "spy_file_directory_pk_seq";

CREATE TABLE "spy_file_directory"
(
    "id_file_directory" INTEGER NOT NULL,
    "fk_parent_file_directory" INTEGER,
    "is_active" BOOLEAN DEFAULT \'t\' NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "position" INTEGER,
    PRIMARY KEY ("id_file_directory")
);

CREATE INDEX "spy_file_directory_i_ba7161" ON "spy_file_directory" ("position");

CREATE INDEX "index-spy_file_directory-fk_parent_file_directory" ON "spy_file_directory" ("fk_parent_file_directory");

CREATE SEQUENCE "spy_file_directory_localized_attributes_pk_seq";

CREATE TABLE "spy_file_directory_localized_attributes"
(
    "id_file_directory_localized_attributes" INTEGER NOT NULL,
    "fk_file_directory" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "title" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_file_directory_localized_attributes"),
    CONSTRAINT "spy_file_directory_localized_attributes-unique-fk_fd-fk_locale" UNIQUE ("fk_file_directory","fk_locale")
);

CREATE INDEX "index-spy_file_directory_localized_attributes-fk_file_directory" ON "spy_file_directory_localized_attributes" ("fk_file_directory");

CREATE INDEX "index-spy_file_directory_localized_attributes-fk_locale" ON "spy_file_directory_localized_attributes" ("fk_locale");

CREATE SEQUENCE "spy_mime_type_pk_seq";

CREATE TABLE "spy_mime_type"
(
    "id_mime_type" INTEGER NOT NULL,
    "comment" VARCHAR(255),
    "is_allowed" BOOLEAN NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id_mime_type"),
    CONSTRAINT "spy_mime_type-name" UNIQUE ("name")
);

CREATE SEQUENCE "spy_file_storage_pk_seq";

CREATE TABLE "spy_file_storage"
(
    "id_file_storage" INTEGER NOT NULL,
    "fk_file" INTEGER,
    "file_name" VARCHAR,
    "data" TEXT,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    PRIMARY KEY ("id_file_storage"),
    CONSTRAINT "spy_file_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_file_storage-fk_file" ON "spy_file_storage" ("fk_file");

CREATE SEQUENCE "spy_gift_card_pk_seq";

CREATE TABLE "spy_gift_card"
(
    "id_gift_card" INTEGER NOT NULL,
    "attributes" TEXT,
    "code" VARCHAR(40) NOT NULL,
    "currency_iso_code" VARCHAR(5),
    "is_active" BOOLEAN DEFAULT \'t\' NOT NULL,
    "name" VARCHAR(40) NOT NULL,
    "replacement_pattern" VARCHAR(40),
    "value" INTEGER NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_gift_card")
);

CREATE SEQUENCE "spy_gift_card_product_abstract_configuration_pk_seq";

CREATE TABLE "spy_gift_card_product_abstract_configuration"
(
    "id_gift_card_product_abstract_configuration" INTEGER NOT NULL,
    "code_pattern" VARCHAR(40) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_gift_card_product_abstract_configuration")
);

CREATE SEQUENCE "spy_gift_card_product_abstract_configuration_link_pk_seq";

CREATE TABLE "spy_gift_card_product_abstract_configuration_link"
(
    "id_gift_card_product_abstract_configuration_link" INTEGER NOT NULL,
    "fk_gift_card_product_abstract_configuration" INTEGER NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    PRIMARY KEY ("id_gift_card_product_abstract_configuration_link")
);

CREATE INDEX "index-spy_gift_card_product_abstract_configuration-ea801cb20841" ON "spy_gift_card_product_abstract_configuration_link" ("fk_product_abstract");

CREATE INDEX "index-spy_gift_card_product_abstract_configuration-5c47cd7f57d8" ON "spy_gift_card_product_abstract_configuration_link" ("fk_gift_card_product_abstract_configuration");

CREATE SEQUENCE "spy_gift_card_product_configuration_pk_seq";

CREATE TABLE "spy_gift_card_product_configuration"
(
    "id_gift_card_product_configuration" INTEGER NOT NULL,
    "value" INTEGER NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_gift_card_product_configuration")
);

CREATE SEQUENCE "spy_gift_card_product_configuration_link_pk_seq";

CREATE TABLE "spy_gift_card_product_configuration_link"
(
    "id_gift_card_product_configuration_link" INTEGER NOT NULL,
    "fk_gift_card_product_configuration" INTEGER NOT NULL,
    "fk_product" INTEGER NOT NULL,
    PRIMARY KEY ("id_gift_card_product_configuration_link")
);

CREATE INDEX "index-spy_gift_card_product_configuration_link-fk_product" ON "spy_gift_card_product_configuration_link" ("fk_product");

CREATE INDEX "index-spy_gift_card_product_configuration_link-fk_-b6cecefc1da0" ON "spy_gift_card_product_configuration_link" ("fk_gift_card_product_configuration");

CREATE SEQUENCE "spy_payment_gift_card_pk_seq";

CREATE TABLE "spy_payment_gift_card"
(
    "id_payment_gift_card" INTEGER NOT NULL,
    "fk_sales_payment" INTEGER NOT NULL,
    "code" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    PRIMARY KEY ("id_payment_gift_card")
);

CREATE INDEX "index-spy_payment_gift_card-fk_sales_payment" ON "spy_payment_gift_card" ("fk_sales_payment");

CREATE SEQUENCE "spy_gift_card_balance_log_pk_seq";

CREATE TABLE "spy_gift_card_balance_log"
(
    "id_gift_card_balance_log" INTEGER NOT NULL,
    "fk_gift_card" INTEGER NOT NULL,
    "fk_sales_order" INTEGER NOT NULL,
    "value" INTEGER NOT NULL,
    "created_at" TIMESTAMP NOT NULL,
    PRIMARY KEY ("id_gift_card_balance_log")
);

CREATE INDEX "spy_gift_card_balance_log_i_f56346" ON "spy_gift_card_balance_log" ("fk_gift_card","created_at","fk_sales_order","value");

CREATE SEQUENCE "spy_glossary_key_pk_seq";

CREATE TABLE "spy_glossary_key"
(
    "id_glossary_key" INTEGER NOT NULL,
    "is_active" BOOLEAN DEFAULT \'t\' NOT NULL,
    "key" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id_glossary_key"),
    CONSTRAINT "spy_glossary_key-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_glossary_key-index-key" ON "spy_glossary_key" ("key");

CREATE INDEX "spy_glossary_key-is_active" ON "spy_glossary_key" ("is_active");

CREATE SEQUENCE "spy_glossary_translation_pk_seq";

CREATE TABLE "spy_glossary_translation"
(
    "id_glossary_translation" INTEGER NOT NULL,
    "fk_glossary_key" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "is_active" BOOLEAN DEFAULT \'t\' NOT NULL,
    "value" TEXT NOT NULL,
    PRIMARY KEY ("id_glossary_translation"),
    CONSTRAINT "spy_glossary_translation-unique-fk_glossary_key" UNIQUE ("fk_glossary_key","fk_locale")
);

CREATE INDEX "spy_glossary_translation-index-fk_locale" ON "spy_glossary_translation" ("fk_locale");

CREATE INDEX "spy_glossary_translation-is_active" ON "spy_glossary_translation" ("is_active");

CREATE INDEX "index-spy_glossary_translation-fk_glossary_key" ON "spy_glossary_translation" ("fk_glossary_key");

CREATE SEQUENCE "spy_glossary_storage_pk_seq";

CREATE TABLE "spy_glossary_storage"
(
    "id_glossary_storage" INT8 NOT NULL,
    "fk_glossary_key" INTEGER NOT NULL,
    "glossary_key" VARCHAR NOT NULL,
    "data" TEXT,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_glossary_storage"),
    CONSTRAINT "spy_glossary_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_glossary_storage-fk_glossary_key" ON "spy_glossary_storage" ("fk_glossary_key");

CREATE SEQUENCE "spy_locale_pk_seq";

CREATE TABLE "spy_locale"
(
    "id_locale" INTEGER NOT NULL,
    "locale_name" VARCHAR(5) NOT NULL,
    "is_active" BOOLEAN DEFAULT \'t\' NOT NULL,
    PRIMARY KEY ("id_locale"),
    CONSTRAINT "spy_locale-unique-locale_name" UNIQUE ("locale_name")
);

CREATE INDEX "spy_locale-index-locale_name" ON "spy_locale" ("locale_name");

CREATE SEQUENCE "spy_navigation_pk_seq";

CREATE TABLE "spy_navigation"
(
    "id_navigation" INTEGER NOT NULL,
    "is_active" BOOLEAN DEFAULT \'t\' NOT NULL,
    "key" VARCHAR(255) NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_navigation"),
    CONSTRAINT "spy_navigation_key-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_navigation-index-key" ON "spy_navigation" ("key");

CREATE INDEX "spy_navigation-index-is_active" ON "spy_navigation" ("is_active");

CREATE SEQUENCE "spy_navigation_node_pk_seq";

CREATE TABLE "spy_navigation_node"
(
    "id_navigation_node" INTEGER NOT NULL,
    "fk_navigation" INTEGER NOT NULL,
    "fk_parent_navigation_node" INTEGER,
    "is_active" BOOLEAN DEFAULT \'t\' NOT NULL,
    "node_key" VARCHAR(32),
    "node_type" VARCHAR(255),
    "position" INTEGER,
    "valid_from" TIMESTAMP,
    "valid_to" TIMESTAMP,
    PRIMARY KEY ("id_navigation_node")
);

CREATE INDEX "spy_navigation_node_i_ba7161" ON "spy_navigation_node" ("position");

CREATE INDEX "spy_navigation_node_i_576b1b" ON "spy_navigation_node" ("node_key");

CREATE INDEX "index-spy_navigation_node-fk_parent_navigation_node" ON "spy_navigation_node" ("fk_parent_navigation_node");

CREATE INDEX "index-spy_navigation_node-fk_navigation" ON "spy_navigation_node" ("fk_navigation");

CREATE SEQUENCE "spy_navigation_node_localized_attributes_pk_seq";

CREATE TABLE "spy_navigation_node_localized_attributes"
(
    "id_navigation_node_localized_attributes" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "fk_navigation_node" INTEGER NOT NULL,
    "fk_url" INTEGER,
    "css_class" VARCHAR(255),
    "external_url" VARCHAR(255),
    "link" VARCHAR(255),
    "title" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_navigation_node_localized_attributes")
);

CREATE INDEX "index-spy_navigation_node_localized_attributes-fk_-4f569df99f9b" ON "spy_navigation_node_localized_attributes" ("fk_navigation_node");

CREATE INDEX "index-spy_navigation_node_localized_attributes-fk_locale" ON "spy_navigation_node_localized_attributes" ("fk_locale");

CREATE INDEX "index-spy_navigation_node_localized_attributes-fk_url" ON "spy_navigation_node_localized_attributes" ("fk_url");

CREATE SEQUENCE "spy_navigation_storage_pk_seq";

CREATE TABLE "spy_navigation_storage"
(
    "id_navigation_storage" INT8 NOT NULL,
    "fk_navigation" INTEGER NOT NULL,
    "navigation_key" VARCHAR NOT NULL,
    "data" TEXT,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_navigation_storage"),
    CONSTRAINT "spy_navigation_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_navigation_storage-fk_navigation" ON "spy_navigation_storage" ("fk_navigation");

CREATE SEQUENCE "spy_newsletter_subscriber_pk_seq";

CREATE TABLE "spy_newsletter_subscriber"
(
    "id_newsletter_subscriber" INTEGER NOT NULL,
    "fk_customer" INTEGER,
    "email" VARCHAR(255) NOT NULL,
    "is_confirmed" BOOLEAN DEFAULT \'f\' NOT NULL,
    "subscriber_key" VARCHAR(150),
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_newsletter_subscriber"),
    CONSTRAINT "spy_newsletter_subscriber-unique-email" UNIQUE ("email"),
    CONSTRAINT "spy_newsletter_subscriber-unique-subscriber_key" UNIQUE ("subscriber_key")
);

CREATE INDEX "spy_newsletter_subscriber-index-email" ON "spy_newsletter_subscriber" ("email");

CREATE INDEX "spy_newsletter_subscriber-index-subscriber_key" ON "spy_newsletter_subscriber" ("subscriber_key");

CREATE INDEX "index-spy_newsletter_subscriber-fk_customer" ON "spy_newsletter_subscriber" ("fk_customer");

CREATE SEQUENCE "spy_newsletter_type_pk_seq";

CREATE TABLE "spy_newsletter_type"
(
    "id_newsletter_type" INTEGER NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_newsletter_type"),
    CONSTRAINT "spy_newsletter_type-unique-name" UNIQUE ("name")
);

CREATE INDEX "spy_newsletter_type-index-name" ON "spy_newsletter_type" ("name");

CREATE TABLE "spy_newsletter_subscription"
(
    "fk_newsletter_subscriber" INTEGER NOT NULL,
    "fk_newsletter_type" INTEGER NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("fk_newsletter_subscriber","fk_newsletter_type")
);

CREATE SEQUENCE "spy_nopayment_paid_pk_seq";

CREATE TABLE "spy_nopayment_paid"
(
    "id_nopayment_paid" INTEGER NOT NULL,
    "fk_sales_order_item" INTEGER NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_nopayment_paid")
);

CREATE INDEX "index-spy_nopayment_paid-fk_sales_order_item" ON "spy_nopayment_paid" ("fk_sales_order_item");

CREATE SEQUENCE "spy_oauth_access_token_pk_seq";

CREATE TABLE "spy_oauth_access_token"
(
    "id_oauth_access_token" INTEGER NOT NULL,
    "fk_oauth_client" VARCHAR(1024) NOT NULL,
    "expirity_date" TIMESTAMP NOT NULL,
    "identifier" VARCHAR(3024) NOT NULL,
    "scopes" VARCHAR(1024),
    "user_identifier" VARCHAR(1024) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_oauth_access_token")
);

CREATE INDEX "index-spy_oauth_access_token-fk_oauth_client" ON "spy_oauth_access_token" ("fk_oauth_client");

CREATE SEQUENCE "spy_oauth_client_pk_seq";

CREATE TABLE "spy_oauth_client"
(
    "id_oauth_client" INTEGER NOT NULL,
    "identifier" VARCHAR(1024) NOT NULL,
    "is_confidential" BOOLEAN,
    "name" VARCHAR(1024) NOT NULL,
    "redirect_uri" VARCHAR(1024),
    "secret" VARCHAR(1024),
    PRIMARY KEY ("id_oauth_client"),
    CONSTRAINT "spy_oauth_client-identifier" UNIQUE ("identifier")
);

CREATE SEQUENCE "spy_oauth_scope_pk_seq";

CREATE TABLE "spy_oauth_scope"
(
    "id_oauth_scope" INTEGER NOT NULL,
    "description" TEXT,
    "identifier" VARCHAR(1024) NOT NULL,
    PRIMARY KEY ("id_oauth_scope"),
    CONSTRAINT "spy_oauth_scope-identifier" UNIQUE ("identifier")
);

CREATE SEQUENCE "spy_oms_transition_log_pk_seq";

CREATE TABLE "spy_oms_transition_log"
(
    "id_oms_transition_log" INTEGER NOT NULL,
    "fk_oms_order_process" INTEGER,
    "fk_sales_order" INTEGER NOT NULL,
    "fk_sales_order_item" INTEGER NOT NULL,
    "command" VARCHAR,
    "condition" VARCHAR,
    "error_message" TEXT,
    "event" VARCHAR(100),
    "hostname" VARCHAR(128) NOT NULL,
    "is_error" BOOLEAN,
    "locked" BOOLEAN,
    "params" TEXT,
    "path" VARCHAR(256),
    "quantity" INTEGER,
    "source_state" VARCHAR(128),
    "target_state" VARCHAR(128),
    "created_at" TIMESTAMP,
    PRIMARY KEY ("id_oms_transition_log")
);

CREATE INDEX "index-spy_oms_transition_log-fk_sales_order" ON "spy_oms_transition_log" ("fk_sales_order");

CREATE INDEX "index-spy_oms_transition_log-fk_sales_order_item" ON "spy_oms_transition_log" ("fk_sales_order_item");

CREATE INDEX "index-spy_oms_transition_log-fk_oms_order_process" ON "spy_oms_transition_log" ("fk_oms_order_process");

CREATE SEQUENCE "spy_oms_order_process_pk_seq";

CREATE TABLE "spy_oms_order_process"
(
    "id_oms_order_process" INTEGER NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_oms_order_process"),
    CONSTRAINT "spy_oms_order_process-name" UNIQUE ("name")
);

CREATE SEQUENCE "spy_oms_state_machine_lock_pk_seq";

CREATE TABLE "spy_oms_state_machine_lock"
(
    "id_oms_state_machine_lock" INTEGER NOT NULL,
    "details" VARCHAR,
    "expires" TIMESTAMP NOT NULL,
    "identifier" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_oms_state_machine_lock"),
    CONSTRAINT "spy_oms_state_machine_lock-identifier" UNIQUE ("identifier")
);

CREATE SEQUENCE "spy_oms_order_item_state_pk_seq";

CREATE TABLE "spy_oms_order_item_state"
(
    "id_oms_order_item_state" INTEGER NOT NULL,
    "description" VARCHAR(255),
    "name" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id_oms_order_item_state"),
    CONSTRAINT "spy_oms_order_item_state-name" UNIQUE ("name")
);

CREATE SEQUENCE "spy_oms_order_item_state_history_pk_seq";

CREATE TABLE "spy_oms_order_item_state_history"
(
    "id_oms_order_item_state_history" INTEGER NOT NULL,
    "fk_oms_order_item_state" INTEGER NOT NULL,
    "fk_sales_order_item" INTEGER NOT NULL,
    "created_at" TIMESTAMP,
    PRIMARY KEY ("id_oms_order_item_state_history")
);

CREATE INDEX "spy_oms_order_item_state_history-index-fk_soi-fk_oois-id_ooish" ON "spy_oms_order_item_state_history" ("fk_sales_order_item","fk_oms_order_item_state");

CREATE SEQUENCE "spy_oms_event_timeout_pk_seq";

CREATE TABLE "spy_oms_event_timeout"
(
    "id_oms_event_timeout" INTEGER NOT NULL,
    "fk_oms_order_item_state" INTEGER NOT NULL,
    "fk_sales_order_item" INTEGER NOT NULL,
    "event" VARCHAR(255) NOT NULL,
    "timeout" TIMESTAMP NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_oms_event_timeout"),
    CONSTRAINT "spy_oms_event_timeout-unique-fk_sales_order_item" UNIQUE ("fk_sales_order_item","fk_oms_order_item_state")
);

CREATE INDEX "spy_oms_event_timeout-timeout" ON "spy_oms_event_timeout" ("timeout");

CREATE INDEX "index-spy_oms_event_timeout-fk_sales_order_item" ON "spy_oms_event_timeout" ("fk_sales_order_item");

CREATE INDEX "index-spy_oms_event_timeout-fk_oms_order_item_state" ON "spy_oms_event_timeout" ("fk_oms_order_item_state");

CREATE SEQUENCE "spy_oms_product_reservation_pk_seq";

CREATE TABLE "spy_oms_product_reservation"
(
    "id_oms_product_reservation" INTEGER NOT NULL,
    "fk_store" INTEGER,
    "reservation_quantity" INTEGER DEFAULT 0 NOT NULL,
    "sku" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id_oms_product_reservation"),
    CONSTRAINT "spy_oms_product_reservation-sku" UNIQUE ("sku","fk_store")
);

CREATE INDEX "index-spy_oms_product_reservation-fk_store" ON "spy_oms_product_reservation" ("fk_store");

CREATE SEQUENCE "spy_oms_product_reservation_store_pk_seq";

CREATE TABLE "spy_oms_product_reservation_store"
(
    "id_oms_product_reservation_store" INTEGER NOT NULL,
    "reservation_quantity" INTEGER NOT NULL,
    "sku" VARCHAR(255) NOT NULL,
    "store" VARCHAR(255) NOT NULL,
    "version" INT8 NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_oms_product_reservation_store"),
    CONSTRAINT "spy_oms_product_reservation_store-unique-store-sku" UNIQUE ("store","sku")
);

CREATE INDEX "spy_oms_product_reservation_store-version" ON "spy_oms_product_reservation_store" ("version");

CREATE INDEX "spy_oms_product_reservation_store-sku" ON "spy_oms_product_reservation_store" ("sku");

CREATE INDEX "spy_oms_product_reservation_store-store" ON "spy_oms_product_reservation_store" ("store");

CREATE SEQUENCE "spy_oms_product_reservation_change_version_pk_seq";

CREATE TABLE "spy_oms_product_reservation_change_version"
(
    "id_oms_product_reservation_id" INTEGER NOT NULL,
    "version" INT8 NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("version")
);

CREATE TABLE "spy_oms_product_reservation_last_exported_version"
(
    "version" INT8 NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP
);

CREATE SEQUENCE "spy_permission_pk_seq";

CREATE TABLE "spy_permission"
(
    "id_permission" INTEGER NOT NULL,
    "key" VARCHAR(255) NOT NULL,
    "configuration_signature" TEXT,
    PRIMARY KEY ("id_permission"),
    CONSTRAINT "spy_permission-key" UNIQUE ("key")
);

CREATE SEQUENCE "spy_price_product_pk_seq";

CREATE TABLE "spy_price_product"
(
    "id_price_product" INTEGER NOT NULL,
    "fk_price_type" INTEGER NOT NULL,
    "fk_product" INTEGER,
    "fk_product_abstract" INTEGER,
    "price" INTEGER DEFAULT 0,
    PRIMARY KEY ("id_price_product"),
    CONSTRAINT "spy_price_product-unique-fk_product_abstract" UNIQUE ("fk_product_abstract","fk_product","fk_price_type"),
    CONSTRAINT "fk_price_type_unique_fk_product_abstract_unique" UNIQUE ("fk_product_abstract","fk_price_type"),
    CONSTRAINT "fk_price_type_unique_fk_product_unique" UNIQUE ("fk_product","fk_price_type")
);

CREATE INDEX "spy_price_product-fk_price_type" ON "spy_price_product" ("fk_price_type");

CREATE INDEX "spy_price_product-index-fk_product-fk_price_type-price" ON "spy_price_product" ("fk_product","fk_price_type","price");

CREATE INDEX "index-spy_price_product-fk_product_abstract" ON "spy_price_product" ("fk_product_abstract");

CREATE SEQUENCE "spy_price_type_pk_seq";

CREATE TABLE "spy_price_type"
(
    "id_price_type" INTEGER NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "price_mode_configuration" INT2,
    PRIMARY KEY ("id_price_type"),
    CONSTRAINT "spy_price_type-name" UNIQUE ("name")
);

CREATE SEQUENCE "spy_price_product_store_pk_seq";

CREATE TABLE "spy_price_product_store"
(
    "id_price_product_store" INT8 NOT NULL,
    "fk_currency" INTEGER NOT NULL,
    "fk_price_product" INTEGER NOT NULL,
    "fk_store" INTEGER,
    "gross_price" INTEGER,
    "net_price" INTEGER,
    "price_data" TEXT,
    "price_data_checksum" VARCHAR,
    PRIMARY KEY ("id_price_product_store")
);

CREATE INDEX "spy_price_product_store-index-fk_pr_pro-fk_cur-fk_st" ON "spy_price_product_store" ("fk_currency","fk_store","fk_price_product","price_data_checksum","net_price","gross_price");

CREATE INDEX "spy_price_product_store-index-fk_pr_pro-id_pr_pro_st" ON "spy_price_product_store" ("fk_price_product","id_price_product_store");

CREATE SEQUENCE "spy_price_product_default_pk_seq";

CREATE TABLE "spy_price_product_default"
(
    "id_price_product_default" INT8 NOT NULL,
    "fk_price_product_store" INT8 NOT NULL,
    PRIMARY KEY ("id_price_product_default"),
    CONSTRAINT "spy_prs_prod_default-unique-price_product_store" UNIQUE ("fk_price_product_store")
);

CREATE INDEX "spy_price_product_default-index-fk_price_product_store" ON "spy_price_product_default" ("fk_price_product_store");

CREATE SEQUENCE "spy_price_product_schedule_pk_seq";

CREATE TABLE "spy_price_product_schedule"
(
    "id_price_product_schedule" INT8 NOT NULL,
    "fk_currency" INTEGER NOT NULL,
    "fk_store" INTEGER NOT NULL,
    "fk_price_type" INTEGER NOT NULL,
    "fk_product" INTEGER,
    "fk_product_abstract" INTEGER,
    "fk_price_product_schedule_list" INT8 NOT NULL,
    "net_price" INTEGER,
    "gross_price" INTEGER,
    "price_data" TEXT,
    "active_from" TIMESTAMP NOT NULL,
    "active_to" TIMESTAMP NOT NULL,
    "is_current" BOOLEAN DEFAULT \'f\' NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_price_product_schedule")
);

CREATE INDEX "index-spy_price_product_schedule-fk_product" ON "spy_price_product_schedule" ("fk_product");

CREATE INDEX "index-spy_price_product_schedule-fk_product_abstract" ON "spy_price_product_schedule" ("fk_product_abstract");

CREATE INDEX "index-spy_price_product_schedule-fk_currency" ON "spy_price_product_schedule" ("fk_currency");

CREATE INDEX "index-spy_price_product_schedule-fk_store" ON "spy_price_product_schedule" ("fk_store");

CREATE INDEX "index-spy_price_product_schedule-fk_price_type" ON "spy_price_product_schedule" ("fk_price_type");

CREATE INDEX "index-spy_price_product_schedule-fk_price_product_schedule_list" ON "spy_price_product_schedule" ("fk_price_product_schedule_list");

CREATE SEQUENCE "spy_price_product_schedule_list_pk_seq";

CREATE TABLE "spy_price_product_schedule_list"
(
    "id_price_product_schedule_list" INT8 NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "is_active" BOOLEAN DEFAULT \'f\',
    "fk_user" INTEGER,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_price_product_schedule_list")
);

CREATE INDEX "index-spy_price_product_schedule_list-fk_user" ON "spy_price_product_schedule_list" ("fk_user");

CREATE INDEX "index-spy_price_product_schedule_list-name" ON "spy_price_product_schedule_list" ("name");

CREATE SEQUENCE "spy_price_product_abstract_storage_pk_seq";

CREATE TABLE "spy_price_product_abstract_storage"
(
    "id_price_product_abstract_storage" INT8 NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "data" TEXT,
    "store" VARCHAR(128),
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_price_product_abstract_storage"),
    CONSTRAINT "spy_price_product_abstract_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_price_product_abstract_storage-fk_product_abstract" ON "spy_price_product_abstract_storage" ("fk_product_abstract");

CREATE SEQUENCE "spy_price_product_concrete_storage_pk_seq";

CREATE TABLE "spy_price_product_concrete_storage"
(
    "id_price_product_concrete_storage" INT8 NOT NULL,
    "fk_product" INTEGER NOT NULL,
    "data" TEXT,
    "store" VARCHAR(128),
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_price_product_concrete_storage"),
    CONSTRAINT "spy_price_product_concrete_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_price_product_concrete_storage-fk_product" ON "spy_price_product_concrete_storage" ("fk_product");

CREATE SEQUENCE "spy_product_abstract_pk_seq";

CREATE TABLE "spy_product_abstract"
(
    "id_product_abstract" INTEGER NOT NULL,
    "fk_tax_set" INTEGER,
    "attributes" TEXT NOT NULL,
    "color_code" VARCHAR(8),
    "new_from" TIMESTAMP,
    "new_to" TIMESTAMP,
    "sku" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_abstract"),
    CONSTRAINT "spy_product_abstract-sku" UNIQUE ("sku")
);

CREATE INDEX "index-spy_product_abstract-fk_tax_set" ON "spy_product_abstract" ("fk_tax_set");

CREATE SEQUENCE "spy_product_abstract_localized_attributes_pk_seq";

CREATE TABLE "spy_product_abstract_localized_attributes"
(
    "id_abstract_attributes" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "attributes" TEXT NOT NULL,
    "description" TEXT,
    "meta_description" TEXT,
    "meta_keywords" TEXT,
    "meta_title" VARCHAR(255),
    "name" VARCHAR NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_abstract_attributes"),
    CONSTRAINT "spy_product_abstract_localized_attributes-unique-fk_pa" UNIQUE ("fk_product_abstract","fk_locale")
);

CREATE INDEX "index-spy_product_abstract_localized_attributes-fk-a7603b3c2144" ON "spy_product_abstract_localized_attributes" ("fk_product_abstract");

CREATE INDEX "index-spy_product_abstract_localized_attributes-fk_locale" ON "spy_product_abstract_localized_attributes" ("fk_locale");

CREATE SEQUENCE "id_product_abstract_store_pk_seq";

CREATE TABLE "spy_product_abstract_store"
(
    "id_product_abstract_store" INTEGER NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "fk_store" INTEGER NOT NULL,
    PRIMARY KEY ("id_product_abstract_store"),
    CONSTRAINT "spy_product_abstract_store-fk_product_abstract-fk_store" UNIQUE ("fk_product_abstract","fk_store")
);

CREATE INDEX "index-spy_product_abstract_store-fk_product_abstract" ON "spy_product_abstract_store" ("fk_product_abstract");

CREATE INDEX "index-spy_product_abstract_store-fk_store" ON "spy_product_abstract_store" ("fk_store");

CREATE SEQUENCE "spy_product_pk_seq";

CREATE TABLE "spy_product"
(
    "id_product" INTEGER NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "attributes" TEXT NOT NULL,
    "is_active" BOOLEAN DEFAULT \'t\' NOT NULL,
    "is_quantity_splittable" BOOLEAN DEFAULT \'t\' NOT NULL,
    "sku" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product"),
    CONSTRAINT "spy_product-sku" UNIQUE ("sku")
);

CREATE INDEX "index-spy_product-fk_product_abstract" ON "spy_product" ("fk_product_abstract");

CREATE SEQUENCE "spy_product_localized_attributes_pk_seq";

CREATE TABLE "spy_product_localized_attributes"
(
    "id_product_attributes" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "fk_product" INTEGER NOT NULL,
    "attributes" TEXT NOT NULL,
    "description" TEXT,
    "is_complete" BOOLEAN DEFAULT \'t\',
    "name" VARCHAR NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_attributes"),
    CONSTRAINT "spy_product_localized_attributes-unique-fk_product" UNIQUE ("fk_product","fk_locale")
);

CREATE INDEX "index-spy_product_localized_attributes-fk_product" ON "spy_product_localized_attributes" ("fk_product");

CREATE INDEX "index-spy_product_localized_attributes-fk_locale" ON "spy_product_localized_attributes" ("fk_locale");

CREATE SEQUENCE "spy_product_attribute_key_pk_seq";

CREATE TABLE "spy_product_attribute_key"
(
    "id_product_attribute_key" INTEGER NOT NULL,
    "is_super" BOOLEAN DEFAULT \'f\' NOT NULL,
    "key" VARCHAR NOT NULL,
    PRIMARY KEY ("id_product_attribute_key"),
    CONSTRAINT "spy_product_attribute_key-unique-key" UNIQUE ("key")
);

CREATE SEQUENCE "spy_product_alternative_pk_seq";

CREATE TABLE "spy_product_alternative"
(
    "id_product_alternative" INTEGER NOT NULL,
    "fk_product" INTEGER NOT NULL,
    "fk_product_abstract_alternative" INTEGER,
    "fk_product_concrete_alternative" INTEGER,
    PRIMARY KEY ("id_product_alternative")
);

CREATE INDEX "index-spy_product_alternative-fk_product" ON "spy_product_alternative" ("fk_product");

CREATE INDEX "index-spy_product_alternative-fk_product_abstract_alternative" ON "spy_product_alternative" ("fk_product_abstract_alternative");

CREATE INDEX "index-spy_product_alternative-fk_product_concrete_alternative" ON "spy_product_alternative" ("fk_product_concrete_alternative");

CREATE SEQUENCE "id_product_alternative_storage_pk_seq";

CREATE TABLE "spy_product_alternative_storage"
(
    "id_product_alternative_storage" INTEGER NOT NULL,
    "fk_product" INTEGER NOT NULL,
    "data" TEXT,
    "sku" VARCHAR(255) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_alternative_storage"),
    CONSTRAINT "spy_product_alternative_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_alternative_storage-fk_product" ON "spy_product_alternative_storage" ("fk_product");

CREATE SEQUENCE "id_product_replacement_for_storage_pk_seq";

CREATE TABLE "spy_product_replacement_for_storage"
(
    "id_product_replacement_for_storage" INTEGER NOT NULL,
    "data" TEXT,
    "sku" VARCHAR(255) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_replacement_for_storage"),
    CONSTRAINT "spy_product_replacement_for_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_replacement_for_storage-sku" ON "spy_product_replacement_for_storage" ("sku");

CREATE SEQUENCE "spy_product_management_attribute_pk_seq";

CREATE TABLE "spy_product_management_attribute"
(
    "id_product_management_attribute" INTEGER NOT NULL,
    "fk_product_attribute_key" INTEGER NOT NULL,
    "allow_input" BOOLEAN DEFAULT \'t\' NOT NULL,
    "input_type" VARCHAR NOT NULL,
    PRIMARY KEY ("id_product_management_attribute"),
    CONSTRAINT "spy_pim_attribute-unique-fk_product_attribute_key" UNIQUE ("fk_product_attribute_key")
);

CREATE INDEX "index-spy_product_management_attribute-fk_product_attribute_key" ON "spy_product_management_attribute" ("fk_product_attribute_key");

CREATE SEQUENCE "spy_product_management_attribute_value_pk_seq";

CREATE TABLE "spy_product_management_attribute_value"
(
    "id_product_management_attribute_value" INTEGER NOT NULL,
    "fk_product_management_attribute" INTEGER NOT NULL,
    "value" TEXT NOT NULL,
    PRIMARY KEY ("id_product_management_attribute_value")
);

CREATE INDEX "index-spy_product_management_attribute_value-fk_pr-7f614d579abb" ON "spy_product_management_attribute_value" ("fk_product_management_attribute");

CREATE SEQUENCE "spy_product_management_attribute_value_translation_pk_seq";

CREATE TABLE "spy_product_management_attribute_value_translation"
(
    "id_product_management_attribute_value_translation" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "fk_product_management_attribute_value" INTEGER NOT NULL,
    "translation" TEXT NOT NULL,
    PRIMARY KEY ("id_product_management_attribute_value_translation"),
    CONSTRAINT "spy_pim_attribute_value_translation-unique-locale_attribute_val" UNIQUE ("fk_locale","fk_product_management_attribute_value")
);

CREATE INDEX "index-spy_product_management_attribute_value_trans-a710a253ee1d" ON "spy_product_management_attribute_value_translation" ("fk_locale");

CREATE INDEX "index-spy_product_management_attribute_value_trans-8f14a52f8fbf" ON "spy_product_management_attribute_value_translation" ("fk_product_management_attribute_value");

CREATE SEQUENCE "spy_sales_order_item_bundle_pk_seq";

CREATE TABLE "spy_sales_order_item_bundle"
(
    "id_sales_order_item_bundle" INTEGER NOT NULL,
    "cart_note" VARCHAR(255),
    "gross_price" INTEGER NOT NULL,
    "image" TEXT,
    "name" VARCHAR(255) NOT NULL,
    "net_price" INTEGER DEFAULT 0,
    "price" INTEGER DEFAULT 0,
    "sku" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_order_item_bundle")
);

CREATE SEQUENCE "spy_product_bundle_pk_seq";

CREATE TABLE "spy_product_bundle"
(
    "id_product_bundle" INTEGER NOT NULL,
    "fk_bundled_product" INTEGER NOT NULL,
    "fk_product" INTEGER NOT NULL,
    "quantity" INTEGER DEFAULT 1 NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_bundle")
);

COMMENT ON COLUMN "spy_product_bundle"."fk_bundled_product" IS \'Representation of the single item in this bundle\';

COMMENT ON COLUMN "spy_product_bundle"."fk_product" IS \'Relation to the main bundle product\';

COMMENT ON COLUMN "spy_product_bundle"."quantity" IS \'Number of items bundled. For instance when you have 5000 equal items you will have quantity 5000\';

CREATE INDEX "spy_product_bundle-index-fk_product" ON "spy_product_bundle" ("fk_product");

CREATE INDEX "index-spy_product_bundle-fk_bundled_product" ON "spy_product_bundle" ("fk_bundled_product");

CREATE SEQUENCE "spy_product_category_pk_seq";

CREATE TABLE "spy_product_category"
(
    "id_product_category" INTEGER NOT NULL,
    "fk_category" INTEGER NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "product_order" INTEGER DEFAULT 0,
    PRIMARY KEY ("id_product_category"),
    CONSTRAINT "spy_product_category-unique-fk_product_abstract" UNIQUE ("fk_product_abstract","fk_category")
);

CREATE INDEX "index-spy_product_category-fk_category" ON "spy_product_category" ("fk_category");

CREATE INDEX "index-spy_product_category-fk_product_abstract" ON "spy_product_category" ("fk_product_abstract");

CREATE SEQUENCE "spy_product_category_filter_pk_seq";

CREATE TABLE "spy_product_category_filter"
(
    "id_product_category_filter" INTEGER NOT NULL,
    "fk_category" INTEGER,
    "filter_data" TEXT NOT NULL,
    PRIMARY KEY ("id_product_category_filter"),
    CONSTRAINT "spy_product_category_filter-unique-fk_category" UNIQUE ("fk_category")
);

CREATE INDEX "spy_product_category_filter_i_adaed7" ON "spy_product_category_filter" ("fk_category");

CREATE SEQUENCE "spy_product_category_filter_storage_pk_seq";

CREATE TABLE "spy_product_category_filter_storage"
(
    "id_product_category_filter_storage" INT8 NOT NULL,
    "fk_category" INTEGER NOT NULL,
    "data" TEXT,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_category_filter_storage"),
    CONSTRAINT "spy_product_category_filter_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_category_filter_storage-fk_category" ON "spy_product_category_filter_storage" ("fk_category");

CREATE SEQUENCE "spy_product_abstract_category_storage_pk_seq";

CREATE TABLE "spy_product_abstract_category_storage"
(
    "id_product_abstract_category_storage" INT8 NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "data" TEXT,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_abstract_category_storage"),
    CONSTRAINT "spy_product_abstract_category_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_abstract_category_storage-fk_product_abstract" ON "spy_product_abstract_category_storage" ("fk_product_abstract");

CREATE SEQUENCE "id_product_discontinued_pk_seq";

CREATE TABLE "spy_product_discontinued"
(
    "id_product_discontinued" INTEGER NOT NULL,
    "fk_product" INTEGER NOT NULL,
    "active_until" DATE NOT NULL,
    "discontinued_on" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_discontinued")
);

CREATE INDEX "index-spy_product_discontinued-fk_product" ON "spy_product_discontinued" ("fk_product");

CREATE SEQUENCE "id_product_discontinued_note_pk_seq";

CREATE TABLE "spy_product_discontinued_note"
(
    "id_product_discontinued_note" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "fk_product_discontinued" INTEGER NOT NULL,
    "note" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_discontinued_note"),
    CONSTRAINT "spy_product_discontinued_note-unique-fk_product_discontinued" UNIQUE ("fk_product_discontinued","fk_locale")
);

CREATE INDEX "index-spy_product_discontinued_note-fk_product_discontinued" ON "spy_product_discontinued_note" ("fk_product_discontinued");

CREATE INDEX "index-spy_product_discontinued_note-fk_locale" ON "spy_product_discontinued_note" ("fk_locale");

CREATE SEQUENCE "id_product_discontinued_storage_pk_seq";

CREATE TABLE "spy_product_discontinued_storage"
(
    "id_product_discontinued_storage" INTEGER NOT NULL,
    "fk_product_discontinued" INTEGER NOT NULL,
    "data" TEXT,
    "key" VARCHAR(255) NOT NULL,
    "locale" VARCHAR NOT NULL,
    "sku" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_discontinued_storage")
);

CREATE INDEX "spy_product_discontinued_storage-fk_product_discontinued" ON "spy_product_discontinued_storage" ("fk_product_discontinued");

CREATE SEQUENCE "spy_product_group_pk_seq";

CREATE TABLE "spy_product_group"
(
    "id_product_group" INTEGER NOT NULL,
    "product_group_key" VARCHAR(32),
    PRIMARY KEY ("id_product_group")
);

CREATE INDEX "spy_product_group_i_55ec34" ON "spy_product_group" ("product_group_key");

CREATE TABLE "spy_product_abstract_group"
(
    "fk_product_abstract" INTEGER NOT NULL,
    "fk_product_group" INTEGER NOT NULL,
    "position" INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY ("fk_product_abstract","fk_product_group")
);

CREATE SEQUENCE "spy_product_abstract_group_storage_pk_seq";

CREATE TABLE "spy_product_abstract_group_storage"
(
    "id_product_abstract_group_storage" INT8 NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "data" TEXT,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_abstract_group_storage"),
    CONSTRAINT "spy_product_abstract_group_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_abstract_group_storage-fk_product_abstract" ON "spy_product_abstract_group_storage" ("fk_product_abstract");

CREATE SEQUENCE "spy_product_image_set_pk_seq";

CREATE TABLE "spy_product_image_set"
(
    "id_product_image_set" INTEGER NOT NULL,
    "fk_locale" INTEGER,
    "fk_product" INTEGER,
    "fk_product_abstract" INTEGER,
    "fk_resource_product_set" INTEGER,
    "name" VARCHAR(255),
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_image_set"),
    CONSTRAINT "fk_locale-fk_product-fk_product_abstract" UNIQUE ("fk_locale","fk_product","fk_product_abstract")
);

CREATE INDEX "spy_product_image_set-index-fk_product" ON "spy_product_image_set" ("fk_product");

CREATE INDEX "spy_product_image_set-index-fk_product_abstract" ON "spy_product_image_set" ("fk_product_abstract");

CREATE INDEX "spy_product_image_set-fk_resource_product_set" ON "spy_product_image_set" ("fk_resource_product_set");

CREATE INDEX "index-spy_product_image_set-fk_locale" ON "spy_product_image_set" ("fk_locale");

CREATE SEQUENCE "spy_product_image_pk_seq";

CREATE TABLE "spy_product_image"
(
    "id_product_image" INTEGER NOT NULL,
    "external_url_large" VARCHAR(2048),
    "external_url_small" VARCHAR(2048),
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_image")
);

CREATE SEQUENCE "spy_product_image_set_to_product_image_pk_seq";

CREATE TABLE "spy_product_image_set_to_product_image"
(
    "id_product_image_set_to_product_image" INTEGER NOT NULL,
    "fk_product_image" INTEGER NOT NULL,
    "fk_product_image_set" INTEGER NOT NULL,
    "sort_order" INTEGER NOT NULL,
    PRIMARY KEY ("id_product_image_set_to_product_image"),
    CONSTRAINT "fk_product_image_set-fk_product_image" UNIQUE ("fk_product_image_set","fk_product_image")
);

CREATE INDEX "index-spy_product_image_set_to_product_image-fk_pr-73c1243c19c1" ON "spy_product_image_set_to_product_image" ("fk_product_image_set");

CREATE INDEX "index-spy_product_image_set_to_product_image-fk_product_image" ON "spy_product_image_set_to_product_image" ("fk_product_image");

CREATE SEQUENCE "spy_product_abstract_image_storage_pk_seq";

CREATE TABLE "spy_product_abstract_image_storage"
(
    "id_product_abstract_image_storage" INT8 NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "data" TEXT,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_abstract_image_storage"),
    CONSTRAINT "spy_product_abstract_image_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_abstract_image_storage-fk_product_abstract" ON "spy_product_abstract_image_storage" ("fk_product_abstract");

CREATE SEQUENCE "spy_product_concrete_image_storage_pk_seq";

CREATE TABLE "spy_product_concrete_image_storage"
(
    "id_product_concrete_image_storage" INT8 NOT NULL,
    "fk_product" INTEGER NOT NULL,
    "data" TEXT,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_concrete_image_storage"),
    CONSTRAINT "spy_product_concrete_image_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_concrete_image_storage-fk_product" ON "spy_product_concrete_image_storage" ("fk_product");

CREATE SEQUENCE "spy_product_label_pk_seq";

CREATE TABLE "spy_product_label"
(
    "id_product_label" INTEGER NOT NULL,
    "front_end_reference" VARCHAR,
    "is_active" BOOLEAN DEFAULT \'f\' NOT NULL,
    "is_dynamic" BOOLEAN DEFAULT \'f\' NOT NULL,
    "is_exclusive" BOOLEAN DEFAULT \'f\' NOT NULL,
    "is_published" BOOLEAN DEFAULT \'f\',
    "name" VARCHAR NOT NULL,
    "position" INTEGER NOT NULL,
    "valid_from" TIMESTAMP,
    "valid_to" TIMESTAMP,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_label"),
    CONSTRAINT "spy_product_label-name" UNIQUE ("name")
);

CREATE INDEX "idx-spy_product_label-position" ON "spy_product_label" ("position");

CREATE SEQUENCE "spy_product_label_localized_attributes_pk_seq";

CREATE TABLE "spy_product_label_localized_attributes"
(
    "id_product_label_localized_attributes" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "fk_product_label" INTEGER NOT NULL,
    "name" VARCHAR,
    PRIMARY KEY ("id_product_label_localized_attributes"),
    CONSTRAINT "spy_product_label_localized_attributes-fk_product_label-fk_loc" UNIQUE ("fk_product_label","fk_locale")
);

CREATE INDEX "idx-spy_product_label_localized_attributes-fk_product_label" ON "spy_product_label_localized_attributes" ("fk_product_label");

CREATE INDEX "index-spy_product_label_localized_attributes-fk_locale" ON "spy_product_label_localized_attributes" ("fk_locale");

CREATE SEQUENCE "spy_product_label_product_abstract_pk_seq";

CREATE TABLE "spy_product_label_product_abstract"
(
    "id_product_label_product_abstract" INTEGER NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "fk_product_label" INTEGER NOT NULL,
    PRIMARY KEY ("id_product_label_product_abstract"),
    CONSTRAINT "spy_product_label_product_abstract-fk_product_label-fk_pa" UNIQUE ("fk_product_label","fk_product_abstract")
);

CREATE INDEX "idx-spy_product_label_product_abstract-fk_product_label" ON "spy_product_label_product_abstract" ("fk_product_label");

CREATE INDEX "idx-spy_product_label_product_abstract-fk_product_abstract" ON "spy_product_label_product_abstract" ("fk_product_abstract");

CREATE SEQUENCE "spy_product_label_dictionary_storage_pk_seq";

CREATE TABLE "spy_product_label_dictionary_storage"
(
    "id_product_label_dictionary_storage" INT8 NOT NULL,
    "data" TEXT,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_label_dictionary_storage"),
    CONSTRAINT "spy_product_label_dictionary_storage-unique-key" UNIQUE ("key")
);

CREATE SEQUENCE "spy_product_abstract_label_storage_pk_seq";

CREATE TABLE "spy_product_abstract_label_storage"
(
    "id_product_abstract_label_storage" INT8 NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "data" TEXT,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_abstract_label_storage"),
    CONSTRAINT "spy_product_abstract_label_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_abstract_label_storage-fk_product_abstract" ON "spy_product_abstract_label_storage" ("fk_product_abstract");

CREATE SEQUENCE "spy_product_option_group_pk_seq";

CREATE TABLE "spy_product_option_group"
(
    "id_product_option_group" INTEGER NOT NULL,
    "fk_tax_set" INTEGER,
    "active" BOOLEAN,
    "name" VARCHAR(255),
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_option_group")
);

CREATE INDEX "index-spy_product_option_group-fk_tax_set" ON "spy_product_option_group" ("fk_tax_set");

CREATE TABLE "spy_product_abstract_product_option_group"
(
    "fk_product_abstract" INTEGER NOT NULL,
    "fk_product_option_group" INTEGER NOT NULL,
    PRIMARY KEY ("fk_product_abstract","fk_product_option_group")
);

CREATE SEQUENCE "spy_product_option_value_pk_seq";

CREATE TABLE "spy_product_option_value"
(
    "id_product_option_value" INTEGER NOT NULL,
    "fk_product_option_group" INTEGER NOT NULL,
    "price" INTEGER,
    "sku" VARCHAR(255) NOT NULL,
    "value" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_option_value"),
    CONSTRAINT "spy_product_option_value-sku" UNIQUE ("sku")
);

COMMENT ON COLUMN "spy_product_option_value"."price" IS \'Deprecated\';

CREATE INDEX "index-spy_product_option_value-fk_product_option_group" ON "spy_product_option_value" ("fk_product_option_group");

CREATE SEQUENCE "spy_product_option_value_price_pk_seq";

CREATE TABLE "spy_product_option_value_price"
(
    "id_product_option_value_price" INTEGER NOT NULL,
    "fk_currency" INTEGER NOT NULL,
    "fk_product_option_value" INTEGER NOT NULL,
    "fk_store" INTEGER,
    "gross_price" INTEGER,
    "net_price" INTEGER,
    PRIMARY KEY ("id_product_option_value_price"),
    CONSTRAINT "spy_product_option_value_price-fk_value-fk_store-fk_currency" UNIQUE ("fk_product_option_value","fk_store","fk_currency")
);

CREATE INDEX "index-spy_product_option_value_price-fk_currency" ON "spy_product_option_value_price" ("fk_currency");

CREATE INDEX "index-spy_product_option_value_price-fk_store" ON "spy_product_option_value_price" ("fk_store");

CREATE INDEX "index-spy_product_option_value_price-fk_product_option_value" ON "spy_product_option_value_price" ("fk_product_option_value");

CREATE SEQUENCE "spy_product_abstract_option_storage_pk_seq";

CREATE TABLE "spy_product_abstract_option_storage"
(
    "id_product_abstract_option_storage" INT8 NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "data" TEXT,
    "store" VARCHAR(128) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_abstract_option_storage"),
    CONSTRAINT "spy_product_abstract_option_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_abstract_option_storage-fk_product_abstract" ON "spy_product_abstract_option_storage" ("fk_product_abstract");

CREATE SEQUENCE "spy_product_abstract_page_search_pk_seq";

CREATE TABLE "spy_product_abstract_page_search"
(
    "id_product_abstract_page_search" INT8 NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "structured_data" TEXT NOT NULL,
    "data" TEXT,
    "store" VARCHAR(128) NOT NULL,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_abstract_page_search"),
    CONSTRAINT "spy_product_abstract_page_search-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_abstract_page_search-fk_product_abstract" ON "spy_product_abstract_page_search" ("fk_product_abstract");

CREATE SEQUENCE "spy_product_concrete_page_search_pk_seq";

CREATE TABLE "spy_product_concrete_page_search"
(
    "id_product_concrete_page_search" INT8 NOT NULL,
    "fk_product" INTEGER NOT NULL,
    "structured_data" TEXT NOT NULL,
    "data" TEXT,
    "store" VARCHAR(128) NOT NULL,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_concrete_page_search"),
    CONSTRAINT "spy_product_concrete_page_search-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_concrete_page_search-fk_product" ON "spy_product_concrete_page_search" ("fk_product");

CREATE SEQUENCE "id_product_quantity_pk_seq";

CREATE TABLE "spy_product_quantity"
(
    "id_product_quantity" INTEGER NOT NULL,
    "fk_product" INTEGER NOT NULL,
    "quantity_interval" INTEGER NOT NULL,
    "quantity_max" INTEGER,
    "quantity_min" INTEGER NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_quantity"),
    CONSTRAINT "spy_product_quantity-unique-fk_product" UNIQUE ("fk_product")
);

CREATE INDEX "index-spy_product_quantity-fk_product" ON "spy_product_quantity" ("fk_product");

CREATE SEQUENCE "id_product_quantity_storage_pk_seq";

CREATE TABLE "spy_product_quantity_storage"
(
    "id_product_quantity_storage" INTEGER NOT NULL,
    "fk_product" INTEGER NOT NULL,
    "data" TEXT,
    "key" VARCHAR NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_quantity_storage")
);

CREATE INDEX "spy_product_quantity_storage-fk_product" ON "spy_product_quantity_storage" ("fk_product");

CREATE SEQUENCE "spy_product_relation_type_pk_seq";

CREATE TABLE "spy_product_relation_type"
(
    "id_product_relation_type" INTEGER NOT NULL,
    "key" VARCHAR NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_relation_type")
);

CREATE SEQUENCE "spy_product_relation_pk_seq";

CREATE TABLE "spy_product_relation"
(
    "id_product_relation" INTEGER NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "fk_product_relation_type" INTEGER NOT NULL,
    "is_active" BOOLEAN DEFAULT \'t\' NOT NULL,
    "is_rebuild_scheduled" BOOLEAN DEFAULT \'f\' NOT NULL,
    "query_set_data" TEXT,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_relation"),
    CONSTRAINT "spy_product-relation-unique-fk_product_abstract" UNIQUE ("fk_product_abstract","fk_product_relation_type")
);

CREATE INDEX "index-spy_product_relation-fk_product_abstract" ON "spy_product_relation" ("fk_product_abstract");

CREATE INDEX "index-spy_product_relation-fk_product_relation_type" ON "spy_product_relation" ("fk_product_relation_type");

CREATE SEQUENCE "spy_product_rel_prod_abs_type_pk_seq";

CREATE TABLE "spy_product_relation_product_abstract"
(
    "id_product_relation_product_abstract" INTEGER NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "fk_product_relation" INTEGER NOT NULL,
    "order" INTEGER NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_relation_product_abstract")
);

CREATE INDEX "index-spy_product_relation_product_abstract-fk_product_relation" ON "spy_product_relation_product_abstract" ("fk_product_relation");

CREATE INDEX "index-spy_product_relation_product_abstract-fk_product_abstract" ON "spy_product_relation_product_abstract" ("fk_product_abstract");

CREATE SEQUENCE "spy_product_abstract_relation_storage_pk_seq";

CREATE TABLE "spy_product_abstract_relation_storage"
(
    "id_product_abstract_relation_storage" INT8 NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "data" TEXT,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_abstract_relation_storage"),
    CONSTRAINT "spy_product_abstract_relation_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_abstract_relation_storage-fk_product_abstract" ON "spy_product_abstract_relation_storage" ("fk_product_abstract");

CREATE SEQUENCE "id_product_review_pk_seq";

CREATE TABLE "spy_product_review"
(
    "id_product_review" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "customer_reference" VARCHAR(255) NOT NULL,
    "description" TEXT,
    "nickname" VARCHAR(255),
    "rating" INTEGER DEFAULT 0 NOT NULL,
    "status" INT2 DEFAULT 0 NOT NULL,
    "summary" TEXT,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_review")
);

CREATE INDEX "spy_product_review-fk_product_abstract" ON "spy_product_review" ("fk_product_abstract");

CREATE INDEX "spy_product_review-fk_locale" ON "spy_product_review" ("fk_locale");

CREATE INDEX "spy_product_review-customer_reference" ON "spy_product_review" ("customer_reference");

CREATE SEQUENCE "spy_product_review_search_pk_seq";

CREATE TABLE "spy_product_review_search"
(
    "id_product_review_search" INT8 NOT NULL,
    "fk_product_review" INTEGER NOT NULL,
    "structured_data" TEXT NOT NULL,
    "data" TEXT,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_review_search"),
    CONSTRAINT "spy_product_review_search-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_review_search-fk_product_review" ON "spy_product_review_search" ("fk_product_review");

CREATE SEQUENCE "spy_product_abstract_review_storage_pk_seq";

CREATE TABLE "spy_product_abstract_review_storage"
(
    "id_product_abstract_review_storage" INT8 NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "data" TEXT,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_abstract_review_storage"),
    CONSTRAINT "spy_product_abstract_review_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_abstract_review_storage-fk_product_abstract" ON "spy_product_abstract_review_storage" ("fk_product_abstract");

CREATE SEQUENCE "spy_product_search_pk_seq";

CREATE TABLE "spy_product_search"
(
    "id_product_search" INTEGER NOT NULL,
    "fk_locale" INTEGER,
    "fk_product" INTEGER,
    "is_searchable" BOOLEAN DEFAULT \'t\',
    PRIMARY KEY ("id_product_search")
);

CREATE INDEX "spy_product_search-index-fk-product-fk-locale-is_searchable" ON "spy_product_search" ("fk_product","fk_locale","is_searchable");

CREATE TABLE "spy_product_search_attribute_map"
(
    "fk_product_attribute_key" INTEGER NOT NULL,
    "synced" BOOLEAN DEFAULT \'f\',
    "target_field" VARCHAR NOT NULL,
    PRIMARY KEY ("fk_product_attribute_key","target_field")
);

CREATE INDEX "spy_product_search_attribute_map_i_a1d33d" ON "spy_product_search_attribute_map" ("fk_product_attribute_key");

CREATE SEQUENCE "spy_product_search_attribute_pk_seq";

CREATE TABLE "spy_product_search_attribute"
(
    "id_product_search_attribute" INTEGER NOT NULL,
    "fk_product_attribute_key" INTEGER NOT NULL,
    "filter_type" VARCHAR NOT NULL,
    "position" INTEGER DEFAULT 0 NOT NULL,
    "synced" BOOLEAN DEFAULT \'f\',
    PRIMARY KEY ("id_product_search_attribute"),
    CONSTRAINT "spy_product_search_attribute-unique-fk_product_attribute_key" UNIQUE ("fk_product_attribute_key")
);

CREATE SEQUENCE "spy_product_search_config_storage_pk_seq";

CREATE TABLE "spy_product_search_config_storage"
(
    "id_product_search_config_storage" INT8 NOT NULL,
    "data" TEXT,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_search_config_storage"),
    CONSTRAINT "spy_product_search_config_storage-unique-key" UNIQUE ("key")
);

CREATE SEQUENCE "spy_product_set_pk_seq";

CREATE TABLE "spy_product_set"
(
    "id_product_set" INTEGER NOT NULL,
    "is_active" BOOLEAN DEFAULT \'f\' NOT NULL,
    "product_set_key" VARCHAR(255) NOT NULL,
    "weight" INTEGER DEFAULT 0 NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_set"),
    CONSTRAINT "spy_product_set-product_set_key" UNIQUE ("product_set_key")
);

CREATE SEQUENCE "spy_product_abstract_set_pk_seq";

CREATE TABLE "spy_product_abstract_set"
(
    "id_product_abstract_set" INTEGER NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "fk_product_set" INTEGER NOT NULL,
    "position" INTEGER DEFAULT 0 NOT NULL,
    PRIMARY KEY ("id_product_abstract_set"),
    CONSTRAINT "spy_product_abstract_set-unique-fk_product_set" UNIQUE ("fk_product_set","fk_product_abstract")
);

CREATE INDEX "spy_product_abstract_set-fk_product_set" ON "spy_product_abstract_set" ("fk_product_set");

CREATE INDEX "spy_product_abstract_set-fk_product_abstract" ON "spy_product_abstract_set" ("fk_product_abstract");

CREATE SEQUENCE "spy_product_set_data_pk_seq";

CREATE TABLE "spy_product_set_data"
(
    "id_product_set_data" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "fk_product_set" INTEGER NOT NULL,
    "description" TEXT,
    "meta_description" TEXT,
    "meta_keywords" TEXT,
    "meta_title" VARCHAR(255),
    "name" VARCHAR NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_set_data"),
    CONSTRAINT "spy_product_set_data-unique-fk_product_set" UNIQUE ("fk_product_set","fk_locale")
);

CREATE INDEX "spy_product_set_data-fk_product_set" ON "spy_product_set_data" ("fk_product_set");

CREATE INDEX "spy_product_set_data-fk_locale" ON "spy_product_set_data" ("fk_locale");

CREATE SEQUENCE "spy_product_set_page_search_pk_seq";

CREATE TABLE "spy_product_set_page_search"
(
    "id_product_set_page_search" INT8 NOT NULL,
    "fk_product_set" INTEGER NOT NULL,
    "structured_data" TEXT NOT NULL,
    "data" TEXT,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_set_page_search"),
    CONSTRAINT "spy_product_set_page_search-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_set_page_search-fk_product_set" ON "spy_product_set_page_search" ("fk_product_set");

CREATE SEQUENCE "spy_product_set_storage_pk_seq";

CREATE TABLE "spy_product_set_storage"
(
    "id_product_set_storage" INT8 NOT NULL,
    "fk_product_set" INTEGER NOT NULL,
    "data" TEXT,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_set_storage"),
    CONSTRAINT "spy_product_set_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_set_storage-fk_product_set" ON "spy_product_set_storage" ("fk_product_set");

CREATE SEQUENCE "spy_product_abstract_storage_pk_seq";

CREATE TABLE "spy_product_abstract_storage"
(
    "id_product_abstract_storage" INT8 NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "data" TEXT,
    "store" VARCHAR(128) NOT NULL,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_abstract_storage"),
    CONSTRAINT "spy_product_abstract_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_abstract_storage-fk_product_abstract" ON "spy_product_abstract_storage" ("fk_product_abstract");

CREATE SEQUENCE "spy_product_concrete_storage_pk_seq";

CREATE TABLE "spy_product_concrete_storage"
(
    "id_product_concrete_storage" INT8 NOT NULL,
    "fk_product" INTEGER NOT NULL,
    "data" TEXT,
    "locale" VARCHAR(16) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_product_concrete_storage"),
    CONSTRAINT "spy_product_concrete_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_product_concrete_storage-fk_product" ON "spy_product_concrete_storage" ("fk_product");

CREATE SEQUENCE "spy_product_validity_pk_seq";

CREATE TABLE "spy_product_validity"
(
    "id_product_validity" INTEGER NOT NULL,
    "fk_product" INTEGER NOT NULL,
    "valid_from" TIMESTAMP,
    "valid_to" TIMESTAMP,
    PRIMARY KEY ("id_product_validity"),
    CONSTRAINT "spy_product_validity-fk_product-unique" UNIQUE ("fk_product")
);

CREATE INDEX "index-spy_product_validity-fk_product" ON "spy_product_validity" ("fk_product");

CREATE TABLE "spy_propel_heartbeat"
(
    "heartbeat_check" VARCHAR NOT NULL,
    PRIMARY KEY ("heartbeat_check")
);

CREATE SEQUENCE "spy_queue_process_pk_seq";

CREATE TABLE "spy_queue_process"
(
    "id_queue_process" INTEGER NOT NULL,
    "server_id" VARCHAR(255) NOT NULL,
    "process_pid" INTEGER NOT NULL,
    "worker_pid" INTEGER NOT NULL,
    "queue_name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_queue_process"),
    CONSTRAINT "spy_queue_process-unique-key" UNIQUE ("server_id","process_pid","queue_name")
);

CREATE INDEX "spy_queue_process-index-key" ON "spy_queue_process" ("server_id","queue_name");

CREATE SEQUENCE "id_quote_pk_seq";

CREATE TABLE "spy_quote"
(
    "id_quote" INTEGER NOT NULL,
    "fk_store" INTEGER NOT NULL,
    "customer_reference" VARCHAR(255) NOT NULL,
    "quote_data" TEXT NOT NULL,
    "uuid" VARCHAR(255),
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_quote"),
    CONSTRAINT "spy_quote-unique-uuid" UNIQUE ("uuid")
);

CREATE INDEX "spy_quote-fk_store" ON "spy_quote" ("fk_store");

CREATE INDEX "spy_quote-customer_reference" ON "spy_quote" ("customer_reference");

CREATE SEQUENCE "spy_refund_pk_seq";

CREATE TABLE "spy_refund"
(
    "id_refund" INTEGER NOT NULL,
    "fk_sales_order" INTEGER NOT NULL,
    "amount" INTEGER NOT NULL,
    "comment" VARCHAR,
    "created_at" TIMESTAMP,
    PRIMARY KEY ("id_refund")
);

CREATE INDEX "index-spy_refund-fk_sales_order" ON "spy_refund" ("fk_sales_order");

CREATE SEQUENCE "spy_sales_order_pk_seq";

CREATE TABLE "spy_sales_order"
(
    "id_sales_order" INTEGER NOT NULL,
    "fk_locale" INTEGER,
    "fk_sales_order_address_billing" INTEGER NOT NULL,
    "fk_sales_order_address_shipping" INTEGER NOT NULL,
    "cart_note" VARCHAR(255),
    "currency_iso_code" VARCHAR(5),
    "customer_reference" VARCHAR(255),
    "email" VARCHAR(255),
    "first_name" VARCHAR(100),
    "is_test" BOOLEAN DEFAULT \'f\' NOT NULL,
    "last_name" VARCHAR(100),
    "order_reference" VARCHAR(45) NOT NULL,
    "price_mode" INT2,
    "salutation" INT2,
    "store" VARCHAR(255),
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_order"),
    CONSTRAINT "spy_sales_order-order_reference" UNIQUE ("order_reference")
);

CREATE INDEX "spy_sales_order-customer_reference" ON "spy_sales_order" ("customer_reference");

CREATE INDEX "spy_sales_order-store" ON "spy_sales_order" ("store");

CREATE INDEX "spy_sales_order-currency_iso_code" ON "spy_sales_order" ("currency_iso_code");

CREATE INDEX "index-spy_sales_order-fk_sales_order_address_billing" ON "spy_sales_order" ("fk_sales_order_address_billing");

CREATE INDEX "index-spy_sales_order-fk_sales_order_address_shipping" ON "spy_sales_order" ("fk_sales_order_address_shipping");

CREATE INDEX "index-spy_sales_order-fk_locale" ON "spy_sales_order" ("fk_locale");

CREATE SEQUENCE "spy_sales_order_item_pk_seq";

CREATE TABLE "spy_sales_order_item"
(
    "id_sales_order_item" INTEGER NOT NULL,
    "fk_oms_order_item_state" INTEGER NOT NULL,
    "fk_oms_order_process" INTEGER,
    "fk_sales_order" INTEGER NOT NULL,
    "fk_sales_order_item_bundle" INTEGER,
    "canceled_amount" INTEGER DEFAULT 0,
    "cart_note" VARCHAR(255),
    "discount_amount_aggregation" INTEGER DEFAULT 0,
    "discount_amount_full_aggregation" INTEGER DEFAULT 0,
    "expense_price_aggregation" INTEGER DEFAULT 0,
    "gross_price" INTEGER NOT NULL,
    "group_key" VARCHAR(255),
    "is_quantity_splittable" BOOLEAN DEFAULT \'t\' NOT NULL,
    "last_state_change" TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "net_price" INTEGER DEFAULT 0,
    "price" INTEGER DEFAULT 0,
    "price_to_pay_aggregation" INTEGER DEFAULT 0,
    "product_option_price_aggregation" INTEGER DEFAULT 0,
    "quantity" INTEGER DEFAULT 1 NOT NULL,
    "refundable_amount" INTEGER DEFAULT 0,
    "sku" VARCHAR(255) NOT NULL,
    "subtotal_aggregation" INTEGER,
    "tax_amount" INTEGER DEFAULT 0,
    "tax_amount_after_cancellation" INTEGER DEFAULT 0,
    "tax_amount_full_aggregation" INTEGER DEFAULT 0,
    "tax_rate" NUMERIC(8,2),
    "tax_rate_average_aggregation" NUMERIC(8,2),
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_order_item")
);

COMMENT ON COLUMN "spy_sales_order_item"."discount_amount_aggregation" IS \'/Total discount amount for item/\';

COMMENT ON COLUMN "spy_sales_order_item"."discount_amount_full_aggregation" IS \'/Total discount amount for item with options or item expenses/\';

COMMENT ON COLUMN "spy_sales_order_item"."expense_price_aggregation" IS \'/Total price amount for item from item expenses/\';

COMMENT ON COLUMN "spy_sales_order_item"."gross_price" IS \'/price for one unit including tax, without shipping, coupons/\';

COMMENT ON COLUMN "spy_sales_order_item"."net_price" IS \'/Price for one unit not including tax, without shipping, coupons/\';

COMMENT ON COLUMN "spy_sales_order_item"."price" IS \'/Price for item, can be gross or net price depending on tax mode/\';

COMMENT ON COLUMN "spy_sales_order_item"."price_to_pay_aggregation" IS \'/Total item price to pay after discounts including options or item expenses/\';

COMMENT ON COLUMN "spy_sales_order_item"."product_option_price_aggregation" IS \'/Total price amount for item from options/\';

COMMENT ON COLUMN "spy_sales_order_item"."quantity" IS \'/Quantity ordered for item/\';

COMMENT ON COLUMN "spy_sales_order_item"."refundable_amount" IS \'/Total item refundable amount/\';

COMMENT ON COLUMN "spy_sales_order_item"."subtotal_aggregation" IS \'/Subtotal price amount (item + options + item expenses) before discounts/\';

COMMENT ON COLUMN "spy_sales_order_item"."tax_amount" IS \'/Calculated tax amount based on tax mode/\';

COMMENT ON COLUMN "spy_sales_order_item"."tax_amount_after_cancellation" IS \'/Calculated tax full amount based on tax mode, includes options, item expenses, /\';

COMMENT ON COLUMN "spy_sales_order_item"."tax_amount_full_aggregation" IS \'/Calculated tax full amount based on tax mode, includes options, item expenses/\';

COMMENT ON COLUMN "spy_sales_order_item"."tax_rate_average_aggregation" IS \'/Calculated tax rate, includes options, item expenses, /\';

CREATE INDEX "spy_sales_order_item-sku" ON "spy_sales_order_item" ("sku");

CREATE INDEX "index-spy_sales_order_item-fk_sales_order_item_bundle" ON "spy_sales_order_item" ("fk_sales_order_item_bundle");

CREATE INDEX "index-spy_sales_order_item-fk_sales_order" ON "spy_sales_order_item" ("fk_sales_order");

CREATE INDEX "index-spy_sales_order_item-fk_oms_order_item_state" ON "spy_sales_order_item" ("fk_oms_order_item_state");

CREATE INDEX "index-spy_sales_order_item-fk_oms_order_process" ON "spy_sales_order_item" ("fk_oms_order_process");

CREATE SEQUENCE "spy_sales_discount_pk_seq";

CREATE TABLE "spy_sales_discount"
(
    "id_sales_discount" INTEGER NOT NULL,
    "fk_sales_expense" INTEGER,
    "fk_sales_order" INTEGER,
    "fk_sales_order_item" INTEGER,
    "fk_sales_order_item_option" INTEGER,
    "amount" INTEGER NOT NULL,
    "description" VARCHAR(510),
    "display_name" VARCHAR(255) NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_discount")
);

CREATE INDEX "index-spy_sales_discount-fk_sales_order" ON "spy_sales_discount" ("fk_sales_order");

CREATE INDEX "index-spy_sales_discount-fk_sales_order_item" ON "spy_sales_discount" ("fk_sales_order_item");

CREATE INDEX "index-spy_sales_discount-fk_sales_expense" ON "spy_sales_discount" ("fk_sales_expense");

CREATE INDEX "index-spy_sales_discount-fk_sales_order_item_option" ON "spy_sales_discount" ("fk_sales_order_item_option");

CREATE SEQUENCE "spy_sales_discount_code_pk_seq";

CREATE TABLE "spy_sales_discount_code"
(
    "id_sales_discount_code" INTEGER NOT NULL,
    "fk_sales_discount" INTEGER NOT NULL,
    "code" VARCHAR(255) NOT NULL,
    "codepool_name" VARCHAR(255) NOT NULL,
    "is_once_per_customer" BOOLEAN DEFAULT \'t\',
    "is_refundable" BOOLEAN DEFAULT \'f\',
    "is_reusable" BOOLEAN DEFAULT \'f\',
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_discount_code")
);

CREATE INDEX "index-spy_sales_discount_code-fk_sales_discount" ON "spy_sales_discount_code" ("fk_sales_discount");

CREATE SEQUENCE "spy_sales_order_item_gift_card_pk_seq";

CREATE TABLE "spy_sales_order_item_gift_card"
(
    "id_sales_order_item_gift_card" INTEGER NOT NULL,
    "fk_sales_order_item" INTEGER NOT NULL,
    "attributes" TEXT,
    "code" VARCHAR(40),
    "pattern" VARCHAR(40),
    "value" INTEGER,
    PRIMARY KEY ("id_sales_order_item_gift_card")
);

CREATE INDEX "index-spy_sales_order_item_gift_card-fk_sales_order_item" ON "spy_sales_order_item_gift_card" ("fk_sales_order_item");

CREATE SEQUENCE "spy_sales_order_item_option_pk_seq";

CREATE TABLE "spy_sales_order_item_option"
(
    "id_sales_order_item_option" INTEGER NOT NULL,
    "fk_sales_order_item" INTEGER NOT NULL,
    "canceled_amount" INTEGER DEFAULT 0,
    "discount_amount_aggregation" INTEGER DEFAULT 0,
    "gross_price" INTEGER DEFAULT 0 NOT NULL,
    "group_name" VARCHAR NOT NULL,
    "net_price" INTEGER DEFAULT 0,
    "price" INTEGER DEFAULT 0,
    "sku" VARCHAR(255) NOT NULL,
    "tax_amount" INTEGER DEFAULT 0,
    "tax_rate" NUMERIC(8,2) NOT NULL,
    "value" VARCHAR NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_order_item_option")
);

COMMENT ON COLUMN "spy_sales_order_item_option"."discount_amount_aggregation" IS \'/Total discount amount for item/\';

COMMENT ON COLUMN "spy_sales_order_item_option"."net_price" IS \'/Price for one unit not including tax, without shipping, coupons/\';

COMMENT ON COLUMN "spy_sales_order_item_option"."price" IS \'/Price for item, can be gross or net price depending on tax mode/\';

COMMENT ON COLUMN "spy_sales_order_item_option"."tax_amount" IS \'/Calculated tax amount based on tax mode/\';

CREATE INDEX "index-spy_sales_order_item_option-fk_sales_order_item" ON "spy_sales_order_item_option" ("fk_sales_order_item");

CREATE SEQUENCE "spy_sales_order_address_pk_seq";

CREATE TABLE "spy_sales_order_address"
(
    "id_sales_order_address" INTEGER NOT NULL,
    "fk_country" INTEGER NOT NULL,
    "fk_region" INTEGER,
    "address1" VARCHAR(255),
    "address2" VARCHAR(255),
    "address3" VARCHAR(255),
    "cell_phone" VARCHAR(255),
    "city" VARCHAR(255) NOT NULL,
    "comment" VARCHAR(255),
    "company" VARCHAR(255),
    "description" VARCHAR(255),
    "email" VARCHAR(255),
    "first_name" VARCHAR(100) NOT NULL,
    "last_name" VARCHAR(100) NOT NULL,
    "middle_name" VARCHAR(100),
    "phone" VARCHAR(255),
    "po_box" VARCHAR(255),
    "salutation" INT2,
    "zip_code" VARCHAR(15) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_order_address")
);

CREATE INDEX "index-spy_sales_order_address-fk_country" ON "spy_sales_order_address" ("fk_country");

CREATE INDEX "index-spy_sales_order_address-fk_region" ON "spy_sales_order_address" ("fk_region");

CREATE SEQUENCE "spy_sales_order_address_history_pk_seq";

CREATE TABLE "spy_sales_order_address_history"
(
    "id_sales_order_address_history" INTEGER NOT NULL,
    "fk_country" INTEGER NOT NULL,
    "fk_region" INTEGER,
    "fk_sales_order_address" INTEGER NOT NULL,
    "address1" VARCHAR(255),
    "address2" VARCHAR(255),
    "address3" VARCHAR(255),
    "cell_phone" VARCHAR(255),
    "city" VARCHAR(255) NOT NULL,
    "comment" VARCHAR(255),
    "company" VARCHAR(255),
    "description" VARCHAR(255),
    "email" VARCHAR(255),
    "first_name" VARCHAR(100) NOT NULL,
    "is_billing" BOOLEAN DEFAULT \'f\',
    "last_name" VARCHAR(100) NOT NULL,
    "middle_name" VARCHAR(100),
    "phone" VARCHAR(255),
    "po_box" VARCHAR(255),
    "salutation" INT2,
    "zip_code" VARCHAR(15) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_order_address_history")
);

CREATE INDEX "index-spy_sales_order_address_history-fk_country" ON "spy_sales_order_address_history" ("fk_country");

CREATE INDEX "index-spy_sales_order_address_history-fk_sales_order_address" ON "spy_sales_order_address_history" ("fk_sales_order_address");

CREATE INDEX "index-spy_sales_order_address_history-fk_region" ON "spy_sales_order_address_history" ("fk_region");

CREATE SEQUENCE "spy_sales_order_totals_pk_seq";

CREATE TABLE "spy_sales_order_totals"
(
    "id_sales_order_totals" INTEGER NOT NULL,
    "fk_sales_order" INTEGER DEFAULT 0 NOT NULL,
    "canceled_total" INTEGER DEFAULT 0,
    "discount_total" INTEGER DEFAULT 0,
    "grand_total" INTEGER DEFAULT 0,
    "order_expense_total" INTEGER DEFAULT 0,
    "refund_total" INTEGER DEFAULT 0,
    "subtotal" INTEGER DEFAULT 0,
    "tax_total" INTEGER DEFAULT 0,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_order_totals")
);

CREATE INDEX "index-spy_sales_order_totals-fk_sales_order" ON "spy_sales_order_totals" ("fk_sales_order");

CREATE SEQUENCE "spy_sales_order_note_pk_seq";

CREATE TABLE "spy_sales_order_note"
(
    "id_sales_order_note" INTEGER NOT NULL,
    "fk_sales_order" INTEGER NOT NULL,
    "command" VARCHAR(255) NOT NULL,
    "message" VARCHAR(255) NOT NULL,
    "success" BOOLEAN NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_order_note")
);

CREATE INDEX "index-spy_sales_order_note-fk_sales_order" ON "spy_sales_order_note" ("fk_sales_order");

CREATE SEQUENCE "spy_sales_order_comment_pk_seq";

CREATE TABLE "spy_sales_order_comment"
(
    "id_sales_order_comment" INTEGER NOT NULL,
    "fk_sales_order" INTEGER NOT NULL,
    "message" TEXT NOT NULL,
    "username" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_order_comment")
);

CREATE INDEX "index-spy_sales_order_comment-fk_sales_order" ON "spy_sales_order_comment" ("fk_sales_order");

CREATE SEQUENCE "spy_sales_expense_pk_seq";

CREATE TABLE "spy_sales_expense"
(
    "id_sales_expense" INTEGER NOT NULL,
    "fk_sales_order" INTEGER,
    "canceled_amount" INTEGER DEFAULT 0,
    "discount_amount_aggregation" INTEGER DEFAULT 0,
    "gross_price" INTEGER NOT NULL,
    "name" VARCHAR(255),
    "net_price" INTEGER DEFAULT 0,
    "price" INTEGER DEFAULT 0,
    "price_to_pay_aggregation" INTEGER DEFAULT 0,
    "refundable_amount" INTEGER DEFAULT 0,
    "tax_amount" INTEGER DEFAULT 0,
    "tax_amount_after_cancellation" INTEGER DEFAULT 0,
    "tax_rate" NUMERIC(8,2),
    "type" VARCHAR(150),
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_expense")
);

COMMENT ON COLUMN "spy_sales_expense"."discount_amount_aggregation" IS \'/Total discount amount for item/\';

COMMENT ON COLUMN "spy_sales_expense"."net_price" IS \'/Price for one unit not including tax, without shipping, coupons/\';

COMMENT ON COLUMN "spy_sales_expense"."price" IS \'/Price for item, can be gross or net price depending on tax mode/\';

COMMENT ON COLUMN "spy_sales_expense"."price_to_pay_aggregation" IS \'/Total item price to pay after discounts/\';

COMMENT ON COLUMN "spy_sales_expense"."refundable_amount" IS \'/Total item refundable amount/\';

COMMENT ON COLUMN "spy_sales_expense"."tax_amount" IS \'/Calculated tax amount based on tax mode/\';

COMMENT ON COLUMN "spy_sales_expense"."tax_amount_after_cancellation" IS \'/Calculated tax full amount based on tax mode, includes options, item expenses, /\';

CREATE INDEX "spy_sales_expense-index-fk_sales_order" ON "spy_sales_expense" ("fk_sales_order","type");

CREATE SEQUENCE "spy_sales_order_item_metadata_pk_seq";

CREATE TABLE "spy_sales_order_item_metadata"
(
    "id_sales_order_item_metadata" INTEGER NOT NULL,
    "fk_sales_order_item" INTEGER NOT NULL,
    "image" TEXT,
    "super_attributes" TEXT NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_order_item_metadata")
);

CREATE INDEX "spy_sales_order_item_metadata-index-fk_sales_order_item" ON "spy_sales_order_item_metadata" ("fk_sales_order_item");

CREATE SEQUENCE "spy_sales_shipment_pk_seq";

CREATE TABLE "spy_sales_shipment"
(
    "id_sales_shipment" INTEGER NOT NULL,
    "fk_sales_expense" INTEGER,
    "fk_sales_order" INTEGER NOT NULL,
    "carrier_name" VARCHAR(255),
    "delivery_time" VARCHAR(255),
    "name" VARCHAR(255),
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_shipment")
);

CREATE INDEX "index-spy_sales_shipment-fk_sales_order" ON "spy_sales_shipment" ("fk_sales_order");

CREATE INDEX "index-spy_sales_shipment-fk_sales_expense" ON "spy_sales_shipment" ("fk_sales_expense");

CREATE SEQUENCE "id_sales_order_threshold_pk_seq";

CREATE TABLE "spy_sales_order_threshold"
(
    "id_sales_order_threshold" INTEGER NOT NULL,
    "fk_currency" INTEGER NOT NULL,
    "fk_sales_order_threshold_type" INTEGER NOT NULL,
    "fk_store" INTEGER NOT NULL,
    "fee" INTEGER,
    "message_glossary_key" VARCHAR NOT NULL,
    "threshold" INTEGER NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_order_threshold")
);

CREATE INDEX "index-spy_sales_order_threshold-fk_sales_order_threshold_type" ON "spy_sales_order_threshold" ("fk_sales_order_threshold_type");

CREATE INDEX "index-spy_sales_order_threshold-fk_currency" ON "spy_sales_order_threshold" ("fk_currency");

CREATE INDEX "index-spy_sales_order_threshold-fk_store" ON "spy_sales_order_threshold" ("fk_store");

CREATE SEQUENCE "id_sales_order_threshold_tax_set_pk_seq";

CREATE TABLE "spy_sales_order_threshold_tax_set"
(
    "id_sales_order_threshold_tax_set" INTEGER NOT NULL,
    "fk_tax_set" INTEGER NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_order_threshold_tax_set")
);

CREATE INDEX "index-spy_sales_order_threshold_tax_set-fk_tax_set" ON "spy_sales_order_threshold_tax_set" ("fk_tax_set");

CREATE SEQUENCE "id_sales_order_threshold_type_pk_seq";

CREATE TABLE "spy_sales_order_threshold_type"
(
    "id_sales_order_threshold_type" INTEGER NOT NULL,
    "key" VARCHAR NOT NULL,
    "threshold_group" VARCHAR NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_order_threshold_type"),
    CONSTRAINT "spy_sales_order_threshold_type-unique-key" UNIQUE ("key")
);

CREATE SEQUENCE "spy_sales_payment_pk_seq";

CREATE TABLE "spy_sales_payment"
(
    "id_sales_payment" INTEGER NOT NULL,
    "fk_sales_order" INTEGER NOT NULL,
    "fk_sales_payment_method_type" INTEGER NOT NULL,
    "amount" INTEGER NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_payment")
);

CREATE INDEX "index-spy_sales_payment-fk_sales_order" ON "spy_sales_payment" ("fk_sales_order");

CREATE INDEX "index-spy_sales_payment-fk_sales_payment_method_type" ON "spy_sales_payment" ("fk_sales_payment_method_type");

CREATE SEQUENCE "spy_sales_payment_method_type_pk_seq";

CREATE TABLE "spy_sales_payment_method_type"
(
    "id_sales_payment_method_type" INTEGER NOT NULL,
    "payment_method" VARCHAR NOT NULL,
    "payment_provider" VARCHAR NOT NULL,
    PRIMARY KEY ("id_sales_payment_method_type")
);

CREATE INDEX "spy_sales_payment_method_type-type" ON "spy_sales_payment_method_type" ("payment_provider","payment_method");

CREATE SEQUENCE "spy_sales_reclamation_pk_seq";

CREATE TABLE "spy_sales_reclamation"
(
    "id_sales_reclamation" INTEGER NOT NULL,
    "fk_sales_order" INTEGER NOT NULL,
    "customer_email" VARCHAR(255) NOT NULL,
    "customer_name" VARCHAR(511) NOT NULL,
    "customer_reference" VARCHAR(255),
    "is_open" BOOLEAN NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_sales_reclamation")
);

CREATE INDEX "index-spy_sales_reclamation-fk_sales_order" ON "spy_sales_reclamation" ("fk_sales_order");

CREATE SEQUENCE "spy_sales_reclamation_item_pk_seq";

CREATE TABLE "spy_sales_reclamation_item"
(
    "id_sales_reclamation_item" INTEGER NOT NULL,
    "fk_sales_order_item" INTEGER NOT NULL,
    "fk_sales_reclamation" INTEGER NOT NULL,
    PRIMARY KEY ("id_sales_reclamation_item")
);

CREATE INDEX "index-spy_sales_reclamation_item-fk_sales_reclamation" ON "spy_sales_reclamation_item" ("fk_sales_reclamation");

CREATE INDEX "index-spy_sales_reclamation_item-fk_sales_order_item" ON "spy_sales_reclamation_item" ("fk_sales_order_item");

CREATE SEQUENCE "spy_sequence_number_pk_seq";

CREATE TABLE "spy_sequence_number"
(
    "id_sequence_number" INTEGER NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "current_id" INTEGER NOT NULL,
    PRIMARY KEY ("id_sequence_number"),
    CONSTRAINT "spy_sequence_number-name" UNIQUE ("name")
);

CREATE SEQUENCE "spy_shipment_carrier_pk_seq";

CREATE TABLE "spy_shipment_carrier"
(
    "id_shipment_carrier" INTEGER NOT NULL,
    "is_active" BOOLEAN DEFAULT \'t\' NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id_shipment_carrier")
);

CREATE INDEX "spy_shipment_carrier-is_active" ON "spy_shipment_carrier" ("is_active");

CREATE SEQUENCE "spy_shipment_method_pk_seq";

CREATE TABLE "spy_shipment_method"
(
    "id_shipment_method" INTEGER NOT NULL,
    "fk_shipment_carrier" INTEGER NOT NULL,
    "fk_tax_set" INTEGER,
    "availability_plugin" VARCHAR(255),
    "default_price" INTEGER,
    "delivery_time_plugin" VARCHAR(255),
    "is_active" BOOLEAN DEFAULT \'t\' NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "price_plugin" VARCHAR(255),
    "shipment_method_key" VARCHAR(255),
    PRIMARY KEY ("id_shipment_method")
);

COMMENT ON COLUMN "spy_shipment_method"."default_price" IS \'Deprecated\';

CREATE INDEX "spy_shipment_method-is_active" ON "spy_shipment_method" ("is_active");

CREATE INDEX "index-spy_shipment_method-fk_shipment_carrier" ON "spy_shipment_method" ("fk_shipment_carrier");

CREATE INDEX "index-spy_shipment_method-fk_tax_set" ON "spy_shipment_method" ("fk_tax_set");

CREATE SEQUENCE "spy_shipment_method_price_pk_seq";

CREATE TABLE "spy_shipment_method_price"
(
    "id_shipment_method_price" INTEGER NOT NULL,
    "fk_currency" INTEGER NOT NULL,
    "fk_shipment_method" INTEGER NOT NULL,
    "fk_store" INTEGER,
    "default_gross_price" INTEGER,
    "default_net_price" INTEGER,
    PRIMARY KEY ("id_shipment_method_price"),
    CONSTRAINT "spy_shipment_method_price-fk_shipment_method-fk_currency-fk_s" UNIQUE ("fk_shipment_method","fk_store","fk_currency")
);

CREATE INDEX "index-spy_shipment_method_price-fk_currency" ON "spy_shipment_method_price" ("fk_currency");

CREATE INDEX "index-spy_shipment_method_price-fk_store" ON "spy_shipment_method_price" ("fk_store");

CREATE INDEX "index-spy_shipment_method_price-fk_shipment_method" ON "spy_shipment_method_price" ("fk_shipment_method");

CREATE SEQUENCE "spy_state_machine_transition_log_pk_seq";

CREATE TABLE "spy_state_machine_transition_log"
(
    "id_state_machine_transition_log" INTEGER NOT NULL,
    "fk_state_machine_process" INTEGER NOT NULL,
    "command" VARCHAR,
    "condition" VARCHAR,
    "error_message" TEXT,
    "event" VARCHAR(100),
    "hostname" VARCHAR(128) NOT NULL,
    "identifier" INTEGER NOT NULL,
    "is_error" BOOLEAN,
    "locked" BOOLEAN,
    "params" TEXT,
    "path" VARCHAR(256),
    "source_state" VARCHAR(128),
    "target_state" VARCHAR(128),
    "created_at" TIMESTAMP,
    PRIMARY KEY ("id_state_machine_transition_log")
);

CREATE INDEX "index-spy_state_machine_transition_log-fk_state_machine_process" ON "spy_state_machine_transition_log" ("fk_state_machine_process");

CREATE SEQUENCE "spy_state_machine_process_pk_seq";

CREATE TABLE "spy_state_machine_process"
(
    "id_state_machine_process" INTEGER NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "state_machine_name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_state_machine_process"),
    CONSTRAINT "spy_state_machine_process-name" UNIQUE ("name","state_machine_name")
);

CREATE INDEX "spy_state_machine_process-state_machine_name" ON "spy_state_machine_process" ("state_machine_name");

CREATE SEQUENCE "spy_state_machine_lock_pk_seq";

CREATE TABLE "spy_state_machine_lock"
(
    "id_state_machine_lock" INTEGER NOT NULL,
    "expires" TIMESTAMP NOT NULL,
    "identifier" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_state_machine_lock"),
    CONSTRAINT "spy_state_machine_lock-identifier" UNIQUE ("identifier")
);

CREATE SEQUENCE "spy_state_machine_item_state_pk_seq";

CREATE TABLE "spy_state_machine_item_state"
(
    "id_state_machine_item_state" INTEGER NOT NULL,
    "fk_state_machine_process" INTEGER NOT NULL,
    "description" VARCHAR(255),
    "name" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id_state_machine_item_state"),
    CONSTRAINT "spy_state_machine_item_state-name" UNIQUE ("name","fk_state_machine_process")
);

CREATE INDEX "index-spy_state_machine_item_state-fk_state_machine_process" ON "spy_state_machine_item_state" ("fk_state_machine_process");

CREATE SEQUENCE "spy_state_machine_item_state_history_pk_seq";

CREATE TABLE "spy_state_machine_item_state_history"
(
    "id_state_machine_item_state_history" INTEGER NOT NULL,
    "fk_state_machine_item_state" INTEGER NOT NULL,
    "identifier" INTEGER NOT NULL,
    "created_at" TIMESTAMP,
    PRIMARY KEY ("id_state_machine_item_state_history")
);

CREATE INDEX "spy_state_machine_item_state_history-identifier" ON "spy_state_machine_item_state_history" ("identifier");

CREATE INDEX "index-spy_state_machine_item_state_history-fk_stat-86748ef1e826" ON "spy_state_machine_item_state_history" ("fk_state_machine_item_state");

CREATE SEQUENCE "spy_state_machine_event_timeout_pk_seq";

CREATE TABLE "spy_state_machine_event_timeout"
(
    "id_state_machine_event_timeout" INTEGER NOT NULL,
    "fk_state_machine_item_state" INTEGER NOT NULL,
    "fk_state_machine_process" INTEGER NOT NULL,
    "event" VARCHAR(255) NOT NULL,
    "identifier" INTEGER NOT NULL,
    "timeout" TIMESTAMP NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_state_machine_event_timeout"),
    CONSTRAINT "spy_state_machine_item_state-unique-identifier" UNIQUE ("identifier","fk_state_machine_item_state")
);

CREATE INDEX "spy_state_machine_event_timeout-timeout" ON "spy_state_machine_event_timeout" ("timeout");

CREATE INDEX "index-spy_state_machine_event_timeout-fk_state_mac-d2bb0e7f2734" ON "spy_state_machine_event_timeout" ("fk_state_machine_item_state");

CREATE INDEX "index-spy_state_machine_event_timeout-fk_state_machine_process" ON "spy_state_machine_event_timeout" ("fk_state_machine_process");

CREATE SEQUENCE "spy_stock_pk_seq";

CREATE TABLE "spy_stock"
(
    "id_stock" INTEGER NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id_stock"),
    CONSTRAINT "spy_stock-name" UNIQUE ("name")
);

CREATE SEQUENCE "spy_stock_product_pk_seq";

CREATE TABLE "spy_stock_product"
(
    "id_stock_product" INTEGER NOT NULL,
    "fk_product" INTEGER NOT NULL,
    "fk_stock" INTEGER NOT NULL,
    "is_never_out_of_stock" BOOLEAN DEFAULT \'f\',
    "quantity" INTEGER DEFAULT 0,
    PRIMARY KEY ("id_stock_product"),
    CONSTRAINT "spy_stock_product-unique-fk_stock" UNIQUE ("fk_stock","fk_product")
);

CREATE INDEX "spy_stock_product-fk_product" ON "spy_stock_product" ("fk_product");

CREATE INDEX "index-spy_stock_product-fk_stock" ON "spy_stock_product" ("fk_stock");

CREATE SEQUENCE "spy_store_pk_seq";

CREATE TABLE "spy_store"
(
    "id_store" INTEGER NOT NULL,
    "name" VARCHAR(255),
    PRIMARY KEY ("id_store")
);

CREATE SEQUENCE "spy_tax_set_pk_seq";

CREATE TABLE "spy_tax_set"
(
    "id_tax_set" INTEGER NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "uuid" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_tax_set"),
    CONSTRAINT "spy_tax_set-unique-uuid" UNIQUE ("uuid")
);

CREATE SEQUENCE "spy_tax_rate_pk_seq";

CREATE TABLE "spy_tax_rate"
(
    "id_tax_rate" INTEGER NOT NULL,
    "fk_country" INTEGER,
    "name" VARCHAR(255) NOT NULL,
    "rate" NUMERIC(8,2) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_tax_rate")
);

CREATE INDEX "index-spy_tax_rate-fk_country" ON "spy_tax_rate" ("fk_country");

CREATE TABLE "spy_tax_set_tax"
(
    "fk_tax_rate" INTEGER NOT NULL,
    "fk_tax_set" INTEGER NOT NULL,
    PRIMARY KEY ("fk_tax_rate","fk_tax_set")
);

CREATE SEQUENCE "id_tax_product_storage_pk_seq";

CREATE TABLE "spy_tax_product_storage"
(
    "id_tax_product_storage" INTEGER NOT NULL,
    "fk_product_abstract" INTEGER NOT NULL,
    "data" TEXT,
    "sku" VARCHAR(255) NOT NULL,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_tax_product_storage"),
    CONSTRAINT "spy_tax_product_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_tax_product_storage-fk_product_abstract" ON "spy_tax_product_storage" ("fk_product_abstract");

CREATE SEQUENCE "id_tax_set_storage_pk_seq";

CREATE TABLE "spy_tax_set_storage"
(
    "id_tax_set_storage" INTEGER NOT NULL,
    "fk_tax_set" INTEGER NOT NULL,
    "data" TEXT,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_tax_set_storage"),
    CONSTRAINT "spy_tax_set_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_tax_set_storage-fk_tax_set" ON "spy_tax_set_storage" ("fk_tax_set");

CREATE SEQUENCE "spy_touch_pk_seq";

CREATE TABLE "spy_touch"
(
    "id_touch" INTEGER NOT NULL,
    "item_event" INT2 NOT NULL,
    "item_id" INTEGER NOT NULL,
    "item_type" VARCHAR(255) NOT NULL,
    "touched" TIMESTAMP NOT NULL,
    PRIMARY KEY ("id_touch"),
    CONSTRAINT "spy_touch-unique-item_id" UNIQUE ("item_id","item_event","item_type")
);

CREATE INDEX "spy_touch-index-item_id" ON "spy_touch" ("item_id");

CREATE INDEX "index_spy_touch-item_event_item_type_touched" ON "spy_touch" ("item_event","item_type","touched");

CREATE SEQUENCE "spy_touch_storage_pk_seq";

CREATE TABLE "spy_touch_storage"
(
    "id_touch_storage" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "fk_store" INTEGER,
    "fk_touch" INTEGER NOT NULL,
    "key" VARCHAR NOT NULL,
    PRIMARY KEY ("id_touch_storage"),
    CONSTRAINT "spy_touch_storage-unique-fk_locale" UNIQUE ("fk_locale","key")
);

CREATE INDEX "spy_touch_storage-index-key" ON "spy_touch_storage" ("key");

CREATE INDEX "index-spy_touch_storage-fk_touch" ON "spy_touch_storage" ("fk_touch");

CREATE INDEX "index-spy_touch_storage-fk_store" ON "spy_touch_storage" ("fk_store");

CREATE INDEX "index-spy_touch_storage-fk_locale" ON "spy_touch_storage" ("fk_locale");

CREATE SEQUENCE "spy_touch_search_pk_seq";

CREATE TABLE "spy_touch_search"
(
    "id_touch_search" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "fk_store" INTEGER,
    "fk_touch" INTEGER NOT NULL,
    "key" VARCHAR NOT NULL,
    PRIMARY KEY ("id_touch_search"),
    CONSTRAINT "spy_touch_search-unique-fk_locale" UNIQUE ("fk_locale","key")
);

CREATE INDEX "spy_touch_search-index-key" ON "spy_touch_search" ("key");

CREATE INDEX "index-spy_touch_search-fk_touch" ON "spy_touch_search" ("fk_touch");

CREATE INDEX "index-spy_touch_search-fk_store" ON "spy_touch_search" ("fk_store");

CREATE INDEX "index-spy_touch_search-fk_locale" ON "spy_touch_search" ("fk_locale");

CREATE SEQUENCE "spy_unauthenticated_customer_access_pk_seq";

CREATE TABLE "spy_unauthenticated_customer_access"
(
    "id_unauthenticated_customer_access" INTEGER NOT NULL,
    "content_type" VARCHAR(100) NOT NULL,
    "is_restricted" BOOLEAN NOT NULL,
    PRIMARY KEY ("id_unauthenticated_customer_access"),
    CONSTRAINT "spy_unauthenticated_customer_access_u_0984b8" UNIQUE ("content_type")
);

CREATE SEQUENCE "unauthenticated_customer_access_storage_pk_seq";

CREATE TABLE "spy_unauthenticated_customer_access_storage"
(
    "id_unauthenticated_customer_access_storage" INTEGER NOT NULL,
    "key" VARCHAR(255) NOT NULL,
    "data" TEXT,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_unauthenticated_customer_access_storage")
);

CREATE SEQUENCE "spy_url_pk_seq";

CREATE TABLE "spy_url"
(
    "id_url" INTEGER NOT NULL,
    "fk_locale" INTEGER NOT NULL,
    "fk_resource_categorynode" INTEGER,
    "fk_resource_page" INTEGER,
    "fk_resource_product_abstract" INTEGER,
    "fk_resource_product_set" INTEGER,
    "fk_resource_redirect" INTEGER,
    "url" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id_url"),
    CONSTRAINT "spy_url_unique_key" UNIQUE ("url")
);

CREATE INDEX "spy_url-fk_resource_product_set" ON "spy_url" ("fk_resource_product_set");

CREATE INDEX "index-spy_url-fk_resource_categorynode" ON "spy_url" ("fk_resource_categorynode");

CREATE INDEX "index-spy_url-fk_resource_page" ON "spy_url" ("fk_resource_page");

CREATE INDEX "index-spy_url-fk_resource_product_abstract" ON "spy_url" ("fk_resource_product_abstract");

CREATE INDEX "index-spy_url-fk_locale" ON "spy_url" ("fk_locale");

CREATE INDEX "index-spy_url-fk_resource_redirect" ON "spy_url" ("fk_resource_redirect");

CREATE SEQUENCE "spy_url_redirect_pk_seq";

CREATE TABLE "spy_url_redirect"
(
    "id_url_redirect" INTEGER NOT NULL,
    "status" INTEGER DEFAULT 301 NOT NULL,
    "to_url" VARCHAR(255) NOT NULL,
    PRIMARY KEY ("id_url_redirect")
);

CREATE INDEX "spy_url_redirect-to_url" ON "spy_url_redirect" ("to_url","status");

CREATE SEQUENCE "spy_url_storage_pk_seq";

CREATE TABLE "spy_url_storage"
(
    "id_url_storage" INT8 NOT NULL,
    "fk_categorynode" INTEGER,
    "fk_page" INTEGER,
    "fk_product_abstract" INTEGER,
    "fk_product_set" INTEGER,
    "fk_redirect" INTEGER,
    "fk_url" INTEGER NOT NULL,
    "url" VARCHAR NOT NULL,
    "data" TEXT,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_url_storage"),
    CONSTRAINT "spy_url_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_url_storage-fk_url" ON "spy_url_storage" ("fk_url");

CREATE SEQUENCE "spy_url_redirect_storage_pk_seq";

CREATE TABLE "spy_url_redirect_storage"
(
    "id_url_redirect_storage" INT8 NOT NULL,
    "fk_url_redirect" INTEGER NOT NULL,
    "data" TEXT,
    "key" VARCHAR,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_url_redirect_storage"),
    CONSTRAINT "spy_url_redirect_storage-unique-key" UNIQUE ("key")
);

CREATE INDEX "spy_url_redirect_storage-fk_url_redirect" ON "spy_url_redirect_storage" ("fk_url_redirect");

CREATE SEQUENCE "spy_user_pk_seq";

CREATE TABLE "spy_user"
(
    "id_user" INTEGER NOT NULL,
    "fk_locale" INTEGER,
    "first_name" VARCHAR(45) NOT NULL,
    "is_agent" BOOLEAN,
    "last_login" TIMESTAMP,
    "last_name" VARCHAR(255) NOT NULL,
    "password" VARCHAR(255) NOT NULL,
    "status" INT2 DEFAULT 0 NOT NULL,
    "username" VARCHAR(45) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_user"),
    CONSTRAINT "spy_user-username" UNIQUE ("username")
);

CREATE SEQUENCE "id_vault_deposit_pk_seq";

CREATE TABLE "spy_vault_deposit"
(
    "id_vault_deposit" INTEGER NOT NULL,
    "data_type" VARCHAR(255) NOT NULL,
    "data_key" VARCHAR(255) NOT NULL,
    "initial_vector" VARCHAR(255) NOT NULL,
    "cipher_text" TEXT NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_vault_deposit"),
    CONSTRAINT "spy_vault_deposit-unique-data_type-data_key" UNIQUE ("data_type","data_key")
);

CREATE INDEX "spy_vault_deposit-data_type-data_key" ON "spy_vault_deposit" ("data_type","data_key");

CREATE SEQUENCE "spy_wishlist_pk_seq";

CREATE TABLE "spy_wishlist"
(
    "id_wishlist" INTEGER NOT NULL,
    "fk_customer" INTEGER NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    "uuid" VARCHAR,
    PRIMARY KEY ("id_wishlist"),
    CONSTRAINT "spy_wishlist-unique-fk_customer-name" UNIQUE ("fk_customer","name"),
    CONSTRAINT "spy_wishlist-unique-uuid" UNIQUE ("uuid")
);

CREATE INDEX "index-spy_wishlist-fk_customer" ON "spy_wishlist" ("fk_customer");

CREATE SEQUENCE "spy_wishlist_item_pk_seq";

CREATE TABLE "spy_wishlist_item"
(
    "id_wishlist_item" INTEGER NOT NULL,
    "fk_wishlist" INTEGER NOT NULL,
    "sku" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id_wishlist_item")
);

CREATE INDEX "index-spy_wishlist_item-fk_wishlist" ON "spy_wishlist_item" ("fk_wishlist");

CREATE INDEX "index-spy_wishlist_item-sku" ON "spy_wishlist_item" ("sku");

CREATE TABLE "spy_acl_role_archive"
(
    "id_acl_role" INTEGER NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    "archived_at" TIMESTAMP,
    PRIMARY KEY ("id_acl_role")
);

CREATE INDEX "spy_acl_role_archive_i_d94269" ON "spy_acl_role_archive" ("name");

CREATE TABLE "spy_acl_rule_archive"
(
    "id_acl_rule" INTEGER NOT NULL,
    "fk_acl_role" INTEGER NOT NULL,
    "bundle" VARCHAR(45) NOT NULL,
    "controller" VARCHAR(45) NOT NULL,
    "action" VARCHAR(45) NOT NULL,
    "type" INT2 NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    "archived_at" TIMESTAMP,
    PRIMARY KEY ("id_acl_rule")
);

CREATE TABLE "spy_acl_group_archive"
(
    "id_acl_group" INTEGER NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    "archived_at" TIMESTAMP,
    PRIMARY KEY ("id_acl_group")
);

CREATE INDEX "spy_acl_group_archive_i_d94269" ON "spy_acl_group_archive" ("name");

CREATE TABLE "spy_auth_reset_password_archive"
(
    "id_auth_reset_password" INTEGER NOT NULL,
    "fk_user" INTEGER NOT NULL,
    "code" VARCHAR(35) NOT NULL,
    "status" INT2 NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    "archived_at" TIMESTAMP,
    PRIMARY KEY ("id_auth_reset_password","fk_user")
);

CREATE INDEX "spy_auth_reset_password_archive_i_4db226" ON "spy_auth_reset_password_archive" ("code");

CREATE TABLE "spy_product_search_attribute_map_archive"
(
    "fk_product_attribute_key" INTEGER NOT NULL,
    "synced" BOOLEAN DEFAULT \'f\',
    "target_field" VARCHAR NOT NULL,
    "archived_at" TIMESTAMP,
    PRIMARY KEY ("fk_product_attribute_key","target_field")
);

CREATE INDEX "spy_product_search_attribute_map_archive_i_a1d33d" ON "spy_product_search_attribute_map_archive" ("fk_product_attribute_key");

CREATE TABLE "spy_product_search_attribute_archive"
(
    "id_product_search_attribute" INTEGER NOT NULL,
    "fk_product_attribute_key" INTEGER NOT NULL,
    "filter_type" VARCHAR NOT NULL,
    "position" INTEGER DEFAULT 0 NOT NULL,
    "synced" BOOLEAN DEFAULT \'f\',
    "archived_at" TIMESTAMP,
    PRIMARY KEY ("id_product_search_attribute")
);

CREATE INDEX "spy_product_search_attribute_archive_i_a1d33d" ON "spy_product_search_attribute_archive" ("fk_product_attribute_key");

CREATE TABLE "spy_user_archive"
(
    "id_user" INTEGER NOT NULL,
    "fk_locale" INTEGER,
    "first_name" VARCHAR(45) NOT NULL,
    "is_agent" BOOLEAN,
    "last_login" TIMESTAMP,
    "last_name" VARCHAR(255) NOT NULL,
    "password" VARCHAR(255) NOT NULL,
    "status" INT2 DEFAULT 0 NOT NULL,
    "username" VARCHAR(45) NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    "archived_at" TIMESTAMP,
    PRIMARY KEY ("id_user")
);

CREATE INDEX "spy_user_archive_i_f86ef3" ON "spy_user_archive" ("username");

ALTER TABLE "spy_acl_rule" ADD CONSTRAINT "spy_acl_rule-fk_acl_role"
    FOREIGN KEY ("fk_acl_role")
    REFERENCES "spy_acl_role" ("id_acl_role")
    ON DELETE CASCADE;

ALTER TABLE "spy_acl_user_has_group" ADD CONSTRAINT "spy_acl_user_has_group-fk_user"
    FOREIGN KEY ("fk_user")
    REFERENCES "spy_user" ("id_user")
    ON DELETE CASCADE;

ALTER TABLE "spy_acl_user_has_group" ADD CONSTRAINT "spy_acl_user_has_group-fk_acl_group"
    FOREIGN KEY ("fk_acl_group")
    REFERENCES "spy_acl_group" ("id_acl_group")
    ON DELETE CASCADE;

ALTER TABLE "spy_acl_groups_has_roles" ADD CONSTRAINT "spy_acl_groups_has_roles-fk_acl_role"
    FOREIGN KEY ("fk_acl_role")
    REFERENCES "spy_acl_role" ("id_acl_role")
    ON DELETE CASCADE;

ALTER TABLE "spy_acl_groups_has_roles" ADD CONSTRAINT "spy_acl_groups_has_roles-fk_acl_group"
    FOREIGN KEY ("fk_acl_group")
    REFERENCES "spy_acl_group" ("id_acl_group")
    ON DELETE CASCADE;

ALTER TABLE "spy_auth_reset_password" ADD CONSTRAINT "spy_auth_reset_password-fk_user"
    FOREIGN KEY ("fk_user")
    REFERENCES "spy_user" ("id_user")
    ON DELETE CASCADE;

ALTER TABLE "spy_availability_abstract" ADD CONSTRAINT "spy_availability_abstract-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_availability" ADD CONSTRAINT "spy_availability-fk_spy_availability_abstract"
    FOREIGN KEY ("fk_availability_abstract")
    REFERENCES "spy_availability_abstract" ("id_availability_abstract");

ALTER TABLE "spy_availability" ADD CONSTRAINT "spy_availability-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_availability_notification_subscription" ADD CONSTRAINT "spy_availability_notification_subscription-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_availability_notification_subscription" ADD CONSTRAINT "spy_availability_notification_subscription-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_category" ADD CONSTRAINT "spy_category_fk_7e2c46"
    FOREIGN KEY ("fk_category_template")
    REFERENCES "spy_category_template" ("id_category_template");

ALTER TABLE "spy_category_attribute" ADD CONSTRAINT "spy_category_attribute_fk_12b6d0"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_category_attribute" ADD CONSTRAINT "spy_category_attribute_fk_723c48"
    FOREIGN KEY ("fk_category")
    REFERENCES "spy_category" ("id_category");

ALTER TABLE "spy_category_node" ADD CONSTRAINT "spy_category_node_fk_b54a47"
    FOREIGN KEY ("fk_parent_category_node")
    REFERENCES "spy_category_node" ("id_category_node");

ALTER TABLE "spy_category_node" ADD CONSTRAINT "spy_category_node_fk_723c48"
    FOREIGN KEY ("fk_category")
    REFERENCES "spy_category" ("id_category");

ALTER TABLE "spy_category_closure_table" ADD CONSTRAINT "spy_category_closure_table_fk_d3e44d"
    FOREIGN KEY ("fk_category_node")
    REFERENCES "spy_category_node" ("id_category_node");

ALTER TABLE "spy_category_closure_table" ADD CONSTRAINT "spy_category_closure_table_fk_a3476a"
    FOREIGN KEY ("fk_category_node_descendant")
    REFERENCES "spy_category_node" ("id_category_node");

ALTER TABLE "spy_category_image_set" ADD CONSTRAINT "spy_category_image_set-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_category_image_set" ADD CONSTRAINT "spy_category_image_set-fk_category"
    FOREIGN KEY ("fk_category")
    REFERENCES "spy_category" ("id_category");

ALTER TABLE "spy_category_image_set_to_category_image" ADD CONSTRAINT "spy_category_image_set_to_category_image-fk_category_image_set"
    FOREIGN KEY ("fk_category_image_set")
    REFERENCES "spy_category_image_set" ("id_category_image_set");

ALTER TABLE "spy_category_image_set_to_category_image" ADD CONSTRAINT "spy_category_image_set_to_category_image-fk_category_image"
    FOREIGN KEY ("fk_category_image")
    REFERENCES "spy_category_image" ("id_category_image");

ALTER TABLE "spy_cms_page" ADD CONSTRAINT "spy_cms_page-fk_template"
    FOREIGN KEY ("fk_template")
    REFERENCES "spy_cms_template" ("id_cms_template")
    ON DELETE CASCADE;

ALTER TABLE "spy_cms_page_localized_attributes" ADD CONSTRAINT "spy_cms_page_localized_attributes-fk_cms_page"
    FOREIGN KEY ("fk_cms_page")
    REFERENCES "spy_cms_page" ("id_cms_page")
    ON UPDATE CASCADE
    ON DELETE CASCADE;

ALTER TABLE "spy_cms_page_localized_attributes" ADD CONSTRAINT "spy_cms_page_localized_attributes-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_cms_glossary_key_mapping" ADD CONSTRAINT "spy_cms_glossary_key_mapping-fk_page"
    FOREIGN KEY ("fk_page")
    REFERENCES "spy_cms_page" ("id_cms_page")
    ON DELETE CASCADE;

ALTER TABLE "spy_cms_glossary_key_mapping" ADD CONSTRAINT "spy_cms_glossary_key_mapping-fk_glossary_key"
    FOREIGN KEY ("fk_glossary_key")
    REFERENCES "spy_glossary_key" ("id_glossary_key")
    ON DELETE CASCADE;

ALTER TABLE "spy_cms_version" ADD CONSTRAINT "spy_cms_version-fk_cms_page"
    FOREIGN KEY ("fk_cms_page")
    REFERENCES "spy_cms_page" ("id_cms_page")
    ON DELETE CASCADE;

ALTER TABLE "spy_cms_version" ADD CONSTRAINT "spy_cms_version-fk_user"
    FOREIGN KEY ("fk_user")
    REFERENCES "spy_user" ("id_user");

ALTER TABLE "spy_cms_page_store" ADD CONSTRAINT "spy_cms_page_store-fk_cms_page"
    FOREIGN KEY ("fk_cms_page")
    REFERENCES "spy_cms_page" ("id_cms_page");

ALTER TABLE "spy_cms_page_store" ADD CONSTRAINT "spy_cms_page_store-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_cms_block_glossary_key_mapping" ADD CONSTRAINT "spy_cms_block_glossary_key_mapping-fk_cms_block"
    FOREIGN KEY ("fk_cms_block")
    REFERENCES "spy_cms_block" ("id_cms_block")
    ON DELETE CASCADE;

ALTER TABLE "spy_cms_block_glossary_key_mapping" ADD CONSTRAINT "spy_cms_block_glossary_key_mapping-fk_glossary_key"
    FOREIGN KEY ("fk_glossary_key")
    REFERENCES "spy_glossary_key" ("id_glossary_key")
    ON DELETE CASCADE;

ALTER TABLE "spy_cms_block" ADD CONSTRAINT "spy_cms_block-fk_template"
    FOREIGN KEY ("fk_template")
    REFERENCES "spy_cms_block_template" ("id_cms_block_template")
    ON DELETE CASCADE;

ALTER TABLE "spy_cms_block_store" ADD CONSTRAINT "spy_cms_block_store-fk_cms_block"
    FOREIGN KEY ("fk_cms_block")
    REFERENCES "spy_cms_block" ("id_cms_block");

ALTER TABLE "spy_cms_block_store" ADD CONSTRAINT "spy_cms_block_store-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_cms_block_category_connector" ADD CONSTRAINT "spy_cms_block_category_connector-fk_cms_block"
    FOREIGN KEY ("fk_cms_block")
    REFERENCES "spy_cms_block" ("id_cms_block")
    ON DELETE CASCADE;

ALTER TABLE "spy_cms_block_category_connector" ADD CONSTRAINT "spy_cms_block_category_connector-fk_category"
    FOREIGN KEY ("fk_category")
    REFERENCES "spy_category" ("id_category")
    ON DELETE CASCADE;

ALTER TABLE "spy_cms_block_category_connector" ADD CONSTRAINT "spy_cms_block_category_connector-fk_category_template"
    FOREIGN KEY ("fk_category_template")
    REFERENCES "spy_category_template" ("id_category_template")
    ON DELETE CASCADE;

ALTER TABLE "spy_cms_block_category_connector" ADD CONSTRAINT "spy_cms_block_category_connector-fk_cms_block_category_position"
    FOREIGN KEY ("fk_cms_block_category_position")
    REFERENCES "spy_cms_block_category_position" ("id_cms_block_category_position")
    ON DELETE CASCADE;

ALTER TABLE "spy_cms_block_product_connector" ADD CONSTRAINT "spy_cms_block_product_connector-fk_cms_block"
    FOREIGN KEY ("fk_cms_block")
    REFERENCES "spy_cms_block" ("id_cms_block")
    ON DELETE CASCADE;

ALTER TABLE "spy_cms_block_product_connector" ADD CONSTRAINT "spy_cms_block_product_connector-fk_product_abstract"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract")
    ON DELETE CASCADE;

ALTER TABLE "spy_content_localized" ADD CONSTRAINT "spy_content_localized-fk_content"
    FOREIGN KEY ("fk_content")
    REFERENCES "spy_content" ("id_content");

ALTER TABLE "spy_content_localized" ADD CONSTRAINT "spy_content_localized-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_region" ADD CONSTRAINT "spy_region-fk_country"
    FOREIGN KEY ("fk_country")
    REFERENCES "spy_country" ("id_country");

ALTER TABLE "spy_customer" ADD CONSTRAINT "spy_customer-default_billing_address"
    FOREIGN KEY ("default_billing_address")
    REFERENCES "spy_customer_address" ("id_customer_address")
    ON DELETE SET NULL;

ALTER TABLE "spy_customer" ADD CONSTRAINT "spy_customer-default_shipping_address"
    FOREIGN KEY ("default_shipping_address")
    REFERENCES "spy_customer_address" ("id_customer_address")
    ON DELETE SET NULL;

ALTER TABLE "spy_customer" ADD CONSTRAINT "spy_customer-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_customer" ADD CONSTRAINT "spy_customer-fk_user"
    FOREIGN KEY ("fk_user")
    REFERENCES "spy_user" ("id_user");

ALTER TABLE "spy_customer_address" ADD CONSTRAINT "spy_customer_address-fk_customer"
    FOREIGN KEY ("fk_customer")
    REFERENCES "spy_customer" ("id_customer")
    ON DELETE CASCADE;

ALTER TABLE "spy_customer_address" ADD CONSTRAINT "spy_customer_address-fk_region"
    FOREIGN KEY ("fk_region")
    REFERENCES "spy_region" ("id_region");

ALTER TABLE "spy_customer_address" ADD CONSTRAINT "spy_customer_address-fk_country"
    FOREIGN KEY ("fk_country")
    REFERENCES "spy_country" ("id_country");

ALTER TABLE "spy_customer_group_to_customer" ADD CONSTRAINT "spy_customer_group_to_customer-fk_customer_group"
    FOREIGN KEY ("fk_customer_group")
    REFERENCES "spy_customer_group" ("id_customer_group")
    ON DELETE CASCADE;

ALTER TABLE "spy_customer_group_to_customer" ADD CONSTRAINT "spy_customer_group_to_customer-fk_customer"
    FOREIGN KEY ("fk_customer")
    REFERENCES "spy_customer" ("id_customer");

ALTER TABLE "spy_customer_note" ADD CONSTRAINT "spy_customer_note-fk_customer"
    FOREIGN KEY ("fk_customer")
    REFERENCES "spy_customer" ("id_customer");

ALTER TABLE "spy_customer_note" ADD CONSTRAINT "spy_customer_note-fk_user"
    FOREIGN KEY ("fk_user")
    REFERENCES "spy_user" ("id_user");

ALTER TABLE "spy_discount" ADD CONSTRAINT "spy_discount-fk_discount_voucher_pool"
    FOREIGN KEY ("fk_discount_voucher_pool")
    REFERENCES "spy_discount_voucher_pool" ("id_discount_voucher_pool");

ALTER TABLE "spy_discount" ADD CONSTRAINT "spy_discount-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_discount_store" ADD CONSTRAINT "spy_discount_store-fk_discount"
    FOREIGN KEY ("fk_discount")
    REFERENCES "spy_discount" ("id_discount");

ALTER TABLE "spy_discount_store" ADD CONSTRAINT "spy_discount_store-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_discount_voucher" ADD CONSTRAINT "spy_discount_voucher-fk_discount_voucher_pool"
    FOREIGN KEY ("fk_discount_voucher_pool")
    REFERENCES "spy_discount_voucher_pool" ("id_discount_voucher_pool");

ALTER TABLE "spy_discount_amount" ADD CONSTRAINT "spy_discount_amount-fk_currency"
    FOREIGN KEY ("fk_currency")
    REFERENCES "spy_currency" ("id_currency");

ALTER TABLE "spy_discount_amount" ADD CONSTRAINT "spy_discount_amount-fk_discount"
    FOREIGN KEY ("fk_discount")
    REFERENCES "spy_discount" ("id_discount");

ALTER TABLE "spy_discount_promotion" ADD CONSTRAINT "spy_discount_promotion-fk_discount"
    FOREIGN KEY ("fk_discount")
    REFERENCES "spy_discount" ("id_discount");

ALTER TABLE "pyz_example_state_machine_item" ADD CONSTRAINT "pyz_example_state_machine_item-fk_state_machine_item_state"
    FOREIGN KEY ("fk_state_machine_item_state")
    REFERENCES "spy_state_machine_item_state" ("id_state_machine_item_state");

ALTER TABLE "spy_file" ADD CONSTRAINT "spy_file-fk_file_directory"
    FOREIGN KEY ("fk_file_directory")
    REFERENCES "spy_file_directory" ("id_file_directory");

ALTER TABLE "spy_file_info" ADD CONSTRAINT "spy_file_info-fk_file"
    FOREIGN KEY ("fk_file")
    REFERENCES "spy_file" ("id_file")
    ON DELETE CASCADE;

ALTER TABLE "spy_file_localized_attributes" ADD CONSTRAINT "spy_file_localized_attributes-fk_file"
    FOREIGN KEY ("fk_file")
    REFERENCES "spy_file" ("id_file")
    ON UPDATE CASCADE
    ON DELETE CASCADE;

ALTER TABLE "spy_file_localized_attributes" ADD CONSTRAINT "spy_file_localized_attributes-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_file_directory" ADD CONSTRAINT "spy_file_directory_fk_47023d"
    FOREIGN KEY ("fk_parent_file_directory")
    REFERENCES "spy_file_directory" ("id_file_directory")
    ON DELETE CASCADE;

ALTER TABLE "spy_file_directory_localized_attributes" ADD CONSTRAINT "spy_file_directory_localized_attributes_fk_52d44c"
    FOREIGN KEY ("fk_file_directory")
    REFERENCES "spy_file_directory" ("id_file_directory")
    ON DELETE CASCADE;

ALTER TABLE "spy_file_directory_localized_attributes" ADD CONSTRAINT "spy_file_directory_localized_attributes_fk_12b6d0"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_gift_card_product_abstract_configuration_link" ADD CONSTRAINT "spy_gift_card_product_abstract_conf_link-fk_product_abstract"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract");

ALTER TABLE "spy_gift_card_product_abstract_configuration_link" ADD CONSTRAINT "spy_gift_card_pa_conf_link-fk_gift_card_pa_conf"
    FOREIGN KEY ("fk_gift_card_product_abstract_configuration")
    REFERENCES "spy_gift_card_product_abstract_configuration" ("id_gift_card_product_abstract_configuration");

ALTER TABLE "spy_gift_card_product_configuration_link" ADD CONSTRAINT "spy_gift_card_product_configuration_link-fk_product"
    FOREIGN KEY ("fk_product")
    REFERENCES "spy_product" ("id_product");

ALTER TABLE "spy_gift_card_product_configuration_link" ADD CONSTRAINT "spy_gift_card_p_conf_link-fk_gift_card_p_conf"
    FOREIGN KEY ("fk_gift_card_product_configuration")
    REFERENCES "spy_gift_card_product_configuration" ("id_gift_card_product_configuration");

ALTER TABLE "spy_payment_gift_card" ADD CONSTRAINT "spy_payment_gift_card-fk_payment"
    FOREIGN KEY ("fk_sales_payment")
    REFERENCES "spy_sales_payment" ("id_sales_payment");

ALTER TABLE "spy_gift_card_balance_log" ADD CONSTRAINT "spy_gift_card_balance_log-fk_gift_card"
    FOREIGN KEY ("fk_gift_card")
    REFERENCES "spy_gift_card" ("id_gift_card");

ALTER TABLE "spy_gift_card_balance_log" ADD CONSTRAINT "spy_gift_card_balance_log-fk_sales_order"
    FOREIGN KEY ("fk_sales_order")
    REFERENCES "spy_sales_order" ("id_sales_order");

ALTER TABLE "spy_glossary_translation" ADD CONSTRAINT "spy_glossary_translation-fk_glossary_key"
    FOREIGN KEY ("fk_glossary_key")
    REFERENCES "spy_glossary_key" ("id_glossary_key")
    ON DELETE CASCADE;

ALTER TABLE "spy_glossary_translation" ADD CONSTRAINT "spy_glossary_translation-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale")
    ON DELETE CASCADE;

ALTER TABLE "spy_navigation_node" ADD CONSTRAINT "spy_navigation_node_fk_07636b"
    FOREIGN KEY ("fk_parent_navigation_node")
    REFERENCES "spy_navigation_node" ("id_navigation_node")
    ON DELETE CASCADE;

ALTER TABLE "spy_navigation_node" ADD CONSTRAINT "spy_navigation_node_fk_6f985c"
    FOREIGN KEY ("fk_navigation")
    REFERENCES "spy_navigation" ("id_navigation")
    ON DELETE CASCADE;

ALTER TABLE "spy_navigation_node_localized_attributes" ADD CONSTRAINT "spy_navigation_node_localized_attributes_fk_43843f"
    FOREIGN KEY ("fk_navigation_node")
    REFERENCES "spy_navigation_node" ("id_navigation_node")
    ON DELETE CASCADE;

ALTER TABLE "spy_navigation_node_localized_attributes" ADD CONSTRAINT "spy_navigation_node_localized_attributes_fk_12b6d0"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_navigation_node_localized_attributes" ADD CONSTRAINT "spy_navigation_node_localized_attributes_fk_76593a"
    FOREIGN KEY ("fk_url")
    REFERENCES "spy_url" ("id_url");

ALTER TABLE "spy_newsletter_subscriber" ADD CONSTRAINT "spy_newsletter_subscriber-fk_customer"
    FOREIGN KEY ("fk_customer")
    REFERENCES "spy_customer" ("id_customer");

ALTER TABLE "spy_newsletter_subscription" ADD CONSTRAINT "spy_newsletter_subscription-fk_newsletter_subscriber"
    FOREIGN KEY ("fk_newsletter_subscriber")
    REFERENCES "spy_newsletter_subscriber" ("id_newsletter_subscriber");

ALTER TABLE "spy_newsletter_subscription" ADD CONSTRAINT "spy_newsletter_subscription-fk_newsletter_type"
    FOREIGN KEY ("fk_newsletter_type")
    REFERENCES "spy_newsletter_type" ("id_newsletter_type");

ALTER TABLE "spy_nopayment_paid" ADD CONSTRAINT "spy_nopayment_paid-fk_sales_order_item"
    FOREIGN KEY ("fk_sales_order_item")
    REFERENCES "spy_sales_order_item" ("id_sales_order_item");

ALTER TABLE "spy_oauth_access_token" ADD CONSTRAINT "spy_oauth_access_token-identifier"
    FOREIGN KEY ("fk_oauth_client")
    REFERENCES "spy_oauth_client" ("identifier");

ALTER TABLE "spy_oms_transition_log" ADD CONSTRAINT "spy_oms_transition_log-fk_sales_order"
    FOREIGN KEY ("fk_sales_order")
    REFERENCES "spy_sales_order" ("id_sales_order");

ALTER TABLE "spy_oms_transition_log" ADD CONSTRAINT "spy_oms_transition_log-fk_sales_order_item"
    FOREIGN KEY ("fk_sales_order_item")
    REFERENCES "spy_sales_order_item" ("id_sales_order_item");

ALTER TABLE "spy_oms_transition_log" ADD CONSTRAINT "spy_oms_transition_log-fk_oms_order_process"
    FOREIGN KEY ("fk_oms_order_process")
    REFERENCES "spy_oms_order_process" ("id_oms_order_process");

ALTER TABLE "spy_oms_order_item_state_history" ADD CONSTRAINT "spy_oms_order_item_state_history-fk_sales_order_item"
    FOREIGN KEY ("fk_sales_order_item")
    REFERENCES "spy_sales_order_item" ("id_sales_order_item");

ALTER TABLE "spy_oms_order_item_state_history" ADD CONSTRAINT "spy_oms_order_item_state_history-fk_oms_order_item_state"
    FOREIGN KEY ("fk_oms_order_item_state")
    REFERENCES "spy_oms_order_item_state" ("id_oms_order_item_state");

ALTER TABLE "spy_oms_event_timeout" ADD CONSTRAINT "spy_oms_event_timeout-fk_sales_order_item"
    FOREIGN KEY ("fk_sales_order_item")
    REFERENCES "spy_sales_order_item" ("id_sales_order_item");

ALTER TABLE "spy_oms_event_timeout" ADD CONSTRAINT "spy_oms_event_timeout-fk_oms_order_item_state"
    FOREIGN KEY ("fk_oms_order_item_state")
    REFERENCES "spy_oms_order_item_state" ("id_oms_order_item_state");

ALTER TABLE "spy_oms_product_reservation" ADD CONSTRAINT "spy_oms_product_reservation-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_price_product" ADD CONSTRAINT "spy_price_product-fk_product"
    FOREIGN KEY ("fk_product")
    REFERENCES "spy_product" ("id_product");

ALTER TABLE "spy_price_product" ADD CONSTRAINT "spy_price_product-fk_price_type"
    FOREIGN KEY ("fk_price_type")
    REFERENCES "spy_price_type" ("id_price_type");

ALTER TABLE "spy_price_product" ADD CONSTRAINT "spy_price_product-fk_product_abstract"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract");

ALTER TABLE "spy_price_product_store" ADD CONSTRAINT "spy_price_product_store-fk_currency"
    FOREIGN KEY ("fk_currency")
    REFERENCES "spy_currency" ("id_currency");

ALTER TABLE "spy_price_product_store" ADD CONSTRAINT "spy_price_product_store-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_price_product_store" ADD CONSTRAINT "spy_price_product_store-fk_price_product"
    FOREIGN KEY ("fk_price_product")
    REFERENCES "spy_price_product" ("id_price_product");

ALTER TABLE "spy_price_product_default" ADD CONSTRAINT "spy_price_product_default-fk_price_product_store"
    FOREIGN KEY ("fk_price_product_store")
    REFERENCES "spy_price_product_store" ("id_price_product_store")
    ON DELETE CASCADE;

ALTER TABLE "spy_price_product_schedule" ADD CONSTRAINT "spy_price_product_schedule-fk_product"
    FOREIGN KEY ("fk_product")
    REFERENCES "spy_product" ("id_product");

ALTER TABLE "spy_price_product_schedule" ADD CONSTRAINT "spy_price_product_schedule-fk_product_abstract"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract");

ALTER TABLE "spy_price_product_schedule" ADD CONSTRAINT "spy_price_product_schedule-fk_currency"
    FOREIGN KEY ("fk_currency")
    REFERENCES "spy_currency" ("id_currency");

ALTER TABLE "spy_price_product_schedule" ADD CONSTRAINT "spy_price_product_schedule-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_price_product_schedule" ADD CONSTRAINT "spy_price_product_schedule-fk_price_type"
    FOREIGN KEY ("fk_price_type")
    REFERENCES "spy_price_type" ("id_price_type");

ALTER TABLE "spy_price_product_schedule" ADD CONSTRAINT "spy_price_product_schedule-fk_price_product_schedule_list"
    FOREIGN KEY ("fk_price_product_schedule_list")
    REFERENCES "spy_price_product_schedule_list" ("id_price_product_schedule_list");

ALTER TABLE "spy_price_product_schedule_list" ADD CONSTRAINT "spy_price_product_schedule_list-fk_user"
    FOREIGN KEY ("fk_user")
    REFERENCES "spy_user" ("id_user");

ALTER TABLE "spy_product_abstract" ADD CONSTRAINT "spy_product_abstract-fk_tax_set"
    FOREIGN KEY ("fk_tax_set")
    REFERENCES "spy_tax_set" ("id_tax_set");

ALTER TABLE "spy_product_abstract_localized_attributes" ADD CONSTRAINT "spy_product_abstract_localized_attributes-fk_product_abstract"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract")
    ON UPDATE CASCADE
    ON DELETE CASCADE;

ALTER TABLE "spy_product_abstract_localized_attributes" ADD CONSTRAINT "spy_product_abstract_localized_attributes-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_product_abstract_store" ADD CONSTRAINT "spy_product_abstract_store-fk_product"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract");

ALTER TABLE "spy_product_abstract_store" ADD CONSTRAINT "spy_product_abstract_store-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_product" ADD CONSTRAINT "spy_product-fk_product_abstract"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract");

ALTER TABLE "spy_product_localized_attributes" ADD CONSTRAINT "spy_product_localized_attributes-fk_product"
    FOREIGN KEY ("fk_product")
    REFERENCES "spy_product" ("id_product")
    ON UPDATE CASCADE
    ON DELETE CASCADE;

ALTER TABLE "spy_product_localized_attributes" ADD CONSTRAINT "spy_product_localized_attributes-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_product_alternative" ADD CONSTRAINT "spy_product_alternative-fk_product"
    FOREIGN KEY ("fk_product")
    REFERENCES "spy_product" ("id_product");

ALTER TABLE "spy_product_alternative" ADD CONSTRAINT "spy_product_alternative-fk_product_abstract_alternative"
    FOREIGN KEY ("fk_product_abstract_alternative")
    REFERENCES "spy_product_abstract" ("id_product_abstract");

ALTER TABLE "spy_product_alternative" ADD CONSTRAINT "spy_product_alternative-fk_product_concrete_alternative"
    FOREIGN KEY ("fk_product_concrete_alternative")
    REFERENCES "spy_product" ("id_product");

ALTER TABLE "spy_product_management_attribute" ADD CONSTRAINT "spy_pim_attribute-fk_product_attribute_key"
    FOREIGN KEY ("fk_product_attribute_key")
    REFERENCES "spy_product_attribute_key" ("id_product_attribute_key");

ALTER TABLE "spy_product_management_attribute_value" ADD CONSTRAINT "spy_pim_attribute_value-fk_pim_attribute"
    FOREIGN KEY ("fk_product_management_attribute")
    REFERENCES "spy_product_management_attribute" ("id_product_management_attribute");

ALTER TABLE "spy_product_management_attribute_value_translation" ADD CONSTRAINT "spy_pim_attribute_value-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_product_management_attribute_value_translation" ADD CONSTRAINT "spy_pim_attribute_value_translation-fk_pim_attribute_value"
    FOREIGN KEY ("fk_product_management_attribute_value")
    REFERENCES "spy_product_management_attribute_value" ("id_product_management_attribute_value");

ALTER TABLE "spy_product_bundle" ADD CONSTRAINT "spy_product_bundle-fk_bundled_product"
    FOREIGN KEY ("fk_bundled_product")
    REFERENCES "spy_product" ("id_product")
    ON UPDATE CASCADE
    ON DELETE CASCADE;

ALTER TABLE "spy_product_bundle" ADD CONSTRAINT "spy_product_bundle-fk_product"
    FOREIGN KEY ("fk_product")
    REFERENCES "spy_product" ("id_product")
    ON UPDATE CASCADE
    ON DELETE CASCADE;

ALTER TABLE "spy_product_category" ADD CONSTRAINT "spy_product_category-fk_category"
    FOREIGN KEY ("fk_category")
    REFERENCES "spy_category" ("id_category");

ALTER TABLE "spy_product_category" ADD CONSTRAINT "spy_product_category-fk_product_abstract"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract");

ALTER TABLE "spy_product_category_filter" ADD CONSTRAINT "spy_product_category_filter-fk_category"
    FOREIGN KEY ("fk_category")
    REFERENCES "spy_category" ("id_category");

ALTER TABLE "spy_product_discontinued" ADD CONSTRAINT "spy_product_discontinued-fk_product"
    FOREIGN KEY ("fk_product")
    REFERENCES "spy_product" ("id_product");

ALTER TABLE "spy_product_discontinued_note" ADD CONSTRAINT "spy_product_discontinued_note-fk_product_discontinued"
    FOREIGN KEY ("fk_product_discontinued")
    REFERENCES "spy_product_discontinued" ("id_product_discontinued");

ALTER TABLE "spy_product_discontinued_note" ADD CONSTRAINT "spy_product_discontinued_note-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_product_abstract_group" ADD CONSTRAINT "spy_product_abstract_group-fk_product_group"
    FOREIGN KEY ("fk_product_group")
    REFERENCES "spy_product_group" ("id_product_group");

ALTER TABLE "spy_product_abstract_group" ADD CONSTRAINT "spy_product_abstract_group-fk_product_abstract"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract")
    ON DELETE CASCADE;

ALTER TABLE "spy_product_image_set" ADD CONSTRAINT "spy_product_image_set-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_product_image_set" ADD CONSTRAINT "spy_product_image_set-fk_product"
    FOREIGN KEY ("fk_product")
    REFERENCES "spy_product" ("id_product");

ALTER TABLE "spy_product_image_set" ADD CONSTRAINT "spy_product_image_set-fk_product_abstract"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract");

ALTER TABLE "spy_product_image_set" ADD CONSTRAINT "spy_product_image_set-fk_resource_product_set"
    FOREIGN KEY ("fk_resource_product_set")
    REFERENCES "spy_product_set" ("id_product_set");

ALTER TABLE "spy_product_image_set_to_product_image" ADD CONSTRAINT "spy_product_image_set_to_product_image-fk_product_image_set"
    FOREIGN KEY ("fk_product_image_set")
    REFERENCES "spy_product_image_set" ("id_product_image_set");

ALTER TABLE "spy_product_image_set_to_product_image" ADD CONSTRAINT "spy_product_image_set_to_product_image-fk_product_image"
    FOREIGN KEY ("fk_product_image")
    REFERENCES "spy_product_image" ("id_product_image");

ALTER TABLE "spy_product_label_localized_attributes" ADD CONSTRAINT "spy_product_label_localized_attributes_fk_3dcfb4"
    FOREIGN KEY ("fk_product_label")
    REFERENCES "spy_product_label" ("id_product_label");

ALTER TABLE "spy_product_label_localized_attributes" ADD CONSTRAINT "spy_product_label_localized_attributes_fk_12b6d0"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_product_label_product_abstract" ADD CONSTRAINT "spy_product_label_product_abstract_fk_3dcfb4"
    FOREIGN KEY ("fk_product_label")
    REFERENCES "spy_product_label" ("id_product_label");

ALTER TABLE "spy_product_label_product_abstract" ADD CONSTRAINT "spy_product_label_product_abstract_fk_371a4f"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract");

ALTER TABLE "spy_product_option_group" ADD CONSTRAINT "spy_product_option_group-fk_tax_set"
    FOREIGN KEY ("fk_tax_set")
    REFERENCES "spy_tax_set" ("id_tax_set")
    ON DELETE SET NULL;

ALTER TABLE "spy_product_abstract_product_option_group" ADD CONSTRAINT "spy_product_abstract-fk_product_abstract"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract");

ALTER TABLE "spy_product_abstract_product_option_group" ADD CONSTRAINT "spy_product_abstract-fk_product_option_group"
    FOREIGN KEY ("fk_product_option_group")
    REFERENCES "spy_product_option_group" ("id_product_option_group");

ALTER TABLE "spy_product_option_value" ADD CONSTRAINT "spy_product_option_value-fk_product_option_group"
    FOREIGN KEY ("fk_product_option_group")
    REFERENCES "spy_product_option_group" ("id_product_option_group");

ALTER TABLE "spy_product_option_value_price" ADD CONSTRAINT "spy_product_option_value_price-fk_currency"
    FOREIGN KEY ("fk_currency")
    REFERENCES "spy_currency" ("id_currency");

ALTER TABLE "spy_product_option_value_price" ADD CONSTRAINT "spy_product_option_value_price-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_product_option_value_price" ADD CONSTRAINT "spy_product_option_value_price-fk_product_option_value"
    FOREIGN KEY ("fk_product_option_value")
    REFERENCES "spy_product_option_value" ("id_product_option_value")
    ON DELETE CASCADE;

ALTER TABLE "spy_product_quantity" ADD CONSTRAINT "spy_product_quantity-fk_product"
    FOREIGN KEY ("fk_product")
    REFERENCES "spy_product" ("id_product");

ALTER TABLE "spy_product_relation" ADD CONSTRAINT "spy_product-relation-fk_product_abstract"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract");

ALTER TABLE "spy_product_relation" ADD CONSTRAINT "spy_product-relation-type-fk_product_abstract"
    FOREIGN KEY ("fk_product_relation_type")
    REFERENCES "spy_product_relation_type" ("id_product_relation_type");

ALTER TABLE "spy_product_relation_product_abstract" ADD CONSTRAINT "spy_product-rel-prod-rel-fk_product_relation"
    FOREIGN KEY ("fk_product_relation")
    REFERENCES "spy_product_relation" ("id_product_relation");

ALTER TABLE "spy_product_relation_product_abstract" ADD CONSTRAINT "spy_product-rel-prod-abs-fk_product_abstract"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract");

ALTER TABLE "spy_product_review" ADD CONSTRAINT "spy_product_review-fk_product_abstract"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract");

ALTER TABLE "spy_product_review" ADD CONSTRAINT "spy_product_review-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_product_search" ADD CONSTRAINT "spy_product_search-fk_product"
    FOREIGN KEY ("fk_product")
    REFERENCES "spy_product" ("id_product");

ALTER TABLE "spy_product_search" ADD CONSTRAINT "spy_product_search-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_product_search_attribute_map" ADD CONSTRAINT "spy_product_search_attribute_map-fk_product_attribute_key"
    FOREIGN KEY ("fk_product_attribute_key")
    REFERENCES "spy_product_attribute_key" ("id_product_attribute_key")
    ON DELETE CASCADE;

ALTER TABLE "spy_product_search_attribute" ADD CONSTRAINT "spy_product_search_attribute-fk_product_attribute_key"
    FOREIGN KEY ("fk_product_attribute_key")
    REFERENCES "spy_product_attribute_key" ("id_product_attribute_key");

ALTER TABLE "spy_product_abstract_set" ADD CONSTRAINT "spy_product_abstract_set-fk_product_set"
    FOREIGN KEY ("fk_product_set")
    REFERENCES "spy_product_set" ("id_product_set");

ALTER TABLE "spy_product_abstract_set" ADD CONSTRAINT "spy_product_abstract_set-fk_product_abstract"
    FOREIGN KEY ("fk_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract")
    ON DELETE CASCADE;

ALTER TABLE "spy_product_set_data" ADD CONSTRAINT "spy_product_set_data-fk_product_set"
    FOREIGN KEY ("fk_product_set")
    REFERENCES "spy_product_set" ("id_product_set")
    ON DELETE CASCADE;

ALTER TABLE "spy_product_set_data" ADD CONSTRAINT "spy_product_set_data-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_product_validity" ADD CONSTRAINT "spy_product_validity-fk_product"
    FOREIGN KEY ("fk_product")
    REFERENCES "spy_product" ("id_product");

ALTER TABLE "spy_quote" ADD CONSTRAINT "spy_quote-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_refund" ADD CONSTRAINT "spy_refund-fk_sales_order"
    FOREIGN KEY ("fk_sales_order")
    REFERENCES "spy_sales_order" ("id_sales_order");

ALTER TABLE "spy_sales_order" ADD CONSTRAINT "spy_sales_order-fk_sales_order_address_billing"
    FOREIGN KEY ("fk_sales_order_address_billing")
    REFERENCES "spy_sales_order_address" ("id_sales_order_address");

ALTER TABLE "spy_sales_order" ADD CONSTRAINT "spy_sales_order-fk_sales_order_address_shipping"
    FOREIGN KEY ("fk_sales_order_address_shipping")
    REFERENCES "spy_sales_order_address" ("id_sales_order_address");

ALTER TABLE "spy_sales_order" ADD CONSTRAINT "spy_sales_order-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_sales_order_item" ADD CONSTRAINT "spy_sales_order_item-fk_sales_order_item_bundle"
    FOREIGN KEY ("fk_sales_order_item_bundle")
    REFERENCES "spy_sales_order_item_bundle" ("id_sales_order_item_bundle");

ALTER TABLE "spy_sales_order_item" ADD CONSTRAINT "spy_sales_order_item-fk_sales_order"
    FOREIGN KEY ("fk_sales_order")
    REFERENCES "spy_sales_order" ("id_sales_order");

ALTER TABLE "spy_sales_order_item" ADD CONSTRAINT "spy_sales_order_item-fk_oms_order_item_state"
    FOREIGN KEY ("fk_oms_order_item_state")
    REFERENCES "spy_oms_order_item_state" ("id_oms_order_item_state");

ALTER TABLE "spy_sales_order_item" ADD CONSTRAINT "spy_sales_order_item-fk_oms_order_process"
    FOREIGN KEY ("fk_oms_order_process")
    REFERENCES "spy_oms_order_process" ("id_oms_order_process");

ALTER TABLE "spy_sales_discount" ADD CONSTRAINT "spy_sales_discount-fk_sales_order"
    FOREIGN KEY ("fk_sales_order")
    REFERENCES "spy_sales_order" ("id_sales_order");

ALTER TABLE "spy_sales_discount" ADD CONSTRAINT "spy_sales_discount-fk_sales_order_item"
    FOREIGN KEY ("fk_sales_order_item")
    REFERENCES "spy_sales_order_item" ("id_sales_order_item");

ALTER TABLE "spy_sales_discount" ADD CONSTRAINT "spy_sales_discount-fk_sales_expense"
    FOREIGN KEY ("fk_sales_expense")
    REFERENCES "spy_sales_expense" ("id_sales_expense");

ALTER TABLE "spy_sales_discount" ADD CONSTRAINT "spy_sales_discount-fk_sales_order_item_option"
    FOREIGN KEY ("fk_sales_order_item_option")
    REFERENCES "spy_sales_order_item_option" ("id_sales_order_item_option");

ALTER TABLE "spy_sales_discount_code" ADD CONSTRAINT "spy_sales_discount_code-fk_sales_discount"
    FOREIGN KEY ("fk_sales_discount")
    REFERENCES "spy_sales_discount" ("id_sales_discount");

ALTER TABLE "spy_sales_order_item_gift_card" ADD CONSTRAINT "spy_sales_order_item_gift_card-fk_sales_order_item"
    FOREIGN KEY ("fk_sales_order_item")
    REFERENCES "spy_sales_order_item" ("id_sales_order_item");

ALTER TABLE "spy_sales_order_item_option" ADD CONSTRAINT "spy_sales_order_item_option-fk_sales_order_item"
    FOREIGN KEY ("fk_sales_order_item")
    REFERENCES "spy_sales_order_item" ("id_sales_order_item");

ALTER TABLE "spy_sales_order_address" ADD CONSTRAINT "spy_sales_order_address-fk_country"
    FOREIGN KEY ("fk_country")
    REFERENCES "spy_country" ("id_country");

ALTER TABLE "spy_sales_order_address" ADD CONSTRAINT "spy_sales_order_address-fk_region"
    FOREIGN KEY ("fk_region")
    REFERENCES "spy_region" ("id_region");

ALTER TABLE "spy_sales_order_address_history" ADD CONSTRAINT "spy_sales_order_address_history-fk_country"
    FOREIGN KEY ("fk_country")
    REFERENCES "spy_country" ("id_country");

ALTER TABLE "spy_sales_order_address_history" ADD CONSTRAINT "spy_sales_order_address_history-fk_sales_order_address"
    FOREIGN KEY ("fk_sales_order_address")
    REFERENCES "spy_sales_order_address" ("id_sales_order_address");

ALTER TABLE "spy_sales_order_address_history" ADD CONSTRAINT "spy_sales_order_address_history-fk_region"
    FOREIGN KEY ("fk_region")
    REFERENCES "spy_region" ("id_region");

ALTER TABLE "spy_sales_order_totals" ADD CONSTRAINT "spy_sales_order_totals-fk_sales_order"
    FOREIGN KEY ("fk_sales_order")
    REFERENCES "spy_sales_order" ("id_sales_order");

ALTER TABLE "spy_sales_order_note" ADD CONSTRAINT "spy_sales_order_note-fk_sales_order"
    FOREIGN KEY ("fk_sales_order")
    REFERENCES "spy_sales_order" ("id_sales_order");

ALTER TABLE "spy_sales_order_comment" ADD CONSTRAINT "spy_sales_order_comment-fk_sales_order"
    FOREIGN KEY ("fk_sales_order")
    REFERENCES "spy_sales_order" ("id_sales_order");

ALTER TABLE "spy_sales_expense" ADD CONSTRAINT "spy_sales_expense-fk_sales_order"
    FOREIGN KEY ("fk_sales_order")
    REFERENCES "spy_sales_order" ("id_sales_order");

ALTER TABLE "spy_sales_order_item_metadata" ADD CONSTRAINT "spy_sales_order_item_metadata-fk_sales_order_item"
    FOREIGN KEY ("fk_sales_order_item")
    REFERENCES "spy_sales_order_item" ("id_sales_order_item");

ALTER TABLE "spy_sales_shipment" ADD CONSTRAINT "spy_sales_shipment-fk_sales_order"
    FOREIGN KEY ("fk_sales_order")
    REFERENCES "spy_sales_order" ("id_sales_order");

ALTER TABLE "spy_sales_shipment" ADD CONSTRAINT "spy_sales_shipment-fk_sales_expense"
    FOREIGN KEY ("fk_sales_expense")
    REFERENCES "spy_sales_expense" ("id_sales_expense");

ALTER TABLE "spy_sales_order_threshold" ADD CONSTRAINT "spy_sales_order_threshold-fk_sales_order_threshold_type"
    FOREIGN KEY ("fk_sales_order_threshold_type")
    REFERENCES "spy_sales_order_threshold_type" ("id_sales_order_threshold_type");

ALTER TABLE "spy_sales_order_threshold" ADD CONSTRAINT "spy_sales_order_threshold-fk_currency"
    FOREIGN KEY ("fk_currency")
    REFERENCES "spy_currency" ("id_currency");

ALTER TABLE "spy_sales_order_threshold" ADD CONSTRAINT "spy_sales_order_threshold-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_sales_order_threshold_tax_set" ADD CONSTRAINT "spy_sales_order_threshold_tax_set-fk_tax_set"
    FOREIGN KEY ("fk_tax_set")
    REFERENCES "spy_tax_set" ("id_tax_set");

ALTER TABLE "spy_sales_payment" ADD CONSTRAINT "spy_sales_payment-fk_sales_order"
    FOREIGN KEY ("fk_sales_order")
    REFERENCES "spy_sales_order" ("id_sales_order");

ALTER TABLE "spy_sales_payment" ADD CONSTRAINT "spy_sales_payment-fk_sales_payment_method_type"
    FOREIGN KEY ("fk_sales_payment_method_type")
    REFERENCES "spy_sales_payment_method_type" ("id_sales_payment_method_type");

ALTER TABLE "spy_sales_reclamation" ADD CONSTRAINT "spy_sales_reclamation-fk_sales_order"
    FOREIGN KEY ("fk_sales_order")
    REFERENCES "spy_sales_order" ("id_sales_order");

ALTER TABLE "spy_sales_reclamation_item" ADD CONSTRAINT "spy_sales_reclamation_item-fk_sales_reclamation"
    FOREIGN KEY ("fk_sales_reclamation")
    REFERENCES "spy_sales_reclamation" ("id_sales_reclamation");

ALTER TABLE "spy_sales_reclamation_item" ADD CONSTRAINT "spy_sales_reclamation_item-fk_sales_order_item"
    FOREIGN KEY ("fk_sales_order_item")
    REFERENCES "spy_sales_order_item" ("id_sales_order_item");

ALTER TABLE "spy_shipment_method" ADD CONSTRAINT "spy_shipment_method-fk_shipment_carrier"
    FOREIGN KEY ("fk_shipment_carrier")
    REFERENCES "spy_shipment_carrier" ("id_shipment_carrier");

ALTER TABLE "spy_shipment_method" ADD CONSTRAINT "spy_shipment_method-fk_tax_set"
    FOREIGN KEY ("fk_tax_set")
    REFERENCES "spy_tax_set" ("id_tax_set");

ALTER TABLE "spy_shipment_method_price" ADD CONSTRAINT "spy_shipment_method_price-fk_currency"
    FOREIGN KEY ("fk_currency")
    REFERENCES "spy_currency" ("id_currency");

ALTER TABLE "spy_shipment_method_price" ADD CONSTRAINT "spy_shipment_method_price-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_shipment_method_price" ADD CONSTRAINT "spy_shipment_method_price-fk_shipment_method"
    FOREIGN KEY ("fk_shipment_method")
    REFERENCES "spy_shipment_method" ("id_shipment_method");

ALTER TABLE "spy_state_machine_transition_log" ADD CONSTRAINT "spy_state_machine_transition_log-fk_state_machine_process"
    FOREIGN KEY ("fk_state_machine_process")
    REFERENCES "spy_state_machine_process" ("id_state_machine_process");

ALTER TABLE "spy_state_machine_item_state" ADD CONSTRAINT "spy_state_machine_item_state-fk_state_machine_process"
    FOREIGN KEY ("fk_state_machine_process")
    REFERENCES "spy_state_machine_process" ("id_state_machine_process");

ALTER TABLE "spy_state_machine_item_state_history" ADD CONSTRAINT "spy_state_machine_item_state_h-fk_state_machine_item_state"
    FOREIGN KEY ("fk_state_machine_item_state")
    REFERENCES "spy_state_machine_item_state" ("id_state_machine_item_state");

ALTER TABLE "spy_state_machine_event_timeout" ADD CONSTRAINT "spy_state_machine_event_timeout-fk_state_machine_item_state"
    FOREIGN KEY ("fk_state_machine_item_state")
    REFERENCES "spy_state_machine_item_state" ("id_state_machine_item_state");

ALTER TABLE "spy_state_machine_event_timeout" ADD CONSTRAINT "spy_state_machine_event_timeout-fk_state_machine_process"
    FOREIGN KEY ("fk_state_machine_process")
    REFERENCES "spy_state_machine_process" ("id_state_machine_process");

ALTER TABLE "spy_stock_product" ADD CONSTRAINT "spy_stock_product-fk_product"
    FOREIGN KEY ("fk_product")
    REFERENCES "spy_product" ("id_product");

ALTER TABLE "spy_stock_product" ADD CONSTRAINT "spy_stock_product-fk_stock"
    FOREIGN KEY ("fk_stock")
    REFERENCES "spy_stock" ("id_stock");

ALTER TABLE "spy_tax_rate" ADD CONSTRAINT "spy_tax_rate-fk_country"
    FOREIGN KEY ("fk_country")
    REFERENCES "spy_country" ("id_country");

ALTER TABLE "spy_tax_set_tax" ADD CONSTRAINT "spy_tax_set_tax-fk_tax_set"
    FOREIGN KEY ("fk_tax_set")
    REFERENCES "spy_tax_set" ("id_tax_set")
    ON DELETE CASCADE;

ALTER TABLE "spy_tax_set_tax" ADD CONSTRAINT "spy_tax_set_tax-fk_tax_rate"
    FOREIGN KEY ("fk_tax_rate")
    REFERENCES "spy_tax_rate" ("id_tax_rate");

ALTER TABLE "spy_touch_storage" ADD CONSTRAINT "spy_touch_storage-fk_touch"
    FOREIGN KEY ("fk_touch")
    REFERENCES "spy_touch" ("id_touch");

ALTER TABLE "spy_touch_storage" ADD CONSTRAINT "spy_touch_storage-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_touch_storage" ADD CONSTRAINT "spy_touch_storage-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_touch_search" ADD CONSTRAINT "spy_touch_search-fk_touch"
    FOREIGN KEY ("fk_touch")
    REFERENCES "spy_touch" ("id_touch");

ALTER TABLE "spy_touch_search" ADD CONSTRAINT "spy_touch_search-fk_store"
    FOREIGN KEY ("fk_store")
    REFERENCES "spy_store" ("id_store");

ALTER TABLE "spy_touch_search" ADD CONSTRAINT "spy_touch_search-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_url" ADD CONSTRAINT "spy_url-fk_resource_categorynode"
    FOREIGN KEY ("fk_resource_categorynode")
    REFERENCES "spy_category_node" ("id_category_node")
    ON DELETE CASCADE;

ALTER TABLE "spy_url" ADD CONSTRAINT "spy_url-fk_resource_page"
    FOREIGN KEY ("fk_resource_page")
    REFERENCES "spy_cms_page" ("id_cms_page")
    ON DELETE CASCADE;

ALTER TABLE "spy_url" ADD CONSTRAINT "spy_url-fk_resource_product_set"
    FOREIGN KEY ("fk_resource_product_set")
    REFERENCES "spy_product_set" ("id_product_set")
    ON DELETE CASCADE;

ALTER TABLE "spy_url" ADD CONSTRAINT "spy_url-fk_resource_product_abstract"
    FOREIGN KEY ("fk_resource_product_abstract")
    REFERENCES "spy_product_abstract" ("id_product_abstract")
    ON DELETE CASCADE;

ALTER TABLE "spy_url" ADD CONSTRAINT "spy_url-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale")
    ON DELETE CASCADE;

ALTER TABLE "spy_url" ADD CONSTRAINT "spy_url-fk_resource_redirect"
    FOREIGN KEY ("fk_resource_redirect")
    REFERENCES "spy_url_redirect" ("id_url_redirect")
    ON DELETE CASCADE;

ALTER TABLE "spy_user" ADD CONSTRAINT "spy_user-fk_locale"
    FOREIGN KEY ("fk_locale")
    REFERENCES "spy_locale" ("id_locale");

ALTER TABLE "spy_wishlist" ADD CONSTRAINT "spy_wishlist-fk_customer"
    FOREIGN KEY ("fk_customer")
    REFERENCES "spy_customer" ("id_customer");

ALTER TABLE "spy_wishlist_item" ADD CONSTRAINT "spy_wishlist_item-fk_wishlist"
    FOREIGN KEY ("fk_wishlist")
    REFERENCES "spy_wishlist" ("id_wishlist");

ALTER TABLE "spy_wishlist_item" ADD CONSTRAINT "spy_wishlist_item-sku"
    FOREIGN KEY ("sku")
    REFERENCES "spy_product" ("sku");

COMMIT;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'zed' => '
BEGIN;

DROP TABLE IF EXISTS "spy_acl_role" CASCADE;

DROP SEQUENCE "spy_acl_role_pk_seq";

DROP TABLE IF EXISTS "spy_acl_rule" CASCADE;

DROP SEQUENCE "spy_acl_rule_pk_seq";

DROP TABLE IF EXISTS "spy_acl_group" CASCADE;

DROP SEQUENCE "spy_acl_group_pk_seq";

DROP TABLE IF EXISTS "spy_acl_user_has_group" CASCADE;

DROP TABLE IF EXISTS "spy_acl_groups_has_roles" CASCADE;

DROP TABLE IF EXISTS "spy_auth_reset_password" CASCADE;

DROP SEQUENCE "spy_auth_reset_password_pk_seq";

DROP TABLE IF EXISTS "spy_availability_abstract" CASCADE;

DROP SEQUENCE "spy_availability_abstract_pk_seq";

DROP TABLE IF EXISTS "spy_availability" CASCADE;

DROP SEQUENCE "spy_availability_pk_seq";

DROP TABLE IF EXISTS "spy_availability_storage" CASCADE;

DROP SEQUENCE "spy_availability_storage_pk_seq";

DROP TABLE IF EXISTS "spy_availability_notification_subscription" CASCADE;

DROP SEQUENCE "id_availability_notification_subscription_pk_seq";

DROP TABLE IF EXISTS "spy_category" CASCADE;

DROP SEQUENCE "spy_category_pk_seq";

DROP TABLE IF EXISTS "spy_category_attribute" CASCADE;

DROP SEQUENCE "spy_category_attribute_pk_seq";

DROP TABLE IF EXISTS "spy_category_node" CASCADE;

DROP SEQUENCE "spy_category_node_pk_seq";

DROP TABLE IF EXISTS "spy_category_closure_table" CASCADE;

DROP SEQUENCE "spy_category_closure_table_pk_seq";

DROP TABLE IF EXISTS "spy_category_image_set" CASCADE;

DROP SEQUENCE "spy_category_image_set_pk_seq";

DROP TABLE IF EXISTS "spy_category_image" CASCADE;

DROP SEQUENCE "spy_category_image_pk_seq";

DROP TABLE IF EXISTS "spy_category_image_set_to_category_image" CASCADE;

DROP SEQUENCE "spy_category_image_set_to_category_image_pk_seq";

DROP TABLE IF EXISTS "spy_category_image_storage" CASCADE;

DROP SEQUENCE "spy_category_image_storage_pk_seq";

DROP TABLE IF EXISTS "spy_category_node_page_search" CASCADE;

DROP SEQUENCE "spy_category_node_page_search_pk_seq";

DROP TABLE IF EXISTS "spy_category_tree_storage" CASCADE;

DROP SEQUENCE "spy_category_tree_storage_pk_seq";

DROP TABLE IF EXISTS "spy_category_node_storage" CASCADE;

DROP SEQUENCE "spy_category_node_storage_pk_seq";

DROP TABLE IF EXISTS "spy_category_template" CASCADE;

DROP SEQUENCE "spy_category_template_pk_seq";

DROP TABLE IF EXISTS "spy_cms_template" CASCADE;

DROP SEQUENCE "spy_cms_template_pk_seq";

DROP TABLE IF EXISTS "spy_cms_page" CASCADE;

DROP SEQUENCE "spy_cms_page_pk_seq";

DROP TABLE IF EXISTS "spy_cms_page_localized_attributes" CASCADE;

DROP SEQUENCE "spy_cms_page_localized_attributes_pk_seq";

DROP TABLE IF EXISTS "spy_cms_glossary_key_mapping" CASCADE;

DROP SEQUENCE "spy_cms_glossary_key_mapping_pk_seq";

DROP TABLE IF EXISTS "spy_cms_version" CASCADE;

DROP SEQUENCE "spy_cms_version_pk_seq";

DROP TABLE IF EXISTS "spy_cms_page_store" CASCADE;

DROP SEQUENCE "id_cms_page_store_pk_seq";

DROP TABLE IF EXISTS "spy_cms_block_template" CASCADE;

DROP SEQUENCE "spy_cms_block_template_pk_seq";

DROP TABLE IF EXISTS "spy_cms_block_glossary_key_mapping" CASCADE;

DROP SEQUENCE "spy_cms_block_glossary_key_mapping_pk_seq";

DROP TABLE IF EXISTS "spy_cms_block" CASCADE;

DROP SEQUENCE "spy_cms_block_pk_seq";

DROP TABLE IF EXISTS "spy_cms_block_store" CASCADE;

DROP SEQUENCE "id_cms_block_store_pk_seq";

DROP TABLE IF EXISTS "spy_cms_block_category_connector" CASCADE;

DROP SEQUENCE "spy_cms_block_category_connector_pk_seq";

DROP TABLE IF EXISTS "spy_cms_block_category_position" CASCADE;

DROP SEQUENCE "spy_cms_block_category_position_pk_seq";

DROP TABLE IF EXISTS "spy_cms_block_category_storage" CASCADE;

DROP SEQUENCE "spy_cms_block_category_storage_pk_seq";

DROP TABLE IF EXISTS "spy_cms_block_product_connector" CASCADE;

DROP SEQUENCE "spy_cms_block_product_connector_pk_seq";

DROP TABLE IF EXISTS "spy_cms_block_product_storage" CASCADE;

DROP SEQUENCE "spy_cms_block_product_storage_pk_seq";

DROP TABLE IF EXISTS "spy_cms_block_storage" CASCADE;

DROP SEQUENCE "spy_cms_block_storage_pk_seq";

DROP TABLE IF EXISTS "spy_cms_page_search" CASCADE;

DROP SEQUENCE "spy_cms_page_search_pk_seq";

DROP TABLE IF EXISTS "spy_cms_page_storage" CASCADE;

DROP SEQUENCE "spy_cms_page_storage_pk_seq";

DROP TABLE IF EXISTS "spy_content" CASCADE;

DROP SEQUENCE "spy_content_pk_seq";

DROP TABLE IF EXISTS "spy_content_localized" CASCADE;

DROP SEQUENCE "spy_content_localized_pk_seq";

DROP TABLE IF EXISTS "spy_content_storage" CASCADE;

DROP SEQUENCE "spy_content_storage_pk_seq";

DROP TABLE IF EXISTS "spy_country" CASCADE;

DROP SEQUENCE "spy_country_pk_seq";

DROP TABLE IF EXISTS "spy_region" CASCADE;

DROP SEQUENCE "spy_region_pk_seq";

DROP TABLE IF EXISTS "spy_currency" CASCADE;

DROP SEQUENCE "spy_currency_pk_seq";

DROP TABLE IF EXISTS "spy_customer" CASCADE;

DROP SEQUENCE "spy_customer_pk_seq";

DROP TABLE IF EXISTS "spy_customer_address" CASCADE;

DROP SEQUENCE "spy_customer_address_pk_seq";

DROP TABLE IF EXISTS "spy_customer_group" CASCADE;

DROP SEQUENCE "spy_customer_group_pk_seq";

DROP TABLE IF EXISTS "spy_customer_group_to_customer" CASCADE;

DROP SEQUENCE "spy_customer_group_to_customer_pk_seq";

DROP TABLE IF EXISTS "spy_customer_note" CASCADE;

DROP SEQUENCE "spy_customer_note_pk_seq";

DROP TABLE IF EXISTS "spy_discount" CASCADE;

DROP SEQUENCE "spy_discount_pk_seq";

DROP TABLE IF EXISTS "spy_discount_store" CASCADE;

DROP SEQUENCE "id_discount_store_pk_seq";

DROP TABLE IF EXISTS "spy_discount_voucher_pool" CASCADE;

DROP SEQUENCE "spy_discount_voucher_pool_pk_seq";

DROP TABLE IF EXISTS "spy_discount_voucher" CASCADE;

DROP SEQUENCE "spy_discount_voucher_pk_seq";

DROP TABLE IF EXISTS "spy_discount_amount" CASCADE;

DROP SEQUENCE "spy_discount_amount_pk_seq";

DROP TABLE IF EXISTS "spy_discount_promotion" CASCADE;

DROP SEQUENCE "spy_discount_promotion_pk_seq";

DROP TABLE IF EXISTS "spy_event_behavior_entity_change" CASCADE;

DROP SEQUENCE "spy_event_behavior_entity_change_pk_seq";

DROP TABLE IF EXISTS "pyz_example_state_machine_item" CASCADE;

DROP SEQUENCE "pyz_example_state_machine_item_pk_seq";

DROP TABLE IF EXISTS "spy_file" CASCADE;

DROP SEQUENCE "spy_file_pk_seq";

DROP TABLE IF EXISTS "spy_file_info" CASCADE;

DROP SEQUENCE "spy_file_info_pk_seq";

DROP TABLE IF EXISTS "spy_file_localized_attributes" CASCADE;

DROP SEQUENCE "spy_file_localized_attributes_pk_seq";

DROP TABLE IF EXISTS "spy_file_directory" CASCADE;

DROP SEQUENCE "spy_file_directory_pk_seq";

DROP TABLE IF EXISTS "spy_file_directory_localized_attributes" CASCADE;

DROP SEQUENCE "spy_file_directory_localized_attributes_pk_seq";

DROP TABLE IF EXISTS "spy_mime_type" CASCADE;

DROP SEQUENCE "spy_mime_type_pk_seq";

DROP TABLE IF EXISTS "spy_file_storage" CASCADE;

DROP SEQUENCE "spy_file_storage_pk_seq";

DROP TABLE IF EXISTS "spy_gift_card" CASCADE;

DROP SEQUENCE "spy_gift_card_pk_seq";

DROP TABLE IF EXISTS "spy_gift_card_product_abstract_configuration" CASCADE;

DROP SEQUENCE "spy_gift_card_product_abstract_configuration_pk_seq";

DROP TABLE IF EXISTS "spy_gift_card_product_abstract_configuration_link" CASCADE;

DROP SEQUENCE "spy_gift_card_product_abstract_configuration_link_pk_seq";

DROP TABLE IF EXISTS "spy_gift_card_product_configuration" CASCADE;

DROP SEQUENCE "spy_gift_card_product_configuration_pk_seq";

DROP TABLE IF EXISTS "spy_gift_card_product_configuration_link" CASCADE;

DROP SEQUENCE "spy_gift_card_product_configuration_link_pk_seq";

DROP TABLE IF EXISTS "spy_payment_gift_card" CASCADE;

DROP SEQUENCE "spy_payment_gift_card_pk_seq";

DROP TABLE IF EXISTS "spy_gift_card_balance_log" CASCADE;

DROP SEQUENCE "spy_gift_card_balance_log_pk_seq";

DROP TABLE IF EXISTS "spy_glossary_key" CASCADE;

DROP SEQUENCE "spy_glossary_key_pk_seq";

DROP TABLE IF EXISTS "spy_glossary_translation" CASCADE;

DROP SEQUENCE "spy_glossary_translation_pk_seq";

DROP TABLE IF EXISTS "spy_glossary_storage" CASCADE;

DROP SEQUENCE "spy_glossary_storage_pk_seq";

DROP TABLE IF EXISTS "spy_locale" CASCADE;

DROP SEQUENCE "spy_locale_pk_seq";

DROP TABLE IF EXISTS "spy_navigation" CASCADE;

DROP SEQUENCE "spy_navigation_pk_seq";

DROP TABLE IF EXISTS "spy_navigation_node" CASCADE;

DROP SEQUENCE "spy_navigation_node_pk_seq";

DROP TABLE IF EXISTS "spy_navigation_node_localized_attributes" CASCADE;

DROP SEQUENCE "spy_navigation_node_localized_attributes_pk_seq";

DROP TABLE IF EXISTS "spy_navigation_storage" CASCADE;

DROP SEQUENCE "spy_navigation_storage_pk_seq";

DROP TABLE IF EXISTS "spy_newsletter_subscriber" CASCADE;

DROP SEQUENCE "spy_newsletter_subscriber_pk_seq";

DROP TABLE IF EXISTS "spy_newsletter_type" CASCADE;

DROP SEQUENCE "spy_newsletter_type_pk_seq";

DROP TABLE IF EXISTS "spy_newsletter_subscription" CASCADE;

DROP TABLE IF EXISTS "spy_nopayment_paid" CASCADE;

DROP SEQUENCE "spy_nopayment_paid_pk_seq";

DROP TABLE IF EXISTS "spy_oauth_access_token" CASCADE;

DROP SEQUENCE "spy_oauth_access_token_pk_seq";

DROP TABLE IF EXISTS "spy_oauth_client" CASCADE;

DROP SEQUENCE "spy_oauth_client_pk_seq";

DROP TABLE IF EXISTS "spy_oauth_scope" CASCADE;

DROP SEQUENCE "spy_oauth_scope_pk_seq";

DROP TABLE IF EXISTS "spy_oms_transition_log" CASCADE;

DROP SEQUENCE "spy_oms_transition_log_pk_seq";

DROP TABLE IF EXISTS "spy_oms_order_process" CASCADE;

DROP SEQUENCE "spy_oms_order_process_pk_seq";

DROP TABLE IF EXISTS "spy_oms_state_machine_lock" CASCADE;

DROP SEQUENCE "spy_oms_state_machine_lock_pk_seq";

DROP TABLE IF EXISTS "spy_oms_order_item_state" CASCADE;

DROP SEQUENCE "spy_oms_order_item_state_pk_seq";

DROP TABLE IF EXISTS "spy_oms_order_item_state_history" CASCADE;

DROP SEQUENCE "spy_oms_order_item_state_history_pk_seq";

DROP TABLE IF EXISTS "spy_oms_event_timeout" CASCADE;

DROP SEQUENCE "spy_oms_event_timeout_pk_seq";

DROP TABLE IF EXISTS "spy_oms_product_reservation" CASCADE;

DROP SEQUENCE "spy_oms_product_reservation_pk_seq";

DROP TABLE IF EXISTS "spy_oms_product_reservation_store" CASCADE;

DROP SEQUENCE "spy_oms_product_reservation_store_pk_seq";

DROP TABLE IF EXISTS "spy_oms_product_reservation_change_version" CASCADE;

DROP SEQUENCE "spy_oms_product_reservation_change_version_pk_seq";

DROP TABLE IF EXISTS "spy_oms_product_reservation_last_exported_version" CASCADE;

DROP TABLE IF EXISTS "spy_permission" CASCADE;

DROP SEQUENCE "spy_permission_pk_seq";

DROP TABLE IF EXISTS "spy_price_product" CASCADE;

DROP SEQUENCE "spy_price_product_pk_seq";

DROP TABLE IF EXISTS "spy_price_type" CASCADE;

DROP SEQUENCE "spy_price_type_pk_seq";

DROP TABLE IF EXISTS "spy_price_product_store" CASCADE;

DROP SEQUENCE "spy_price_product_store_pk_seq";

DROP TABLE IF EXISTS "spy_price_product_default" CASCADE;

DROP SEQUENCE "spy_price_product_default_pk_seq";

DROP TABLE IF EXISTS "spy_price_product_schedule" CASCADE;

DROP SEQUENCE "spy_price_product_schedule_pk_seq";

DROP TABLE IF EXISTS "spy_price_product_schedule_list" CASCADE;

DROP SEQUENCE "spy_price_product_schedule_list_pk_seq";

DROP TABLE IF EXISTS "spy_price_product_abstract_storage" CASCADE;

DROP SEQUENCE "spy_price_product_abstract_storage_pk_seq";

DROP TABLE IF EXISTS "spy_price_product_concrete_storage" CASCADE;

DROP SEQUENCE "spy_price_product_concrete_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_abstract" CASCADE;

DROP SEQUENCE "spy_product_abstract_pk_seq";

DROP TABLE IF EXISTS "spy_product_abstract_localized_attributes" CASCADE;

DROP SEQUENCE "spy_product_abstract_localized_attributes_pk_seq";

DROP TABLE IF EXISTS "spy_product_abstract_store" CASCADE;

DROP SEQUENCE "id_product_abstract_store_pk_seq";

DROP TABLE IF EXISTS "spy_product" CASCADE;

DROP SEQUENCE "spy_product_pk_seq";

DROP TABLE IF EXISTS "spy_product_localized_attributes" CASCADE;

DROP SEQUENCE "spy_product_localized_attributes_pk_seq";

DROP TABLE IF EXISTS "spy_product_attribute_key" CASCADE;

DROP SEQUENCE "spy_product_attribute_key_pk_seq";

DROP TABLE IF EXISTS "spy_product_alternative" CASCADE;

DROP SEQUENCE "spy_product_alternative_pk_seq";

DROP TABLE IF EXISTS "spy_product_alternative_storage" CASCADE;

DROP SEQUENCE "id_product_alternative_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_replacement_for_storage" CASCADE;

DROP SEQUENCE "id_product_replacement_for_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_management_attribute" CASCADE;

DROP SEQUENCE "spy_product_management_attribute_pk_seq";

DROP TABLE IF EXISTS "spy_product_management_attribute_value" CASCADE;

DROP SEQUENCE "spy_product_management_attribute_value_pk_seq";

DROP TABLE IF EXISTS "spy_product_management_attribute_value_translation" CASCADE;

DROP SEQUENCE "spy_product_management_attribute_value_translation_pk_seq";

DROP TABLE IF EXISTS "spy_sales_order_item_bundle" CASCADE;

DROP SEQUENCE "spy_sales_order_item_bundle_pk_seq";

DROP TABLE IF EXISTS "spy_product_bundle" CASCADE;

DROP SEQUENCE "spy_product_bundle_pk_seq";

DROP TABLE IF EXISTS "spy_product_category" CASCADE;

DROP SEQUENCE "spy_product_category_pk_seq";

DROP TABLE IF EXISTS "spy_product_category_filter" CASCADE;

DROP SEQUENCE "spy_product_category_filter_pk_seq";

DROP TABLE IF EXISTS "spy_product_category_filter_storage" CASCADE;

DROP SEQUENCE "spy_product_category_filter_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_abstract_category_storage" CASCADE;

DROP SEQUENCE "spy_product_abstract_category_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_discontinued" CASCADE;

DROP SEQUENCE "id_product_discontinued_pk_seq";

DROP TABLE IF EXISTS "spy_product_discontinued_note" CASCADE;

DROP SEQUENCE "id_product_discontinued_note_pk_seq";

DROP TABLE IF EXISTS "spy_product_discontinued_storage" CASCADE;

DROP SEQUENCE "id_product_discontinued_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_group" CASCADE;

DROP SEQUENCE "spy_product_group_pk_seq";

DROP TABLE IF EXISTS "spy_product_abstract_group" CASCADE;

DROP TABLE IF EXISTS "spy_product_abstract_group_storage" CASCADE;

DROP SEQUENCE "spy_product_abstract_group_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_image_set" CASCADE;

DROP SEQUENCE "spy_product_image_set_pk_seq";

DROP TABLE IF EXISTS "spy_product_image" CASCADE;

DROP SEQUENCE "spy_product_image_pk_seq";

DROP TABLE IF EXISTS "spy_product_image_set_to_product_image" CASCADE;

DROP SEQUENCE "spy_product_image_set_to_product_image_pk_seq";

DROP TABLE IF EXISTS "spy_product_abstract_image_storage" CASCADE;

DROP SEQUENCE "spy_product_abstract_image_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_concrete_image_storage" CASCADE;

DROP SEQUENCE "spy_product_concrete_image_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_label" CASCADE;

DROP SEQUENCE "spy_product_label_pk_seq";

DROP TABLE IF EXISTS "spy_product_label_localized_attributes" CASCADE;

DROP SEQUENCE "spy_product_label_localized_attributes_pk_seq";

DROP TABLE IF EXISTS "spy_product_label_product_abstract" CASCADE;

DROP SEQUENCE "spy_product_label_product_abstract_pk_seq";

DROP TABLE IF EXISTS "spy_product_label_dictionary_storage" CASCADE;

DROP SEQUENCE "spy_product_label_dictionary_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_abstract_label_storage" CASCADE;

DROP SEQUENCE "spy_product_abstract_label_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_option_group" CASCADE;

DROP SEQUENCE "spy_product_option_group_pk_seq";

DROP TABLE IF EXISTS "spy_product_abstract_product_option_group" CASCADE;

DROP TABLE IF EXISTS "spy_product_option_value" CASCADE;

DROP SEQUENCE "spy_product_option_value_pk_seq";

DROP TABLE IF EXISTS "spy_product_option_value_price" CASCADE;

DROP SEQUENCE "spy_product_option_value_price_pk_seq";

DROP TABLE IF EXISTS "spy_product_abstract_option_storage" CASCADE;

DROP SEQUENCE "spy_product_abstract_option_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_abstract_page_search" CASCADE;

DROP SEQUENCE "spy_product_abstract_page_search_pk_seq";

DROP TABLE IF EXISTS "spy_product_concrete_page_search" CASCADE;

DROP SEQUENCE "spy_product_concrete_page_search_pk_seq";

DROP TABLE IF EXISTS "spy_product_quantity" CASCADE;

DROP SEQUENCE "id_product_quantity_pk_seq";

DROP TABLE IF EXISTS "spy_product_quantity_storage" CASCADE;

DROP SEQUENCE "id_product_quantity_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_relation_type" CASCADE;

DROP SEQUENCE "spy_product_relation_type_pk_seq";

DROP TABLE IF EXISTS "spy_product_relation" CASCADE;

DROP SEQUENCE "spy_product_relation_pk_seq";

DROP TABLE IF EXISTS "spy_product_relation_product_abstract" CASCADE;

DROP SEQUENCE "spy_product_rel_prod_abs_type_pk_seq";

DROP TABLE IF EXISTS "spy_product_abstract_relation_storage" CASCADE;

DROP SEQUENCE "spy_product_abstract_relation_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_review" CASCADE;

DROP SEQUENCE "id_product_review_pk_seq";

DROP TABLE IF EXISTS "spy_product_review_search" CASCADE;

DROP SEQUENCE "spy_product_review_search_pk_seq";

DROP TABLE IF EXISTS "spy_product_abstract_review_storage" CASCADE;

DROP SEQUENCE "spy_product_abstract_review_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_search" CASCADE;

DROP SEQUENCE "spy_product_search_pk_seq";

DROP TABLE IF EXISTS "spy_product_search_attribute_map" CASCADE;

DROP TABLE IF EXISTS "spy_product_search_attribute" CASCADE;

DROP SEQUENCE "spy_product_search_attribute_pk_seq";

DROP TABLE IF EXISTS "spy_product_search_config_storage" CASCADE;

DROP SEQUENCE "spy_product_search_config_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_set" CASCADE;

DROP SEQUENCE "spy_product_set_pk_seq";

DROP TABLE IF EXISTS "spy_product_abstract_set" CASCADE;

DROP SEQUENCE "spy_product_abstract_set_pk_seq";

DROP TABLE IF EXISTS "spy_product_set_data" CASCADE;

DROP SEQUENCE "spy_product_set_data_pk_seq";

DROP TABLE IF EXISTS "spy_product_set_page_search" CASCADE;

DROP SEQUENCE "spy_product_set_page_search_pk_seq";

DROP TABLE IF EXISTS "spy_product_set_storage" CASCADE;

DROP SEQUENCE "spy_product_set_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_abstract_storage" CASCADE;

DROP SEQUENCE "spy_product_abstract_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_concrete_storage" CASCADE;

DROP SEQUENCE "spy_product_concrete_storage_pk_seq";

DROP TABLE IF EXISTS "spy_product_validity" CASCADE;

DROP SEQUENCE "spy_product_validity_pk_seq";

DROP TABLE IF EXISTS "spy_propel_heartbeat" CASCADE;

DROP TABLE IF EXISTS "spy_queue_process" CASCADE;

DROP SEQUENCE "spy_queue_process_pk_seq";

DROP TABLE IF EXISTS "spy_quote" CASCADE;

DROP SEQUENCE "id_quote_pk_seq";

DROP TABLE IF EXISTS "spy_refund" CASCADE;

DROP SEQUENCE "spy_refund_pk_seq";

DROP TABLE IF EXISTS "spy_sales_order" CASCADE;

DROP SEQUENCE "spy_sales_order_pk_seq";

DROP TABLE IF EXISTS "spy_sales_order_item" CASCADE;

DROP SEQUENCE "spy_sales_order_item_pk_seq";

DROP TABLE IF EXISTS "spy_sales_discount" CASCADE;

DROP SEQUENCE "spy_sales_discount_pk_seq";

DROP TABLE IF EXISTS "spy_sales_discount_code" CASCADE;

DROP SEQUENCE "spy_sales_discount_code_pk_seq";

DROP TABLE IF EXISTS "spy_sales_order_item_gift_card" CASCADE;

DROP SEQUENCE "spy_sales_order_item_gift_card_pk_seq";

DROP TABLE IF EXISTS "spy_sales_order_item_option" CASCADE;

DROP SEQUENCE "spy_sales_order_item_option_pk_seq";

DROP TABLE IF EXISTS "spy_sales_order_address" CASCADE;

DROP SEQUENCE "spy_sales_order_address_pk_seq";

DROP TABLE IF EXISTS "spy_sales_order_address_history" CASCADE;

DROP SEQUENCE "spy_sales_order_address_history_pk_seq";

DROP TABLE IF EXISTS "spy_sales_order_totals" CASCADE;

DROP SEQUENCE "spy_sales_order_totals_pk_seq";

DROP TABLE IF EXISTS "spy_sales_order_note" CASCADE;

DROP SEQUENCE "spy_sales_order_note_pk_seq";

DROP TABLE IF EXISTS "spy_sales_order_comment" CASCADE;

DROP SEQUENCE "spy_sales_order_comment_pk_seq";

DROP TABLE IF EXISTS "spy_sales_expense" CASCADE;

DROP SEQUENCE "spy_sales_expense_pk_seq";

DROP TABLE IF EXISTS "spy_sales_order_item_metadata" CASCADE;

DROP SEQUENCE "spy_sales_order_item_metadata_pk_seq";

DROP TABLE IF EXISTS "spy_sales_shipment" CASCADE;

DROP SEQUENCE "spy_sales_shipment_pk_seq";

DROP TABLE IF EXISTS "spy_sales_order_threshold" CASCADE;

DROP SEQUENCE "id_sales_order_threshold_pk_seq";

DROP TABLE IF EXISTS "spy_sales_order_threshold_tax_set" CASCADE;

DROP SEQUENCE "id_sales_order_threshold_tax_set_pk_seq";

DROP TABLE IF EXISTS "spy_sales_order_threshold_type" CASCADE;

DROP SEQUENCE "id_sales_order_threshold_type_pk_seq";

DROP TABLE IF EXISTS "spy_sales_payment" CASCADE;

DROP SEQUENCE "spy_sales_payment_pk_seq";

DROP TABLE IF EXISTS "spy_sales_payment_method_type" CASCADE;

DROP SEQUENCE "spy_sales_payment_method_type_pk_seq";

DROP TABLE IF EXISTS "spy_sales_reclamation" CASCADE;

DROP SEQUENCE "spy_sales_reclamation_pk_seq";

DROP TABLE IF EXISTS "spy_sales_reclamation_item" CASCADE;

DROP SEQUENCE "spy_sales_reclamation_item_pk_seq";

DROP TABLE IF EXISTS "spy_sequence_number" CASCADE;

DROP SEQUENCE "spy_sequence_number_pk_seq";

DROP TABLE IF EXISTS "spy_shipment_carrier" CASCADE;

DROP SEQUENCE "spy_shipment_carrier_pk_seq";

DROP TABLE IF EXISTS "spy_shipment_method" CASCADE;

DROP SEQUENCE "spy_shipment_method_pk_seq";

DROP TABLE IF EXISTS "spy_shipment_method_price" CASCADE;

DROP SEQUENCE "spy_shipment_method_price_pk_seq";

DROP TABLE IF EXISTS "spy_state_machine_transition_log" CASCADE;

DROP SEQUENCE "spy_state_machine_transition_log_pk_seq";

DROP TABLE IF EXISTS "spy_state_machine_process" CASCADE;

DROP SEQUENCE "spy_state_machine_process_pk_seq";

DROP TABLE IF EXISTS "spy_state_machine_lock" CASCADE;

DROP SEQUENCE "spy_state_machine_lock_pk_seq";

DROP TABLE IF EXISTS "spy_state_machine_item_state" CASCADE;

DROP SEQUENCE "spy_state_machine_item_state_pk_seq";

DROP TABLE IF EXISTS "spy_state_machine_item_state_history" CASCADE;

DROP SEQUENCE "spy_state_machine_item_state_history_pk_seq";

DROP TABLE IF EXISTS "spy_state_machine_event_timeout" CASCADE;

DROP SEQUENCE "spy_state_machine_event_timeout_pk_seq";

DROP TABLE IF EXISTS "spy_stock" CASCADE;

DROP SEQUENCE "spy_stock_pk_seq";

DROP TABLE IF EXISTS "spy_stock_product" CASCADE;

DROP SEQUENCE "spy_stock_product_pk_seq";

DROP TABLE IF EXISTS "spy_store" CASCADE;

DROP SEQUENCE "spy_store_pk_seq";

DROP TABLE IF EXISTS "spy_tax_set" CASCADE;

DROP SEQUENCE "spy_tax_set_pk_seq";

DROP TABLE IF EXISTS "spy_tax_rate" CASCADE;

DROP SEQUENCE "spy_tax_rate_pk_seq";

DROP TABLE IF EXISTS "spy_tax_set_tax" CASCADE;

DROP TABLE IF EXISTS "spy_tax_product_storage" CASCADE;

DROP SEQUENCE "id_tax_product_storage_pk_seq";

DROP TABLE IF EXISTS "spy_tax_set_storage" CASCADE;

DROP SEQUENCE "id_tax_set_storage_pk_seq";

DROP TABLE IF EXISTS "spy_touch" CASCADE;

DROP SEQUENCE "spy_touch_pk_seq";

DROP TABLE IF EXISTS "spy_touch_storage" CASCADE;

DROP SEQUENCE "spy_touch_storage_pk_seq";

DROP TABLE IF EXISTS "spy_touch_search" CASCADE;

DROP SEQUENCE "spy_touch_search_pk_seq";

DROP TABLE IF EXISTS "spy_unauthenticated_customer_access" CASCADE;

DROP SEQUENCE "spy_unauthenticated_customer_access_pk_seq";

DROP TABLE IF EXISTS "spy_unauthenticated_customer_access_storage" CASCADE;

DROP SEQUENCE "unauthenticated_customer_access_storage_pk_seq";

DROP TABLE IF EXISTS "spy_url" CASCADE;

DROP SEQUENCE "spy_url_pk_seq";

DROP TABLE IF EXISTS "spy_url_redirect" CASCADE;

DROP SEQUENCE "spy_url_redirect_pk_seq";

DROP TABLE IF EXISTS "spy_url_storage" CASCADE;

DROP SEQUENCE "spy_url_storage_pk_seq";

DROP TABLE IF EXISTS "spy_url_redirect_storage" CASCADE;

DROP SEQUENCE "spy_url_redirect_storage_pk_seq";

DROP TABLE IF EXISTS "spy_user" CASCADE;

DROP SEQUENCE "spy_user_pk_seq";

DROP TABLE IF EXISTS "spy_vault_deposit" CASCADE;

DROP SEQUENCE "id_vault_deposit_pk_seq";

DROP TABLE IF EXISTS "spy_wishlist" CASCADE;

DROP SEQUENCE "spy_wishlist_pk_seq";

DROP TABLE IF EXISTS "spy_wishlist_item" CASCADE;

DROP SEQUENCE "spy_wishlist_item_pk_seq";

DROP TABLE IF EXISTS "spy_acl_role_archive" CASCADE;

DROP TABLE IF EXISTS "spy_acl_rule_archive" CASCADE;

DROP TABLE IF EXISTS "spy_acl_group_archive" CASCADE;

DROP TABLE IF EXISTS "spy_auth_reset_password_archive" CASCADE;

DROP TABLE IF EXISTS "spy_product_search_attribute_map_archive" CASCADE;

DROP TABLE IF EXISTS "spy_product_search_attribute_archive" CASCADE;

DROP TABLE IF EXISTS "spy_user_archive" CASCADE;

COMMIT;
',
);
    }

}