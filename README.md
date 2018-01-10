# FutureActivities Stripe

A simple Stripe payment method for use with Magento REST API.
This also supports refunds from within the Magento admin.

## How to use

This is a Magento REST API only checkout method. PUT an order to the following endpoint:

    /rest/V1/carts/mine/order
    
With the following data:

    {
        "paymentMethod": {
            "method": "stripe_rest",
    		"additional_data": {
    		    "token": "[STRIPE-TOKEN]"
    		}
        }
    }

## Settings

When enabling this payment method you need to set the public and secret keys, for both the test and live versions.

## API

Call the following API endpoint to retrieve the test and live public keys:

    /V1/stripe/credentials
