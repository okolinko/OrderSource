<?php

namespace Toppik\OrderSource\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $installer->getConnection()
            ->addColumn(
                $installer->getTable('sales_order'),
                'source',
                [
                    'type'              =>  Table::TYPE_TEXT,
                    'length'            =>  255,
                    'nullable'          =>  true,
                    'default'           =>  null,
                    'comment'           =>  'Toppik Order Source',
                ]);

        $installer->endSetup();
    }
}