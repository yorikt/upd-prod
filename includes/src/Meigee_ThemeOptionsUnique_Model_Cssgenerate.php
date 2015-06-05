<?php 
/**
 * Magento
 *
 * @author    Meigeeteam http://www.meaigeeteam.com <nick@meaigeeteam.com>
 * @copyright Copyright (C) 2010 - 2012 Meigeeteam
 *
 */
class Meigee_ThemeOptionsUnique_Model_Cssgenerate extends Mage_Core_Model_Abstract
{
    private $baseColors;
	private $catlabelsColors;
    private $appearance;
    private $mediaPath;
    private $dirPath;
    private $filePath;
	private $headerColors;
	private $headerSliderColors;
	private $menuColors;
	private $contentColors;
	private $buttonsColors;
	private $productsColors;
	private $socialLinksColors;
	private $footerColors;

    private function setParams () {
        $this->baseColors = Mage::getStoreConfig('meigee_unique_design/base');
		$this->catlabelsColors = Mage::getStoreConfig('meigee_unique_design/catlabels');
        $this->appearance = Mage::getStoreConfig('meigee_unique_design/appearance');
		$this->headerColors = Mage::getStoreConfig('meigee_unique_design/header');
		$this->headerSliderColors = Mage::getStoreConfig('meigee_unique_design/headerslider');
		$this->menuColors = Mage::getStoreConfig('meigee_unique_design/menu');
		$this->contentColors = Mage::getStoreConfig('meigee_unique_design/content');
		$this->buttonsColors = Mage::getStoreConfig('meigee_unique_design/buttons');
		$this->productsColors = Mage::getStoreConfig('meigee_unique_design/products');
		$this->socialLinksColors = Mage::getStoreConfig('meigee_unique_design/social_links');
		$this->footerColors = Mage::getStoreConfig('meigee_unique_design/footer');
    }

    private function setLocation () {
        $this->mediaPath = Mage::getBaseDir('media') . 'images/';
        $this->dirPath = Mage::getBaseDir('skin') . '/frontend/unique/default/css/';
        $this->filePath = $this->dirPath . 'skin.css';
    }

