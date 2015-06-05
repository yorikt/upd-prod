<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Vendor_Vendors_Block_Adminhtml_Managevendors_Edit_Tab_Commentgrid extends Mage_Adminhtml_Block_Template 
{

	public function __construct(){
		parent::__construct();
		/*$this->setId('commentGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);*/
		
		//$this->setTemplate('sales/order/view/tab/historylist.phtml');
	}

	/*protected function _prepareCollection(){
		$collection = Mage::getModel('comment/comment')->getCollection()->addFieldToFilter(array('vendor_id'), array($this->getRequest()->getParam('id')));
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}*/
    
    protected function getFullHistory()
    {
    	$user = Mage::getSingleton('admin/session');
    	$userId = $user->getUser()->getUserId();
    	
    	//$collection = Mage::getModel('comment/comment')->getCollection()->addFieldToFilter(array('vendor_id','admin_id'), array($this->getRequest()->getParam('id'),$userId));
    	$collection = Mage::getModel('comment/comment')->getCollection()->addFieldToFilter('admin_id',$adminId)->addFieldToFilter('vendor_id',$this->getRequest()->getParam('id'))->setOrder('created_at','DESC');
    	
    	$history = array();
    	foreach($collection as $value){
    		$history[] = array('comment'=>$value->getComment(),'created_at'=>$value->getCreatedAt());
    	}
    	
    	return $history;
    
    	//return parent::_prepareColumns();
    }
    
    

}?>
<script type="text/javascript">
function addComment(){

	if(document.getElementById('comment').value==''){
		alert('Comment can not be null');
		return false;
	}

	$action = document.getElementById('comment_url').value;
	var reloadurl = $action;
	new Ajax.Request(reloadurl, {
		method: 'post',
		parameters: "comment[comment]="+document.getElementById('comment').value+"&comment[status]="+document.getElementById('status').value+"&comment[vendor_id]="+document.getElementById('vendor_id').value+'&comment[admin_id]='+document.getElementById('admin_id').value,
		onComplete: function(transport) {
			document.getElementById('add_comment_form').style.display == 'block';
			document.getElementById('comment').value = '';
			
			
			$action_list = document.getElementById('comment_list_url').value;
			var reloadurl_list = $action_list;
			new Ajax.Request(reloadurl_list, {
				method: 'post',
				parameters: "",
				onComplete: function(transport) {
					
					
					document.getElementById('add_comment_form').style.display == 'block';
					$('container_add_comment_form').update(transport.responseText);
					document.getElementById('add_comment_form').style.display == 'block';
					/*document.getElementById('entry-edit').innerHTML = "";
					document.getElementById('entry-edit').innerHTML = transport.innerHTML;*/
				}
			});
			
		}
	});
}

function openCommentForm(){
	if(document.getElementById('comment_form').style.display == 'none')
	{
		document.getElementById('comment_form').style.display='block';
	}
	/*else
	{
		document.getElementById('add_comment_form').style.display = 'none';
	}*/	
}
function closeCommentForm(){
	if(document.getElementById('comment_form').style.display == 'block')
	{
		document.getElementById('comment_form').style.display='none';
	}
	/*else
	{
		document.getElementById('add_comment_form').style.display = 'none';
	}*/	
}
</script>