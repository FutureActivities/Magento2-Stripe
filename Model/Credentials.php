<?php
namespace FutureActivities\Stripe\Model;

use FutureActivities\Stripe\Api\CredentialsInterface;
use \Nzime\Api\Model\PageResult;
 
class Credentials implements CredentialsInterface
{
    const XML_PATH_TEST_ENABLED = 'payment/stripe_rest/test_enabled';
    const XML_PATH_TEST_CLIENT = 'payment/stripe_rest/test_public_key';
    const XML_PATH_LIVE_CLIENT = 'payment/stripe_rest/public_key';
    
    public function __construct(\Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }
   
    /**
     * Returns the test and live public keys
     * 
     * @api
     * @return FutureActivities\Stripe\Api\Data\CredentialsResultInterface
     */
    public function client() 
    {
        $result = new CredentialsResult();
        $result->setTestEnabled($this->scopeConfig->getValue(self::XML_PATH_TEST_ENABLED, \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
        $result->setTest($this->scopeConfig->getValue(self::XML_PATH_TEST_CLIENT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
        $result->setLive($this->scopeConfig->getValue(self::XML_PATH_LIVE_CLIENT, \Magento\Store\Model\ScopeInterface::SCOPE_STORE));
        
        return $result;
    }
}