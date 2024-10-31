<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://www.recruitology.com
 * @since      0.9.0
 *
 * @package    Rc_Wp_Job_Board
 * @subpackage Rc_Wp_Job_Board/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      0.9.0
 * @package    Rc_Wp_Job_Board
 * @subpackage Rc_Wp_Job_Board/includes
 * @author     Recruitology <developers@recruitology.com>
 */
class Rc_Wp_Job_Board_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.9.0
	 */
	public static function deactivate() {

	    // Disconnect api key
	    $api_key = get_option('recruitology_api_key');
//        echo $api_key;exit;

        $data = array("connected" => 0);
        $url = 'https://api.recruitology.com/api/wordpress/company/' . $api_key .'/';

        $response = wp_remote_request( $url, ['method' => 'PUT','body' => $data] );

        delete_option('recruitology_api_key');
        delete_option('recruitology_company_data');
        delete_option('recruitology_jobspage_postid');
        delete_option('recruitology_custom_settings');

        // Delete Post
	}

}
