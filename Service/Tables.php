<?php

namespace MageSuite\ClearAttributes\Service;

class Tables
{
    /**
     * @var \Magento\Framework\App\ResourceConnectionFactory
     */
    protected $resourceFactory;

    /**
     * @var \Magento\Framework\DB\Adapter\AdapterInterface
     */
    protected $connection;

    public function __construct(
        \Magento\Framework\App\ResourceConnectionFactory $resourceFactory
    )
    {
        $this->resourceFactory = $resourceFactory;
    }

    /**
     * @return array
     */
    public function getTablesToClear(){
        return [
            "catalog_category_entity_datetime",
            "catalog_category_entity_decimal",
            "catalog_category_entity_int",
            "catalog_category_entity_text",
            "catalog_category_entity_varchar",
            "catalog_product_entity_datetime",
            "catalog_product_entity_decimal",
            "catalog_product_entity_gallery",
            "catalog_product_entity_int",
            "catalog_product_entity_media_gallery",
            "catalog_product_entity_text",
            "catalog_product_entity_varchar"
        ];
    }

    /**
     * @param string $table
     * @return string
     */
    public function getDeleteSql($table) {
        $connection = $this->getConnection();
        $tableName = $connection->getTableName($table);
        $eavAttributeTableName = $connection->getTableName("eav_attribute");

        return "DELETE FROM {$tableName} WHERE attribute_id NOT IN (SELECT attribute_id FROM {$eavAttributeTableName});";
    }

    /**
     * @return \Magento\Framework\DB\Adapter\AdapterInterface
     */
    public function getConnection(){
        if(! $this->connection) {
            /* @var $resource \Magento\Framework\App\ResourceConnection */
            $resource = $this->resourceFactory->create();
            $this->connection = $resource->getConnection();
        }

        return $this->connection;
    }
}
