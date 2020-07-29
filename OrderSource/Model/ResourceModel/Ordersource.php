<?php
namespace Toppik\OrderSource\Model\ResourceModel;

class Ordersource extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    const ORDERSOURCE_TABLE = 'toppik_ordersource';

    /**
     * {@inheritdoc}
     */
    protected function _construct()
    {
        $this->_init(self::ORDERSOURCE_TABLE, 'id');
    }


}
