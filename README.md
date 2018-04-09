![CardGate](https://cdn.curopayments.net/thumb/200/logos/cardgate.png)

# CardGate module for CS.Cart

## Support

This plugin supports CS.Cart version **4.4.x-4.6.x**.

## Preparation

The usage of this module requires that you have obtained CardGate RESTful API credentials.
Please visit [My Cardgate](https://my.cardgate.com/) and retrieve your RESTful API username and password, or contact your accountmanager.

## Installation

1. Download and unzip the cardgate.zip file to your desktop.

2. Upload the **contents** of the zip file to the **root folder** of your webshop.

3. Open the URL **http://mywebshop.com/cardgate_install.php** in your browser, which will install the plug-in. (Replace **http://mywebshop.com** with the URL of your webshop)

4. Delete the file **cardgate_install.php** from the **root folder** of your webshop.

5. **Clear your cache.** Perhaps the Smarty templates need to be recompiled before changes to the templates are **visible.**

6. You can achieve this bij adding the parameter **ctpl** to your admin URL.

## Configuration

1. Login to the **admin** of your webshop.

2. Choose **Payment methods** in the **Administration** menu.

3. Click on the **Add payment** button. 

4. First the **CardGate Generic** payment method needs to be set. This payment method contains the configuration settings for all CardGate payment methods.

5. Fill in the name of the generic payment method and choose the **CardGate Generic** payment method from the **Processor** menu.

6. Make sure this payment method is **not Active** so that it won't be visible in the checkout.

7. Choose the **Configure** tab.

8. Enter the **Site ID**, and **Hash key** which you can find at **Sites** on <a href="https://my.cardgate.com" target='new'>My CardGate</a>.

9. Enter the **Merchant ID** and the **Merchant API Key** which you have received from CardGate.

10. Set the testmode to **Test** for a test transaction

11. Fill in the other details and click on the **Save** button.

12. **N.B.** These settings apply to **all** CardGate payment methods.  
 
13. In the same way, create the **specific** CardGate payment methods that you want to use in your shop.

14. The settings of the **General** tab are applicable for each **specific** payment method.

15. Make sure when you are finished testing that you switch from **Test Mode** to **Live Mode** in the **CardGate Generic** payment methodfor and save it (**Save**).

## Requirements

No further requirements.
