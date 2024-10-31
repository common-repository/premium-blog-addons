<?php



/**
 * Widgets Loader class.
 *
 * @category   Class
 * @package    premiumblogWidgets
 * @subpackage WordPress
 * @since      1.0.0
 * php version 7.4
 */

if (!defined('ABSPATH')) {
	// Exit if accessed directly.
	exit;
}

/**
 * Main Premium Blog Widgets Class
 *
 * The init class that runs the Premium Blog Widgets plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 */
use premiumblogWidgets\Classes\Utilities;

final class PBW_WIDGETS
{

	/**
	 * Page buildres
	 */
	private $builder_elementor;
	private $builder_wordpress;
	private $social_sharing;
	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.3.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.0.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct()
	{

		// Get page builders status;
		$this->builder_elementor = get_option('premiumblog_builders_elementor');
		//$this->builder_wordpress = get_option( 'premiumblog_builders_wordpress' );
		$this->social_sharing = get_option('premiumblog_tools_social_sharing');

		// Load the translation.
		add_action('init', array($this, 'i18n'));
		

		// Initialize the plugin.
		add_action('plugins_loaded', array($this, 'php_version'));
		add_action('plugins_loaded', array($this, 'load_elementor_widgets'));

		//Enqueue Scripts
		add_action('wp_enqueue_scripts', array($this, 'premiumblog_widget_scripts'));
		add_action('admin_enqueue_scripts', array($this, 'premiumblog_admin_scripts'));

		add_action('wp_enqueue_scripts', array($this, 'premiumblog_scripts'));


		if ($this->builder_elementor == "on") {
			add_action('elementor/editor/before_enqueue_scripts', array($this, 'premiumblog_widget_scripts'));
			// Editor CSS/JS
			add_action('elementor/editor/after_enqueue_styles', [$this, 'enqueue_panel_styles'], 988);
		}
		//Register Image Sizes
		add_action('init', array($this, 'premiumblog_image_sizes'));

		//Add custom class to Body element
		add_filter('body_class', function ($classes) {
			return array_merge($classes, array('premium-blog'));
		});
	}



	/**
	 * Plugin scripts & styles
	 *
	 * @since v1.0.0
	 */
	public function premiumblog_widget_scripts()
	{
		if ($this->builder_elementor == "on") {
			wp_enqueue_script('jquery');
			wp_enqueue_script('premiumblog-posts-carousel-script', PBW_ASSETS_PATH . 'owl/carousel.min.js', array(), '2.3.4', false);
			wp_enqueue_script('premiumblog-plugin-main', PBW_ASSETS_PATH . 'js/premiumblog-main.js', array(), '1.0.0', false);
			wp_enqueue_style('premiumblog-font-icons', PBW_ASSETS_PATH . 'css/fontello.css', [], '1.0.0');
			wp_enqueue_style('premiumblog-editor-icons', PBW_ASSETS_PATH . 'css/premiumblog-icons.css', [], '1.0.0');
			wp_enqueue_style('premiumblog-posts-carousel-owl-style', PBW_ASSETS_PATH . 'owl/assets/owl.carousel.min.css', array(), '2.3.4');
			wp_enqueue_style('premiumblog-posts-carousel-theme', PBW_ASSETS_PATH . 'owl/assets/owl.theme.default.min.css', array(), '2.3.4');
			wp_enqueue_style('premiumblog-animate-css', plugins_url('/assets/css/animate.min.css', PBW_WIDGETS), array(), '4.1.1');
		}
	}
	public function premiumblog_scripts()
	{
		wp_register_script('premiumblog-frontend-js', PBW_ASSETS_PATH . 'js/custom.js', array('jquery'), '1.0.0', true);
		wp_localize_script(
			'premiumblog-frontend-js',
			'premiumblog_ajax',
			array(
				'ajax_url' => admin_url('admin-ajax.php'),
				'resturl' => get_rest_url() . 'premiumblog/v1/',
				'nonce' => wp_create_nonce('premiumblog-nonce')
			)
		);

		wp_enqueue_script('premiumblog-frontend-js');
	}
	public function premiumblog_admin_scripts($hook)
	{
		//print_r($hook);
		if ($hook == 'toplevel_page_premiumblog' || $hook == 'pb-addons_page_pbw-widgets' || $hook == 'pb-addons_page_pbw-tools') {

			//Plugin Back-end CSS
			wp_enqueue_style('premiumblog-admin-css', PBW_ASSETS_PATH . 'css/admin.css');
			wp_enqueue_style('premiumblog-admin-fonts', PBW_ASSETS_PATH . 'css/fontello.css');
			// //Plugin Back-end JS
			// wp_enqueue_script('premiumblog-admin-js', PBW_ASSETS_PATH . 'js/panel.js', 'jQuery', '1.0.0', true);
		}
	}


