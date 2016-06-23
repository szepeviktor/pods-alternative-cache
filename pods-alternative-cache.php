<?php
/*
Plugin Name: Pods Alternative Cache
Plugin URI: http://pods.io/2014/04/16/introducing-pods-alternative-cache/
Description: Alternative caching engine for Pods for large sites on hosts with hard limits on how much you can cache
Version: 2.0
Author: The Pods Framework Team
Author URI: http://pods.io/
*/

define( 'PODS_ALT_CACHE_DIR', plugin_dir_path( __FILE__ ) );

/**
 * @global $pods_alternative_cache Pods_Alternative_Cache
 */
global $pods_alternative_cache;

/**
 * Setup default constants, add hooks
 */
function pods_alternative_cache_init() {

	/**
	 * @var $pods_alternative_cache Pods_Alternative_Cache
	 */
	global $pods_alternative_cache;

	if ( ! defined( 'PODS_ALT_CACHE' ) ) {
		define( 'PODS_ALT_CACHE', true );
	}

	if ( ! defined( 'PODS_ALT_CACHE_TYPE' ) ) {
		define( 'PODS_ALT_CACHE_TYPE', 'file' ); // file | db | memcache
	}

	include_once PODS_ALT_CACHE_DIR . 'classes/Pods/Alternative/Cache.php';
	include_once PODS_ALT_CACHE_DIR . 'classes/Pods/Alternative/Cache/Storage.php';

	$cache_type = 'file';

	if ( in_array( PODS_ALT_CACHE_TYPE, array( 'file', 'db', 'memcached' ) ) ) {
		$cache_type = PODS_ALT_CACHE_TYPE;
	}

	$pods_alternative_cache = new Pods_Alternative_Cache( $cache_type );

	register_activation_hook( __FILE__, array( $pods_alternative_cache, 'activate' ) );
	register_deactivation_hook( __FILE__, array( $pods_alternative_cache, 'deactivate' ) );

}
add_action( 'plugins_loaded', 'pods_alternative_cache_init' );
