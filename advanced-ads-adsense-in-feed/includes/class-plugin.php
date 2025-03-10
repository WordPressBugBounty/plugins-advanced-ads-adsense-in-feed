<?php
/**
 * The plugin bootstrap.
 *
 * @package AdvancedAds\InFeed
 * @author  Advanced Ads <info@wpadvancedads.com>
 * @since   1.2.0
 */

namespace AdvancedAds\InFeed;

use AdvancedAds\Framework\Loader;
use AdvancedAds\Framework\Utilities\Str;
use AdvancedAds\InFeed\Admin\Placement_Settings;

defined( 'ABSPATH' ) || exit;

/**
 * Plugin.
 */
class Plugin extends Loader {

	/**
	 * Main instance
	 *
	 * Ensure only one instance is loaded or can be loaded.
	 *
	 * @return Plugin
	 */
	public static function get(): Plugin {
		static $instance;

		if ( null === $instance ) {
			$instance = new Plugin();
			$instance->setup();
		}

		return $instance;
	}

	/**
	 * Get plugin version
	 *
	 * @return string
	 */
	public function get_version(): string {
		return AAINF_VERSION;
	}

	/**
	 * Bootstrap plugin.
	 *
	 * @return void
	 */
	private function setup(): void {
		$this->define_constants();
		$this->includes();

		add_action( 'init', [ $this, 'load_textdomain' ] );
		$this->load();
	}

	/**
	 * Define Advanced Ads constant
	 *
	 * @return void
	 */
	private function define_constants(): void {
		$this->define( 'AA_INFEED_ABSPATH', dirname( AAINF_FILE ) . '/' );
		$this->define( 'AA_INFEED_BASENAME', plugin_basename( AAINF_FILE ) );
		$this->define( 'AA_INFEED_BASE_URL', plugin_dir_url( AAINF_FILE ) );
		$this->define( 'AA_INFEED_SLUG', 'advanced-ads-adsense-in-feed' );
	}

	/**
	 * Includes core files used in admin and on the frontend.
	 *
	 * @return void
	 */
	private function includes(): void {
		$this->register_integration( Placement_Types::class );

		if ( is_admin() ) {
			$this->register_integration( Placement_Settings::class );
		} else {
			$this->register_integration( Frontend::class );
		}
	}

	/**
	 * Check if the current ad is an in-feed item
	 *
	 * @param string $item_id Item ID from a placement.
	 *
	 * @return bool
	 */
	public function is_infeed_ad( $item_id ): bool {
		$_item = explode( '_', $item_id );

		if ( 'ad' !== $_item[0] || ! isset( $_item[1] ) || empty( $_item[1] ) ) {
			return false;
		}

		$ad = wp_advads_get_ad( $_item[1] );

		return $ad->is_type( 'adsense' ) && Str::contains( 'in-feed', $ad->get_content() );
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @return void
	 */
	public function load_textdomain(): void {
		$locale = get_user_locale();
		$locale = apply_filters( 'plugin_locale', $locale, 'advanced-ads-adsense-in-feed' );

		unload_textdomain( 'advanced-ads-adsense-in-feed' );
		if ( false === load_textdomain( 'advanced-ads-adsense-in-feed', WP_LANG_DIR . '/plugins/advanced-ads-adsense-in-feed-' . $locale . '.mo' ) ) {
			load_textdomain( 'advanced-ads-adsense-in-feed', WP_LANG_DIR . '/advanced-ads-adsense-in-feed/advanced-ads-adsense-in-feed-' . $locale . '.mo' );
		}

		load_plugin_textdomain( 'advanced-ads-adsense-in-feed', false, dirname( AA_INFEED_BASENAME ) . '/languages' );
	}
}
