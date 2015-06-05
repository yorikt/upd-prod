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
class USAPoolDirect_Purchaseorder_Block_Adminhtml_Purchaseorder_Commmetlist extends Mage_Adminhtml_Block_Template{}
$tablename = Mage::getSingleton("core/resource")->getTableName('purchaseorder_comment_comment');
$connection = Mage::getSingleton('core/resource')->getConnection('core_write');

$user = Mage::getSingleton('admin/session');
$user_id = $user->getUser()->getUserId();

$order_id  =  Mage:: registry ('order_id');
$po_number  =  Mage:: registry ('po_number');
$query = 'SELECT * FROM ' . $tablename .'
WHERE admin_id = '.$user_id.' AND order_id = '.$order_id.' AND po_number='.$po_number.' AND status=1 ORDER BY created_at desc';
$comment_data = $connection->fetchAll($query);

$history = array();
foreach($comment_data as $value){
	
	$history[] = array('comment'=>$value['comment'],'created_at'=>$value['created_at'],
						'firstname'=>$value['admin_first_name'],'lastname'=>$value['admin_last_name']);
}
ob_start("callback");

?>


   
        <ul class="note-list">
        <?php foreach ($history as $_item):
       
        ?>
        <li>
                <strong><?php echo date("F j, Y g:i a",strtotime($_item['created_at'])); ?> - <?php echo $_item['firstname']." ".$_item['lastname'];?></strong>
                <?php //echo $this->getItemCreatedAt($_item, 'time') ?>
                <?php if (isset($_item['comment']) && $_item['comment']!=''): ?>
                    <br/><?php echo $_item['comment']; ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ul>
   
<?php 
ob_end_flush();
?>