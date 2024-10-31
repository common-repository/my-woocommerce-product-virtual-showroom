<?php				
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// PROCESS 
function MyWooCommerceShowroom_processData(){
	
	if($_SERVER['REQUEST_METHOD'] == 'POST' && current_user_can('administrator') ){
	
		check_admin_referer( 'MyWooCommerceShowroom' );
		check_ajax_referer('MyWooCommerceShowroom');	
				
		$MyWooCommerceShowroom_title = sanitize_text_field($_REQUEST['MyWooCommerceShowroom_title']);
		
		$MyWooCommerceShowroom_url = array_map( 'sanitize_text_field', $_REQUEST['MyWooCommerceShowroom_pic_url'] );
		
		if(!empty($_REQUEST['MyWooCommerceShowroom_pic_id']) && $_REQUEST['MyWooCommerceShowroom_pic_id'] != "" ){
			$MyWooCommerceShowroom_PICS = array(
					'id' =>  (int)$_REQUEST['MyWooCommerceShowroom_pic_id'],
					'url' => $MyWooCommerceShowroom_url
			);	
		}

		if($MyWooCommerceShowroom_title){
			update_option('MyWooCommerceShowroom_title',$MyWooCommerceShowroom_title);
		}

		if($MyWooCommerceShowroom_PICS){		
			update_option( 'MyWooCommerceShowroom_pics', $MyWooCommerceShowroom_PICS);
		}


	}
}


function MyWooCommerceShowroom(){
		
		$MyWooCommerceShowroom_title =  get_option("MyWooCommerceShowroom_title");	
		$MyWooCommerceShowroom_pics =  get_option("MyWooCommerceShowroom_pics");	
		
 
		print "
		<h2>".esc_attr(get_option('MyWooCommerceShowroom_title'))."</h2>";?>


		<div id="MyWooCommerceShowroom_wrappper">

			<div class='tab'>
			  <a href="#upload" data-tab="upload"  class="current ">1. <?php print __('Select Photo','MyWooCommerceShowroom');?></a>
			  <a href="#product"  disabled data-tab="product" class='toSecond disabled'>2. <?php print esc_html__('Select Product','MyWooCommerceShowroom');?></a>
			  <a href="#preview" disabled data-tab="preview" class='toThird disabled' >3. <?php print esc_html__('Preview Product','MyWooCommerceShowroom');?></a>
			</div>		
			<div id="upload" class="tabcontent current">
			  <h3 class='showroomtitle'><?php print __('Upload a Picture of your Space','MyWooCommerceShowroom');?></h3>
			  
								<div class="uploader"
								
								<?php 	 
											if(get_locale()=='el'){
												print "style='background:url(".plugins_url('images/defaults-el.png', __FILE__ ).") no-repeat center center;'";
											}else print "style='background:url(".plugins_url('images/default.png', __FILE__ ).") no-repeat center center;'";
								
								?>
								
								>
									<img src="" class='userSelected'/>
									<input type="file" accept="image/x-png,image/gif,image/jpeg" name="userprofile_picture"  id="filePhoto" />
								</div>	
			</div>
			<div id="product" class="tabcontent ">
			  <h3 class='showroomtitle'><?php print esc_html__('Click On a Product to Select','MyWooCommerceShowroom');?></h3>
						<div class='productList'>
								 <?php					
										MyWooCommerceShowroom_Media();
								?>
						</div>		
			</div>
			<div id="preview" class="tabcontent">
			  <h3 class='showroomtitle'><?php print esc_html__('Preview Product - Move & Resize','MyWooCommerceShowroom');?></h3>
							<div class='ShowroomfinalActions'>
									<p class='ViewProduct'></p>
									<p class='AddtoCartProduct'></p>																
							</div>	
									 
							<div class="showroom ">	
							
									<div id='controls'>
											<p id='decreaseSize'><i class='fa fa-minus  fa-2x ' title='<?php print esc_html__('Click on Product Image to Resize','MyWooCommerceShowroom') ;?>' ></i> </p>
											<p id='increaseSize'><i class='fa fa-plus  fa-2x ' title='<?php print esc_html__('Click on Product Image to Resize','MyWooCommerceShowroom') ;?>'></i> </p>
																								
									 </div>	
									<div id='forDownload'>
										<p class="productdrag"><img class='product' src=""  /></p>
										<div class="extraproducts"></div>
										<img  class='userPic' src=""/>
									</div>
									
							</div>	
			</div>		

		
		</div>		
<?php

}


function MyWooCommerceShowroom_Media(){
	
		$MyWooCommerceShowroom_pics =  get_option("MyWooCommerceShowroom_pics");	
		print "<div class=' WoocommerceSamplerDataNotFromDB  '>";		
			for ($i=0; $i<31;$i++) {
				if(!empty($MyWooCommerceShowroom_pics['url'][$i])){
					print "<p>	<img tabindex='0' src='".esc_attr($MyWooCommerceShowroom_pics['url'][$i])."' /></p>";
				}
			}
		print "</div>";		
	
}


add_shortcode( 'MyWooCommerceShowroom', 'MyWooCommerceShowroom' );
?>