<?php

namespace Magenest\Cybergame\Setup;

use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup,ModuleContextInterface  $contex)
    {
        $installer = $setup;
        $installer->startSetup();
        if (!$installer->tableExists('room_extra_option')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('room_extra_option')
            )->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => false,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                    'auto_increment' => true
                ],
                'id'
            )->addColumn(
                'product_id',
                Table::TYPE_INTEGER,
                255,
                [
                    'nullable' => false
                ],
                'product id'
            )->addColumn(
                'name',
                Table::TYPE_TEXT,
                null,
                [
                    'nullable' => false
                ],
                'name'
            )->addColumn(
                'number_pc',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => false
                ],
                'number_pc'
            )->addColumn(
                'address',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false
                ],
                'number_pc'
            )->addColumn(
                'food_price',
                Table::TYPE_DECIMAL,
                255,
                [
                    'nullable' => false
                ],
                'food_price'
            )->addColumn(
                'drink_price',
                Table::TYPE_DECIMAL,
                255,
                [
                    'nullable' => false
                ],
                'drink_price'
            )->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Created At'
            )->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            );
            $installer->getConnection()->createTable($table);
        }

        if (!$installer->tableExists('gamer_account_list')) {
            $table = $installer->getConnection()->newTable(
                $installer->getTable('gamer_account_list')
            )->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => false,
                    'nullable' => false,
                    'primary' => true,
                    'unsigned' => true,
                    'auto_increment' => true
                ],
                'id'
            )->addColumn(
                'product_id',
                Table::TYPE_INTEGER,
                255,
                [
                    'nullable' => false
                ],
                'product id'
            )->addColumn(
                'account_name',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false
                ],
                'account name'
            )->addColumn(
                'password',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false
                ],
                'password'
            )->addColumn(
                'hour',
                Table::TYPE_DECIMAL,
                null,
                [
                    'nullable' => false
                ],
                'hour'
            )->addColumn(
                'created_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
                'Created At'
            )->addColumn(
                'updated_at',
                \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
                null,
                ['nullable' => false, 'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
                'Updated At'
            );
            $installer->getConnection()->createTable($table);
            $installer->getConnection()->addIndex(
                $installer->getTable('gamer_account_list'),
                $setup->getIdxName(
                    $installer->getTable('gamer_account_list'),
                    ['account_name'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['account_name'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        $installer->endSetup();
    }
}
