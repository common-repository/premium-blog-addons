<?php
$html = '';
$tags = array(
    'span' => array(
        'class' => array()
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
$html .= '<div class="premiumblog-category-tile tile-' . $item['_id'] . '" style="background-image: url('.$item['tile_bg_image']['url'].')">';
if ( 'yes' === $settings['full_box_link'] ) {
    $html .= '<a href="'.$category_url.'" class="premiumblog-link-overlay"></a>';
}
if ( 'yes' === $settings['show_post_count'] ) {
    $html .= '<div class="premiumblog-post-count"><span>'.$post_count.' '.($post_count > 1 ? 'Posts' : 'Post').'</span></div>';
}
$html .= '<span class="tile-overlay" style="background-color: '.$item['premiumblog_cat_tile_bg_color'].'"></span>';
    $html .= '<div class="tile-content">';
    if ( 'yes' === $settings['show_icon'] ) {
        if($item['selected_icon']['value']) {
            $html .= '<span class="premiumblog-tile-icon"><i class="'.$item['selected_icon']['value'].'"></i></span>';
        }
    }
        $html .= '<a href="'.$category_url.'" class="premiumblog-category-tile-link">';
            $html .= $item['category_title'];
        $html .= '</a>';
    $html .= '</div>';
$html .= '</div>';
echo wp_kses($html, $tags);
?>