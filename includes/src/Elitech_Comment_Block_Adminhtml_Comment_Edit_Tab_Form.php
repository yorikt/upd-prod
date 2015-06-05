<?php
/**
 * Elitech_Comment extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category   	Elitech
 * @package		Elitech_Comment
 * @copyright  	Copyright (c) 2014
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Comment edit form tab
 *
 * @category	Elitech
 * @package		Elitech_Comment
 * @author Ultimate Module Creator
 */
class Elitech_Comment_Block_Adminhtml_Comment_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form{	
	/**
	 * prepare the form
	 * @access protected
	 * @return Comment_Comment_Block_Adminhtml_Comment_Edit_Tab_Form
	 * @author Ultimate Module Creator
	 */
	protected function _prepareForm(){
		$form = new Varien_Data_Form();
		$form->setHtmlIdPrefix('comment_');
		$form->setFieldNameSuffix('comment');
		$this->setForm($form);
		$fieldset = $form->addFieldset('comment_form', array('legend'=>Mage::helper('comment')->__('Comment')));
		$wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig();

		$fieldset->addField('comment', 'editor', array(
			'label' => Mage::helper('comment')->__('Comment'),
			'name'  => 'comment',
			'config'	=> $wysiwygConfig,
			'required'  => true,
			'class' => 'required-entry',

		));

		$fieldset->addField('address', 'text', array(
			'label' => Mage::helper('comment')->__('Address'),
			'name'  => 'address',

		));
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('comment')->__('Status'),
			'name'  => 'status',
			'values'=> array(
				array(
					'value' => 1,
					'label' => Mage::helper('comment')->__('Enabled'),
				),
				array(
					'value' => 0,
					'label' => Mage::helper('comment')->__('Disabled'),
				),
			),
		));
		if (Mage::app()->isSingleStoreMode()){
			$fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));
            Mage::registry('current_comment')->setStoreId(Mage::app()->getStore(true)->getId());
		}
		if (Mage::getSingleton('adminhtml/session')->getCommentData()){
			$form->setValues(Mage::getSingleton('adminhtml/session')->getCommentData());
			Mage::getSingleton('adminhtml/session')->setCommentData(null);
		}
		elseif (Mage::registry('current_comment')){
			$form->setValues(Mage::registry('current_comment')->getData());
		}
		return parent::_prepareForm();
	}
}