<?php
/**
 * Class: wop_Model_Overview
 * @author Flipper Code <hello@flippercode.com>
 * @version 2.0.0
 * @package Posts
 */

if ( ! class_exists( 'MTO_Model_Overview' ) ) {

	/**
	 * Overview model for Plugin Overview.
	 * @package Posts
	 * @author Flipper Code <hello@flippercode.com>
	 */
	class MTO_Model_Overview extends FlipperCode_Model_Base {
		/**
		 * Intialize Backup object.
		 */
		function __construct() {
		}
		/**
		 * Admin menu for Settings Operation
		 */
		function navigation() {
			return array(
			'mto_how_overview' => __( 'How to Use', MTO_TEXT_DOMAIN ),
			);
		}
	}
}
