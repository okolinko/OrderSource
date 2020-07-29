<?php
namespace Toppik\OrderSource\Controller\Adminhtml\Items;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Toppik\OrderSource\Controller\Adminhtml\Items
{
    public function execute()
    {
        $resultPage = $this->_initAction();
        $resultPage->getConfig()->getTitle()->prepend(__('Order Sources'));
        return $resultPage;
    }
}