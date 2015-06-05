Event.observe(window, 'load', function() {
	function jsColor(mainId, exceptions, onlyForName){
		if($$(mainId).length){
			if(onlyForName){
				var selection = 'input.input-text';
			}else{
				var selection = 'input.input-text:not('+ exceptions +')';
			}
			var selected_items = $$(mainId)[0].select(selection);
			if(onlyForName){
				selected_items.each(function(val){
					if(val.readAttribute('name') == exceptions){
						new jscolor.color(val);
					}
				});
			}else{
				selected_items.each(function(val){
					new jscolor.color(val);
				});
			}
		}
	}
	jsColor('#meigee_unique_design_base');
	jsColor('#meigee_unique_design_catlabels');
	jsColor('#meigee_unique_design_header', '#meigee_unique_design_header_header_borders_width, #meigee_unique_design_header_search_border_width, #meigee_unique_design_header_dropdown_border_width, #meigee_unique_design_header_account_submenu_link_divider_width');
	jsColor('#meigee_unique_design_headerslider');
	jsColor('#meigee_unique_design_menu', '#meigee_unique_design_menu_submenu_link_border_width, #meigee_unique_design_menu_submenu_borders_width');
	jsColor('#meigee_unique_design_content', '#meigee_unique_design_content_page_title_border_width');
	jsColor('#meigee_unique_design_buttons', '#meigee_unique_design_buttons_buttons_border_width, #meigee_unique_design_buttons_buttons2_border_width');
	jsColor('#meigee_unique_design_products', '#meigee_unique_design_products_product_border_width');
	jsColor('#meigee_unique_design_social_links', '#meigee_unique_design_social_links_social_links_border_width, #meigee_unique_design_social_links_social_links_divider_width');
	jsColor('#meigee_unique_design_footer', '#meigee_unique_design_footer_top_block_borders_width, #meigee_unique_design_footer_top_block_button_border_width, #meigee_unique_design_footer_top_block_list_link_border_width, #meigee_unique_design_footer_bottom_block_list_link_border_width, #meigee_unique_design_footer_bottom_block_borders_width');
	
	
	/* Comments changer */
	commentChanger = {
		load: function(elementId, comments){
			if($$(elementId).length){
				element = $$(elementId)[0];
				commentChanger.changer(element, comments);
				element.observe('change', function(event){
					commentChanger.changer(element, comments);
				});
			}
		},
		changer: function(element, comments){
			elementValue = element.options[element.selectedIndex].value;
			comment = $$(comments[elementValue])[0].innerHTML;
			element.nextSiblings('p.note')[0].select('span')[0].innerHTML = comment;
		}
	}
	
	/* Comments changer. first parameter: set element Id (select), second parameter: set array of the elements Id's that contains comments */
	new commentChanger.load('#meigee_unique_general_header_and_menu_headertype', ['#meigee_unique_general_header_and_menu_headertype1_comments', '#meigee_unique_general_header_and_menu_headertype2_comments']);
	new commentChanger.load('#meigee_unique_headerslider_coin_slidertype', ['#meigee_unique_headerslider_coin_wideslider_comment', '#meigee_unique_headerslider_coin_boxedslider_comment', '#meigee_unique_headerslider_coin_boxedbannerslider_comment', '#meigee_unique_headerslider_coin_header2boxedslider_comment', '#meigee_unique_headerslider_coin_header2boxedsbannerlider_comment']);
	
});