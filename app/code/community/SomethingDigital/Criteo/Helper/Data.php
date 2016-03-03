<?php

class SomethingDigital_Criteo_Helper_Data extends Mage_Core_Helper_Abstract
{   
    /**
     * Get a hash of the customer's email address per Criteo requirements
     *
     * Returns an empty string if the customer is not logged in
     * 
     * @return string 
     */   
    public function getHashedEmail()
    {
        $email = Mage::helper('customer')->getCustomer()->getEmail();
        if($email) {
            return md5(mb_convert_encoding(trim(strtolower(str_replace('"',"",$email))), "UTF-8", "ISO-8859-1"));
        }
        return '';
    }

    /**
     * Converts entity_id to product_id to get the product ID from non product 
     * entities
     * 
     * @return string
     */
    public function handleConfigProductIdentifier()
    {
        $conf = Mage::getStoreConfig('somethingdigital_criteo/settings/product_identifier');
        if($conf === 'entity_id') {
            return 'product_id';
        }
        return $conf;
    }
}