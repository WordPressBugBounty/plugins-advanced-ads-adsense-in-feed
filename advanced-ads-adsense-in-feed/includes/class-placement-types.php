<?php
/**
 * Placement Types.
 *
 * @package AdvancedAds\InFeed
 * @author  Advanced Ads <info@wpadvancedads.com>
 * @since   1.2.0
 */

namespace AdvancedAds\InFeed;

use AdvancedAds\Abstracts\Types;
use AdvancedAds\Framework\Interfaces\Integration_Interface;

defined( 'ABSPATH' ) || exit;

/**
 * Placement Types.
 */
class Placement_Types implements Integration_Interface {

	/**
	 * Hook into WordPress.
	 *
	 * @return void
	 */
	public function hooks(): void {
		add_filter( 'advanced-ads-placement-types-manager', [ $this, 'register_types' ] );
	}

	/**
	 * Register the placement type
	 *
	 * @param Types $manager Placement types manager.
	 *
	 * @return void
	 */
	public function register_types( Types $manager ): void {
		$manager->register_type( In_Feed_Type::class );
	}
}
