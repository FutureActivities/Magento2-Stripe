<?php
namespace FutureActivities\Stripe\Api\Data;

/**
 * @api
 */
interface CredentialsResultInterface
{
    /**
     * Set the data
     * 
     * @param boolean $value
     * @return null
     */
    public function setTestEnabled($value);
        
    /**
     * Get the result 
     * 
     * @return boolean
     */
    public function getTestEnabled();
    
    /**
     * Set the data
     * 
     * @param string $id
     * @return string
     */
    public function setTest($id);
    
    /**
     * Get the result
     * 
     * @return string
     */
    public function getTest();

    /**
     * Set the data
     * 
     * @param string $id
     * @return null
     */
    public function setLive($id);
        
    /**
     * Get the result ID
     * 
     * @return string
     */
    public function getLive();
}
