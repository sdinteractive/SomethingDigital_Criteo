<?php

class SomethingDigital_Criteo_Block_Success extends Mage_Checkout_Block_Onepage_Success
{
    /**
     * Determines whether or not order was placed by a new customer
     * 
     * @return int
     */
    public function getCriteoIsNewCustomer()
    {
        $customer = Mage::getSingleton('customer/session');
        $orders = Mage::getResourceModel('sales/order_collection')->addFieldToSelect('*')->addFieldToFilter('customer_id',$customer->getId());
        if($orders->count() < 2) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Gets the order items in the format required by Criteo
     * 
     * @return string
     */
    public function getCriteoOrderItems()
    {
        $orderId = Mage::getSingleton('checkout/session')->getLastOrderId();
        $order = Mage::getModel('sales/order')->load($orderId);
        $items = $order->getAllVisibleItems();
        $arr = [];
        $i = 0;
        foreach($items as $item) {
            $arr[$i]['id'] = $item->getData(Mage::helper('somethingdigital_criteo')->handleConfigProductIdentifier());
            $arr[$i]['price'] = (double)substr($item->getData('price'), 0, -2);
            $arr[$i]['quantity'] = (int)substr($item->getData('qty_ordered'), 0, -5);
            $i++;
        }
        return json_encode($arr);
    }
}
