<?php
namespace Toppik\OrderSource\Model\Observer;

use Magento\Framework\App\Area;
use Magento\Customer\Model\Session;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\State;
use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;
use Psr\Log\LoggerInterface;
use Toppik\OrderSource\Model\Ordersource;
use Toppik\Subscriptions\Helper\Data;

class SaveOrderSourceToOrderObserver implements ObserverInterface
{
    /**
     * @var ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var Ordersource $ordersource
     */
    protected $_orderSource;

    /**
     * @var RequestInterface
     */
    protected $_request;
    /**
     * @var State
     */
    private $state;
    /**
     * @var Data
     */
    private $subscriptionHelper;
    /**
     * @var Session
     */
    private $customerSession;
    
    /**
     * @var LoggerInterface
     */
    private $logger;
	
    /**
     * @var \Toppik\OrderSource\Model\Merchant\Source
     */
    private $merchantSource;
	
    /**
     * @param LoggerInterface $logger
     * @internal param Session $customerSession
     * @internal param Data $subscriptionHelper
     * @internal param State $state
     * @internal param ObjectManagerInterface $objectmanager
     * @internal param Ordersource $ordersource
     * @internal param RequestInterface $request
     */
    public function __construct(
        LoggerInterface $logger,
        Session $customerSession,
        Data $subscriptionHelper,
        State $state,
        ObjectManagerInterface $objectmanager,
        Ordersource $ordersource,
        RequestInterface $request,
		\Toppik\OrderSource\Model\Merchant\Source $merchantSource
    )
    {
        $this->_orderSource = $ordersource;
        $this->_request = $request;
        $this->_objectManager = $objectmanager;
        $this->state = $state;
        $this->subscriptionHelper = $subscriptionHelper;
        $this->customerSession = $customerSession;
        $this->logger = $logger;
		$this->merchantSource = $merchantSource;
    }

    public function execute(EventObserver $observer)
    {
        /* @var Order $order */
        $order = $observer->getOrder();
        /* @var Quote $quote */
        $quote = $observer->getQuote();
        $areaCode = $this->state->getAreaCode();
        $requestOrderSource = $this->_request->getParam('ordersource');
        $requestMerchantSource = $this->_request->getParam('merchantsource');
        $isSubscription = !! $quote->getHasSubscription();
        $isFirstSubscription = false;
        if($isSubscription) {
            $isFirstSubscription = $this->subscriptionHelper->profileHasOrderByOrder($order);
        }
        $customerService = $this->isCustomerService();
		
		if($areaCode === Area::AREA_ADMINHTML && $requestMerchantSource) {
			$order->setPreconfiguredMerchantSource($requestMerchantSource);
		}
		
        if($areaCode === Area::AREA_ADMINHTML && $requestOrderSource) {
            $orderSource = $requestOrderSource;
        } else {
            if($isSubscription) {
                if($isFirstSubscription) {
                    if($customerService) {
                        $orderSource = $this->_orderSource->getDefaultAutoshipFirstCs();
                    } else {
                        $orderSource = $this->_orderSource->getDefaultAutoshipFirstWeb();
                    }
                } else {
                    $orderSource = $this->_orderSource->getDefaultAutoship();
                }
            } else {
                if($customerService) {
                    $orderSource = $this->_orderSource->getDefaultCs();
                } else {
                    if(preg_match('#orders\.fiftyone\.com#', $order->getCustomerEmail())) {
                        $orderSource = $this->_orderSource->getDefaultBorderfree();
                    } else {
                        $orderSource = $this->_orderSource->getDefaultWeb();
                    }
                }
            }
        }
        
        if($order->getGrandTotal() == 0 && $customerService && ! $order->getCouponCode()) {
            $orderSource = $this->_orderSource->getDefaultFree();
        }
        
		$merchantSource = $this->merchantSource->getSourceByOrder($order);
		
        $order->setMerchantSource($merchantSource);
        $order->setSource($orderSource);
        $order->save();

        $send = ($areaCode === Area::AREA_ADMINHTML) || (! isset($_SERVER['REQUEST_METHOD']));

//        $this->logger->debug(
//            'sendr'
//            . ' '
//            . var_export(($areaCode === Area::AREA_ADMINHTML), true)
//            . ' '
//            . var_export((! isset($_SERVER['REQUEST_METHOD'])), true)
//            . ' '
//            . var_export($send, true)
//            . ' '
//            . var_export($order->getIncrementId(), true)
//        );

        return $this;
    }

    private function isCustomerService()
    {
        if($this->state->getAreaCode() === Area::AREA_ADMINHTML) {
            return true;
        }
        if($this->customerSession->isLoggedIn() && $this->customerSession->getAdminId()) {
            return true;
        }
        return false;
    }
}
