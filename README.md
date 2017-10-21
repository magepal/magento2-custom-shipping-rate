## Custom Shipping Rate for Magento2

[![Total Downloads](https://poser.pugx.org/magepal/magento2-customshippingrate/downloads)](https://packagist.org/packages/magepal/magento2-customshippingrate)
[![Latest Stable Version](https://poser.pugx.org/magepal/magento2-customshippingrate/v/stable)](https://packagist.org/packages/magepal/magento2-customshippingrate)

Set custom shipping rates for individual customer, orders and/or delivery areas

#### 1 - Installation 
##### Manual Installation
To install Custom Shipping Rate for Magento2
 * Download the extension
 * Unzip the file
 * Create a folder {Magento root}/app/code/MagePal/CustomShippingRate
 * Copy the content from the unzip folder


##### Using Composer

```
composer require magepal/magento2-customshippingrate
```

#### 2 -  Enable Custom Shipping Rate
 * php -f bin/magento module:enable --clear-static-content MagePal_CustomShippingRate
 * php -f bin/magento setup:upgrade

#### 3 - Config Custom Shipping Rate
Log into your Magento Admin, then goto Stores -> Configuration -> Sales -> Shipping Methods -> Custom Shipping Rate


### Admin Order Create

![Magento Custom Shippiing Rate Admin](https://user-images.githubusercontent.com/1415141/31851928-739627c4-b63d-11e7-9015-631047df5e48.gif)

### Frontend

![Magento Custom Shippiing Rate Frontend](https://cloud.githubusercontent.com/assets/1415141/24302598/9202baf6-1089-11e7-8396-8460a1699fdd.png)

### Configuration

![Magento Custom Shippiing Rate Configuration](https://cloud.githubusercontent.com/assets/1415141/18804815/4573fa96-81ce-11e6-93bf-5b8ece97e237.png)


----

Need help setting up or want to customize this extension to meet your business needs? Please email support@magepal.com and if we like your idea we will add this feature for free or at a discounted rate.
