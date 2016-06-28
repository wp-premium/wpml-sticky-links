<?php 
/*
Plugin Name: WPML Sticky Links
Plugin URI: https://wpml.org/
Description: Prevents internal links from ever breaking. <a href="https://wpml.org">Documentation</a>.
Author: OnTheGoSystems
Author URI: http://www.onthegosystems.com/
Version: 1.3.19
Plugin Slug: wpml-sticky-links
*/

if(defined('WPML_STICKY_LINKS_VERSION')) return;

define('WPML_STICKY_LINKS_VERSION', '1.3.19');
define('WPML_STICKY_LINKS_PATH', dirname(__FILE__));

require WPML_STICKY_LINKS_PATH . '/embedded/wpml/commons/src/dependencies/class-wpml-dependencies.php';
require WPML_STICKY_LINKS_PATH . '/inc/constants.php';
require WPML_STICKY_LINKS_PATH . '/inc/sticky-links.class.php';
