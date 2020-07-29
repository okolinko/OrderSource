<?php
namespace Toppik\OrderSource\Model\ResourceModel\Ordersource;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Toppik\OrderSource\Model\Ordersource', 'Toppik\OrderSource\Model\ResourceModel\Ordersource');
    }
}