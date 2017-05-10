<?php
 
namespace Octonism\Exportorder\Observer;
 
use Magento\Framework\ObjectManager\ObjectManager;
 
class OrderPlaceAfter implements \Magento\Framework\Event\ObserverInterface {
 
    /** @var \Magento\Framework\Logger\Monolog */
    protected $_logger;
    
    /**
     * @var \Magento\Framework\ObjectManager\ObjectManager
     */
    protected $_objectManager;
    
    protected $_orderFactory;    
    protected $_checkoutSession;
    
    public function __construct(        
        \Psr\Log\LoggerInterface $loggerInterface,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Framework\ObjectManager\ObjectManager $objectManager
    ) {
        $this->_logger = $loggerInterface;
        $this->_objectManager = $objectManager;        
        $this->_orderFactory = $orderFactory;
        $this->_checkoutSession = $checkoutSession;        
    }
 
    /**
     * 
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer ) {        
        
        $order = $observer->getEvent()->getOrder();
        $order_id = $order->getID();
        $order_number = $order->getIncrementId();
         //$order = $this->orderFacory->load($lastorderId);
       foreach ($order->getAllItems() as $item) {
            $products[] = array(
                            'id' => $item->getProductId(), 
                            'sku' => $item->getSku(), 
                            'name' => $item->getName()
                        );
        }
        //Retrive Billing information
        $b_address = $order->getBillingAddress();
        $billingAddressToArray = array(
                                   'firstname' => $b_address->getFirstname(),
                                   'lastname' => $b_address->getLastname(),
                                   'company' => $b_address->getCompany(),
                                   'street' => implode(' ',$b_address->getStreet()),
                                   'city'   =>  $b_address->getCity(),
                                   'region' => $b_address->getRegion(),
                                   'postcode' => $b_address->getPostcode(),
                                   'country_id' => $b_address->getCountryId(),
                                   'telephone' => $b_address->getTelephone()
                                );
        print_r($billingAddressToArray);
        //Retrive Shipping information
        $s_address = $order->getShippingAddress();
        $shippingAddressToArray = array(
                                   'firstname' => $s_address->getFirstname(),
                                   'lastname' => $s_address->getLastname(),
                                   'company' => $s_address->getCompany(),
                                   'street' => implode(' ',$s_address->getStreet()),
                                   'city'   =>  $s_address->getCity(),
                                   'region' => $s_address->getRegion(),
                                   'postcode' => $s_address->getPostcode(),
                                   'country_id' => $s_address->getCountryId(),
                                   'telephone' => $s_address->getTelephone()
                                );
        print_r($shippingAddressToArray);
        die();
    }
}