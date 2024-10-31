<?php

/**
 * Plugin Name: Premium BLog Addons  
 * Description: You can create amazing blog layouts by using supported page builder with any theme of your choice. All the widgets are highly customizable with pre-designed layouts. Just drag and drop the widgets and play with the settings and make cool layouts.
 * Plugin URI:   https://wordpress.org/plugins/premium-blog-addons
 * Version:     1.0
 * Author:     Muhammad Asad Mushtaq
 * Author URI:  https://innvosol.com
 * tested up to: 6.1.1
 * Text Domain: premium-blog
 * keywords: blog layout, blog widgets, Blog widgets , Premium Blog, PBW, Elementor Addons, Elementor , Blog layouts, blog addons, template kit  elementor kit . 
 * 
 * @package Premium BLog Widgets
 * @category Core 
 * 
 */

if (!defined('PBW_WIDGETS')) {
    define('PBW_WIDGETS', __FILE__);
}
if(! defined('PBW_VERSION')){
    define('PBW_VERSION', '1.0');
}
if (!defined('PBW_PLUGIN_PATH')) {
    define("PBW_PLUGIN_PATH", plugin_dir_path(__FILE__));
}
if (!defined('PBW_ASSETS_PATH')) {
    define("PBW_ASSETS_PATH", plugins_url('assets/', __FILE__));
}
if (!defined('PB_WIDGET_ASSETS_PATH')) {
    define("PB_WIDGET_ASSETS_PATH", plugins_url('widgets/', __FILE__));
}
if (!function_exists('pbw_fs')) {
    // Create a helper function for easy SDK access.
    function pbw_fs()
    {
        global $pbw_fs;

        if (!isset($pbw_fs)) {
            // Include Freemius SDK.
            require_once dirname(__FILE__) . '/freemius/start.php';

            $pbw_fs = fs_dynamic_init(array(
                'id'                  => '11663',
                'slug'                => 'premium-blog-widgets',
                'type'                => 'plugin',
                'public_key'          => 'pk_cdee9509c43159e48092f22ab29ba',
                'is_premium'          => false,
                'has_addons'          => false,
                'has_paid_plans'      => false,
                'menu'                => array(
                    'slug'           => 'premiumblog',
                    'first-path'     => 'admin.php?page=premiumblog',
                    'account'        => false,
                    'support'        => false,
                ),
            ));
        }

        return $pbw_fs;
    }

    // Init Freemius.
    pbw_fs();
    // Signal that SDK was initiated.
    do_action('pbw_fs_loaded');
}

/**
 * Include helper functions class.
 */
require PBW_PLUGIN_PATH . 'include/utilities.php';

/**
 * Include the plugin loader class.
 */
require PBW_PLUGIN_PATH . 'plugin-loader.php';


/**
 * Include Admin helper functions.
 */
include PBW_PLUGIN_PATH . 'admin/helper.php';

/**
 * Include Registered Settings and Sections.
 */
include PBW_PLUGIN_PATH . 'admin/settings.php';

/**
 * Include Fields callback functions.
 */
include PBW_PLUGIN_PATH . 'admin/fields.php';

/**
 * Include Admin menus.
 */
include PBW_PLUGIN_PATH . 'admin/menus.php';

/**
 * Settings Panel HTML
 */
include PBW_PLUGIN_PATH . 'admin/panel-html.php';


/**
 * Register default settings
 */
require PBW_PLUGIN_PATH . 'include/default-settings.php';
register_activation_hook(PBW_WIDGETS, 'premiumblog_set_default_settings');



/**
 * add settings link on plugin page
 */

function premiumblog_settings_link($links)
{
    $settings_link = '<a href="admin.php?page=premiumblog">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}

$plugin = plugin_basename(__FILE__);

add_filter("plugin_action_links_$plugin", 'premiumblog_settings_link');





