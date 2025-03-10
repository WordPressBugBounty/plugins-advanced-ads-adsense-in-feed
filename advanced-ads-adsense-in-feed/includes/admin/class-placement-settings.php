<?php
/**
 * Admin Placement Settings.
 *
 * @package AdvancedAds\InFeed
 * @author  Advanced Ads <info@wpadvancedads.com>
 * @since   1.2.0
 */

namespace AdvancedAds\InFeed\Admin;

use AdvancedAds\Abstracts\Placement;
use AdvancedAds\Framework\Interfaces\Integration_Interface;
use AdvancedAds\Utilities\WordPress;

defined( 'ABSPATH' ) || exit;

/**
 * Placement Settings.
 */
class Placement_Settings implements Integration_Interface {

	/**
	 * Hook into WordPress.
	 *
	 * @return void
	 */
	public function hooks(): void {
		add_action( 'advanced-ads-placement-options-before', [ $this, 'placement_options_check' ], 10, 2 );
		add_action( 'advanced-ads-placement-options-after', [ $this, 'placement_options' ], 11, 2 );
	}

	/**
	 * Check if this is indeed an In-feed ad
	 *
	 * @param string    $placement_slug Placement id.
	 * @param Placement $placement      Placement instance.
	 *
	 * @return void
	 */
	public function placement_options_check( $placement_slug, $placement ): void {
		if ( $placement->is_type( 'adsense_in_feed' ) ) {
			if ( ! wp_advads_infeed()->is_infeed_ad( $placement->get_item() ) ) {
				echo wp_kses_post(
					sprintf(
						'<p class="advads-error-message">%s</p>',
						sprintf(
						/* translators: %s is a link. */
							__(
								'This placement can only deliver a single In-feed ad. Use the <a href="%s" target="_blank">Post Lists placement</a> for other ad types.',
								'advanced-ads-adsense-in-feed'
							),
							'https://wpadvancedads.com/manual/placement-post-lists/'
						)
					)
				);
			}
		}
	}

	/**
	 * Render placement options
	 *
	 * @param string    $placement_slug Placement id.
	 * @param Placement $placement      Placement instance.
	 *
	 * @return void
	 */
	public function placement_options( $placement_slug, $placement ): void {
		if ( $placement->is_type( 'adsense_in_feed' ) ) {
			$options        = $placement->get_data();
			$index          = $options['adsense_in_feed_pages_index'] ?? 1;
			$index_option   = '<input type="number" name="advads[placements][options][adsense_in_feed_pages_index]" value="' . $index . '" name="advads-placements-adsense-in-feed-index' . $placement_slug . '"/>';
			$option_content = sprintf(
			/* translators: $s is an index, e.g., "5". */
				__( 'Inject before %s. post', 'advanced-ads-adsense-in-feed' ),
				$index_option
			);

			$description = __( 'Before which post to inject the ad on post lists.', 'advanced-ads-adsense-in-feed' );
			WordPress::render_option(
				'placement-in-feed-position',
				__( 'position', 'advanced-ads-adsense-in-feed' ),
				$option_content,
				$description
			);
		}
	}
}