	public function enqueue_panel_styles()
	{
		wp_enqueue_style('premiumblog-editor-css', PBW_ASSETS_PATH . 'css/editor.css');
	}


	/**
	 * Plugin Image sizes
	 *
	 * @since v1.0.0
	 */
	public function premiumblog_image_sizes()
	{
		add_image_size('premiumblog-carousel-thumb', 280, 480, true);
		add_image_size('premiumblog-carousel-thumb-small', 320, 220, true);
		add_image_size('premiumblog-grid-thumb', 800, 620, true);
		add_image_size('premiumblog-classic-thumb', 480, 320, true);
		add_image_size('premiumblog-classic-thumb-large', 640, 420, true);
		add_image_size('premiumblog-slider-wide', 1920, 900, true);
		add_image_size('pbw-author-avatar-md', 200, 200, true);
	}
	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function i18n()
	{
		load_plugin_textdomain('premium-blog');

		add_action( 'wp_ajax_mailchimp_subscribe', [new Utilities, 'ajax_mailchimp_subscribe'] );
		add_action( 'wp_ajax_nopriv_mailchimp_subscribe', [new Utilities, 'ajax_mailchimp_subscribe'] );
		
	}
	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function load_elementor_widgets()
	{

		if ($this->builder_elementor == "on") {
			// Check if Elementor installed and activated.
			if (!did_action('elementor/loaded')) {
				add_action('admin_notices', array($this, 'premiumblog_notice_missing_main_plugin'));
				return;
			}

			// Check for required Elementor version.
			if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
				add_action('admin_notices', array($this, 'premiumblog_notice_minimum_elementor_version'));
				return;
			}

			// Once we get here, We have passed all validation checks so we can safely include our widgets.
			require_once 'elementor-widgets.php';
		}
	}

	


	/**
	 * Check PHP version
	 * @since 1.0.0
	 * @access public
	 */
	public function php_version()
	{
		// Check for required PHP version.
		if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
			add_action('admin_notices', array($this, 'premiumblog_admin_notice_minimum_php_version'));
			return;
		}
	}

	/**
	 * Admin notice
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	function premiumblog_notice_missing_main_plugin()
	{

		$message = sprintf(
			__('%1$s requires %2$s to be installed and activated to function properly. %3$s', 'premium-blog'),
			'<strong>' . __('Premium Blog Widgets - Elementor', 'premium-blog') . '</strong>',
			'<strong>' . __('Elementor', 'premium-blog') . '</strong>',
			'<a href="' . esc_url(admin_url('plugin-install.php?s=Elementor&tab=search&type=term')) . '">' . __('Please click here to install/activate Elementor', 'premium-blog') . '</a>'
		);

		printf('<div class="notice notice-warning is-dismissible"><p style="padding: 5px 0">%1$s</p></div>', $message);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	function premiumblog_notice_minimum_elementor_version()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'premium-blog'),
			'<strong>' . esc_html__('Premium Blog Widgets - Elementor', 'premium-blog') . '</strong>',
			'<strong>' . esc_html__('Elementor', 'premium-blog') . '</strong>',
			MINIMUM_ELEMENTOR_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function premiumblog_admin_notice_minimum_php_version()
	{

		if (isset($_GET['activate'])) unset($_GET['activate']);

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'premium-blog'),
			'<strong>' . esc_html__('premiumblog Widgets', 'premium-blog') . '</strong>',
			'<strong>' . esc_html__('PHP', 'premium-blog') . '</strong>',
			MINIMUM_PHP_VERSION
		);

		printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
	}
}

// Instantiate PBW_WIDGETS.
new PBW_WIDGETS();
