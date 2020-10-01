<?php
/**
 * Plugin Name: WPML Sticky Links
 * Plugin URI: https://wpml.org/
 * Description: Prevents internal links from ever breaking | <a href="https://wpml.org">Documentation</a> | <a href="https://wpml.org/version/sticky-links-1-5-4/">WPML Sticky Links 1.5.4 release notes</a>
 * Author: OnTheGoSystems
 * Author URI: http://www.onthegosystems.com/
 * Version: 1.5.4
 * Plugin Slug: wpml-sticky-links
 *
 * @package WPML\SL
 */

if ( defined( 'WPML_STICKY_LINKS_VERSION' ) ) {
	return;
}

define( 'WPML_STICKY_LINKS_VERSION', '1.5.4' );
define( 'WPML_STICKY_LINKS_PATH', dirname( __FILE__ ) );

require WPML_STICKY_LINKS_PATH . '/inc/constants.php';

$autoloader_dir = WPML_STICKY_LINKS_PATH . '/vendor';
if ( version_compare( PHP_VERSION, '5.3.0' ) >= 0 ) {
	$autoloader = $autoloader_dir . '/autoload.php';
} else {
	$autoloader = $autoloader_dir . '/autoload_52.php';
}
require_once $autoloader;


global $WPML_Sticky_Links;

if ( ! isset( $WPML_Sticky_Links ) ) {
	$WPML_Sticky_Links = new WPML_Sticky_Links();
	$WPML_Sticky_Links->init_hooks();
}

add_action( 'wpml_loaded', 'wpml_stick_links_load' );
function wpml_stick_links_load() {
	$action_filter_loader = new WPML_Action_Filter_Loader();
	$action_filter_loader->load(
		[
			WPML\SL\CustomFields::class,
		]
	);
}

if ( ! function_exists( 'icl_js_escape' ) ) {
	function icl_js_escape( $str ) {
		$str = esc_js( $str );
		$str = htmlspecialchars_decode( $str );

		return $str;
	}
}
