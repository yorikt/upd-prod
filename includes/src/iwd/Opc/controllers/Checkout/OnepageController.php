<?php
require_once Mage::getModuleDir('controllers', 'Mage_Checkout').DS.'OnepageController.php';
class IWD_Opc_Checkout_OnepageController extends Mage_Checkout_OnepageController{

   

    /**
     * Checkout page
     */
    public function indexAction(){
    	
    	$scheme = Mage::app()->getRequest()->getScheme();
    	if ($scheme == 'http'){
    		$secure = false;
    	}else{
    		$secure = true;
    	}
    	
    	if (Mage::helper('opc')->isEnable()){
    		$this->_redirect('onepage', array('_secure'=>$secure));
    		return;
    	}else{
    		parent::indexAction();
    	}
    }  
}