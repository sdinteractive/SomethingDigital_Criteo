<?php

class SomethingDigital_Criteo_Block_Result extends Mage_CatalogSearch_Block_Result
{
    /**
     * Maximum result identifiers to include in the list for Criteo.
	 *
	 * @const int
     */
    const CRITEO_UPPER_BOUND = 3;

    public function getCriteoViewListAsJson()
    {
        // Set up list sorting options (to mimic regular search.)
        $this->setListOrders();
        $this->setListModes();
        $this->setListCollection();

        $list = $this->getListBlock();

        // Now we need to trigger the list's pre-html logic.
        // This applies the necessary sorting options to the collection.
        // Note that the collection is cached for later, so we must do this.
        $list->_beforeToHtml();

        $i = 0;
        $data = [];
        $identifier_key = Mage::getStoreConfig('somethingdigital_criteo/settings/product_identifier');
        foreach($list->getLoadedProductCollection() as $product) {
            $data[] = $product->getData($identifier_key);
            $i++;
            if($i >= self::CRITEO_UPPER_BOUND) {
                break;
            }
        }

        return json_encode($data);
    }

    /**
     * Retrieve a product block list to pull product items from.
     *
     * Note that this is never rendered; we only want to reuse its logic to sort products correctly.
     *
     * @return Mage_Catalog_Block_Product_List
     */
    public function getListBlock()
    {
        return $this->getLayout()->getBlockSingleton('Mage_Catalog_Block_Product_List');
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