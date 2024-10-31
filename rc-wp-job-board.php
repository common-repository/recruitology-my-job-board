<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.recruitology.com
 * @since             0.9.1
 * @package           Rc_Wp_Job_Board
 *
 * @wordpress-plugin
 * Plugin Name:       Recruitology My Job Board
 * Plugin URI:        https://www.recruitology.com/products/job-board
 * Description:       Incorporate your company's job listings on your Wordpress company website. You'll have access to our free applicant tracking system. Not getting enough applicants from your company website, purchase one of oir recommended job distribution packages by placing your job on Indeed, ZipRecruiter, Glassdoor, Facebook, LinkedIn, and Twitter.
 * Version:           0.9.1
 * Author:            Recruitology
 * Author URI:        https://www.recruitology.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       rc-wp-job-board
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 0.9.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RC_WP_JOB_BOARD_VERSION', '0.9.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-rc-wp-job-board-activator.php
 */
function activate_rc_wp_job_board() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rc-wp-job-board-activator.php';
	Rc_Wp_Job_Board_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-rc-wp-job-board-deactivator.php
 */
function deactivate_rc_wp_job_board() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-rc-wp-job-board-deactivator.php';
	Rc_Wp_Job_Board_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_rc_wp_job_board' );
register_deactivation_hook( __FILE__, 'deactivate_rc_wp_job_board' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-rc-wp-job-board.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.9.0
 */
function run_rc_wp_job_board() {

	$plugin = new Rc_Wp_Job_Board();
	$plugin->run();

}
run_rc_wp_job_board();
