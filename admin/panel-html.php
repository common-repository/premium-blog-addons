<?php
function premiumblog_options_page_html()
{
    // check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
?>

    <div class="premiumblog-admin-wrap">
        <div class="premiumblog-panel-head">
            <?php
            $page_name = sanitize_text_field($_GET['page']);
            //echo $page_name;
            ?>
            <div class="side-panel-col">
                <div class="panel-logo">
                    <!-- <span><img src="<?php echo PBW_ASSETS_PATH ?>img/logo-admin-screen.png" alt="premiumblog Logo"></span> -->
                    <span class="pbw-logo-title"><?php esc_html_e('PB Addons', 'premium-blog'); ?></span>
                </div>
            </div>
            <div class="side-panel-col">
                <ul class="premiumblog-panel-tabs">
                    <li>
                        <a href="admin.php?page=premiumblog" class="panel-tab-link<?php echo (esc_attr($page_name == 'premiumblog' ? ' active' : '')) ?>">
                            <i class="icon-cubes"></i> Page Builders</a>
                    </li>
                    <li>
                        <a href="admin.php?page=pbw-widgets" class="panel-tab-link<?php echo (esc_attr($page_name == 'pbw-widgets' ? ' active' : '')) ?>">
                            <i class="icon-group"></i> Elements </a>
                    </li>
                    <li>
                        <a href="admin.php?page=pbw-tools" class="panel-tab-link<?php echo (esc_attr($page_name == 'pbw-tools' ? ' active' : '')) ?>">
                            <i class="icon-magic"></i> Tools & Settings</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="premiumblog-panel-content <?php echo 'page-' . esc_attr($page_name) ?>">
            <?php
            if (isset($_GET['settings-updated'])) {
                // add settings saved message with the class of "updated"
                add_settings_error('premiumblog_messages', 'premiumblog_message', __('Saved Settings ', 'premium-blog'), 'updated');
            }

            // show error/update messages
            settings_errors('premiumblog_messages');
            ?>
            <form action="options.php" method="post">
                <?php
                if ($page_name == 'premiumblog') {
                    // output security fields for the registered setting "premiumblog"
                    settings_fields('premiumblog');
                ?>
                    <h2 class="panel-section-heading"><?php esc_html_e('Page Builders', 'premium-blog') ?></h2>
                    <h3 class="panel-section-subheading"><?php esc_html_e('Select the Page builders you want to enable premiumblog widgets on.', 'premium-blog'); ?></h3>
                    <!-- <div class="pbw-builder-notice"><?php esc_html_e('You should enable page builder.') ?></div> -->
                    <div class="form-fields-row form-widgets-row">
                        <?php
                        // Output setting fields for page builders section
                        premiumblog_settings_section_field('premiumblog', 'premiumblog_builders_elementor');  //premiumblog_settings_section_field( 'premiumblog', 'premiumblog_builders_wordpress' );

                        ?>
                    </div>

                <?php
                }
                if ($page_name == 'pbw-widgets') {
                    // output security fields for the registered setting "premiumblog"
                    settings_fields('pbw-widgets');
                ?>
                    <h2 class="panel-section-heading"><?php esc_html_e('Blog Post Widgets') ?></h2>
                    <h3 class="panel-section-subheading"><?php esc_html_e('Select the widgets you want to enable.', 'premium-blog'); ?></h3>
                    <h3 class="widgets-section__header">Dynamic Content Elements </h3>
                    <div class="form-fields-row widgets-row">
                        <?php
                        // Output setting fields for page widgets section
                        premiumblog_settings_section_field('pbw-widgets', 'premiumblog_widgets_posts_grid');
                        premiumblog_settings_section_field('pbw-widgets', 'premiumblog_widgets_posts_list');
                        premiumblog_settings_section_field('pbw-widgets', 'premiumblog_widgets_posts_carousel');
                        premiumblog_settings_section_field('pbw-widgets', 'premiumblog_widgets_posts_classic');
                        premiumblog_settings_section_field('pbw-widgets', 'premiumblog_widgets_category_tiles');
                        premiumblog_settings_section_field('pbw-widgets', 'premiumblog_widgets_posts_slider');
                        premiumblog_settings_section_field('pbw-widgets', 'premiumblog_widgets_author_box');
                        premiumblog_settings_section_field('pbw-widgets', 'premiumblog_widgets_news_ticker');
                        premiumblog_settings_section_field('pbw-widgets', 'premiumblog_widgets_posts_flex_cards');
                        ?>
                    </div>
                    <h3 class="widgets-section__header">Form Styler Elements</h3>
                    <div class="form-fields-row widgets-row">
                        <?php
                    
                        // Output setting fields for page widgets section
                         premiumblog_settings_section_field('pbw-widgets', 'premiumblog_widgets_mailchimp_form');
                        ?>
                    </div>
                <?php
                }
                if ($page_name == 'pbw-tools') { 
                     // output security fields for the registered setting "premiumblog"
                     settings_fields('pbw-tools');
                    
                    ?> 
                    <h2 class="panel-section-heading"><?php esc_html_e('Tools & Setting') ?></h2>
                    <h3 class="panel-section-subheading"><?php esc_html_e('Feel free to reach us for help or support via any of the channel mentioned below.', 'premium-blog'); ?></h3>
                    <div class="form-fields-row tools-fields-row">
                        <div class="pbw-tools-box">
                            <div>
                                <h2 class="panel-section-subheading tools-subheading"><?php esc_html_e('Integrations', 'premium-blog'); ?></2>
                            </div>
                            <div class="pbw-setting">
                                <h4>
                                    <span>MailChimp API Key</span>
                                    <br>
                                    <a href="" target="_blank">How to get MailChimp API Key?</a>
                                </h4>
                                <input type="text" name="pbw_mailchimp_api_key" id="pbw_mailchimp_api_key" value="<?php echo esc_attr(get_option('pbw_mailchimp_api_key')); ?>
                                ">
                            </div>

                            <!-- <div class="pbw-setting">
                                <h4>
                                    <span>Google Map API Key</span>
                                    <br>
                                    <a href="" target="_blank">How to get Google Map API Key?</a>
                                </h4>
                                <input type="text" name="pbw_google_map_api_key" id="pbw_google_map_api_key" value="<?php echo esc_attr(get_option('pbw_google_map_api_key')); ?>
                                ">
                            </div> -->

                        </div>
                        <!-- <div class="pbw-tools-box">
                            2
                        </div> -->
                    </div>
                <?php } ?>

                <?php
                submit_button('Save Option');
                ?>
            </form>
        </div>
    </div>

<?php
}
?>