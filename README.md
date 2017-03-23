## Custom Shipping Rate for Magento2
Set custom shipping rates for individual customer, orders and/or delivery areas

#### 1 - Installation 
##### Manual Installation
Install Gmail Smtp App for Magento2
 * Download the extension
 * Unzip the file
 * Create a folder {Magento root}/app/code/MagePal/CustomShippingRate
 * Copy the content from the unzip folder


##### Using Composer

```
composer config repositories.magepal-customshippingrate git git@github.com:magepal/magento2-customshippingrate.git
composer require magepal/magento2-customshippingrate
```

#### 2 -  Enable Custom Shipping Rate
 * php -f bin/magento module:enable --clear-static-content MagePal_CustomShippingRate
 * php -f bin/magento setup:upgrade

#### 3 - Config Custom Shipping Rate
Log into your Magento Admin, then goto Stores -> Configuration -> Sales -> Shipping Methods -> Custom Shipping Rate (Admin Only)


### Order Create

![image](https://cloud.githubusercontent.com/assets/1415141/18804805/305c80f6-81ce-11e6-8b50-004bb12c35d5.png)

### Configuration

![image](https://cloud.githubusercontent.com/assets/1415141/18804815/4573fa96-81ce-11e6-93bf-5b8ece97e237.png)

