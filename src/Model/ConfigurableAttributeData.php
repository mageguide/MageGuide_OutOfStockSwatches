<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace MageGuide\OutOfStockSwatches\Model;

use Magento\Catalog\Model\Product;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable\Attribute;

/**
 * Class ConfigurableAttributeData
 * @api
 * @since 100.0.2
 */
class ConfigurableAttributeData extends \Magento\ConfigurableProduct\Model\ConfigurableAttributeData
{

    /**
     * @var \Magento\CatalogInventory\Model\Stock\Item
     */
    private $stockItem;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $modelProduct;

    public function __construct(
        \Magento\CatalogInventory\Model\Stock\Item $stockItem,
        \Magento\Catalog\Model\Product $modelProduct //,
        //\Magento\InventorySalesAdminUi\Model\GetSalableQuantityDataBySku $salableStockStatus
    )
    {
        $this->stockItem = $stockItem;
        $this->modelProduct = $modelProduct;
        //$this->_salableStockStatus = $salableStockStatus;
    }

    /**
     * Get product attributes
     *
     * @param Product $product
     * @param array $options
     * @return array
     */
    public function getAttributesData(Product $product, array $options = [])
    {
        $defaultValues = [];
        $attributes = [];
        $onesizeLabel = $product->getData('onesize_label');
        foreach ($product->getTypeInstance()->getConfigurableAttributes($product) as $attribute) {
            $attributeOptionsData = $this->getAttributeOptionsData($attribute, $options);
            if ($attributeOptionsData) {
                $productAttribute = $attribute->getProductAttribute();
                $attributeId = $productAttribute->getId();
                $attributes[$attributeId] = [
                    'id' => $attributeId,
                    'code' => $productAttribute->getAttributeCode(),
                    'label' => $productAttribute->getStoreLabel($product->getStoreId()),
                    'options' => $attributeOptionsData,
                    'position' => $attribute->getPosition(),
                    'onesizeLabel' => $onesizeLabel,
                ];
                $defaultValues[$attributeId] = $this->getAttributeConfigValue($attributeId, $product);
            }
        }
        return [
            'attributes' => $attributes,
            'defaultValues' => $defaultValues,
        ];
    }

    /**
     * @param Attribute $attribute
     * @param array $config
     * @return array
     */
    protected function getAttributeOptionsData($attribute, $config)
    {
        $attributeOptionsData = [];
        foreach ($attribute->getOptions() as $attributeOption) {
            try {
                $optionId = $attributeOption['value_index'];
                //$stockItem = $this->stockItem->load($config[$attribute->getAttributeId()][$optionId], 'product_id');
                //$productqty = $stockItem->getQty();
                $loadedProduct = $this->modelProduct->load($config[$attribute->getAttributeId()][$optionId][0]);
                $productqty = $loadedProduct->getQuantityAndStockStatus()['qty'];
                //$qty = $this->_salableStockStatus->execute($loadedProduct->getSku());
//                if(array_key_exists(0, $qty)){
//                    if(array_key_exists('qty', $qty[0])){
//                        $productqty= $qty[0]['qty'];
//                    }
//                }
                $attributeOptionsData[] = [
                    'id' => $optionId,
                    'label' => $attributeOption['label'],
                    'products' => isset($config[$attribute->getAttributeId()][$optionId])
                        ? $config[$attribute->getAttributeId()][$optionId]
                        : [],
                    'productqty' => $productqty,
                ];
            } catch (\Exception $e) {

            }
        }
        return $attributeOptionsData;
    }
}
