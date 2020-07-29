<?php

namespace Toppik\OrderSource\Model\Ordersource;


use Magento\Backend\Block\Widget\Context;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $this->loadedData = [];

        $this->_coreRegistry = new \Magento\Framework\Registry();

        $ordersource = $this->_coreRegistry->registry('order_source');

        if ($ordersource && $ordersource->getId()) {
            $this->loadedData = $ordersource->getData();
        }

        return $this->loadedData;
    }

    /**
     * @inheritdoc
     */
    public function addFilter(\Magento\Framework\Api\Filter $filter)
    {

    }
}
