<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
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
 * @category    design
 * @package     default_default
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
class Vendor_Vendors_Block_Adminhtml_Managevendors_Historylist extends Mage_Adminhtml_Block_Widget_Grid{}
$paramId  =  Mage:: registry ('paramId');
$adminId  =  Mage:: registry ('admin_id');

//$collection = Mage::getModel('comment/comment')->getCollection()->addFieldToFilter(array('vendor_id','admin_id'), array($paramId,$adminId))->setOrder('created_at','DESC');
$collection = Mage::getModel('comment/comment')->getCollection()->addFieldToFilter('admin_id',$adminId)->addFieldToFilter('vendor_id',$paramId)->setOrder('created_at','DESC');

 
$history = array();
foreach($collection as $value){
	$history[] = array('comment'=>$value->getComment(),'created_at'=>$value->getCreatedAt(),'admin_id'=>$value->getAdminId());
}
ob_start("callback");

?>

<div  id="container_add_comment_form">


<button style="float: right;margin-right:5px;" onclick="openCommentForm();" class="scalable " type="button" title="Reset" id="">
<span><span><span>Add Comment</span></span></span>
</button>
<br><br>
<div style="display: block;" id="add_comment_form">
	<div class="entry-edit-head">
	    <h4 class="icon-head head-edit-form fieldset-legend">Comment</h4>
	    <div class="form-buttons"></div>
	</div>
	<div class="entry-edit  fieldset ">
	    
		<div style="clear: both;">&nbsp;</div>
	    <div id="comment_form" style="display: none;">
		    <div class="hor-scroll">
		            <span class="field-row">
		               <label for="comment">Comment <span class="required">*</span></label>
					   <textarea cols="120" rows="6" class="textarea" name="comment[comment]" id="comment"></textarea>
					</span>
					<table cellspacing="0" class="form-list">
			            <tbody>
			                <tr>
			                   <td class="hidden" colspan="2">
			                   	<input type="hidden" value="1" name="comment[status]" id="status">
			                   </td>
			    			</tr>
							<tr>
			        			<td class="label" style="width: 140px;"></td>
			    				<td class="value" >
			    					<button style="" onclick="addComment();" name="comment[comment]" class="scalable save" type="button" title="Add Comment" id="">
			    					<span><span><span>Add Comment</span></span></span></button>
			        				<button style="float: right;margin-right: 100px;" onclick="closeCommentForm();" class="scalable " type="button" title="Reset" id="">
									<span><span><span>Cancel</span></span></span>
									</button>
			        			</td>
			    			</tr>
							<tr>
			        			<td class="hidden" colspan="2">
			        				<input type="hidden" value="<?php echo $paramId;?>" name="comment[vendor_id]" id="vendor_id">
			        			</td>
			    			</tr>
							<tr>
			        			<td class="hidden" colspan="2">
			        				<?php $user = Mage::getSingleton('admin/session');
						  				$userId = $user->getUser()->getUserId();?>
									<input type="hidden" value="<?php echo $userId;?>" name="comment[admin_id]" id="admin_id">
			        				<input type="hidden" value="<?php echo Mage::helper('adminhtml')->getUrl('/comment_comment/save/key');?>" name="comment[comment_url]" id="comment_url">
			        				<input type="hidden" value="<?php echo Mage::helper('adminhtml')->getUrl('/vendors_managevendors/commentsHistory/id/'.$paramId);?>" name="comment[comment_list_url]" id="comment_list_url">
			        			
			        			</td>
			    			</tr>
			
			            </tbody>
		       		</table>
		    	</div>
		    </div>
		    <div class="entry-edit" id="entry-edit">
   
        <ul class="note-list">
        <?php foreach ($history as $_item):
       
        ?>
        <?php
        $user = Mage::getModel('admin/user')->getCollection()->getData();
      
        //echo "<pre>";
        $name = '';
        foreach($user as $userData=>$val){
        	if($_item['admin_id']==$val['user_id']){
				$name = ucfirst($val['firstname']).' '.ucfirst($val['lastname']);
        	}
		} 
        ?>
            <li>
                <strong><?php echo date("F j, Y g:i a",strtotime($_item['created_at'])); ?> - <?php echo $name;?></strong>
                <?php //echo $this->getItemCreatedAt($_item, 'time') ?>
                <?php if (isset($_item['comment']) && $_item['comment']!=''): ?>
                    <br/><?php echo $_item['comment']; ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ul>
   
	</div>
	    
	    
	</div>
	
	
</div>
</div>
<?php 
ob_end_flush();
?>
