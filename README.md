# MageGuide OutOfStockSwatches
Tested on: ```2.3+```

## Description
When a configurable product has one super attribute and one of its children is out of stock, Magento would not display the out of stock child. It would display it only when the option `Display Out of Stock Products` is set to Yes. With this module you can show the out of stock swatches without enabling this option.

## Functionalities 
- Out of stock swatches are displayed by default.
- These swatches would be crossed out and user would not be able to select them.

## Steps to setup
- Upload module files in `app/code/MageGuide`
- Install module
```
        $ php bin/magento module:enable MageGuide_OutOfStockSwatches
        $ php bin/magento setup:upgrade
        $ php bin/magento setup:di:compile
```

