<?php

class SomethingDigital_Criteo_Block_Listing extends Mage_Catalog_Block_Product_List
{
    /**
     * Get the first three products from the current category page
     * 
     * @return string
     */
    public function getCriteoViewList()
    {   
        $i = 0;
        $data = [];
        foreach($this->getLoadedProductCollection() as $product) {
            $data[] = $product->getData(Mage::getStoreConfig('somethingdigital_criteo/settings/product_identifier'));
            $i++;
            if($i >= 3) {
                break;
            }
        }
        return json_encode($data);
    }

    /**
     * Get searched keywords
     * @return string
     */
    public function getCriteoSearchKeywords()
    {
        /** @var Mage_CatalogSearch_Helper_Data $catalogsearch */
        $catalogsearch = Mage::helper('catalogsearch');
        return $catalogsearch->getQueryText();
    }
}