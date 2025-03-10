<?php
/**
 * Advanced Ads – Google AdSense In-feed Placement
 *
 * @package   AdvancedAds
 * @author    Advanced Ads <support@wpadvancedads.com>
 * @license   GPL-2.0+
 * @link      https://wpadvancedads.com
 * @copyright since 2013 Advanced Ads
 *
 * @wordpress-plugin
 * Plugin Name:       Advanced Ads – Google AdSense In-feed Placement
 * Version:           2.0.0
 * Description:       Display AdSense In-feed ads between posts
 * Plugin URI:        https://wpadvancedads.com/
 * Author:            Advanced Ads
 * Author URI:        https://wpadvancedads.com
 * Text Domain:       advanced-ads-adsense-in-feed
 * Domain Path:       /languages
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @requires
 * Requires at least: 5.7
 * Requires PHP:      7.4
 */

// Early bail!!
if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( defined( 'AAINF_FILE' ) ) {
	return;
}

define( 'AAINF_FILE', __FILE__ );
define( 'AAINF_VERSION', '2.0.0' );

// Load the autoloader.
require_once __DIR__ . '/includes/class-autoloader.php';
\AdvancedAds\InFeed\Autoloader::get()->initialize();

if ( ! function_exists( 'wp_advads_infeed' ) ) {
	/**
	 * Returns the main instance of the plugin.
	 *
	 * @return \AdvancedAds\InFeed\Plugin
	 * @since 1.2.0
	 */
	function wp_advads_infeed() {
		return \AdvancedAds\InFeed\Plugin::get();
	}
}

\AdvancedAds\InFeed\Bootstrap::get()->start();
