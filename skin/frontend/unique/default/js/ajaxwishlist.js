function ajaxCompare(url,id){
	url = url.replace("catalog/product_compare/add","ajax/whishlist/compare");
	url += 'isAjax/1/';
	jQuery('#ajax_loading'+id).show();
	jQuery.ajax( {
		url : url,
		dataType : 'json',
		success : function(data) {
			jQuery('#ajax_loading'+id).hide();
			if(data.status == 'ERROR'){
				alert(data.message);
			}else{

				jQuery('body').append('<div class="add-to-cart-success">' + data.message +'<a href="#" class="btn-remove"><i class="fa fa-times" /></a></div>');
				setTimeout(function () {jQuery('.add-to-cart-success').slideUp(500)}, 5000);
				jQuery('.add-to-cart-success a.btn-remove').click(function(){
					jQuery(this).parent().slideUp(500);
					return false;
				})

				if(jQuery('.block-compare').length){
                    jQuery('.block-compare').replaceWith(data.sidebar);
                }else{
                    if(jQuery('.col-right').length){
                    	jQuery('.col-right').prepend(data.sidebar);
                    }
                }
			}
		}
	});
}
function ajaxWishlist(url,id){
	url = url.replace("wishlist/index","ajax/whishlist");
	url += 'isAjax/1/';
	url = url.replace("https://", "http://");	//added on 16th September 2014

	jQuery('#ajax_wishlist_loading'+id).show();
	
	function popUpMessage(data){
		jQuery('body').append('<div class="add-to-cart-success">' + data.message +'<a href="#" class="btn-remove"><i class="fa fa-times" /></a></div>');
		setTimeout(function () {jQuery('.add-to-cart-success').slideUp(500, function(){jQuery(this).remove()})}, 5000);
		jQuery('.add-to-cart-success a.btn-remove').click(function(){
			jQuery(this).parent().slideUp(500, function(){jQuery(this).remove()});
			return false;
		})
	}
	
	jQuery.ajax( {
		url : url,
		dataType : 'json',
		success : function(data) {
			jQuery('#ajax_wishlist_loading'+id).hide();
			if(data.status == 'ERROR'){
				popUpMessage(data);
			}else{
				popUpMessage(data);
				
				if(jQuery('.block-wishlist').length){
                    jQuery('.block-wishlist').replaceWith(data.sidebar);
                }else{
                    if(jQuery('.col-right').length){
                    	jQuery('.col-right').prepend(data.sidebar);
                    }
                }
			}
		}
	});
}