    public function saveCss()
    {

        $this->setParams();

$css = "/**
*
* This file is generated automaticaly. Please do no edit it directly cause all changes will be lost.
*
*/
";

if ($this->appearance['font_main'] == 1)
{
    $css .= '/*====== Font Replacement - Main Text =======*/ ';
    if ($this->appearance['main_default_sizes'] == 0)
        {
$css .= '
body{
    font-family: '. $this->appearance['gfontmain'] .', sans-serif; 
    font-size:'. $this->appearance['main_fontsize'] .'px !important;
    line-height:' . $this->appearance['main_lineheight'] .'px !important;
    font-weight:' .$this->appearance['main_fontweight'] .' !important;
}

';
	}else{
		$css .= '
		body{
			font-family: '. $this->appearance['gfontmain'] .', sans-serif;
		}
		
		';
	}
};


if ($this->appearance['font'] == 1)
{
    $css .= '/*====== Font Replacement - Titles =======*/ ';
    if ($this->appearance['default_sizes'] == 0)
        {
$css .= '
header.rating-title h2,
.widget .widget-title h1,
.widget .widget-title h2,
.widget-title h1,
.widget-title h2,
.page-title h1,
.page-title h2,
.page-title h3,
.page-title h4,
.page-title h5,
.page-title h6,
#footer h3,
aside.sidebar .block .block-title strong span,
.product-name h1,
.block-related h2, 
.dashboard .box-head h2,
.product-name a,
.price,
button.button span span,
.content-subscribe-block .block-title h3,
.text-banner .text-banner-content h2,
.product-tabs li span,
header#header .top-cart .block-title .title-cart,
.nav-container a.level-top > span,
header#header .slider-banners .banner-content h2,
.header-slider-container .iosSlider .slider .item h2,
#footer .footer-block-title h2,
.menu-button,
aside.sidebar .block.block-layered-nav dl dt.filter-label,
aside.sidebar .actions a,
.sorter .view-mode .grid,
.sorter .view-mode .list,
.sorter label,
.label-new,
.label-sale,
.pages li.current,
.pages li a,
.catalog-product-view .box-reviews h2,
.meigee-tabs a,
.more-views h2,
aside .block-related .block-title span,
aside .block-related .related-button a,
.product-sibebar-banner .banner h2,
.product-options dt label,
.related-wrapper-bottom .block-related .block-title strong span,
.product-collateral h2,
#login-holder form .fieldset .legend,
.dashboard .welcome-msg .hello,
.box-title h2,
.box-title h3,
.box-title h4,
.dashboard .box-head h3,
.dashboard .box-head h2,
.fieldset .legend,
.order-details h2.table-caption,
#my-orders-table h3.product-name,
#checkout-review-table h3.product-name,
.product-review .product-name,
.cart header h2,
aside.sidebar .block .block-subtitle,
aside.sidebar .block.block-wishlist li.item .product-details .product-name a,
#cart-accordion h3.accordion-title,
.gift-messages-form .item .details .product-name,
.opc .step-title h2,
.nav-wide#nav-wide ul.level0 li.level1 span.subtitle,
#login-form h2,
.add-to-cart-success a,
.cart-remove-box a,
header#header .top-cart .block-content .actions a,
header#header .top-cart .block-content .subtotal .label,
header#header .top-cart .block-content .subtotal .price,
.menu-tags h5,
.menu-categories h5,
.menu-recent h5,
a.aw-blog-read-more,
.products-grid .availability-only,
.products-list .availability-only,
.ajax-index-options .product-view .product-shop .product-name h2,
.products-grid li.item .quick-view-wrapper .btn-quick-view span span,
.products-list li.item .quick-view-wrapper .btn-quick-view span span,
#footer .block-title strong span,
.widget-latest li h3 a,
.content-text-banner .banner-content h3,
.opc-wrapper-opc .opc-block-title h3 {
    font-family: '. $this->appearance['gfont'] .', sans-serif; 
    font-size:'. $this->appearance['fontsize'] .'px !important;
    line-height:' . $this->appearance['lineheight'] .'px !important;
    font-weight:' .$this->appearance['fontweight'] .' !important;
}';
        } else {
        $css .= '
header.rating-title h2,
.widget .widget-title h1,
.widget .widget-title h2,
.widget-title h1,
.widget-title h2,
.page-title h1,
.page-title h2,
.page-title h3,
.page-title h4,
.page-title h5,
.page-title h6,
#footer h3,
aside.sidebar .block .block-title strong span,
.product-name h1,
.block-related h2, 
.dashboard .box-head h2,
.product-name a,
.price,
button.button span span,
.content-subscribe-block .block-title h3,
.text-banner .text-banner-content h2,
.product-tabs li span,
header#header .top-cart .block-title .title-cart,
.nav-container a.level-top > span,
header#header .slider-banners .banner-content h2,
.header-slider-container .iosSlider .slider .item h2,
#footer .footer-block-title h2,
.menu-button,
aside.sidebar .block.block-layered-nav dl dt.filter-label,
aside.sidebar .actions a,
.sorter .view-mode .grid,
.sorter .view-mode .list,
.sorter label,
.label-new,
.label-sale,
.pages li.current,
.pages li a,
.catalog-product-view .box-reviews h2,
.meigee-tabs a,
.more-views h2,
aside .block-related .block-title span,
aside .block-related .related-button a,
.product-sibebar-banner .banner h2,
.product-options dt label,
.related-wrapper-bottom .block-related .block-title strong span,
.product-collateral h2,
#login-holder form .fieldset .legend,
.dashboard .welcome-msg .hello,
.box-title h2,
.box-title h3,
.box-title h4,
.dashboard .box-head h3,
.dashboard .box-head h2,
.fieldset .legend,
.order-details h2.table-caption,
#my-orders-table h3.product-name,
#checkout-review-table h3.product-name,
.product-review .product-name,
.cart header h2,
aside.sidebar .block .block-subtitle,
aside.sidebar .block.block-wishlist li.item .product-details .product-name a,
#cart-accordion h3.accordion-title,
.gift-messages-form .item .details .product-name,
.opc .step-title h2,
.nav-wide#nav-wide ul.level0 li.level1 span.subtitle,
#login-form h2,
.add-to-cart-success a,
.cart-remove-box a,
header#header .top-cart .block-content .actions a,
header#header .top-cart .block-content .subtotal .label,
header#header .top-cart .block-content .subtotal .price,
.menu-tags h5,
.menu-categories h5,
.menu-recent h5,
a.aw-blog-read-more,
.products-grid .availability-only,
.products-list .availability-only,
.ajax-index-options .product-view .product-shop .product-name h2,
.products-grid li.item .quick-view-wrapper .btn-quick-view span span,
.products-list li.item .quick-view-wrapper .btn-quick-view span span,
#footer .block-title strong span,
.widget-latest li h3 a,
.content-text-banner .banner-content h3,
.opc-wrapper-opc .opc-block-title h3 {font-family: ' . $this->appearance['gfont'] .', sans-serif;}';
    }
}

if (isset($this->appearance['custompatern'])) {
$css .= '

/*====== Custom Patern =======*/
body { background: url("' . MAGE::helper('ThemeOptionsUnique')->getThemeOptionsUnique('mediaurl') . $this->appearance['custompatern'] . '")  top repeat !important;}';
}
$css .= '

/*====== Site Bg =======*/
body,
body.boxed-layout {background-color:#' . $this->baseColors['sitebg'] . ';}

/*====== Skin Color #1 =======*/
a,
.price,
.header-slider-container .iosSlider .slider .item h2 span,
.catalog-product-view .box-reviews .form-add h3 span,
.block-account li strong,
header#header .top-cart .block-content .subtotal .price,
.block-account li a:hover {color:#' . $this->baseColors['maincolor'] . ';}

.content-subscribe-block,
header#header .links li a.top-link-login,
header#header .customer-name,
aside.sidebar .block.block-layered-nav .ui-slider .ui-slider-handle,
.pages li.current,
.catalog-product-view .box-reviews .data-table thead,
.catalog-product-view .box-reviews .full-review,
#login-holder form .actions button span span,
.cart-table .btn-continue span span,
.my-wishlist .buttons-set .btn-update span span,
header#header .form-search .indent:hover button > span,
.iwdbutton button.button:hover span span,
.cart .btn-proceed-checkout:hover span span,
header#header .top-cart .block-content .actions button.button:hover span span,
.wide-subscribe-wrapper .background-wrapper,
.content-text-banner > i {background-color:#' . $this->baseColors['maincolor'] . ';}

.products-grid li.item .quick-view-wrapper .btn-quick-view,
.products-list li.item .quick-view-wrapper .btn-quick-view {background-color: rgba('.MAGE::helper('ThemeOptionsUnique')->HexToRGB($this->baseColors['maincolor']).',.9);}

header#header .form-search .indent:hover,
header#header .form-search.focus .indent {border-color:#' . $this->baseColors['maincolor'] . ';}


/*====== Skin Color #2 =======*/
a:hover,
.toolbar .sorter .view-mode strong,
.catalog-product-view .box-reviews ul li small span,
.products-list .add-to-links i:hover,
.products-grid .btn-quick-view:hover span,
.products-list .btn-quick-view:hover span,
.products-list.small .product-name a:hover,
.sorter .view-mode a:hover,
.sorter a.asc:hover,
.sorter a.desc:hover,
.ratings .rating-links a:hover,
.products-grid .add-to-links li i:hover,
.block-vertical-nav li a:hover,
aside.sidebar .product-name a:hover,
.tags-list li a:hover,
nav.breadcrumbs li a:hover,
header#header nav.breadcrumbs li a:hover,
.product-view .product-shop .add-to-links-box i:hover,
.product-options-bottom .add-to-links i:hover,
.product-options-bottom .email-friend i:hover,
div.quantity-decrease i:hover,
div.quantity-increase i:hover,
aside .block-related .related-button a:hover,
.block-related .product-name a:hover,
.related-wrapper-bottom .block-subtitle a:hover,
.block-compare li.item .btn-remove i:hover,
#login-holder .close-button i:hover,
#login-holder .forgot-link:hover,
#login-holder .link-box a:hover,
.dashboard .box-title a i:hover,
.dashboard .box-head a i:hover,
aside.sidebar .block.block-wishlist li.item .product-details .btn-remove i:hover,
aside.sidebar .block.block-wishlist li.item .product-details .product-name a:hover,
header#header .top-cart .product-name a:hover,
header#header .top-cart .btn-edit i:hover,
header#header .top-cart .btn-remove i:hover,
.products-grid .product-name a:hover,
.postTitle h2 a:hover,
.block-blog li a:hover,
.crosssell .product-details button.button:hover span,
.crosssell .product-details .add-to-links i:hover,
.crosssell .product-details .product-name a:hover,
.widget-latest li h3 a:hover {color:#' . $this->baseColors['secondcolor'] . ';}

button.button:hover span span,
header#header .top-cart .block-title .title-cart,
.ui-slider-horizontal .ui-slider-range,
.products-grid .availability-only,
.products-list .availability-only,
.label-sale,
.sidebar-slider .sidebarSlideSelectors li.selected,
.product-view .add-to-cart button.button span span,
.cart .btn-proceed-checkout span span,
header#header .top-cart .block-content .actions button.button span span,
.slider-container .prev i:hover,
.slider-container .next i:hover,
.header-slider-container .iosSlider .prev i:hover,
.header-slider-container .iosSlider .next i:hover,
aside.sidebar .actions a:hover,
aside .block-related .prev i:hover,
aside .block-related .next i:hover,
.product-view .product-prev i:hover,
.product-view .product-next i:hover,
.more-views .prev i:hover,
.more-views .next i:hover,
.catalog-product-view .box-reviews .full-review:hover,
.related-wrapper-bottom .block-related .next i:hover,
.related-wrapper-bottom .block-related .prev i:hover,
aside.sidebar .block.block-wishlist .link-cart i:hover,
.block-wishlist .prev i:hover,
.block-wishlist .next i:hover,
#login-holder form .actions button:hover span span,
.cart-table .btn-continue:hover span span,
.my-wishlist .buttons-set .btn-update:hover span span,
a.aw-blog-read-more:hover,
#toTopHover i:hover,
.products-list .button-holder .button:hover > span,
.products-grid .button-holder .button:hover > span,
#footer .block-tags li a:hover {background-color:#' . $this->baseColors['secondcolor'] . '}

#footer .block-tags li a:hover {border-color: #' . $this->baseColors['secondcolor'] . ';}

.label-type-5 div.label-sale:before,
.products-grid.label-type-5 .availability-only:before,
.products-list.label-type-5 .availability-only:before {border-top-color: #' . $this->baseColors['secondcolor'] . ';}
.label-type-5 div.label-sale:after,
.products-grid.label-type-5 .availability-only:after,
.products-list.label-type-5 .availability-only:after {border-bottom-color: #' . $this->baseColors['secondcolor'] . ';}


/*====== Category Labels =======*/
.nav-wide#nav-wide li.level-top .category-label.label_one { 
    background-color: #' . $this->catlabelsColors['label_one'] . ';
    border-color: #' . $this->catlabelsColors['label_one'] . ';
    color: #' . $this->catlabelsColors['label_one_color'] . ';
}
.nav-wide#nav-wide li.level-top.over .category-label.label_one { 
    background-color: #' . $this->catlabelsColors['label_one_h'] . ';
    border-color: #' . $this->catlabelsColors['label_one_h'] . ';
    color: #' . $this->catlabelsColors['label_one_color_h'] . ';
}
.nav-wide#nav-wide li.level-top .category-label.label_two { 
    background-color: #' . $this->catlabelsColors['label_two'] . ';
    border-color: #' . $this->catlabelsColors['label_two'] . ';
    color: #' . $this->catlabelsColors['label_two_color'] . ';
}
.nav-wide#nav-wide li.level-top.over .category-label.label_two { 
    background-color: #' . $this->catlabelsColors['label_two_h'] . ';
    border-color: #' . $this->catlabelsColors['label_two_h'] . ';
    color: #' . $this->catlabelsColors['label_two_color_h'] . ';
}
.nav-wide#nav-wide li.level-top .category-label.label_three { 
    background-color: #' . $this->catlabelsColors['label_three'] . ';
    border-color: #' . $this->catlabelsColors['label_three'] . ';
    color: #' . $this->catlabelsColors['label_three_color'] . ';
}
.nav-wide#nav-wide li.level-top.over .category-label.label_three { 
    background-color: #' . $this->catlabelsColors['label_three_h'] . ';
    border-color: #' . $this->catlabelsColors['label_three_h'] . ';
    color: #' . $this->catlabelsColors['label_three_color_h'] . ';
}

';

if ($this->baseColors['base_override'] == 1) {
    $css .= '/*====== Header ======*/

header#header,
header#header > .container_12 {background-color: #' . $this->headerColors['header_bg'] . ';}
header#header,
header#header .header-top .first-line .header-phones,
header#header .header-top .first-line .welcome-msg {color: #' . $this->headerColors['header_text'] . ';}
header#header a {color: #' . $this->headerColors['header_link'] . ';}
header#header a:hover {color: #' . $this->headerColors['header_link_h'] . ';}
header#header .header-top-right,
header#header .header-top .first-line {
	border-color: #' . $this->headerColors['header_borders'] . ';
	border-width: ' . $this->headerColors['header_borders_width'] . 'px;
}
header#header .header-top .first-line .header-phones {border-color: #' . $this->headerColors['header_divider_color'] . ';}

/**** Sticky Header ****/
header#header.floating,
header#header.floating .header-bottom-left,
header#header.floating > .container_12,
header#header.header-2.floating .header-bottom-wrapper,
body.boxed-layout header#header.header-2.floating .header-bottom-wrapper .container_12 {background-color: #' . $this->headerColors['header_sticky_bg'] . ';} 

/**** Header Search ****/
header#header .form-search .indent {
	background-color: #' . $this->headerColors['search_bg'] . ';
	border-color: #' . $this->headerColors['search_border_and_button'] . ';
	border-width: ' . $this->headerColors['search_border_width'] . 'px;
}
header#header .form-search .indent input {
	background-color: #' . $this->headerColors['search_bg'] . ';
	color: #' . $this->headerColors['search_color'] . ';
}
header#header .form-search button > span {background-color: #' . $this->headerColors['search_border_and_button'] . ';}
header#header .form-search button span i {color: #' . $this->headerColors['search_button_color'] . '}
header#header .form-search.focus .indent {border-color: #' . $this->headerColors['active_search_border'] . ';}
header#header .form-search.focus .indent,
header#header .form-search.focus .indent input,
header#header .form-search.focus button > span {background-color: #' . $this->headerColors['active_search_bg'] . ';}
header#header .form-search.focus .indent input {color: #' . $this->headerColors['active_search_color'] . ';}
header#header .form-search.focus button span i {color: #' . $this->headerColors['active_search_button_color'] . '}
header#header .form-search .indent:hover {border-color: #' . $this->headerColors['search_border_and_button_h'] . ';}
header#header .form-search .indent:hover,
header#header .form-search .indent:hover input {background-color: #' . $this->headerColors['search_bg_h'] . ';}
header#header .form-search .indent:hover input {color: #' . $this->headerColors['search_color_h'] . ';}
header#header .form-search .indent:hover button > span {background-color: #' . $this->headerColors['search_border_and_button_h'] . ';}
header#header .form-search .indent:hover button span i {color: #' . $this->headerColors['search_button_color_h'] . ';}

