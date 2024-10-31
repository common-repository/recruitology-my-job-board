<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.recruitology.com
 * @since      0.9.0
 *
 * @package    Rc_Wp_Job_Board
 * @subpackage Rc_Wp_Job_Board/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rc_Wp_Job_Board
 * @subpackage Rc_Wp_Job_Board/admin
 * @author     Recruitology <developers@recruitology.com>
 */
class Rc_Wp_Job_Board_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.9.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.9.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.9.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->rc_option_key = 'recruitology_api_key';
        $this->rc_api_key = get_option( $this->rc_option_key );
        $this->api_url = 'https://api.recruitology.com/api/job-listing-widgets/?api_key='.$this->rc_api_key;

        $this->loadDependancies();
	}

	private function get_plugin_path() {
	    return plugin_dir_path( dirname( __FILE__ ) );
    }

	private function loadDependancies() {
        add_action('admin_menu', array( $this, 'addPluginAdminMenu' ), 9);
        add_action( 'admin_post_customize_css', array($this, 'setCustomCss'), 0 );

        add_action( 'admin_post_rc_set_company_id', array($this, 'setCompanyId'), 0 );
    }

    private function getWidgetUrl( $type ) {

        $url = $this->api_url . '&widget_type=' . $type;
        $json = wp_remote_retrieve_body( wp_remote_get( $url ) );
        $obj = json_decode($json, true);

        return $obj['widget_url'];
    }

    public function addPluginAdminMenu() {
        //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
        add_menu_page(  $this->plugin_name, 'Recruitology', 'administrator',

        $this->plugin_name, array( $this, 'displayPluginAdminDashboard' ), 'dashicons-welcome-widgets-menus', 26 );

        //add_submenu_page( '$parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
//        add_submenu_page( $this->plugin_name, 'Plugin Name Settings', 'Settings', 'administrator', $this->plugin_name.'-settings', array( $this, 'displayPluginAdminSettings' ));
    }

    private function activatePlugin( $api_key ) {
        // api/wordpress/company/<api-key>
//        echo $api_key.'<br/';

        $data = array("connected" => 1);
        $url = 'https://api.recruitology.com/api/wordpress/company/' . $api_key .'/';

        $response = wp_remote_request( $url, ['method' => 'PUT','body' => $data] );

        if(!$response) {

            echo 'error';
            return false;
        }

        $resp_data = json_decode(wp_remote_retrieve_body($response), 1);
//        print_r($resp_data['data']);exit;

        return $resp_data['data'];
    }

    public function displayPluginAdminDashboard()
    {
        // Get / Check for API Key
        if ( !$this->rc_api_key ) {

            require_once $this->get_plugin_path() . 'admin/partials/' . $this->plugin_name . '-admin-start.php' ;

        } else {

            $this->active_tab = (isset($_GET['tab'])) ? sanitize_title( $_GET['tab'], 'home' ) : 'home';

            require_once $this->get_plugin_path() . 'admin/partials/' . $this->plugin_name . '-admin-dashboard.php' ;
        }
    }

    public function setCompanyId() {
	    $api_key = sanitize_key( $_POST['rc_api_key'] );

	    $resp = $this->activatePlugin( $api_key  );

	    if( !$resp ){
	        // error
            wp_redirect( admin_url('admin.php?page=rc-wp-job-board&error=activate') );
            exit;
        }
	    // save company data
        $company_data = $resp;
        update_option('recruitology_company_data', $company_data);


	    // save api key/wp company id
	    update_option( $this->rc_option_key, $api_key );


	    // create jobs page
	    $jobs_post_id = $this->createJobsPage();
        update_option('recruitology_jobspage_postid', $jobs_post_id);

        // redirect
        wp_redirect( admin_url('admin.php?page=rc-wp-job-board') );
        exit();
    }

    public function setCustomCss() {
	    $settings = [];

	    $settings['title-text'] = sanitize_text_field( $_POST['title-text'] );
	    $settings['tagline-text'] = sanitize_text_field( $_POST['tagline-text'] );

	    $settings['primary-color'] = sanitize_hex_color( $_POST['primary-color'] );
	    $settings['alt-row-color'] = sanitize_hex_color( $_POST['alt-row-color'] );

	    $settings['show-border'] = ( isset($_POST['show-border']) ) ? true : false;
	    $settings['show-logo'] = ( isset($_POST['show-logo']) ) ? true : false;
	    $settings['show-header-text'] = ( isset($_POST['show-header-text']) ) ? true : false;

        update_option('recruitology_custom_settings', $settings);

        wp_redirect( admin_url('admin.php?page=rc-wp-job-board&tab=customize&save=1') );
        exit;
    }

    public function createJobsPage() {
        $content = '[rc-job-board/]';

        $PageGuid = site_url() . "/jobs";

        $my_post  = array(
            'post_title'     => 'Jobs',
            'post_type'      => 'page',
            'post_name'      => 'Jobs',
            'post_content'   => $content,
            'post_status'    => 'publish',
            'comment_status' => 'closed',
            'ping_status'    => 'closed',
            'post_author'    => 1,
            'menu_order'     => 0,
            'guid'           => $PageGuid );

        // Insert the post into the database
//        kses_remove_filters();
        $id = wp_insert_post($my_post);
//        kses_init_filters();

        return $id;
    }

    /**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.9.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/rc-wp-job-board-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.9.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/rc-wp-job-board-admin.js', array( 'jquery' ), $this->version, false );

	}
}
