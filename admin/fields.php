<?php
/**
 * Setting fields callback functions
 * @param array $args
 */
function premiumblog_builders_elementor_field_pbw( ) {
    $checked = '';
    $value = get_option('premiumblog_builders_elementor');
    if($value == 'on') {
        $checked = 'checked';
    }
    //var_dump($value);
    // Could use ob_start.
    $html  = '';
    $html .= '<div class="switch-field-box switch-page-builder">';
    $html .= '<div class="switch-box-icon"><img src="'.PBW_ASSETS_PATH.'img/admin_icons/elementor.png" alt="WordPress"></div>';
        $html .= '<div class="switch-box-title">Elementor</div>';
        $html .= '<div class="switch-box-control">';
            $html .= '<label class="switch">';
            $html .= '<input id="pbwBuilderElementor" name="premiumblog_builders_elementor" type="checkbox" '.$checked.' />';
            $html .= '<span class="slider round"></span>';
            $html .= '</label>';
        $html .= '</div>';
    $html .= '</div>';
    $tags = array(
        'span' => array(
            'class' => array()
        ),
        'img' => array(
            'src' => array(),
            'alt' => array(),
        ),
        'a' => array(
            'href'  => array(),
            'class' => array(),
        ),
        'div'   => array(
            'class' => array(),
        ),
        'label' => array(
            'class' => array()
        ),
        'input' => array(
            'id'    => array(),
            'name'  => array(),
            'type'  => array(),
            'checked'   => array()
        )
    );
    echo wp_kses($html, $tags);
}

/*
 * Setting Field Callbacks for Widgets section
 */
function premiumblog_widgets_posts_grid_field_pbw( ) {
    $checked = '';
    $value = get_option('premiumblog_widgets_posts_grid');
    if($value == 'on') {
        $checked = 'checked';
    }
    // Could use ob_start.
    //'.PBW_ASSETS_PATH.'img/admin_icons/grid.png
    $html  = '';
    $html .= '<div class="switch-field-box">';
        $html .= '<div class="switch-box-title">Grid View</div>';
        $html .= '<div class="switch-box-control">';
            $html .= '<label class="switch">';
            $html .= '<input id="pbwWidgetGridPosts" name="premiumblog_widgets_posts_grid" type="checkbox" '.$checked.' />';
            $html .= '<span class="slider round"></span>';
            $html .= '</label>';
        $html .= '</div>';
    $html .= '</div>';
    $tags = array(
        'span' => array(
            'class' => array()
        ),
        'img' => array(
            'src' => array(),
            'alt' => array(),
        ),
        'a' => array(
            'href'  => array(),
            'class' => array(),
        ),
        'div'   => array(
            'class' => array(),
        ),
        'label' => array(
            'class' => array()
        ),
        'input' => array(
            'id'    => array(),
            'name'  => array(),
            'type'  => array(),
            'checked'   => array()
        )
    );
    echo wp_kses($html, $tags);
}
function premiumblog_widgets_posts_list_field_pbw( ) {
    $checked = '';
    $value = get_option('premiumblog_widgets_posts_list');
    if($value == 'on') {
        $checked = 'checked';
    }
    //var_dump($value);
    $html  = '';
    $html .= '<div class="switch-field-box">';
        $html .= '<div class="switch-box-title">List View</div>';
        $html .= '<div class="switch-box-control">';
            $html .= '<label class="switch">';
            $html .= '<input id="pbwWidgetPostsList" name="premiumblog_widgets_posts_list" type="checkbox" '.$checked.' />';
            $html .= '<span class="slider round"></span>';
            $html .= '</label>';
        $html .= '</div>';
    $html .= '</div>';
    $tags = array(
        'span' => array(
            'class' => array()
        ),
        'img' => array(
            'src' => array(),
            'alt' => array(),
        ),
        'a' => array(
            'href'  => array(),
            'class' => array(),
        ),
        'div'   => array(
            'class' => array(),
        ),
        'label' => array(
            'class' => array()
        ),
        'input' => array(
            'id'    => array(),
            'name'  => array(),
            'type'  => array(),
            'checked'   => array()
        )
    );
    echo wp_kses($html, $tags);
}
function premiumblog_widgets_posts_carousel_field_pbw( ) {
    $checked = '';
    $value = get_option('premiumblog_widgets_posts_carousel');
    if($value == 'on') {
        $checked = 'checked';
    }
    // Could use ob_start.
    $html  = '';
    $html .= '<div class="switch-field-box">';
        $html .= '<div class="switch-box-title">Carousel</div>';
        $html .= '<div class="switch-box-control">';
            $html .= '<label class="switch">';
            $html .= '<input id="pbwWidgetCarousel" name="premiumblog_widgets_posts_carousel" type="checkbox" '.$checked.' />';
            $html .= '<span class="slider round"></span>';
            $html .= '</label>';
        $html .= '</div>';
    $html .= '</div>';
    $tags = array(
        'span' => array(
            'class' => array()
        ),
        'img' => array(
            'src' => array(),
            'alt' => array(),
        ),
        'a' => array(
            'href'  => array(),
            'class' => array(),
        ),
        'div'   => array(
            'class' => array(),
        ),
        'label' => array(
            'class' => array()
        ),
        'input' => array(
            'id'    => array(),
            'name'  => array(),
            'type'  => array(),
            'checked'   => array()
        )
    );
    echo wp_kses($html, $tags);
}