/**** Header Cart ****/
header#header .top-cart .block-title .title-cart {
	background-color: #' . $this->headerColors['cart_bg'] . ';
	color: #' . $this->headerColors['cart_text'] . ';
}
header#header .top-cart .block-title .title-cart:hover {
	background-color: #' . $this->headerColors['cart_bg_h'] . ';
	color: #' . $this->headerColors['cart_text_h'] . ';
}
header#header .top-cart .block-title .active .title-cart {
	background-color: rgba('.MAGE::helper('ThemeOptionsUnique')->HexToRGB($this->headerColors['cart_active_bg']).',.8);
	color: #' . $this->headerColors['cart_active_text'] . ';
}
header#header .top-cart .block-content {
	background-color: #' . $this->headerColors['dropdown_bg'] . ';
	box-shadow: 0 1px 5px rgba('.MAGE::helper('ThemeOptionsUnique')->HexToRGB($this->headerColors['dropdown_shadow']).',.1);
}
header#header .top-cart .product-name a {color: #' . $this->headerColors['dropdown_product_title'] . ';}
header#header .top-cart .product-name a:hover {color: #' . $this->headerColors['dropdown_product_title_h'] . ';}
header#header .top-cart .block-content .mini-products-list .product-details .price {color: #' . $this->headerColors['dropdown_price_color'] . ';}
header#header .top-cart .cart-price-qt strong {
	background-color: #' . $this->headerColors['dropdown_count_bg'] .';
	color: #' . $this->headerColors['dropdown_count_color'] . ';
}
header#header .top-cart .block-content .item-options dt {color: #' . $this->headerColors['dropdown_label_color'] . ';}
header#header .top-cart .block-content .item-options dd {color: #' . $this->headerColors['dropdown_options_color'] . ';}
header#header .top-cart .btn-edit i,
header#header .top-cart .btn-remove i {color: #' . $this->headerColors['dropdown_icons_color'] . ';}
header#header .top-cart .btn-edit i:hover,
header#header .top-cart .btn-remove i:hover {color: #' . $this->headerColors['dropdown_icons_color_h'] . ';}
header#header .top-cart .block-content .subtotal .label {color: #' . $this->headerColors['dropdown_total_label'] . ';}
header#header .top-cart .block-content .subtotal .price {color: #' . $this->headerColors['dropdown_total_price'] . ';}
header#header .top-cart .block-content .actions {
	border-color: #' . $this->headerColors['dropdown_border_color'] . ';
	border-width: ' . $this->headerColors['dropdown_border_width'] . 'px;
}
header#header .top-cart .block-content .actions a {color: #' . $this->headerColors['dropdown_view_cart_link'] . ';}
header#header .top-cart .block-content .actions a:hover {color: #' . $this->headerColors['dropdown_view_cart_link_h'] . ';}

