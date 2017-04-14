<?php

class SomethingDigital_Criteo_Block_Basket extends Mage_Checkout_Block_Cart
{
    // List of supported checkout controllers
    protected $_checkoutControllers = array('onepage', 'onestepcheckout');


    /**
     * Get the contents of the cart in JSON format to be sent to Criteo
     *
     * @return string
     */
    public function getCriteoViewBasket()
    {
        $basket = [];
        $i = 0;
        foreach($this->getItems() as $item) {
            $basket[$i]['id'] = $item->getData(Mage::helper('somethingdigital_criteo')->handleConfigProductIdentifier());
            $basket[$i]['price'] = $item->getData('price');
            $basket[$i]['quantity'] = $item->getData('qty');
            $i++;
        }
        return json_encode($basket);
    }

    /**
     * Determines whether or not the tracker should be fired
     *
     * @return boolean
     */
    public function fireTracker()
    {
        $controller = Mage::app()->getRequest()->getControllerName();
        $fireTrackerAtCheckout = Mage::getStoreConfig('somethingdigital_criteo/settings/fire_basket_tracker_at_checkout');
        return ((in_array($controller, $this->_checkoutControllers) && $fireTrackerAtCheckout) || !in_array($controller, $this->_checkoutControllers));
    }
}
