<?php
use premiumblogWidgets\Classes\Utilities;
$tags = array(
    'img'   => array(
        'src'   => array(),
    ),
);
?>
<div class="premiumblog-author-box layout-<?php echo $layout ?><?php echo ($settings['default_shadow'] == 'yes' ? ' has-shadow' : '') ?>">
    <div class="pbw-authorbox-left-col">
        <?php if('yes' === $settings['show_avatar']): ?>
        <div class="pbw-avatar<?php echo ($settings['show_avatar_border'] == 'yes' ? ' has-border' : '') ?>">
            <?php
            if($avatar) {
                echo wp_kses($avatar, $tags);
            } else {
                echo '<img src="' . esc_url($settings['avatar']['url']) . '">';
            }
            ?>
        </div>
        <?php endif; ?>
        <?php if('yes' === $settings['show_social']): ?>
        <div class="pbw-social-links">
            <ul>
                <?php
                    if ( $settings['social_links_list'] ) {
                        foreach (  $settings['social_links_list'] as $item ) {
                            $target = $item['social_link']['is_external'] ? '_blank' : '';
                            $nofollow = $item['social_link']['nofollow'] ? 'nofollow' : '';
                            ?>
                            <li>
                                <a href="<?php echo esc_url($item['social_link']['url']) ?>" target="<?php echo esc_attr($target) ?>" rel="<?php echo esc_attr($nofollow) ?>" class="pbw-social-icon<?php echo (esc_attr($settings['social_icon_scale'] == 'yes' ? ' has-scale-effect' : '')) ?>">
                                    <i class="<?php echo esc_attr($item['selected_icon']['value']) ?>"></i>
                                </a>
                            </li>
                        <?php    
                        }
                    }
                ?>
            </ul>
        </div>
        <?php endif; ?>	
    </div>
    <div class="pbw-authorbox-right-col">
        <div class="pbw-author-name">
            <h3><?php echo esc_html ($settings['author_name'] )?></h3>
        </div>
        <?php if('yes' === $settings['show_title']): ?>
        <div class="pbw-author-title">
            <?php
                $target_author = $settings['author_business_url']['is_external'] ? '_blank' : '_self';
                $nofollow_author = $settings['author_business_url']['nofollow'] ? 'nofollow' : 'follow';
            ?>
            <span class="title"><?php echo esc_textarea($settings['author_title']) ?></span>
            <span class="title-sep">at</span>
            <span class="bsuiness"><a href="<?php echo esc_url($settings['author_business_url']['url']) ?>" target="<?php echo esc_attr($target_author) ?>" rel="<?php echo esc_attr($nofollow_author) ?>"><?php echo esc_textarea($settings['author_business']) ?></a></span>
        </div>
        <?php endif; ?>
        <?php if('yes' === $settings['show_bio']): ?>
        <div class="pbw-author-bio">
            <p><?php echo esc_textarea($settings['author_bio']) ?></p>
        </div>
        <?php endif; ?>
        <?php if('yes' === $settings['show_articles']): ?>
        <div class="pbw-author-articles">
            <?php if('yes' === $settings['show_articles']): ?>
            <h4><?php echo esc_textarea($settings['articles_heading_text']) ?></h4>
            <?php endif; ?>
            <div class="pbw-author-posts">
                <?php Utilities::premiumblog_author_recent_post($settings['author_id'],$settings['author_posts_limit']); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>		
</div>