<?php
/*
Plugin Name: WPML Sticky Links
Plugin URI: https://wpml.org/
Description: Prevents internal links from ever breaking | <a href="https://wpml.org">Documentation</a> | <a href="https://wpml.org/version/wpml-3-5-0/">WPML 3.5.0 release notes</a>
Author: OnTheGoSystems
Author URI: http://www.onthegosystems.com/
Version: 1.4.0
Plugin Slug: wpml-sticky-links
*/

if(defined('WPML_STICKY_LINKS_VERSION')) return;

define('WPML_STICKY_LINKS_VERSION', '1.4.0');
define('WPML_STICKY_LINKS_PATH', dirname(__FILE__));

require WPML_STICKY_LINKS_PATH . '/embedded/wpml/commons/src/dependencies/class-wpml-dependencies.php';
require WPML_STICKY_LINKS_PATH . '/inc/constants.php';
require WPML_STICKY_LINKS_PATH . '/inc/sticky-links.class.php';
