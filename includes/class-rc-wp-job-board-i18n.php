<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.recruitology.com
 * @since      0.9.0
 *
 * @package    Rc_Wp_Job_Board
 * @subpackage Rc_Wp_Job_Board/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.9.0
 * @package    Rc_Wp_Job_Board
 * @subpackage Rc_Wp_Job_Board/includes
 * @author     Recruitology <developers@recruitology.com>
 */
class Rc_Wp_Job_Board_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.9.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'rc-wp-job-board',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
