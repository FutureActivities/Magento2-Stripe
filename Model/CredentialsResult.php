<?php
namespace FutureActivities\Stripe\Model;

use FutureActivities\Stripe\Api\Data\CredentialsResultInterface;

class CredentialsResult implements CredentialsResultInterface
{
    protected $testEnabled = false;
    protected $test = null;
    protected $live = null;

    /**
     * Set the data
     * 
     * @param boolean $value
     * @return null
     */
    public function setTestEnabled($value)
    {
        $this->testEnabled = $value;
    }
        
    /**
     * Get the result 
     * 
     * @return boolean
     */
    public function getTestEnabled() 
    {
        return $this->testEnabled;
    }
    
    /**
     * Set the result
     * 
     * @param string $id
     * @return string
     */
    public function setTest($id)
    {
        $this->test = $id;
    }
    
    /**
     * Get the result type
     * 
     * @return string
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set the data
     * 
     * @param string $id
     * @return null
     */
    public function setLive($id) 
    {
        $this->live = $id;
    }
        
    /**
     * Get the result ID
     * 
     * @return string
     */
    public function getLive()
    {
        return $this->live;
    }
    
}