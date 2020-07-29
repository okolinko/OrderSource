<?php
namespace Toppik\OrderSource\Observer;

use Magento\Framework\App\RequestInterface;


class SetOrderOrderSource implements \Magento\Framework\Event\ObserverInterface
{

    protected $_request;
    protected $logger;

    public function __construct(
        \Magento\Framework\App\Request\Http $request,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_request = $request;
        $this->logger = $logger;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     * @return $this
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getOrder();
       try {
               $orderSource = "web";
               $order->setSource($orderSource);
       } catch (\Exception $exception) {
           $this->logger->debug($exception);
       }

        return $this;
    }
}
