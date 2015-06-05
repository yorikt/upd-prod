<?php

class FME_Productattachments_Model_Observer_Product extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the manufacturers_id refers to the key field in your database table.
        $this->_init('productattachments/productattachments', 'productattachments_id');
    }
	
	/**
	 * This method will run when the product is saved
	 * Use this function to update the product model and save
	 *
	 * @param Varien_Event_Observer $observer
	 */
	public function saveTabData(Varien_Event_Observer $observer)
	{
		if ($post = $this->_getRequest()->getPost()) {
			

			//========================================================================
			$related_flag = 0;
			if(isset($post['links'])) {	$related_flag = 1;	} //added on 5th september 2014
			//Upload File 
			$files = $this->uploadFiles( $_FILES );
			
			    if( $files && is_array($files)){
				$files_arr = array_filter($files);
			    		if(!empty($files_arr)){
						$temp_var1 = $post['page'];
						$temp_var2 = $post['limit'];
						$temp_var3 = $post['in_attachments'];
						$temp_var4 = $post['productattachments_id'];
						$temp_var5 = $post['links'];	
		
						unset($post['page']);
						unset($post['limit']);
						unset($post['in_attachments']);
						unset($post['productattachments_id']);
						unset($post['links']); 		
					 
				for( $f=0; $f<count($files); $f++ ){  
				    if(($files[$f])){
				        $fieldname = str_replace('_uploader','',$files[$f]['fieldname']);
				        
				        if( array_key_exists($fieldname, $post) ){
				            $post['filename'] = $files[$f]['url'];
							
									//Get File Size, Icon, Type
									$fileconfig = Mage::getModel('productattachments/image_fileicon');
									$filePath = Mage::getBaseDir('media').'/'.$post['filename'];
									$fileconfig->Fileicon($filePath);
							
									$post['file_icon'] = $fileconfig->displayIcon();
									$post['file_type'] = $fileconfig->getType();
									$post['file_size'] = $fileconfig->getSize();
							
									$fileURL = Mage::getBaseUrl('media').$post['filename'];
									$post['download_link'] = "<a href='".$fileURL."' target='_blank'>Download</a>";
							
				        } 
				   }  
				}  
			   
			
			
					$model = Mage::getModel('productattachments/productattachments');		
					$model->setData($post);
						//->setId($this->getRequest()->getParam('id'));

					try {
						if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
							$model->setCreatedTime(now())
								->setUpdateTime(now());
						} else {
							$model->setUpdateTime(now());
						}	
				
						$attach_details = $model->save();
						 
						$post['page'] = $temp_var1;
						$post['limit'] = $temp_var2;
						$post['in_attachments'] = $temp_var3;
						$post['productattachments_id'] = $temp_var4;
						$post['links'] = $temp_var5; 
						 				 
						if(isset($attach_details['productattachments_id']) &&  $attach_details['productattachments_id']!='')
						{
							$final_attachment_links = $attach_details['productattachments_id'];
					
							if(isset($post['links']) && $post['links']['related_attachments']!=''){
					
								$final_attachment_links .= '&'.$post['links']['related_attachments'];
							}
							$post['links']['related_attachments'] = $final_attachment_links;
						}
						 
					} catch (Exception $e) {
						//echo $e->getMessage();
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				Mage::getSingleton('adminhtml/session')->setFormData($data);
				//$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				//return;
			    }		
			   }
			 } 
			
			//========================================================================


			$productID = Mage::registry('current_product')->getId();
			$condition = $this->_getWriteAdapter()->quoteInto('product_id = ?', $productID);
			
			//Get Related Products	
			
			if(isset($post['links'])) {
				$links = $post['links'];
			}
			
			if (isset($links['related_attachments'])) {
				
				$attachmentIds = Mage::helper('adminhtml/js')->decodeGridSerializedInput($links['related_attachments']);

				if($related_flag == 0 && $files && is_array($files) ) {	}else{ //added on 5th september 2014
					$this->_getWriteAdapter()->delete($this->getTable('productattachments_products'), $condition);
				}
				
				//Save Related Products
				foreach ($attachmentIds as $_attachment) {
					$attachmentArray = array();
					$attachmentArray['productattachments_id'] = $_attachment;
					$attachmentArray['product_id'] = $productID;
					$this->_getWriteAdapter()->insert($this->getTable('productattachments_products'), $attachmentArray);
				}
			} 
		}
	}
	
	/**
	 * Shortcut to getRequest
	 */
	protected function _getRequest()
	{
		return Mage::app()->getRequest();
	}

	protected function uploadFiles( $files ){
        if( !empty($files) && is_array($files) ){
            $result = array();
            foreach( $files as $file=>$info ){
                $result[] = $this->uploadFile( $file );
            }
            return $result;
        }
    }
    
    protected function uploadFile( $file_name ){

        if( !empty($_FILES[$file_name]['name']) ){
            $result = array();
            $dynamicScmsURL = 'productattachments' . DS . 'files';
            $baseScmsMediaURL = Mage::getBaseUrl('media') . DS . 'productattachments' . DS . 'files';
            $baseScmsMediaPath = Mage::getBaseDir('media') . DS .  'productattachments' . DS . 'files';
            
			//Mage::helper('adminhtml')->getAllowedFileExtensions();
			
            $uploader = new Varien_File_Uploader( $file_name );
            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png','pdf','xls','xlsx','doc','docx','zip','ppt','pptx','flv','mp3','mp4','csv','html','bmp','txt','rtf','psd'));
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $result = $uploader->save( $baseScmsMediaPath );
       
            $file = str_replace(DS, '/', $result['file']);
            if( substr($baseScmsMediaURL, strlen($baseScmsMediaURL)-1)=='/' && substr($file, 0, 1)=='/' )    $file = substr($file, 1);
						
            $ScmsMediaUrl = $dynamicScmsURL.$file;
            
            $result['fieldname'] = $file_name;
            $result['url'] = $ScmsMediaUrl;
            $result['file'] = $result['file'];
            return $result;
        } else {
            return false;
        }
    } 
}
