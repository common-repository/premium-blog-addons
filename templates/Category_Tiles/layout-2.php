<?php
$html = '';
$tags = array(
    'span' => array(
        'class' => array(),
        'style' => array(),
    ),
    'a' => array(
        'href'  => array(),
        'class' => array(),
    ),
    'i' => array(
        'class' => array(),
    ),
    'div'   => array(
        'class' => array(),
        'style' => array()
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
$html .= '<div class="premiumblog-category-box box-' . $item['_id'] . '">';

    $html .= '<div class="icon-container">';
    if($item['selected_icon']['value']) {
        $html .= '<span class="premiumblog-box-icon"><i class="'.$item['selected_icon']['value'].'"></i></span>';
    }
    $html .= '</div>';
    $html .= '<div class="image-container" style="background-image: url('.$item['tile_bg_image']['url'].')">';
        if ( 'yes' === $settings['show_post_count'] ) {
            $html .= '<div class="premiumblog-box-post-count"><span>'.$post_count.' '.($post_count > 1 ? 'Posts' : 'Post').'</span></div>';
        }
        $html .= '<span class="tile-overlay" style="background-color: '.$item['premiumblog_cat_tile_bg_color'].'"></span>';
        
    $html .= '</div>';
    $html .= '<div class="category-name">';
        $html .= '<a href="'.$category_url.'" class="premiumblog-category-tile-link">';
            $html .= $item['category_title'];
        $html .= '</a>';
    $html .= '</div>';
$html .= '</div>';
echo wp_kses($html, $tags);
?>