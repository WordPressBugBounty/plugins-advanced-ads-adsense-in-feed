<?php
/**
 * In-feed placement type.
 *
 * @package AdvancedAds\Pro
 * @author  Advanced Ads <info@wpadvancedads.com>
 */

namespace AdvancedAds\InFeed;

use AdvancedAds\Interfaces\Placement_Type;
use AdvancedAds\Abstracts\Placement_Type as Base;

/**
 * Placement type
 */
class In_Feed_Type extends Base implements Placement_Type {
	/**
	 * Get the unique identifier (ID) of the placement type.
	 *
	 * @return string The unique ID of the placement type.
	 */
	public function get_id(): string {
		return 'adsense_in_feed';
	}

	/**
	 * Get the class name of the object as a string.
	 *
	 * @return string
	 */
	public function get_classname(): string {
		return In_Feed_Placement::class;
	}

	/**
	 * Get the title or name of the placement type.
	 *
	 * @return string The title of the placement type.
	 */
	public function get_title(): string {
		return __( 'AdSense In-feed', 'advanced-ads-adsense-in-feed' );
	}

	/**
	 * Get a description of the placement type.
	 *
	 * @return string The description of the placement type.
	 */
	public function get_description(): string {
		return __( 'Display an AdSense In-feed ad between posts', 'advanced-ads-adsense-in-feed' );
	}

	/**
	 * Check if this placement type requires premium.
	 *
	 * @return bool True if premium is required; otherwise, false.
	 */
	public function is_premium(): bool {
		return false;
	}

	/**
	 * Get the URL for upgrading to this placement type.
	 *
	 * @return string The upgrade URL for the placement type.
	 */
	public function get_image(): string {
		return AA_INFEED_BASE_URL . 'assets/img/adsense-in-feed.png';
	}

	/**
	 * Get order number for this placement type.
	 *
	 * @return int The order number.
	 */
	public function get_order(): int {
		return 110;
	}

	/**
	 * Get options for this placement type.
	 *
	 * @return array The options array.
	 */
	public function get_options(): array {
		return $this->apply_filter_on_options(
			[
				'show_position'  => true,
				'show_lazy_load' => true,
			]
		);
	}
}
