<?php
/**
 * Frontend.
 *
 * @package AdvancedAds\InFeed
 * @author  Advanced Ads <info@wpadvancedads.com>
 * @since   1.2.0
 */

namespace AdvancedAds\InFeed;

use AdvancedAds\Framework\Interfaces\Integration_Interface;
use WP_Query;

defined( 'ABSPATH' ) || exit;

/**
 * Frontend.
 */
class Frontend implements Integration_Interface {

	/**
	 * Hook into WordPress.
	 *
	 * @return void
	 */
	public function hooks(): void {
		add_action( 'the_post', [ $this, 'inject_in_feed' ], 20, 2 );
	}

	/**
	 * Echo ad before/after posts in loops on archive pages
	 *
	 * @param \WP_Post $post     post object.
	 * @param WP_Query $wp_query query object.
	 *
	 * @return void
	 */
	public function inject_in_feed( $post, $wp_query = null ): void {
		if (
			! $wp_query instanceof WP_Query ||
			is_feed() ||
			is_admin() ||
			$wp_query->is_singular() ||
			! $wp_query->in_the_loop ||
			! isset( $wp_query->current_post ) ||
			! $wp_query->is_main_query()
		) {
			return;
		}

		$curr_index = $wp_query->current_post + 1; // normalize index.

		// Handle the situation when wp_reset_postdata() is used after secondary query inside main query.
		static $handled_indexes = [];
		if ( isset( $handled_indexes[ $curr_index ] ) ) {
			return;
		}
		$handled_indexes[] = $curr_index;

		$placements = wp_advads_get_placements_by_types( 'adsense_in_feed' );

		foreach ( $placements as $id => $placement ) {
			$item = $placement->get_item();
			if ( empty( $item ) ) {
				continue;
			}

			$options  = $placement->get_data();
			$ad_index = isset( $options['adsense_in_feed_pages_index'] ) ? absint( ( $options['adsense_in_feed_pages_index'] ) ) : 1;

			if ( $ad_index === $curr_index ) {
				$options['placement']['type'] = 'adsense_in_feed';
				if ( wp_advads_infeed()->is_infeed_ad( $item ) ) {
					the_ad_placement( $id, $options );
				}
			}
		}
	}
}