function premiumblog_widgets_posts_classic_field_pbw( ) {
    $checked = '';
    $value = get_option('premiumblog_widgets_posts_classic');
    if($value == 'on') {
        $checked = 'checked';
    }
    // Could use ob_start.
    $html  = '';
    $html .= '<div class="switch-field-box">';
        $html .= '<div class="switch-box-title">Classic</div>';
        $html .= '<div class="switch-box-control">';
            $html .= '<label class="switch">';
            $html .= '<input id="pbwWidgetClassicPosts" name="premiumblog_widgets_posts_classic" type="checkbox" '.$checked.' />';
            $html .= '<span class="slider round"></span>';
            $html .= '</label>';
        $html .= '</div>';
    $html .= '</div>';
    $tags = array(
        'span' => array(
            'class' => array()
        ),
        'img' => array(
            'src' => array(),
            'alt' => array(),
        ),
        'a' => array(
            'href'  => array(),
            'class' => array(),
        ),
        'div'   => array(
            'class' => array(),
        ),
        'label' => array(
            'class' => array()
        ),
        'input' => array(
            'id'    => array(),
            'name'  => array(),
            'type'  => array(),
            'checked'   => array()
        )
    );
    echo wp_kses($html, $tags);
}

function premiumblog_widgets_category_tiles_field_pbw( ) {
    $checked = '';
    $value = get_option('premiumblog_widgets_category_tiles');
    if($value == 'on') {
        $checked = 'checked';
    }
    // Could use ob_start.
    $html  = '';
    $html .= '<div class="switch-field-box">';
        $html .= '<div class="switch-box-title">Categories</div>';
        $html .= '<div class="switch-box-control">';
            $html .= '<label class="switch">';
            $html .= '<input id="pbwWidgetCatTiles" name="premiumblog_widgets_category_tiles" type="checkbox" '.$checked.' />';
            $html .= '<span class="slider round"></span>';
            $html .= '</label>';
        $html .= '</div>';
    $html .= '</div>';
    $tags = array(
        'span' => array(
            'class' => array()
        ),
        'img' => array(
            'src' => array(),
            'alt' => array(),
        ),
        'a' => array(
            'href'  => array(),
            'class' => array(),
        ),
        'div'   => array(
            'class' => array(),
        ),
        'label' => array(
            'class' => array()
        ),
        'input' => array(
            'id'    => array(),
            'name'  => array(),
            'type'  => array(),
            'checked'   => array()
        )
    );
    echo wp_kses($html, $tags);
}


function premiumblog_widgets_posts_slider_field_pbw( ) {
    $checked = '';
    $value = get_option('premiumblog_widgets_posts_slider');
    if($value == 'on') {
        $checked = 'checked';
    }
    // Could use ob_start.
    $html  = '';
    $html .= '<div class="switch-field-box">';
        $html .= '<div class="switch-box-title">Slider</div>';
        $html .= '<div class="switch-box-control">';
            $html .= '<label class="switch">';
            $html .= '<input id="pbwWidgetSlider" name="premiumblog_widgets_posts_slider" type="checkbox" '.$checked.' />';
            $html .= '<span class="slider round"></span>';
            $html .= '</label>';
        $html .= '</div>';
    $html .= '</div>';
    $tags = array(
        'span' => array(
            'class' => array()
        ),
        'img' => array(
            'src' => array(),
            'alt' => array(),
        ),
        'a' => array(
            'href'  => array(),
            'class' => array(),
        ),
        'div'   => array(
            'class' => array(),
        ),
        'label' => array(
            'class' => array()
        ),
        'input' => array(
            'id'    => array(),
            'name'  => array(),
            'type'  => array(),
            'checked'   => array()
        )
    );
    echo wp_kses($html, $tags);
}

