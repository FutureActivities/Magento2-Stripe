<?php
namespace FutureActivities\Stripe\Model;

class Rest extends \Magento\Payment\Model\Method\AbstractMethod
{
    const METHOD_CODE = 'stripe_rest';
    
    protected $_code = self::METHOD_CODE;
    protected $_isGateway = true;
    protected $_canCapture = true;
    protected $_canCapturePartial = true;
    protected $_canRefund = true;
    
    protected $_minOrderTotal = 0;
    
    protected $_testMode = false;
    protected $_testPublic;
    protected $_testSecret;
    protected $_livePublic;
    protected $_liveSecret;
    
    protected $_stripe;
    
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $paymentData,
            $scopeConfig,
            $logger,
            $resource,
            $resourceCollection,
            $data
        );
        
        $this->_testMode = $this->getConfigData('test_enabled');
        $this->_testPublic = $this->getConfigData('test_public_key');
        $this->_testSecret = $this->getConfigData('test_secret');
        $this->_livePublic = $this->getConfigData('live_public_key');
        $this->_liveSecret = $this->getConfigData('live_secret');
        
        $secretKey = $this->_testMode ? $this->_testSecret : $this->_liveSecret;
        \Stripe\Stripe::setApiKey($secretKey);
    }
    
    public function capture(\Magento\Payment\Model\InfoInterface $payment, $amount)
    {
        $order = $payment->getOrder();
        $billing = $order->getBillingAddress();
        
        try {
            
            $charge = \Stripe\Charge::create(array(
                'amount' => $amount * 100,
                'currency' => $order->getOrderCurrencyCode(), 
                'source' => $payment->getAdditionalInformation('token')
            ));
            
            $payment->setTransactionId($charge->id)->setIsTransactionClosed(0);
 
            return $this;
 
        } catch (\Exception $e) {
            $this->debugData(['exception' => $e->getMessage()]);
            throw new \Magento\Framework\Validator\Exception(__($e->getMessage()));
        }
    }
 
    public function refund(\Magento\Payment\Model\InfoInterface $payment, $amount)
    {
        $order = $payment->getOrder();
        $transactionId = $payment->getParentTransactionId();
 
        try {
            $re = \Stripe\Refund::create(array(
                "charge" => $transactionId
            ));

        } catch (\Exception $e) {
            $this->debugData(['exception' => $e->getMessage()]);
            throw new \Magento\Framework\Validator\Exception(__($e->getMessage()));
        }
 
        $payment
            ->setTransactionId($transactionId . '-' . \Magento\Sales\Model\Order\Payment\Transaction::TYPE_REFUND)
            ->setParentTransactionId($transactionId)
            ->setIsTransactionClosed(1)
            ->setShouldCloseParentTransaction(1);
 
        return $this;
    }
    
    public function assignData(\Magento\Framework\DataObject $data)
    {
        parent::assignData($data);
        
        $additionalData = $data->getData(\Magento\Quote\Api\Data\PaymentInterface::KEY_ADDITIONAL_DATA);

        if (!is_array($additionalData)) {
            return $this;
        }

        foreach ($additionalData as $key => $value) {
            $this->getInfoInstance()->setAdditionalInformation($key, $value);
        }
        
        return $this;
    }
 
    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null) 
    {
        $this->_minOrderTotal = $this->getConfigData('min_order_total');
        if ($quote && $quote->getBaseGrandTotal() < $this->_minOrderTotal)
            return false;
        
        return parent::isAvailable($quote);
    }
}
