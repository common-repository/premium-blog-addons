<?php
/**
 * Add the top level menu page.
 */
function premiumblog_options_page() {
    add_menu_page(
        'Premium-Blog-Widgets',
        'PB Addons',
        'manage_options',
        'premiumblog',
        'premiumblog_options_page_html',
        'dashicons-podio',
        50
    );
}
add_action( 'admin_menu', 'premiumblog_options_page' );

/**
 * Add sub-menu page.
 */
function premiumblog_options_page_builders() {
    add_submenu_page(
        'premiumblog',
        'PBW Builders',
        'Builders',
        'manage_options',
        'premiumblog',
        'premiumblog_options_page_html' );
}


add_action('admin_menu', 'premiumblog_options_page_builders');
function premiumblog_options_page_widgets() {
    add_submenu_page(
        'premiumblog',
        'PB Widgets',
        'Widgets',
        'manage_options',
        'pbw-widgets',
        'premiumblog_options_page_html' );
}
add_action('admin_menu', 'premiumblog_options_page_widgets');



function premiumblog_options_page_tools() {
    add_submenu_page(
        'premiumblog',
        'PBW Tools',
        'Tools',
        'manage_options',
        'pbw-tools',
        'premiumblog_options_page_html' );
}
add_action('admin_menu', 'premiumblog_options_page_tools');