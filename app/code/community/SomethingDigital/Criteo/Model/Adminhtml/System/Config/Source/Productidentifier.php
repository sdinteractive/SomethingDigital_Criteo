<?php

class SomethingDigital_Criteo_Model_Adminhtml_System_Config_Source_Productidentifier
{
    /**
     * Options for Product Identifier select field
     * 
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'entity_id', 'label' => 'ID'),
            array('value' => 'sku', 'label' => 'SKU'),
        );
    }
}