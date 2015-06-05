<?php
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_MeigeewidgetsUnique_Block_Featuredcategory
extends Mage_Catalog_Block_Product_Abstract
implements Mage_Widget_Block_Interface
{
    protected $products;

    protected function _construct() {
        parent::_construct();
    }

    protected function catId()
    {
        $cat = explode("/", $this->getData('featured_category'));     
        return $cat[1];
    }
    public function catName () {
        return Mage::getModel('catalog/category')->load($this->catId());
    }

    public function productsAmount() {
        return $this->getData('products_amount');
    }

	public function addToCart() {
		return $this->getData('add_to_cart');
	}

	public function productPrice() {
		return $this->getData('price');
	}

	public function productName() {
		return $this->getData('product_name');
	}

	public function quickView() {
		return $this->getData('quickview');
	}

	public function getQuickViewPos($params) {
		return $this->getData($params);
	}

	public function wishlist() {
		return $this->getData('wishlist');
	}
	
	public function compareProducts() {
		return $this->getData('compare');
	}

	public function ratingStars() {
		return $this->getData('rating_stars');
	}
	
	public function ratingCustLink() {
		return $this->getData('rating_cust_link');
	}
	
	public function ratingAddReviewLink() {
		return $this->getData('rating_add_review_link');
	}

	public function productsPerRow() {
		return $this->getData('products_per_row');
	}

	public function productLink() {
		return $this->getData('product_link');
	}

	public function getButtonsPosition() {
		return $this->getData('buttons_position');
	}

	public function getColumnsRatio(){
		return $this->getData('columns_ratio');
	}

    /*public function getColumnCount () {
        return $this->getData('column_count');
    }*/

    public function getMyCollection () {
		$this->products = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToSelect(array('name', 'price', 'small_image', 'short_description'), 'inner')
			->addAttributeToSelect('news_from_date')
			->addAttributeToSelect('news_to_date')
			->addAttributeToSelect('special_price')
->addAttributeToSelect('megnor_featured_product')
			->addAttributeToSelect('status')
			->addAttributeToFilter('visibility', array(2, 3, 4))
			->addAttributeToSelect('*')
->addAttributeToFilter('megnor_featured_product', '1')
			->addCategoryFilter(Mage::getModel('catalog/category')->load($this->catId()));

		return $this->products;
	}

    public function getSliderOptions () {
        
        if ($this->getData('template') == 'meigee/meigeewidgetsunique/slider.phtml' and $this->getData('autoSlide') == 1) {
            $options =
            ', autoSlide: 1, '
            . 'autoSlideTimer:'.$this->getData('autoSlideTimer').','
            .'autoSlideTransTimer:'.$this->getData('autoSlideTransTimer');
			return $options;
        }
    }
	
	public function getWidgetId () {
        return $this->getData("widget_id");
    }
}
