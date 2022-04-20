![CardGate](https://cdn.curopayments.net/thumb/200/logos/cardgate.png)

# CardGate module for CS.Cart

[![Build Status](https://travis-ci.org/cardgate/cs-cart.svg?branch=master)](https://travis-ci.org/cardgate/cs-cart)

## Support

This plugin supports CS.Cart version **4.4.x-4.14.x**

## Preparation

The usage of this module requires that you have obtained CardGate RESTful API credentials.  
Please visit [My CardGate](https://my.cardgate.com/) and retrieve your credentials, or contact your accountmanager.

## Installation

1. Download and unzip the most recent [cardgate.zip](https://github.com/cardgate/cs-cart/releases) file on your desktop.

2. Upload the **contents** of the **cardgate** folder to the **root** folder of your webshop.

3. **Clear your cache.** Perhaps the Smarty templates need to be recompiled before changes to the templates are **visible.**

4. You can achieve this by adding the parameter **ctpl** to your admin URL.

## Configuration

1. Login to the **admin** of your webshop.

2. Go to **Add-ons**, and choose **Manage add-ons**.

3. Use the Search Box to find the CardGate add-on and click **Install**.

4. Click on **Settings** of the installed add-on.

5. Set the Mode to **Test** for a test transaction.

6. Enter the **site ID**, and **hash key** which you can find at **Sites** on [My CardGate](https://my.cardgate.com/).

7. Enter the **merchant ID** and the **API key** which you have received from CardGate.

8. Click on **Save**.

9. **N.B.** These settings apply to **all** CardGate payment methods.

10. Next, create the **specific** CardGate payment methods that you want to use in your shop.

11. Choose **Payment methods** in the **Administration** menu.

12. Click on the **Add payment** button. 

13. Fill in the name of the payment method and choose the appropriate **CardGate** payment method from the **Processor** menu.

14. Fill in the other details and click on the **Save** button.  
 
15. The settings of the **General** tab are applicable for each **specific** payment method.

16. Make sure when you are finished testing that you switch from **Test Mode** to **Live Mode** in the **CardGate** settings and save it (**Save**).

## Requirements

No further requirements.