function premiumblog_widgets_author_box_field_pbw( ) {
    $checked = '';
    $value = get_option('premiumblog_widgets_author_box');
    if($value == 'on') {
        $checked = 'checked';
    }
    // Could use ob_start.
    $html  = '';
    $html .= '<div class="switch-field-box">';
        $html .= '<div class="switch-box-title">Author Box</div>';
        $html .= '<div class="switch-box-control">';
            $html .= '<label class="switch">';
            $html .= '<input id="pbwWidgetAuthorBox" name="premiumblog_widgets_author_box" type="checkbox" '.$checked.' />';
            $html .= '<span class="slider round"></span>';
            $html .= '</label>';
        $html .= '</div>';
    $html .= '</div>';
    $tags = array(
        'span' => array(
            'class' => array()
        ),
        'img' => array(
            'src' => array(),
            'alt' => array(),
        ),
        'a' => array(
            'href'  => array(),
            'class' => array(),
        ),
        'div'   => array(
            'class' => array(),
        ),
        'label' => array(
            'class' => array()
        ),
        'input' => array(
            'id'    => array(),
            'name'  => array(),
            'type'  => array(),
            'checked'   => array()
        )
    );
    echo wp_kses($html, $tags);
}


function premiumblog_widgets_news_ticker_field_pbw( ) {
    $checked = '';
    $value = get_option('premiumblog_widgets_news_ticker');
    if($value == 'on') {
        $checked = 'checked';
    }
    // Could use ob_start.
    $html  = '';
    $html .= '<div class="switch-field-box">';
        $html .= '<div class="switch-box-title">News Ticker</div>';
        $html .= '<div class="switch-box-control">';
            $html .= '<label class="switch">';
            $html .= '<input id="pbwWidgetNewsTicker" name="premiumblog_widgets_news_ticker" type="checkbox" '.$checked.' />';
            $html .= '<span class="slider round"></span>';
            $html .= '</label>';
        $html .= '</div>';
    $html .= '</div>';
    $tags = array(
        'span' => array(
            'class' => array()
        ),
        'img' => array(
            'src' => array(),
            'alt' => array(),
        ),
        'a' => array(
            'href'  => array(),
            'class' => array(),
        ),
        'div'   => array(
            'class' => array(),
        ),
        'label' => array(
            'class' => array()
        ),
        'input' => array(
            'id'    => array(),
            'name'  => array(),
            'type'  => array(),
            'checked'   => array()
        )
    );
    echo wp_kses($html, $tags);
}


function premiumblog_widgets_posts_flex_cards_field_bp(){
    $checked = '';
    $value = get_option('premiumblog_widgets_posts_flex_cards');
    if($value == 'on') {
        $checked = 'checked';
    }
    // Could use ob_start.
    $html  = '';
    $html .= '<div class="switch-field-box ">';
        $html .= '<div class="switch-box-title">Flex Cards</div>';
        $html .= '<div class="switch-box-control">';
            $html .= '<label class="switch">';
            $html .= '<input id="pbwWidgetFlexCards" name="premiumblog_widgets_posts_flex_cards" type="checkbox" '.$checked.' />';
            $html .= '<span class="slider round"></span>';
            $html .= '</label>';
        $html .= '</div>';
    $html .= '</div>';
    $tags = array(
        'span' => array(
            'class' => array()
        ),
        'img' => array(
            'src' => array(),
            'alt' => array(),
        ),
        'a' => array(
            'href'  => array(),
            'class' => array(),
        ),
        'div'   => array(
            'class' => array(),
        ),
        'label' => array(
            'class' => array()
        ),
        'input' => array(
            'id'    => array(),
            'name'  => array(),
            'type'  => array(),
            'checked'   => array()
        )
    );
    echo wp_kses($html, $tags);
}


// Mailchimp

function premiumblog_widgets_mailchimp_form_field_pbw( ) {
    $checked = '';
    $value = get_option('premiumblog_widgets_mailchimp_form');
    if($value == 'on') {
        $checked = 'checked';
    }
    // Could use ob_start.
    $html  = '';
    $html .= '<div class="switch-field-box">';
        $html .= '<div class="switch-box-title">Mailchimp</div>';
        $html .= '<div class="switch-box-control">';
            $html .= '<label class="switch">';
            $html .= '<input id="pbwWidgetMailchimp" name="premiumblog_widgets_mailchimp_form" type="checkbox" '.$checked.' />';
            $html .= '<span class="slider round"></span>';
            $html .= '</label>';
        $html .= '</div>';
    $html .= '</div>';
    $tags = array(
        'span' => array(
            'class' => array()
        ),
        'img' => array(
            'src' => array(),
            'alt' => array(),
        ),
        'a' => array(
            'href'  => array(),
            'class' => array(),
        ),
        'div'   => array(
            'class' => array(),
        ),
        'label' => array(
            'class' => array()
        ),
        'input' => array(
            'id'    => array(),
            'name'  => array(),
            'type'  => array(),
            'checked'   => array()
        )
    );
    echo wp_kses($html, $tags);
}