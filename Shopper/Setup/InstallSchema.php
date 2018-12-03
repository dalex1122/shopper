<?php

namespace Alexsample\Shopper\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Alexsample\Shopper\Api\Data\ShopperInterface;
use Alexsample\Shopper\Api\Data\OrderInterface;


class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        /**
         * Shopper Table
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable(ShopperInterface::TABLE_NAME)
        )
            ->addColumn(
                ShopperInterface::ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Order Data Id'
            )
            ->addColumn(
                ShopperInterface::EMAIL,
                Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => true],
                ShopperInterface::EMAIL
            )
            ->addColumn(
                ShopperInterface::NAME,
                Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => true],
                ShopperInterface::NAME
            )
            ->addColumn(
                ShopperInterface::LAST_NAME,
                Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => true],
                ShopperInterface::LAST_NAME
            )
            ->addColumn(
                ShopperInterface::PHONE,
                Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => true],
                ShopperInterface::PHONE
            )
            ->addColumn(
                ShopperInterface::CITY,
                Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => true],
                ShopperInterface::CITY
            )
            ->addColumn(
                ShopperInterface::STREET,
                Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => true],
                ShopperInterface::STREET
            )
            ->addColumn(
                ShopperInterface::HOUSE_NUMBER,
                Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => true],
                ShopperInterface::HOUSE_NUMBER
            )->addIndex(
                $installer->getIdxName(
                    ShopperInterface::TABLE_NAME,
                    ShopperInterface::EMAIL,
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                ShopperInterface::EMAIL,
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )->addIndex(
                $installer->getIdxName(
                    ShopperInterface::TABLE_NAME,
                    ShopperInterface::NAME
                ),
                [ShopperInterface::NAME]
            )->addIndex(
                $installer->getIdxName(
                    ShopperInterface::TABLE_NAME,
                    ShopperInterface::LAST_NAME
                ),
                [ShopperInterface::LAST_NAME]
            )->addIndex(
                $installer->getIdxName(
                    $installer->getTable(ShopperInterface::TABLE_NAME),
                    [
                        ShopperInterface::EMAIL,
                        ShopperInterface::NAME,
                        ShopperInterface::LAST_NAME,
                    ],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                [
                    ShopperInterface::EMAIL,
                    ShopperInterface::NAME,
                    ShopperInterface::LAST_NAME,
                ],
                ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
            );
        $installer->getConnection()->createTable($table);

        /**
         * Order Table
         */
        $table = $installer->getConnection()->newTable(
            $installer->getTable(OrderInterface::TABLE_NAME)
        )
            ->addColumn(
                OrderInterface::ID,
                Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                OrderInterface::ID
            )
            ->addColumn(
                OrderInterface::ORDER_ID,
                Table::TYPE_TEXT,
                255,
                ['unsigned' => false, 'nullable' => true],
                OrderInterface::ORDER_ID
            )
            ->addColumn(
                OrderInterface::SHOPPER_ID,
                Table::TYPE_INTEGER,
                null,
                ['unsigned' => true, 'nullable' => true],
                OrderInterface::SHOPPER_ID
            )
            ->addColumn(
                OrderInterface::ORDER_TOTAL,
                Table::TYPE_DECIMAL,
                '12,4',
                [],
                OrderInterface::ORDER_TOTAL
            )->addIndex(
                $installer->getIdxName(
                    OrderInterface::TABLE_NAME,
                    OrderInterface::ORDER_ID,
                    AdapterInterface::INDEX_TYPE_UNIQUE
                ),
                OrderInterface::ORDER_ID,
                ['type' => AdapterInterface::INDEX_TYPE_UNIQUE]
            )
            ->addForeignKey(
                $installer->getFkName(
                    OrderInterface::TABLE_NAME,
                    OrderInterface::SHOPPER_ID,
                    ShopperInterface::TABLE_NAME,
                    ShopperInterface::ID
                ),
                OrderInterface::SHOPPER_ID,
                $installer->getTable(ShopperInterface::TABLE_NAME),
                ShopperInterface::ID,
                Table::ACTION_CASCADE
            );;
        $installer->getConnection()->createTable($table);
    }
}