/**** Login and Register Popup ****/
header#header .links li a.top-link-login {
	background-color: #' . $this->headerColors['login_bg'] . ';
	color: #' . $this->headerColors['login_color'] . ';
}
header#header .links li a.top-link-login:hover {
	background-color: #' . $this->headerColors['login_bg_h'] . ';
	color: #' . $this->headerColors['login_color_h'] . ';
}
#login-holder {background-color: #' . $this->headerColors['login_form_bg'] . ';}
#login-holder form p.required,
#login-holder .form-list label.required em {color: #' . $this->headerColors['login_system_text'] . ';}
#login-holder .page-title h2 {color: #' . $this->headerColors['login_title_color'] . ';}
#login-holder form p {color: #' . $this->headerColors['login_text_color'] . ';}
#login-holder form .fieldset .legend {color: #' . $this->headerColors['login_subtitle_color'] . ';}
#login-holder form .input-box input {
	background-color: #' . $this->headerColors['login_input_bg'] . ';
	border-color: #' . $this->headerColors['login_input_bg'] . ';
	color: #' . $this->headerColors['login_input_color'] . ';
}
#login-holder .link-box a {color: #' . $this->headerColors['login_register_switcher'] . ';}
#login-holder .link-box a:hover {color: #' . $this->headerColors['login_register_switcher_h'] . ';}
#login-holder .close-button i {color: #' . $this->headerColors['login_icon_color'] . ';}
#login-holder .close-button i:hover {color: #' . $this->headerColors['login_icon_color_h'] . ';}
#login-holder .account-create .form-list label {color: #' . $this->headerColors['login_label_color'] . ';}

/**** Wishlist ****/
header#header .right > .top-link-wishlist a {
	color: #' . $this->headerColors['wishlist_color'] . ';
	background-color: #' . $this->headerColors['wishlist_bg'] . ';
}
header#header .right > .top-link-wishlist:hover a {
	color: #' . $this->headerColors['wishlist_color_h'] . ';
	background-color: #' . $this->headerColors['wishlist_bg_h'] . ';
}

/**** Account Block ****/
header#header .customer-name {
	background-color: #' . $this->headerColors['account_bg'] . ';
	color: #' . $this->headerColors['account_color'] . ';
}
header#header .customer-name:hover {
	background-color: #' . $this->headerColors['account_bg_h'] . ';
	color: #' . $this->headerColors['account_color_h'] . ';
}
header#header .customer-name + .links {background-color: #' . $this->headerColors['account_submenu_bg'] . ';}
header#header .customer-name + .links li {
	border-color: #' . $this->headerColors['account_submenu_link_divider'] . ';
	border-width: ' . $this->headerColors['account_submenu_link_divider_width'] . 'px;
}
header#header .customer-name + .links li a {
	color: #' . $this->headerColors['account_submenu_link'] . ';
	background-color: #' . $this->headerColors['account_submenu_link_bg'] . ';
}
header#header .customer-name + .links li a:hover {
	color: #' . $this->headerColors['account_submenu_link_h'] . ';
	background-color: #' . $this->headerColors['account_submenu_link_bg_h'] . ';
} 

/*====== Header Slider ======*/

