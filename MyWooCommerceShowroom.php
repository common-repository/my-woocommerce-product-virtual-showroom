<?php
/*
 * Plugin Name: Virtual Try On Showroom for WooCommerce
 * Plugin URI: https://extend-wp.com/boost-your-sales-virtual-try-on-showroom-woocommerce-plugin-for-wordpress/
 * Description: Virtual Try On Woocommerce Products! Allow your customers test your products - Try Before you Buy Sunglasses, Furniture and more. Increase your Sales Now!
 * Version: 2.6
 * Author: extendWP
 * Author URI: https://extend-wp.com
 *
 * WC requires at least: 2.2
 * WC tested up to: 8.4
 *   
 * License: GPL2
 * Created On: 22-02-2017
 * Updated On: 03-01-2024
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_action('plugins_loaded', 'MyWooCommerceShowroom_translate');
function MyWooCommerceShowroom_translate() {
	load_plugin_textdomain( 'MyWooCommerceShowroom', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
}

function MyWooCommerceShowroom_scripts(){

    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-accordion');
	wp_enqueue_script('jquery-ui-resizable');
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('jquery-ui-droppable');
	wp_enqueue_style( 'jquery-ui-style', plugins_url( "/css/jquery-ui.css", __FILE__ ), true );
		
	wp_enqueue_style( 'MyWooCommerceShowroom_jqueryui_css', 'https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css' );		
	wp_enqueue_style( 'MyWooCommerceShowroom_jqueryui_css');	
	
	if( ! wp_script_is( 'MyWooCommerceShowroom_fontawesome', 'enqueued' ) ) {
		wp_enqueue_style( 'MyWooCommerceShowroom_fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );	
		wp_enqueue_style( 'MyWooCommerceShowroom_fontawesome');
	}
	
    wp_enqueue_style( 'MyWooCommerceShowroom_css', plugins_url( "/css/MyWooCommerceShowroom.css?v=9s", __FILE__ ) );	
	wp_enqueue_style( 'MyWooCommerceShowroom_css');	
	
	
    wp_enqueue_script( 'MyWooCommerceShowroom_js', plugins_url( "/js/MyWooCommerceShowroom.js?v=9s", __FILE__ ) , array('jquery') , null, true);
		
   $MyWooCommerceShowroom = array( 
				'plugin_url' => plugins_url( '', __FILE__ ) ,
				'pic_uploaded' => __('Picture uploaded! Proceed to Step 2 by clicking the tab above or click on the picture if you would like to upload a different one.','MyWooCommerceShowroom'),
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),	
				'prod_selected' => __('Product selected! Proceed to Step 3 by clicking the tab above or click on another product to select.','MyWooCommerceShowroom'),
							
	);		
    wp_localize_script( 'MyWooCommerceShowroom_js', 'MyWooCommerceShowroom_url', $MyWooCommerceShowroom );	
	wp_enqueue_script( 'MyWooCommerceShowroom_js');		
	
}
add_action('wp_enqueue_scripts', 'MyWooCommerceShowroom_scripts');


function MyWooCommerceShowroom_admin_scripts(){

    wp_enqueue_style( 'MyWooCommerceShowroomAdmin_css', plugins_url( "/css/MyWooCommerceShowroom_admin.css", __FILE__ ) );	
	wp_enqueue_style( 'MyWooCommerceShowroomAdmin_css');	
	
	wp_enqueue_script('jquery');
    wp_enqueue_media();
	
	if( ! wp_script_is( 'MyWooCommerceShowroom_fontawesome', 'enqueued' ) ) {
		wp_enqueue_style( 'MyWooCommerceShowroom_fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );	
		wp_enqueue_style( 'MyWooCommerceShowroom_fontawesome');
	}
	
    wp_enqueue_script( 'MyWooCommerceShowroom_admin_js', plugins_url( '/js/MyWooCommerceShowroom_admin.js?v=9d', __FILE__ ), array('jquery','jquery-ui-tabs') , null, true);	
   $MyWooCommerceShowroom = array( 
				'plugin_url' => plugins_url( '', __FILE__ ) ,
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),					
	);		
	
	wp_localize_script( 'MyWooCommerceShowroom_admin_js', 'MyWooCommerceShowroom_url', $MyWooCommerceShowroom );
	
	 wp_enqueue_script( 'MyWooCommerceShowroom_admin_js');
}
add_action('admin_enqueue_scripts', 'MyWooCommerceShowroom_admin_scripts');


include( plugin_dir_path(__FILE__) .'/MyWooCommerceShowroom-options.php');


//ALLOW SHORTCODES ON WIDGETS
add_filter('widget_text', 'do_shortcode');

//ON ACTIVATION OF PREMIUM , DEACTIVE THE FREE ONE
function MyWooCommerceShowroom_activate(){
	require_once(ABSPATH .'/wp-admin/includes/plugin.php');
	$free = "/MyWooCommerceShowroom/MyWooCommerceShowroom.php";
	deactivate_plugins($free);
}
register_activation_hook( __FILE__, 'MyWooCommerceShowroom_activate' );


//ADD MENU LINK AND PAGE
add_action('admin_menu', 'MyWooCommerceShowroom_menu');

function MyWooCommerceShowroom_menu() {
	add_menu_page('My Woocommerce Showroom Settings', 'Showroom', 'administrator', 'MyWooCommerceShowroom_settings', 'MyWooCommerceShowroom_settingsform', 'dashicons-welcome-view-site','100');
}


//ADD ACTION LINKS
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'add_MyWooCommerceShowroom_links' );

function add_MyWooCommerceShowroom_links ( $links ) {
 $links[] =  '<a href="' . admin_url( 'admin.php?page=MyWooCommerceShowroom_settings' ) . '">Settings</a>';
 $links[] = '<a href="https://extend-wp.com/product/product-virtual-try-on-showroom-for-woocommerce/" target="_blank">PRO Version</a>'; 

   return $links;
}

function MyWooCommerceShowroom_title(){
	?>
    	<input type="text" name="MyWooCommerceShowroom_title" id="MyWooCommerceShowroom_title"   value="<?php echo  esc_attr(get_option('MyWooCommerceShowroom_title')); ?>" />
    <?php
}


function MyWooCommerceShowroom_pics(){
	
	$MyWooCommerceShowroom_pics =  get_option("MyWooCommerceShowroom_pics");	

	?>			
		<input id="MyWooCommerceShowroom_pics_upload" type="button" class="button" value="Upload /select Images" />
		
		<p class='uploader_p'></p>
	<?php
		for ($i=0; $i<31;$i++) {
			if(!empty($MyWooCommerceShowroom_pics['url'][$i])){
				print "<img class='existing' src='".esc_url_raw($MyWooCommerceShowroom_pics['url'][$i])."' width='100' />";
			}
		}
	
    for ($i=0; $i<31;$i++) {
        echo "<input type='hidden' name=\"MyWooCommerceShowroom_pic_id[".$i."]\" class='MyWooCommerceShowroom_pics'  />";
    }		
    for ($i=0; $i<31;$i++) {
        echo "<input type='hidden' name=\"MyWooCommerceShowroom_pic_url[".$i."]\" class='MyWooCommerceShowroom_pics_url'  />";
    }
	

}



function MyWooCommerceShowroom_posttype(){
	?>			
		<select disabled class='premium_version'  name="MyWooCommerceShowroom_posttype" id="MyWooCommerceShowroom_posttype">
			<option class='premium_version' value=''><?php esc_html_e("Premium Version Only","MyWooCommerceShowroom");?></option>
		</select>
<?php
}
function MyWooCommerceShowroom_taxonomy(){
	?>			
		<select disabled class='premium_version'  name="MyWooCommerceShowroom_taxonomy" id="MyWooCommerceShowroom_taxonomy">
			<option class='premium_version' value=''><?php esc_html_e("Premium Version Only","MyWooCommerceShowroom");?></option>
		</select>
<?php
}
function MyWooCommerceShowroom_taxTerms(){
	?>			
		<select disabled class='premium_version'  name="MyWooCommerceShowroom_taxTerms" id="MyWooCommerceShowroom_taxTerms">
			<option class='premium_version' value=''><?php esc_html_e("Premium Version Only","MyWooCommerceShowroom");?></option>
		</select>
<?php
}

function MyWooCommerceShowroom_panel_fields(){


	add_settings_section("MyWooCommerceShowroom", "", null, "MyWooCommerceShowroom-options");
	add_settings_field("MyWooCommerceShowroom_title", __("Description/instructions for your Showroom",'MyWooCommerceShowroom'), "MyWooCommerceShowroom_title", "MyWooCommerceShowroom-options", "MyWooCommerceShowroom");	
		

	add_settings_section("MyWooCommerceShowroom_gallery", "", null, "MyWooCommerceShowroom-gallery");	
	add_settings_field("",  __("Images","MyWooCommerceProductDemo",'MyWooCommerceShowroom'), "MyWooCommerceShowroom_pics", "MyWooCommerceShowroom-gallery", "MyWooCommerceShowroom_gallery");	
	
	add_settings_section("MyWooCommerceShowroom_premium", "", null, "MyWooCommerceShowroom-premium");	
	add_settings_field("",  __("Select Products from Specific Post Types","MyWooCommerceProductDemo",'MyWooCommerceShowroom'), "MyWooCommerceShowroom_posttype", "MyWooCommerceShowroom-premium", "MyWooCommerceShowroom_premium");	
	
	add_settings_section("MyWooCommerceShowroom_premium2", "", null, "MyWooCommerceShowroom-premium2");
	add_settings_field("",  __("Select Products from Specific Vocabulary / Taxonomy","MyWooCommerceProductDemo",'MyWooCommerceShowroom'), "MyWooCommerceShowroom_taxonomy", "MyWooCommerceShowroom-premium2", "MyWooCommerceShowroom_premium2");	
	
	add_settings_section("MyWooCommerceShowroom_premium3", "", null, "MyWooCommerceShowroom-premium3");
	add_settings_field("",  __("Select Products from Specific Terms","MyWooCommerceProductDemo",'MyWooCommerceShowroom'), "MyWooCommerceShowroom_taxTerms", "MyWooCommerceShowroom-premium3", "MyWooCommerceShowroom_premium3");	


	register_setting("MyWooCommerceShowroom", "MyWooCommerceShowroom_title");
	register_setting("MyWooCommerceShowroom_gallery", "MyWooCommerceShowroom_pics");

	
}
add_action("admin_init", "MyWooCommerceShowroom_panel_fields");	



function MyWooCommerceShowroom_settingsform() {
	?>
	<div class="wrap ">
	
		<div class='MyWooCommerceShowroomWrap'>
		
			<h2><img src='<?php echo plugins_url( 'images/mywoocommerce-product-virtual-showroom_horizontal.png', __FILE__ ); ?>'style='width:100%'  /></h2>
			
			<form method="post" id='MyWooCommerceShowroom_form'  action= "<?php echo admin_url( 'admin.php?page=MyWooCommerceShowroom_settings' ); ?>">
				
				<?php
					if( isset( $_GET[ 'tab' ] ) ) {
						$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : '';
					}else $active_tab='';
					
				?>
				
				 <h3><?php print __('Allow your customers to check your products on a picture they upload!','MyWooCommerceShowroom'); ?></h3><br/>
				<h2 class="nav-tab-wrapper">
				
					<a href="?page=MyWooCommerceShowroom_settings" class="nav-tab <?php echo $active_tab == '' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e("General","MyWooCommerceShowroom"); ?></a>

				</h2>
				
				<div class='left_wrap' >
				
					<?php MyWooCommerceShowroom_processData(); ?>
					
					<?php

					print "<p><em>".__("Choose photos with no background for your products to appear attractive in the showroom.","MyWooCommerceShowroom")."</em></p>";	
					print "<p><em>".__("Once you are ready, enter the <strong>shortcode [MyWooCommerceShowroom] in any page</strong> you like to run your showroom!","MyWooCommerceShowroom")."</em></p>";

						settings_fields( 'MyWooCommerceShowroom-options' );
						do_settings_sections( 'MyWooCommerceShowroom-options' );		
				
						settings_fields( 'MyWooCommerceShowroom-gallery' );			
						do_settings_sections( 'MyWooCommerceShowroom-gallery' );  

						settings_fields( 'MyWooCommerceShowroom-premium' );			
						do_settings_sections( 'MyWooCommerceShowroom-premium' ); 
						
						settings_fields( 'MyWooCommerceShowroom-premium2' );			
						do_settings_sections( 'MyWooCommerceShowroom-premium2' ); 			
						
						settings_fields( 'MyWooCommerceShowroom-premium3' );			
						do_settings_sections( 'MyWooCommerceShowroom-premium3' ); 
						
					?>	
					<?php wp_nonce_field('MyWooCommerceShowroom'); ?>	
					<p id='save_changes' ><?php submit_button(); ?></p>

				</div>
				
				<div class='right_wrap rightToLeft'>
					<h2><i><?php esc_html_e("INCREASE YOUR SALES NOW!","MyWooCommerceShowroom");?></i>
					
					</h2>
					
					<div id="protabs" class='clearfix'>
						<ul>
							<li><a href="#pro"><?php  esc_html_e( 'PRO Version','crmerpbs' );?></a></li>
							<li><a href="#face"><?php  esc_html_e( 'Glasses TryON with Face Detection', 'crmerpbs' );?></a></li>
							
						</ul>

						<div id='pro'>
							<ul>
								<li><i class='fa fa-check' ></i> <?php esc_html_e("Try it Button single product / shop page!","MyWooCommerceShowroom");?> </li>
								<li><i class='fa fa-check' ></i> <?php esc_html_e("Customize Showroom Colors","MyWooCommerceShowroom");?> </li>
								<li><i class='fa fa-check' ></i> <?php esc_html_e("Match Your Business Case","MyWooCommerceShowroom");?> </li>
								<li><i class='fa fa-check' ></i> <?php esc_html_e("Interactive guide for User","MyWooCommerceShowroom");?> </li>					
								<li><i class='fa fa-check' ></i> <?php esc_html_e("You can Choose Content Type  to show","MyWooCommerceShowroom");?> </li>
								<li><i class='fa fa-check' ></i> <?php esc_html_e("Choose Category of the Content Type","MyWooCommerceShowroom");?> </li>
								<li><i class='fa fa-check' ></i> <?php esc_html_e("Add to cart functionality for each product","MyWooCommerceShowroom");?> </li>
								<li><i class='fa fa-check' ></i> <?php esc_html_e("In the showroom the customer may display multiple images on top of each bachground","MyWooCommerceShowroom");?> </li>
								<li><i class='fa fa-check' ></i> <?php esc_html_e("Screenshot option","MyWooCommerceShowroom");?>		 </li>
							</ul>	
							<p class='center'>			
								<a target='_blank'  href='https://extend-wp.com/product/product-virtual-try-on-showroom-for-woocommerce/'>
									<img class='premium_img' src='<?php echo plugins_url( 'images/virtual-try-woocommerce-showroom-pro.png', __FILE__ ); ?>' alt='Virtual Try On Woocommeerce Product Showroom' title='Virtual Try On Woocommeerce Product Showroom' />
								</a>
							<p  class='center'>
								<a target='_blank' style='background:#0085ba;color:#fff;padding:5px;text-decoration:none;border-radius:5px;' href='https://extend-wp.com/product/product-virtual-try-on-showroom-for-woocommerce/'>
									<i class='fa fa-tags' ></i> <?php esc_html_e("GET IT HERE","MyWooCommerceShowroom");?>
								</a>
							</p>						
						</div>
						<div id='face'>
							<ul>
								<li><i class='fa fa-check' ></i> <?php esc_html_e(" Automatic Face Detection","MyWooCommerceShowroom");?> </li>
								<li><i class='fa fa-check' ></i> <?php esc_html_e(" Real time TRY ON using Web Camera","MyWooCommerceShowroom");?> </li>
								<li><i class='fa fa-check' ></i> <?php esc_html_e(" Virtual Try On with Image","MyWooCommerceShowroom");?> </li>
								
							</ul>
							<p class='center'>			
								<a target='_blank'  href='https://extend-wp.com/product/ai-glasses-virtual-try-on-for-woocommerce-face-detection/'>
									<img class='premium_img' src='<?php echo plugins_url( 'images/ai-glasses-tryon-face-detection-woocommerce.jpg', __FILE__ ); ?>' alt='AI Glasses VIRTUAL TRY ON with Face Detection for WooCommerce' title='AI Glasses VIRTUAL TRY ON with Face Detection for WooCommerce' />
								</a>
							<p  class='center'>
								<a target='_blank' style='background:#0085ba;color:#fff;padding:5px;text-decoration:none;border-radius:5px;' href='https://extend-wp.com/product/ai-glasses-virtual-try-on-for-woocommerce-face-detection/'>
									<i class='fa fa-tags' ></i> <?php esc_html_e("GET IT HERE","MyWooCommerceShowroom");?>
								</a>
							</p>						
						</div>
					</div>
					
				</div>			
				
				
			</form>
		
		</div>
		
		<hr>
		
		
		
		
			<div  class='center footerWP' >	
			
				<p>
					<strong><?php esc_html_e( "You like this plugin? ", 'MyWooCommerceShowroom' ); ?></strong><i class='fa fa-2x fa-smile-o' ></i><br/> <?php esc_html_e( "Then please give us ", 'MyWooCommerceShowroom' ); ?> 
						<a target='_blank' href='https://wordpress.org/support/plugin/my-woocommerce-product-virtual-showroom/reviews/#new-post'>
							<span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span><span class="dashicons dashicons-star-filled"></span>
						</a>
				</p>
				
				<p style='min-width:40%;' >
				<iframe width="100%" height="315" src="https://www.youtube.com/embed/zvMBVo6C3eM" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</p>
				<p>
				<a target='_blank'  href='https://extend-wp.com/'><img style='max-width:150px;height:auto !important;' src='<?php echo plugins_url( 'images/extendwp.png', __FILE__ ); ?>' alt='<?php esc_html_e("Get more plugins by extend-wp.com","MyWooCommerceShowroom"); ?>' title='<?php esc_html_e("Get more plugins by extend-wp.com","MyWooCommerceShowroom"); ?>' /></a>
				</p>
			</div>
	

	</div>
	<?php  
	
}

//ON DEACTIVATION , DELETE THE OPTIONS CREATED

function MyWooCommerceShowroom_deactivation() {
  delete_option('MyWooCommerceShowroom_useMedia');
  delete_option('MyWooCommerceShowroom_pics');
  delete_option('MyWooCommerceShowroom_prod_nr');
  delete_option('MyWooCommerceShowroom_prod_cats');
  delete_option('MyWooCommerceShowroom_prod_nr');
  delete_option('MyWooCommerceShowroom_cat_terms'); 
}
register_deactivation_hook( __FILE__, 'MyWooCommerceShowroom_deactivation' );


/*translated strings*/
$MyWooCommerceShowroomtitl1=__('Upload a picture of your Space - Check how our Product Fits!','MyWooCommerceShowroom');
$MyWooCommerceShowroomtitl2=__('Select a product','MyWooCommerceShowroom');
$MyWooCommerceShowroomtext1=__('View','MyWooCommerceShowroom');
$MyWooCommerceShowroomtext2=__('Here','MyWooCommerceShowroom');
$MyWooCommerceShowroomtext3=__('Upload a Picture of your Space','MyWooCommerceShowroom');
$MyWooCommerceShowroomtext4=__('Click On a Product to Select','MyWooCommerceShowroom');
$MyWooCommerceShowroomtext5=__('Preview Product - Move & Resize','MyWooCommerceShowroom');
$MyWooCommerceShowroomtext6=__('Previous','MyWooCommerceShowroom');
$MyWooCommerceShowroomtext7=__('Next','MyWooCommerceShowroom');
$MyWooCommerceShowroomtext8=__('Download Picture','MyWooCommerceShowroom');
$MyWooCommerceShowroomtext8=__('Select Photo','MyWooCommerceShowroom');
$MyWooCommerceShowroomtext8=__('Select Product','MyWooCommerceShowroom');
$MyWooCommerceShowroomtext8=__('Preview Product','MyWooCommerceShowroom');
$MyWooCommerceShowroomtext9=__('Picture uploaded! Proceed to Step 2 by clicking the tab above or click on the picture if you would like to upload a different one.','MyWooCommerceShowroom');
$MyWooCommerceShowroomtext10=__('Product selected! Proceed to Step 3 by clicking the tab above or click on another product to select.','MyWooCommerceShowroom');
$MyWooCommerceShowroomtext11=__('Allow your customers to check your products on a picture they upload! Increase your Sales Now!','MyWooCommerceShowroom');


