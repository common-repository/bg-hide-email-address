<?php
 /*
  Plugin Name: BG::Hide-Email-Address
  Plugin URI: http://bunte-giraffe.de/bg-hide-email-address
  Description: Hides email addresses from bots, crawlers, scrapers and spiders
  Version: 0.1
  Author: Bunte Giraffe
  Author URI: http://bunte-giraffe.de
  Domain Path: /languages
  Text Domain: bg_hide_email_address
*/
 
 
/* Make sure we don't expose any info if called directly */
if ( !function_exists( 'add_action' ) ) {
	die("This application is not meant to be called directly!");
}


require_once( 'ErrorLogging.php');
require_once( 'utils/text-encode-decode/hc-text-encode-decode.php');


/* Register Wordpress Hooks */
register_uninstall_hook( __FILE__, 'bg_hide_email_address_plugin_uninstall' );
register_activation_hook( __FILE__, 'bg_hide_email_address_activate' );
register_deactivation_hook( __FILE__, 'bg_hide_email_address_deactivate' );

function bg_hide_email_address_activate()  { 
}


function bg_hide_email_address_deactivate(){
}


function bg_hide_email_address_plugin_uninstall() { 
}


add_action( "init", "bghea_plugin_register_shortcodes" );
add_action( "wp_enqueue_scripts", 'bghea_plugin_registerEmailDecoder' );
add_action( "admin_head", "bghea_add_tc_button");
add_action( "admin_enqueue_scripts", "bghea_add_mce_style" );


function bghea_plugin_register_shortcodes() {
	add_shortcode( 'bg-hide-email-address', 
		'bghea_plugin__shortcode_handler_bg_hide_email_address' );
}


function bghea_plugin_registerEmailDecoder() {
	$emailDecoderScriptPath = plugins_url( 'assets/js/bghea-email-decoder.js', __FILE__ );

	$scriptDependencies = array();
	$scriptVersion = NULL;
	$includeInBody = true;

	wp_enqueue_script( 'js-bghea-email-decoder', $emailDecoderScriptPath,
		$scriptDependencies, $scriptVersion, $includeInBody );
}


function bghea_plugin__shortcode_handler_bg_hide_email_address( 
	$shortcodeAttributes, $shortcodeContent = "", $shortcodeName = "")
{
	$attributes = shortcode_atts( array(
		'inline_css' => 'margin-bottom:-3px;'
		), 
		
		$shortcodeAttributes, 'bg-hide-email-address'
	);

	$tmpLog = bghea_LogFile::getInstance();
	$tmpEncodedEmailAddress = bghea_EncodeString( $shortcodeContent);
	if( NULL == $tmpEncodedEmailAddress) {
		$tmpLog->Error( "Failed to encode email address: '" . $shortcodeContent . "'");
		return "";
	}

	$styleTemplate = "vertical-align:text-top;margin-bottom:-3px;";
	$styleTemplate .= "%%INLINE-CSS%%;";
	$styleTemplate = str_replace( "%%INLINE-CSS%%", $attributes['inline_css'], $styleTemplate);

	$canvasTemplate = "
		<canvas id=\"%%CANVAS_ID%%\"
			width=\"%%CANVAS_WIDTH%%\"
			height=\"%%CANVAS_HEIGHT%%\"
			style=\"%%CANVAS_STYLE%%\" 
			onclick='bghea_onCanvasWasClicked(this)' >
				%%CANVAS_CONTENT%%
			</canvas>";

	$tmpCanvasId = uniqid( "bghea-id_");
			
	$canvasFilledIn = str_replace( "%%CANVAS_ID%%", $tmpCanvasId, $canvasTemplate);
	$canvasFilledIn = str_replace( "%%CANVAS_WIDTH%%", "200", $canvasFilledIn);
	$canvasFilledIn = str_replace( "%%CANVAS_HEIGHT%%", "15", $canvasFilledIn);

	$canvasFilledIn = str_replace( "%%CANVAS_STYLE%%", $styleTemplate, $canvasFilledIn);
	$canvasFilledIn = str_replace( "%%CANVAS_CONTENT%%", $tmpEncodedEmailAddress, $canvasFilledIn);

	return $canvasFilledIn;
}


function bghea_add_tc_button() {
    global $typenow;
    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
		return;
    }
    // verify the post type
    if( !in_array( $typenow, array( 'post', 'page' ) ) )
        return;
    // check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {
        add_filter("mce_external_plugins", "bghea_add_tinymce_plugin");
        add_filter('mce_buttons', 'bghea_register_tc_button');
    }
}


function bghea_add_tinymce_plugin($plugin_array) {
    $plugin_array['bghea_tc_button'] = plugins_url( 'assets/js/hide_email_address_mce_plugin.js', __FILE__ ); 
    return $plugin_array;
}


function bghea_register_tc_button($buttons) {
   array_push($buttons, "bghea_tc_button");
   return $buttons;
}


function bghea_add_mce_style() {

	wp_enqueue_style( 'styleBE-tmce-bghea.css',
		plugins_url( "assets/css/styleBE-tmce.css", __FILE__ ) );

}
?>