## Custom Shipping Rate for Magento2

[![Total Downloads](https://poser.pugx.org/magepal/magento2-customshippingrate/downloads)](https://packagist.org/packages/magepal/magento2-customshippingrate)
[![Latest Stable Version](https://poser.pugx.org/magepal/magento2-customshippingrate/v/stable)](https://packagist.org/packages/magepal/magento2-customshippingrate)

This extension provides store owners the ability to add custom shipping cost for every admin order or create predefined shipping methods for frontend customers.

### Custom Shipping Price for Admin Order

![Magento2 Custom Shippiing Rate Admin](https://image.ibb.co/ijTPtH/Custom_Shipping_Rate_for_Magento2_by_Magepal.gif)

### Frontend Shipping Methods

![Magento2 Custom Shippiing Method Frontend](https://image.ibb.co/hjHHDH/Custom_Shipping_Rate_for_Magento2_frontend.png)

### Shipping Configuration

![Magento2 Custom Shippiing price Configuration](https://image.ibb.co/fuxv0x/Custom_Shipping_Rate_for_Magento2_backend.png)

## Installation

#### Step 1 

##### Using Composer (recommended)

```
composer require magepal/magento2-customshippingrate
```

##### Manual Installation
To install Custom Shipping Rate for Magento2
 * Download the extension
 * Unzip the file
 * Create a folder {Magento root}/app/code/MagePal/CustomShippingRate
 * Copy the content from the unzip folder



#### Step 2 -  Enable Custom Shipping Rate
 * php -f bin/magento module:enable --clear-static-content MagePal_CustomShippingRate
 * php -f bin/magento setup:upgrade

#### Step 3 - Config Custom Shipping Rate
Log into your Magento Admin, then goto Stores -> Configuration -> Sales -> Shipping Methods -> Custom Shipping Rate


Contribution
---
Want to contribute to this extension? The quickest way is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).


Support
---
If you encounter any problems or bugs, please open an issue on [GitHub](https://github.com/magepal/magento2-customshippingrate/issues).

Need help setting up or want to customize this extension to meet your business needs? Please email support@magepal.com and if we like your idea we will add this feature for free or at a discounted rate.

© MagePal LLC.