// HPOS compatibility declaration

add_action( 'before_woocommerce_init', function() {
	if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
		\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
	}
} );

// deactivation survey 

include( plugin_dir_path(__FILE__) .'/lib/codecabin/plugin-deactivation-survey/deactivate-feedback-form.php');	
add_filter('codecabin_deactivate_feedback_form_plugins', function($plugins) {

	$plugins[] = (object)array(
		'slug'		=> 'my-woocommerce-product-virtual-showroom',
		'version'	=> '2.6'
	);

	return $plugins;

});

// Email notification form
	
register_activation_hook( __FILE__, 'MyWooCommerceShowroom_notification_hook' );

function MyWooCommerceShowroom_notification_hook() {
    set_transient( 'MyWooCommerceShowroom_notification', true );
}

add_action( 'admin_notices', 'MyWooCommerceShowroom_notification' );

function MyWooCommerceShowroom_notification(){

	$screen = get_current_screen();
	//var_dump( $screen );
	if ( 'toplevel_page_MyWooCommerceShowroom_settings'  !== $screen->base )
	return;

    /* Check transient, if available display notice */
    if( get_transient( 'MyWooCommerceShowroom_notification' ) ){
        ?>
        <div class="updated notice MyWooCommerceShowroom_notification">
			<a href="#" class='dismiss' style='float:right;padding:4px' >close</a>
			<h3><i><?php esc_html_e( "Add your Email below & get ", 'MyWooCommerceShowroom' ); ?><strong style='color:#00a32a'><?php esc_html_e( " discounts", 'MyWooCommerceShowroom' ); ?></strong><?php esc_html_e( " in our pro plugins at", 'MyWooCommerceShowroom' ); ?> <a href='https://extend-wp.com' target='_blank' >extend-wp.com!</a></i></h3>
			<form method='post' id='MyWooCommerceShowroom_signup'>
				<p>
				<input required type='email' name='woopei_email' />
				<input required type='hidden' name='product' value='1150' />
				<input type='submit' class='button button-primary' name='submit' value='<?php esc_html_e("Sign up", "MyWooCommerceShowroom" ); ?>' />
				</p>
			</form>
        </div>
        <?php
    }
}
add_action( 'wp_ajax_nopriv_MyWooCommerceShowroom_push_not', 'MyWooCommerceShowroom_push_not'  );
add_action( 'wp_ajax_MyWooCommerceShowroom_push_not', 'MyWooCommerceShowroom_push_not' );

function MyWooCommerceShowroom_push_not(){
	
	delete_transient( 'MyWooCommerceShowroom_notification' );
			
}

?>