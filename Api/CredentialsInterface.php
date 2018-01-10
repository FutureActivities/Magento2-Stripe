<?php
namespace FutureActivities\Stripe\Api;
 
interface CredentialsInterface
{
    /**
     * Returns the test and live public keys
     * 
     * @api
     * @return FutureActivities\Stripe\Api\Data\CredentialsResultInterface
     */
    public function client();
}