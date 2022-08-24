<?php

namespace MageGuide\OutOfStockSwatches\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
//use Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku;

class StockStatus extends AbstractHelper
{
    /**
     * @var GetSalableQuantityDataBySku
     */
    protected $_salabelStockStatus;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context
        //,GetSalableQuantityDataBySku $salableQuantityDataBySku
    ) {
        parent::__construct($context);
        //$this->_salabelStockStatus = $salableQuantityDataBySku;
    }

    public function getStockBySku($sku){
        //return $this->_salabelStockStatus->execute($sku);
    }


}
