<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.recruitology.com
 * @since      0.9.0
 *
 * @package    Rc_Wp_Job_Board
 * @subpackage Rc_Wp_Job_Board/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.9.0
 * @package    Rc_Wp_Job_Board
 * @subpackage Rc_Wp_Job_Board/includes
 * @author     Recruitology <developers@recruitology.com>
 */
class Rc_Wp_Job_Board {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.9.0
	 * @access   protected
	 * @var      Rc_Wp_Job_Board_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.9.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.9.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.9.0
	 */
	public function __construct() {
		if ( defined( 'RC_WP_JOB_BOARD_VERSION' ) ) {
			$this->version = RC_WP_JOB_BOARD_VERSION;
		} else {
			$this->version = '0.9.0';
		}
		$this->plugin_name = 'rc-wp-job-board';

        $this->rc_option_key = 'recruitology_api_key';

        $this->rc_api_key = get_option( $this->rc_option_key );
        $this->api_url = 'https://api.recruitology.com/api/job-listing-widgets/?api_key='.$this->rc_api_key;


		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Rc_Wp_Job_Board_Loader. Orchestrates the hooks of the plugin.
	 * - Rc_Wp_Job_Board_i18n. Defines internationalization functionality.
	 * - Rc_Wp_Job_Board_Admin. Defines all hooks for the admin area.
	 * - Rc_Wp_Job_Board_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.9.0
	 * @access   private
	 */
	private function load_dependencies() {

        /**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rc-wp-job-board-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rc-wp-job-board-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-rc-wp-job-board-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-rc-wp-job-board-public.php';

        add_shortcode('rc-job-board', array($this, 'renderJobBoardBasic') );
        add_shortcode('rc-job-board-search', array($this, 'renderJobBoardSearch') );
        add_shortcode('rc-job-board-advanced', array($this, 'renderJobBoardAdvanced') );

        $this->loader = new Rc_Wp_Job_Board_Loader();
	}

	private function getWidgetUrl( $type ) {

        $url = $this->api_url . '&widget_type=' . $type;

        $json = wp_remote_retrieve_body( wp_remote_get( $url ) );

        $obj = json_decode($json, true);

        return $obj['widget_url'];
    }

    private function getCustomSettings() {
	    $settings = get_option('recruitology_custom_settings');

        $settings_data = ( !$settings ) ? 'false' : json_encode($settings);

//        $content_settings = "<script type='text/javascript'>var rc_settings = " . $settings_data ."</script>";
        $content_settings = "var rc_settings = " . $settings_data . ";";

	    return $content_settings;
    }

    public function render_widget($type) {
        $widget_url = $this->getWidgetUrl( $type );

        wp_enqueue_script('rc-'.$type, $widget_url);

        $script = $this->getCustomSettings();
        wp_add_inline_script('rc-'.$type, $script, 'before');

        $content = "<div id='rc-jb-holder'></div><style class='rc-widget-styles'></style>";
        echo $content;
//        return $content;
    }

    public function renderJobBoardBasic() {
	    $this->render_widget('basic');
	    return;
    }

    public function renderJobBoardAdvanced() {
        $this->render_widget('advanced');
        return;
    }

    public function renderJobBoardSearch() {
        $this->render_widget('simple');
        return;
    }

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Rc_Wp_Job_Board_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.9.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Rc_Wp_Job_Board_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.9.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Rc_Wp_Job_Board_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.9.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Rc_Wp_Job_Board_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.9.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.9.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.9.0
	 * @return    Rc_Wp_Job_Board_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.9.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
