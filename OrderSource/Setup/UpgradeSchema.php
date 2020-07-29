<?php
namespace Toppik\OrderSource\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Toppik\OrderSource\Model\ResourceModel\Ordersource;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.0.1', '<')) {
            /**
             * Create table 'toppik_ordersource'
             */
            $table = $setup->getConnection()
                ->newTable($setup->getTable(Ordersource::ORDERSOURCE_TABLE))
                ->addColumn(
                    'id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    ['unsigned' => true, 'nullable' => false, 'auto_increment' => true, 'primary' => true ],
                    'Order Source ID'
                )
                ->addColumn(
                    'value',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false]
                )
                ->addColumn(
                    'label',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    ['nullable' => false]
                )
                ->addColumn(
                    'default_autoship',
                    \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'default' => 0]
                )
                ->addColumn(
                    'default_autoship_first_web',
                    \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'default' => 0]
                )
                ->addColumn(
                    'default_autoship_first_cs',
                    \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'default' => 0]
                )
                ->addColumn(
                    'default_web',
                    \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'default' => 0]
                )
                ->addColumn(
                    'default_cs',
                    \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'default' => 0]
                )
                ->addColumn(
                    'default_borderfree',
                    \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'default' => 0]
                )
                ->addColumn(
                    'default_free',
                    \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                    null,
                    ['nullable' => false, 'default' => 0]
                );
            $setup->getConnection()->createTable($table);
        }
		
        if(version_compare($context->getVersion(), '1.0.2') < 0) {
            $this->upgradeTo_1_0_2($setup, $context);
        }
		
        if(version_compare($context->getVersion(), '1.0.3') < 0) {
            $this->upgradeTo_1_0_3($setup, $context);
        }
		
        $setup->endSetup();
    }
	
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    private function upgradeTo_1_0_2(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $setup->getConnection()
            ->addColumn(
                $setup->getTable('sales_order'),
                'merchant_source',
                [
                    'type'              => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'comment'           => 'Merchant Source',
                ]);
    }
	
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    private function upgradeTo_1_0_3(SchemaSetupInterface $setup, ModuleContextInterface $context) {
        $setup->getConnection()
            ->addColumn(
                $setup->getTable('sales_order'),
                'processed_drtv_cs',
                'int(10) unsigned not null default 0 comment "Processed Drtv Cs"'
			);
    }
	
}
