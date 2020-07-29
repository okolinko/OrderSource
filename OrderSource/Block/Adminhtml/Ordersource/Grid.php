<?php

namespace Toppik\OrderSource\Block\Adminhtml\Ordersource;

class Grid extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_blockGroup = 'Toppik_OrderSource';
        $this->_controller = 'adminhtml_ordersource';
        $this->_headerText = __('Order Source');
        $this->_addButtonLabel = __('Add New Order Source');
        parent::_construct();
    }
}