/**** Buttons ****/
.header-slider-container .iosSlider .prev i,
.header-slider-container .iosSlider .next i {
	background-color: #' . $this->headerSliderColors['buttons_bg'] . ';
	color: #' . $this->headerSliderColors['buttons_color'] . ';
}
.header-slider-container .iosSlider .prev i:hover,
.header-slider-container .iosSlider .next i:hover {
	background-color: #' . $this->headerSliderColors['buttons_bg_h'] . ';
	color: #' . $this->headerSliderColors['buttons_color_h'] . ';
}
.header-slider-container .iosSlider .headerSliderSelectors .button-item {background-color: #' . $this->headerSliderColors['bullets_bg'] . '}

/**** Type 1 ****/
.header-slider-container .iosSlider .slider .item h3 {color: #' . $this->headerSliderColors['type1_subtitle'] . ';}
.header-slider-container .iosSlider .slider .item h2 {color: #' . $this->headerSliderColors['type1_title'] . ';} 
.header-slider-container .iosSlider .slider .item h2 span {color: #' . $this->headerSliderColors['type1_title_span'] . ';}
.header-slider-container .iosSlider .slider .item p {color: #' . $this->headerSliderColors['type1_text'] . ';}

/**** Type 2 ****/
.header-slider-container .iosSlider .slider .item .slide-container.slide-skin-2 h3 {color: #' . $this->headerSliderColors['type2_subtitle'] . ';} 
.header-slider-container .iosSlider .slider .item .slide-container.slide-skin-2 h2 {color: #' . $this->headerSliderColors['type2_title'] . ';}
.header-slider-container .iosSlider .slider .item .slide-container.slide-skin-2 h2 span {color: #' . $this->headerSliderColors['type2_title_span'] . ';}
.header-slider-container .iosSlider .slider .item .slide-container.slide-skin-2 p {color: #' . $this->headerSliderColors['type2_text'] . ';}

/*====== Menu ======*/

header#header .header-bottom-left,
header#header.header-2 .header-bottom-wrapper,
body.boxed-layout header#header.header-2 .header-bottom-wrapper .container_12 {background-color: #' . $this->menuColors['menu_bg'] . ';}

/**** Button ****/
.menu-button {
	background-color: #' . $this->menuColors['button_bg'] . ';
	color: #' . $this->menuColors['button_color'] . ';
}
.menu-button:hover {
	background-color: #' . $this->menuColors['button_bg_h'] . ';
	color: #' . $this->menuColors['button_color_h'] . ';
}

/**** Top Level ****/
.nav-container a.level-top {background-color: #' . $this->menuColors['link_bg'] . ';}
.nav-container a.level-top > span {color: #' . $this->menuColors['link_color'] . ';}
.nav-container a.level-top em {color: #' . $this->menuColors['navigation_number_color'] . ';}
.nav-container a.level-top i {color: #' . $this->menuColors['triangle_icon'] . ';}
.nav-container a.level-top:hover,
.nav-container .active a.level-top,
.nav-container .over a.level-top {background-color: #' . $this->menuColors['link_bg_h'] . ';}
.nav-container a.level-top:hover > span,
.nav-container .active a.level-top > span,
.nav-container .over a.level-top > span {color: #' . $this->menuColors['link_color_h'] . ';}
.nav-container a.level-top:hover em,
.nav-container .active a.level-top em,
.nav-container .over a.level-top em {color: #' . $this->menuColors['navigation_number_color_h'] . ';}
.nav-container a.level-top:hover i,
.nav-container .active a.level-top i,
.nav-container .over a.level-top i {color: #' . $this->menuColors['triangle_icon_h'] . ';}

/**** Sticky Header Top Level ****/
header#header.floating .nav-container a.level-top {background-color: #' . $this->menuColors['sticky_link_bg'] . ';}
header#header.floating .nav-container a.level-top > span,
header#header.floating .nav-container a.level-top i {color: #' . $this->menuColors['sticky_link_color'] . ';}
header#header.floating .nav-container a.level-top:hover,
header#header.floating .nav-container .active a.level-top,
header#header.floating .nav-container .over a.level-top {background-color: #' . $this->menuColors['sticky_link_bg_h'] . '; }
header#header.floating .nav-container a.level-top:hover > span,
header#header.floating .nav-container .active a.level-top > span,
header#header.floating .nav-container .over a.level-top > span,
header#header.floating .nav-container a.level-top:hover i,
header#header.floating .nav-container .active a.level-top i,
header#header.floating .nav-container .over a.level-top i {color: #' . $this->menuColors['sticky_link_color_h'] . ';}

/**** Submenu ****/
.nav-wide#nav-wide .menu-wrapper {
	background-color: #' . $this->menuColors['submenu_bg'] . ';
	color: #' . $this->menuColors['submenu_text'] . ';
} 
.nav-wide#nav-wide .menu-wrapper a {color: #' . $this->menuColors['submenu_links'] . ';}
.nav-wide#nav-wide ul.level0 li.level1 span.subtitle {
	background-color: #' . $this->menuColors['submenu_top_link_bg'] . ';
	color: #' . $this->menuColors['submenu_top_link'] . ';
}
.nav-wide#nav-wide ul.level0 li.level1 span.subtitle:hover {
	background-color: #' . $this->menuColors['submenu_top_link_bg_h'] . ';
	color: #' . $this->menuColors['submenu_top_link_h'] . ';
}
.nav-wide#nav-wide ul.level1 a {
	background-color: #' . $this->menuColors['submenu_link_bg'] . ';
	color: #' . $this->menuColors['submenu_link'] . ';
}
.nav-wide#nav-wide ul li,
.nav-wide#nav-wide ul.level1 ul {
	border-color: #' . $this->menuColors['submenu_link_border'] . ';
	border-width: ' . $this->menuColors['submenu_link_border_width'] . 'px;
}
.nav-wide#nav-wide ul.level1 a:hover {
	background-color: #' . $this->menuColors['submenu_link_bg_h'] . ';
	color: #' . $this->menuColors['submenu_link_h'] . ';
}
.nav-wide#nav-wide ul li:hover,
.nav-wide#nav-wide ul.level1 ul:hover {border-color: #' . $this->menuColors['submenu_link_border_h'] . ';}
.nav-wide#nav-wide .bottom-content,
.nav-wide#nav-wide .top-content {
	border-color: #' . $this->menuColors['submenu_borders'] . ';
	border-width: ' . $this->menuColors['submenu_borders_width'] . 'px;
}
.nav-wide#nav-wide .contact-info li i {
	background-color: #' . $this->menuColors['submenu_icons_bg'] . ';
	border-color: #' . $this->menuColors['submenu_icons_border'] . ';
	color: #' . $this->menuColors['submenu_icons_color'] . ';
}
.nav-wide#nav-wide .contact-info li i:hover {
	background-color: #' . $this->menuColors['submenu_icons_bg_h'] . ';
	border-color: #' . $this->menuColors['submenu_icons_border_h'] . ';
	color: #' . $this->menuColors['submenu_icons_color_h'] . ';
}

/*====== Content ======*/

header.rating-title h2,
body .widget .widget-title h1,
body .widget .widget-title h2,
body .widget-title h1,
body .widget-title h2,
.page-title h1,
.page-title h2,
.page-title h3,
.page-title h4,
.page-title h5,
.page-title h6,
.product-name h1,
.block-related h2,
.opc-wrapper-opc h2.opc-title,
.op_block_title,
.related-wrapper-bottom .block-related .block-title strong span,
.postTitle h2 a  {color: #' . $this->contentColors['page_title_color'] . ';}
body .widget .widget-title,
body .widget-title,
.page-title,
header.rating-title,
.related-wrapper-bottom .block-related .block-title {
	border-bottom-color: #' . $this->contentColors['page_title_border'] . ';
	border-bottom-width: ' . $this->contentColors['page_title_border_width'] . 'px;
}

/**** Toolbar ****/
.sorter label {color: #' . $this->contentColors['toolbar_label'] . ';}
.toolbar .sbSelector,
.toolbar .sbOptions,
.toolbar .sbSelector:hover,
.toolbar .sbHolder .sbToggleOpen + .sbSelector {background-color: #' . $this->contentColors['toolbar_select_bg'] . ';}
.toolbar .sbSelector > span.text {color: #' . $this->contentColors['toolbar_select_text'] . ';}
.toolbar .sbSelector span.text + span {border-top-color: #' . $this->contentColors['toolbar_select_text'] . ';}
.toolbar .sbOptions li {background-color: #' . $this->contentColors['toolbar_dropdown_link_bg'] . ';}
.toolbar .sbOptions li a {color: #' . $this->contentColors['toolbar_dropdown_link'] . ';}
.toolbar .sbOptions li:hover {background-color: #' . $this->contentColors['toolbar_dropdown_link_bg_h'] . ';}
.toolbar .sbOptions li:hover a {color: #' . $this->contentColors['toolbar_dropdown_link_h'] . ';}

/**** Pager ****/
.pages li {background-color: #' . $this->contentColors['pager_buttons_bg'] . ';}
.pages li a {color: #' . $this->contentColors['pager_buttons_color'] . ';}
.pages li:hover {background-color: #' . $this->contentColors['pager_buttons_bg_h'] . ';}
.pages li:hover a {color: #' . $this->contentColors['pager_buttons_color_h'] . ';}
.pages li.current {
	background-color: #' . $this->contentColors['pager_active_button_bg'] . ';
	color: #' . $this->contentColors['pager_active_button'] . ';
}

/*====== Buttons ======*/

/**** Type 1 ****/
button.button span span,
aside.sidebar .actions a,
aside.sidebar .block.block-wishlist .link-cart i,
a.aw-blog-read-more,
.add-to-cart-success a,
.cart-remove-box a {
	background-color: #' . $this->buttonsColors['buttons_bg'] . ';
	color: #' . $this->buttonsColors['buttons_color'] . ';
}
.products-list.small .button-holder .button i {color: #' . $this->buttonsColors['buttons_color'] . ';}
button.button > span,
aside.sidebar .actions a,
aside.sidebar .block.block-wishlist .link-cart i,
a.aw-blog-read-more,
.add-to-cart-success a,
.cart-remove-box a {
	border-width: ' . $this->buttonsColors['buttons_border_width'] . 'px;
	border-color: #' . $this->buttonsColors['buttons_border'] . ';
}
button.button:hover span span,
aside.sidebar .actions a:hover,
aside.sidebar .block.block-wishlist .link-cart i:hover,
a.aw-blog-read-more:hover,
.add-to-cart-success a:hover,
.cart-remove-box a:hover,
.products-list .button-holder .button:hover > span,
.products-grid .button-holder .button:hover > span {
	background-color: #' . $this->buttonsColors['buttons_bg_h'] . ';
	color: #' . $this->buttonsColors['buttons_color_h'] . ';
}

button.button.progress-buttons.state-loading,
button.button.progress-buttons.state-success {background-color: #' . $this->buttonsColors['buttons_bg_h'] . ';}
button.button.progress-buttons.state-loading span,
button.button.progress-buttons.state-success span {color: #' . $this->buttonsColors['buttons_color_h'] . '}

.products-list.small button.button.progress-buttons.state-loading span i,
.products-list.small button.button.progress-buttons.state-success span i,
.products-list.small .button-holder .button i:hover {color: #' . $this->buttonsColors['buttons_color_h'] . ';}
button.button:hover > span,
aside.sidebar .actions a:hover,
aside.sidebar .block.block-wishlist .link-cart i:hover,
a.aw-blog-read-more:hover,
.add-to-cart-success a:hover,
.cart-remove-box a:hover {
	border-color: #' . $this->buttonsColors['buttons_border_h'] . ';
}

/**** Type 2 ****/
.product-view .add-to-cart button.button span span,
.iwdbutton button.button span span,
.cart .btn-proceed-checkout span span,
header#header .top-cart .block-content .actions button.button span span,
#login-holder form .actions button:hover span span,
.cart-table .btn-continue:hover span span,
.my-wishlist .buttons-set .btn-update:hover span span {
	background-color: #' . $this->buttonsColors['buttons2_bg'] . ';
	color: #' . $this->buttonsColors['buttons2_color'] . ';
}
.product-view .add-to-cart button.button.progress-buttons {background-color: #' . $this->buttonsColors['buttons2_bg'] . ';}
.product-view .add-to-cart button.button > span,
.iwdbutton button.button > span,
.cart .btn-proceed-checkout > span,
header#header .top-cart .block-content .actions button.button > span,
#login-holder form .actions button > span,
.cart-table .btn-continue > span,
.my-wishlist .buttons-set .btn-update > span {border-width: ' . $this->buttonsColors['buttons2_border_width'] . 'px;}
#login-holder form .actions button span span,
.cart-table .btn-continue span span,
.my-wishlist .buttons-set .btn-update span span,
.iwdbutton button.button:hover span span,
.cart .btn-proceed-checkout:hover span span,
header#header .top-cart .block-content .actions button.button:hover span span {
	background-color: #' . $this->buttonsColors['buttons2_bg_h'] . ';
	color: #' . $this->buttonsColors['buttons2_color_h'] . ';
}
.product-view .add-to-cart button.button.progress-buttons:hover {background-color: #' . $this->buttonsColors['buttons2_bg_h'] . ';}
.product-view .add-to-cart button.button > span,
.iwdbutton button.button > span,
.cart .btn-proceed-checkout > span,
header#header .top-cart .block-content .actions button.button > span,
#login-holder form .actions button:hover > span,
.cart-table .btn-continue:hover > span,
.my-wishlist .buttons-set .btn-update:hover > span {border-color: #' . $this->buttonsColors['buttons2_border'] . ';}
#login-holder form .actions button > span,
.cart-table .btn-continue > span,
.my-wishlist .buttons-set .btn-update > span,
.product-view .add-to-cart button.button:hover > span,
.iwdbutton button.button:hover > span,
.cart .btn-proceed-checkout:hover > span,
header#header .top-cart .block-content .actions button.button:hover > span {border-color: #' . $this->buttonsColors['buttons2_border_h'] . ';}

/*====== Products ======*/

.products-list li.item .product-img-box,
.products-grid li.item .product-img-box {
	background-color: #' . $this->productsColors['product_bg'] . ';
	border-color: #' . $this->productsColors['product_border'] . ';
	border-width: ' . $this->productsColors['product_border_width'] . 'px;
} 
.products-grid .product-name a,
.products-list .product-name a {color: #' . $this->productsColors['product_title'] . ';}
.products-grid .product-name a:hover,
.products-list .product-name a:hover {color: #' . $this->productsColors['product_title_h'] . ';}
.products-grid .desc,
.products-list .desc {color: #' . $this->productsColors['product_text'] . ';}
.products-grid .desc a,
.products-list .desc a {color: #' . $this->productsColors['product_link_color'] . ';}
.products-grid .desc a:hover,
.products-list .desc a:hover {color: #' . $this->productsColors['product_link_color_h'] . ';}
.products-grid .price,
.products-list .price {color: #' . $this->productsColors['product_price'] . ';}
.products-grid .old-price .price,
.products-list .old-price .price {color: #' . $this->productsColors['product_old_price'] . ';}
.products-grid .special-price .price,
.products-list .special-price .price {color: #' . $this->productsColors['product_special_price'] . ';}

/**** Product Labels ****/
.label-new {
	background-color: #' . $this->productsColors['label_new_bg'] . ';
	color: #' . $this->productsColors['label_new_color'] . ';
}
.label-type-5 span.label-new:before {border-top-color: #' . $this->productsColors['label_new_bg'] . ';}
.label-type-5 span.label-new:after {border-bottom-color: #' . $this->productsColors['label_new_bg'] . ';}
.products-grid .availability-only,
.products-list .availability-only,
.label-sale {
	background-color: #' . $this->productsColors['label_sale_bg'] . ';
	color: #' . $this->productsColors['label_sale_color'] . ';
}
.label-type-5 div.label-sale:before,
.products-grid.label-type-5 .availability-only:before,
.products-list.label-type-5 .availability-only:before {border-top-color: #' . $this->productsColors['label_sale_bg'] . ';}
.label-type-5 div.label-sale:after,
.products-grid.label-type-5 .availability-only:after,
.products-list.label-type-5 .availability-only:after {border-bottom-color: #' . $this->productsColors['label_sale_bg'] . ';}

/*====== Social Links ======*/

ul.social-links li a i,
#footer ul.social-links li a i {
	background-color: #' . $this->socialLinksColors['social_links_bg'] . ';
	border-color: #' . $this->socialLinksColors['social_links_border'] . ';
	border-width: ' . $this->socialLinksColors['social_links_border_width'] . 'px;
	color: #' . $this->socialLinksColors['social_links_color'] . ';
}
ul.social-links li a:before,
#footer ul.social-links li a:before {
	border-color: #' . $this->socialLinksColors['social_links_divider'] . ';
	border-width: ' . $this->socialLinksColors['social_links_divider_width'] . 'px;
}
ul.social-links li a:hover i,
#footer ul.social-links li a:hover i {
	background-color: #' . $this->socialLinksColors['social_links_bg_h'] . ';
	border-color: #' . $this->socialLinksColors['social_links_border_h'] . '; 
	color: #' . $this->socialLinksColors['social_links_color_h'] . ';
} 
ul.social-links li a:hover:before,
#footer ul.social-links li a:hover:before {
	border-color: #' . $this->socialLinksColors['social_links_divider_h'] . '; 
}

/*====== Footer ======*/

/**** Top Block ****/
#footer,
#footer > .container_12 {
	background-color: #' . $this->footerColors['top_block_bg'] . ';
	color: #' . $this->footerColors['top_block_text'] . ';
}
#footer a {color: #' . $this->footerColors['top_block_link'] . ';}
#footer a:hover {color: #' . $this->footerColors['top_block_link_h'] . ';}
#footer hr.solid,
#footer hr.dashed,
#footer hr.dotted {
	border-width: ' . $this->footerColors['top_block_borders_width'] . 'px;
	border-color: #' . $this->footerColors['top_block_borders'] . ';
}
#footer .footer-block-title {background-color: #' . $this->footerColors['top_block_title_bg'] . ';}
#footer .footer-block-title h2 {color: #' . $this->footerColors['top_block_title'] . ';}
#footer > .container_12 button > span {
	border-width: ' . $this->footerColors['top_block_button_border_width'] . 'px;
	border-color: #' . $this->footerColors['top_block_button_border'] . ';
}
#footer > .container_12 button span span {
	background: #' . $this->footerColors['top_block_button_bg'] . ';
	color: #' . $this->footerColors['top_block_button'] . ';
}
#footer > .container_12 button:hover > span {
	border-color: #' . $this->footerColors['top_block_button_border_h'] . ';
}
#footer > .container_12 button:hover span span {
	background-color: #' . $this->footerColors['top_block_button_bg_h'] . ';
	color: #' . $this->footerColors['top_block_button_h'] . ';
}
#footer ul li:before,
#footer .footer-links li a {background-color: #' . $this->footerColors['top_block_list_link_bg'] . ';}
#footer ul li a,
#footer .footer-links li a {color: #' . $this->footerColors['top_block_list_link'] . ';}
#footer ul li,
#footer .footer-links li {
	border-color: #' . $this->footerColors['top_block_list_link_border'] . ';
	border-width: ' . $this->footerColors['top_block_list_link_border_width'] . 'px;
}
#footer ul li:after,
#footer .footer-links li a:hover {background-color: #' . $this->footerColors['top_block_list_link_bg_h'] . ';}
#footer ul li a:hover,
#footer .footer-links li a:hover {color: #' . $this->footerColors['top_block_list_link_h'] . ';}
#footer ul li:hover,
#footer .footer-links li:hover {border-color: #' . $this->footerColors['top_block_list_link_border_h'] . ';}
#footer .contact-info li i {
	background-color: #' . $this->footerColors['top_block_icons_list_bg'] . ';
	border-color: #' . $this->footerColors['top_block_icons_list_border'] . ';
	color: #' . $this->footerColors['top_block_icons_list'] . ';
	box-shadow: 0 0 1px #' . $this->footerColors['top_block_icons_list_border'] . ';
}
#footer .contact-info li i:hover {
	background-color: #' . $this->footerColors['top_block_icons_list_bg_h'] . ';
	border-color: #' . $this->footerColors['top_block_icons_list_border_h'] . ';
	color: #' . $this->footerColors['top_block_icons_list_h'] . ';
	box-shadow: 0 0 1px #' . $this->footerColors['top_block_icons_list_border_h'] . ';
}
#footer .contact-info li span,
#footer .contact-info li span a {color: #' . $this->footerColors['top_block_icons_text'] . ';}

/**** Bottom Block ****/
#footer .footer-bottom,
body.boxed-layout #footer .footer-bottom .container_12,
#footer.original,
body.boxed-layout #footer.original .container_12 {
	background-color: #' . $this->footerColors['bottom_block_bg'] . ';
	color: #' . $this->footerColors['bottom_block_text'] . ';
}
#footer .footer-bottom a {color: #' . $this->footerColors['bottom_block_link'] . ';}
#footer .footer-bottom hr.solid,
#footer .footer-bottom hr.dashed,
#footer .footer-bottom hr.dotted {
	border-width: ' . $this->footerColors['bottom_block_borders_width'] . 'px;
	border-color: #' . $this->footerColors['bottom_block_borders'] . ';
}
#footer .footer-bottom .footer-block-title {background-color: #' . $this->footerColors['bottom_block_title_bg'] . ';}
#footer .footer-bottom .footer-block-title h2 {color: #' . $this->footerColors['bottom_block_title'] . ';}
#footer .footer-bottom ul li:before,
#footer .footer-bottom .footer-links li a {background-color: #' . $this->footerColors['bottom_block_list_link_bg'] . ';}
#footer .footer-bottom ul li a,
#footer .footer-bottom .footer-links li a {color: #' . $this->footerColors['bottom_block_list_link'] . ';}
#footer .footer-bottom ul li,
#footer .footer-bottom .footer-links li {
	border-color: #' . $this->footerColors['bottom_block_list_link_border'] . ';
	border-width: ' . $this->footerColors['bottom_block_list_link_border_width'] . 'px;
}
#footer .footer-bottom ul li:after,
#footer .footer-bottom .footer-links li a:hover {background-color: #' . $this->footerColors['bottom_block_list_link_bg_h'] . ';}
#footer .footer-bottom ul li a:hover,
#footer .footer-bottom .footer-links li a:hover {color: #' . $this->footerColors['bottom_block_list_link_h'] . ';}
#footer .footer-bottom ul li:hover,
#footer .footer-bottom .footer-links li:hover {border-color: #' . $this->footerColors['bottom_block_list_link_border_h'] . ';}
#footer .footer-bottom .contact-info li i {
	background-color: #' . $this->footerColors['bottom_block_icons_list_bg'] . ';
	border-color: #' . $this->footerColors['bottom_block_icons_list_border'] . ';
	color: #' . $this->footerColors['bottom_block_icons_list'] . ';
	box-shadow: 0 0 1px #' . $this->footerColors['bottom_block_icons_list_border'] . ';
}
#footer .footer-bottom .contact-info li i:hover {
	background-color: #' . $this->footerColors['bottom_block_icons_list_bg_h'] . ';
	border-color: #' . $this->footerColors['bottom_block_icons_list_border_h'] . ';
	color: #' . $this->footerColors['bottom_block_icons_list_h'] . ';
	box-shadow: 0 0 1px #' . $this->footerColors['bottom_block_icons_list_border_h'] . ';
}
#footer .footer-bottom .contact-info li span,
#footer .footer-bottom .contact-info li span a {color: #' . $this->footerColors['bottom_block_icons_text'] . ';}
#footer.original,
body.boxed-layout #footer.original .container_12 {
	border-color: #' . $this->footerColors['default_links_wrapper_border'] . ';
	border-width: ' . $this->footerColors['default_links_wrapper_border_width'] . 'px;
}
#footer.original .footer-links {background-color: #' . $this->footerColors['default_links_wrapper_bg'] . ';}

/**** Contact Form ****/

#footer #AjaxcontactForm li .input-box input,
#footer #AjaxcontactForm li textarea {
	background-color: #' . $this->footerColors['contact_bg'] . ';
	border-color: #' . $this->footerColors['contact_border'] . ';
	color: #' . $this->footerColors['contact_text'] . ';
}
#footer #AjaxcontactForm li label {color: #' . $this->footerColors['contact_text'] . ';}

/**** Tags Block ****/

#footer .block-tags li a {
	background-color: #' . $this->footerColors['tags_bg'] . ';
	border-color: #' . $this->footerColors['tags_border'] . ';
	color: #' . $this->footerColors['tags_text'] . ';
}
#footer .block-tags li a:hover {
	background-color: #' . $this->footerColors['tags_bg_h'] . ';
	border-color: #' . $this->footerColors['tags_border_h'] . ';
	color: #' . $this->footerColors['tags_text_h'] . ';
}

/**** Newsletter ****/

#footer .footer-subscribe label {color: #' . $this->footerColors['subscribe_text'] . ';}
#footer .footer-subscribe input {
	background-color: #' . $this->footerColors['subscribe_bg'] . ';
	border-color: #' . $this->footerColors['subscribe_border'] . ';
	color: #' . $this->footerColors['subscribe_input_text'] . ';
}

    ';
}


    	$this->saveData($css);
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ThemeOptionsUnique')->__("CSS file with custom styles has been created"));
		Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('ThemeOptionsUnique')->__('<div class="meigee-please"><a target="_blank" href="http://themeforest.net/downloads"><img src="' . Mage::getBaseUrl('skin') . '/adminhtml/default/unique/images/rating.png" /></a><h2>Like us</h2>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, "script", "facebook-jssdk"));</script>
<div class="fb-like" data-href="http://facebook.com/meigeeteam" data-layout="button_count" data-action="like" data-show-faces="false" data-width="200" data-share="true"></div>&nbsp;
<a href="https://twitter.com/meigeeteam" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @meigeeteam</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>'));




        return true;
    }

    private function saveData($data)
    {
        $this->setLocation ();

        try {
	        /*$fh = fopen($file, 'w');
	       	fwrite($fh, $data);
	        fclose($fh);*/

            $fh = new Varien_Io_File(); 
            $fh->setAllowCreateFolders(true); 
            $fh->open(array('path' => $this->dirPath));
            $fh->streamOpen($this->filePath, 'w+'); 
            $fh->streamLock(true); 
            $fh->streamWrite($data); 
            $fh->streamUnlock(); 
            $fh->streamClose(); 
    	}
    	catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ThemeOptionsUnique')->__('Failed creation custom css rules. '.$e->getMessage()));
        }
    }

}