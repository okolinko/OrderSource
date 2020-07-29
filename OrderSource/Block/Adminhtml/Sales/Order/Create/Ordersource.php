<?php

namespace Toppik\OrderSource\Block\Adminhtml\Sales\Order\Create;

class Ordersource extends \Magento\Backend\Block\Template
{
    protected $_orderSource;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param array $data
     */
    public function __construct(\Magento\Backend\Block\Template\Context $context, array $data = [], \Toppik\OrderSource\Model\Ordersource $ordersource)
    {
        $this->_orderSource = $ordersource;
        parent::__construct($context, $data);
    }

    public function getSelectOptions() {
       return $this->_orderSource->getCollection();
    }
    
    public function getDefaultSource() {
        return 'Customer Service';
    }
	
}
