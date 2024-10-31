<?php
/**
 * custom option and settings
 */
function premiumblog_settings_init() {
    
    // Register new settings for "Page Builders" section.
    register_setting( 'premiumblog', 'premiumblog_builders_elementor', ['default' => 'on']);
  //  register_setting( 'premiumblog', 'premiumblog_builders_wordpress', ['default' => 'off']);

  
    // Integrations
    register_setting( 'pbw-tools', 'pbw_mailchimp_api_key', ['default' => '']);
    register_setting( 'pbw-tools', 'pbw_google_map_api_key', ['default' => '']);


    // Register new settings for "Widgets" Section.
    register_setting( 'pbw-widgets', 'premiumblog_widgets_posts_grid', ['default' => 'on']);
    register_setting( 'pbw-widgets', 'premiumblog_widgets_posts_list', ['default' => 'on']);
    register_setting( 'pbw-widgets', 'premiumblog_widgets_posts_carousel', ['default' => 'on']);
    register_setting( 'pbw-widgets', 'premiumblog_widgets_category_tiles', ['default' => 'on']);
    register_setting( 'pbw-widgets', 'premiumblog_widgets_posts_classic', ['default' => 'on']);
    register_setting( 'pbw-widgets', 'premiumblog_widgets_posts_slider', ['default' => 'on']);
    register_setting( 'pbw-widgets', 'premiumblog_widgets_author_box', ['default' => 'on']);
    register_setting( 'pbw-widgets', 'premiumblog_widgets_news_ticker', ['default' => 'on']);
    register_setting( 'pbw-widgets', 'premiumblog_widgets_posts_flex_cards', ['default' => 'on']);
    //Form Styler Elements
    // Mailchimp
    register_setting( 'pbw-widgets', 'premiumblog_widgets_mailchimp_form', ['default' => 'on']);

    

    // Page Builders Section
    add_settings_section(
        'premiumblog_section_builders',
        __( 'Page Builders.', 'premium-blog' ),
        'premiumblog_section_builders_callback',
        'premiumblog'
    );

      // WordPress
    //   add_settings_field(
    //     'premiumblog_builders_wordpress',
    //     'WordPress',
    //     'premiumblog_builders_wordpress_field_pbw',
    //     'premiumblog',
    //     'premiumblog_section_builders'
    // );


    // Widgets Section
    add_settings_section(
        'premiumblog_section_widgets',
        __( 'Widgets.', 'premium-blog' ),
        'premiumblog_section_widgets_callback',
        'pbw-widgets'
    );

    // Tools Section
    add_settings_section(
        'premiumblog_section_tools',
        __( 'Tools.', 'premium-blog' ),
        'premiumblog_section_tools_callback',
        'pbw-tools'
    );

    
    /*
    * Register Setting Fields for Page Builders section
    */

    // Elementor
    add_settings_field(
        'premiumblog_builders_elementor',
        'Elementor',
        'premiumblog_builders_elementor_field_pbw',
        'premiumblog',
        'premiumblog_section_builders'
    );


    /*
    * Register Setting Fields for Widgets Builders section
    */

    // Posts Grid
    add_settings_field(
        'premiumblog_widgets_posts_grid',
        'Posts Grid',
        'premiumblog_widgets_posts_grid_field_pbw',
        'pbw-widgets',
        'premiumblog_section_widgets'
    );
    // Posts List
    add_settings_field(
        'premiumblog_widgets_posts_list',
        'Posts List',
        'premiumblog_widgets_posts_list_field_pbw',
        'pbw-widgets',
        'premiumblog_section_widgets'
    );
    // Posts Carousel
    add_settings_field(
        'premiumblog_widgets_posts_carousel',
        'Carousel',
        'premiumblog_widgets_posts_carousel_field_pbw',
        'pbw-widgets',
        'premiumblog_section_widgets'
    );
    // Posts Classic
    add_settings_field(
        'premiumblog_widgets_posts_classic',
        'Classic Block',
        'premiumblog_widgets_posts_classic_field_pbw',
        'pbw-widgets',
        'premiumblog_section_widgets'
    );
    // Category Tiles
    add_settings_field(
        'premiumblog_widgets_category_tiles',
        'Categories',
        'premiumblog_widgets_category_tiles_field_pbw',
        'pbw-widgets',
        'premiumblog_section_widgets'
    );
    // Posts Slider
    add_settings_field(
        'premiumblog_widgets_posts_slider',
        'Slider',
        'premiumblog_widgets_posts_slider_field_pbw',
        'pbw-widgets',
        'premiumblog_section_widgets'
    );
    // Author Box
    add_settings_field(
        'premiumblog_widgets_author_box',
        'Author Box',
        'premiumblog_widgets_author_box_field_pbw',
        'pbw-widgets',
        'premiumblog_section_widgets'
    );
    // News Ticker
    add_settings_field(
        'premiumblog_widgets_news_ticker',
        'News Ticker',
        'premiumblog_widgets_news_ticker_field_pbw',
        'pbw-widgets',
        'premiumblog_section_widgets'
    );
    // Posts Flex Cards
    add_settings_field(
        'premiumblog_widgets_posts_flex_cards',
        'Flex Cards',
        'premiumblog_widgets_posts_flex_cards_field_bp',
        'pbw-widgets',
        'premiumblog_section_widgets'
    );



    // Form Styler Elements

    // Mailchimp
    add_settings_field(
        'premiumblog_widgets_mailchimp_form',
        'Mailchimp API Key',
        'premiumblog_widgets_mailchimp_form_field_pbw',
        'pbw-widgets',
        'premiumblog_section_widgets'
    );

    // Google Map
    add_settings_field(
        'pbw_google_map_api_key',
        'Google Map API Key',
        'pbw_google_map_api_key_field_pbw',
        'pbw-widgets',
        'premiumblog_section_widgets'
    );
   
}

/**
 * Register our premiumblog_settings_init to the admin_init action hook.
 */
add_action( 'admin_init', 'premiumblog_settings_init' );

/**
 * Section Callback Functions.
 */
function premiumblog_section_builders_callback( $args ) {
    return;
}
function premiumblog_section_widgets_callback( $args ) {
    return;
}
function premiumblog_section_tools_callback( $args ) {
    return;
}
