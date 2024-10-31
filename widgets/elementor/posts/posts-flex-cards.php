<?php

/**
 * Posts Grid.
 *
 * @category   Class
 * @package    premiumblogWidgets
 * @subpackage WordPress
 */

namespace premiumblogWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use premiumblogWidgets\Classes\Utilities;
use Elementor\Group_Control_Border;


// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * FeaturedGrid widget class.
 *
 * @since 1.0.0
 */
class premiumblog_Flex_Cards extends Widget_Base
{

    /**
     * Class constructor.
     *
     * @param array $data Widget data.
     * @param array $args Widget arguments.
     */
    public function __construct($data = array(), $args = null)
    {
        parent::__construct($data, $args);

        wp_register_style('premiumblog-flex-card', plugins_url('/assets/css/posts-flex-card.css', PBW_WIDGETS), array(), '1.0.0');
    }

    /**
     * Retrieve the widget name.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'flexcards';
    }

    /**
     * Retrieve the widget title.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Posts Flex Card', 'premium-blog');
    }

    /**
     * Retrieve the widget icon.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'pbw-icon eicon-slider-album';
    }

    /**
     * Retrieve the list of categories the widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * Note that currently Elementor supports only one category.
     * When multiple categories passed, Elementor uses the first one.
     *
     * @since 1.0.0
     *
     * @access public
     *
     * @return array Widget categories.
     */
    public function get_categories()
    {
        return array('premium-blog');
    }

    /**
     * Enqueue styles.
     */
    public function get_style_depends()
    {
        return array('premiumblog-flex-card');
    }

    /**
     * Register the widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function _register_controls()
    {
        $post_types = Utilities::premiumblog_get_post_types();
        $taxonomies = get_taxonomies([], 'objects');

        /**
         * The Layout Tab
         * 
         */
        $this->start_controls_section(
            'premiumblog_section_flex_layout',
            [
                'label' => __('Layout', 'premium-blog'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'premiumblog_flex_card_show_title',
            array(
                'label'   => __('Post Title', 'premium-blog'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'premium-blog'),
                'label_off' => __('Hide', 'premium-blog'),
                'return_value' => 'yes',
                'default' => 'yes',
            )
        );

        $this->add_control(
            'premiumblog_flex_card_autoplay',
            array(
                'label'   => __('Autoplay', 'premium-blog'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'premium-blog'),
                'label_off' => __('No', 'premium-blog'),
                'return_value' => 'yes',
                'default' => 'no',
            )
        );
        $this->add_control(
            'premiumblog_flex_card_autoplay_speed',
            array(
                'label' => __('Autoplay Speed', 'premium-blog'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 3000,
                'min' => 1000,
                'max' => 10000,
                'step' => 100,
                'condition' => [
                    'premiumblog_flex_card_autoplay' => 'yes',
                ],

            )
        );

        //width of the card
        $this->add_responsive_control(
            'premiumblog_flex_card_width',
            [
                'label' => __('Width', 'premium-blog'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1020,
                ],
                'selectors' => [
                    '{{WRAPPER}} .premiumblog-flex-cards .options' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'premiumblog_flex_card_height',
            [
                'label' => __('Height', 'premium-blog'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 500,
                ],
                'selectors' => [
                    '{{WRAPPER}} .premiumblog-flex-cards .options' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * The Query Tab
         * 
         */

        $this->start_controls_section(
            'section_query',
            array(
                'label' => __('Query', 'premium-blog'),
            )
        );

        $this->add_control(
            'post_type',
            [
                'label' => __('Source', 'premium-blog'),
                'type' => Controls_Manager::SELECT,
                'options' => $post_types,
                'default' => key($post_types),
            ]
        );
        foreach ($taxonomies as $taxonomy => $object) {
            if (!isset($object->object_type[0]) || !in_array($object->object_type[0], array_keys($post_types))) {
                continue;
            }

            $this->add_control(
                $taxonomy . '_ids',
                [
                    'label' => $object->label,
                    'type' => Controls_Manager::SELECT2,
                    'label_block' => true,
                    'multiple' => true,
                    'object_type' => $taxonomy,
                    'options' => wp_list_pluck(get_terms($taxonomy), 'name', 'term_id'),
                    'condition' => [
                        'post_type' => $object->object_type,
                    ],
                ]
            );
        }

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'premium-blog'),
                'type' => Controls_Manager::NUMBER,
                'default' => '5',
            ]
        );

        $this->add_control(
            'offset',
            [
                'label' => __('Offset', 'premium-blog'),
                'type' => Controls_Manager::NUMBER,
                'default' => '0',
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => __('Order By', 'premium-blog'),
                'type' => Controls_Manager::SELECT,
                'options' => Utilities::premiumblog_get_post_orderby_options(),
                'default' => 'date',

            ]
        );

        $this->add_control(
            'order',
            [
                'label' => __('Order', 'premium-blog'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'asc' => 'Ascending',
                    'desc' => 'Descending',
                ],
                'default' => 'desc',

            ]
        );

        $this->end_controls_section();


        /**
         * General Settings
         */

        $this->start_controls_section(
            'premiumblog_section_general_settings',
            [
                'label' => __('General', 'premium-blog'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]

        );

        $this->add_responsive_control(
            'premiumblog_flex_card_margin',
            [
                'label' => __('Margin', 'premium-blog'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .premiumblog-flex-cards .options .option' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        $this->add_control(
            'premiumblog_flex_card_title_color',
            [
                'label' => __('Title Color', 'premium-blog'),
                'type' => Controls_Manager::COLOR,
                'default' => '#019625',
                'selectors' => [
                    '{{WRAPPER}} .info .main a' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->add_control(
            'premiumblog_flex_card_title_hover_color',
            [
                'label' => __('Title Hover Color', 'premium-blog'),
                'type' => Controls_Manager::COLOR,
                'default' => '#F0F0F0',
                'selectors' => [
                    '{{WRAPPER}} .info .main a:hover' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'premiumblog_flex_card_background_overlay',
            [
                'label' => __('Background Overlay', 'premium-blog'),
                'type' => Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.5)',
                'selectors' => [
                    '{{WRAPPER}} .premiumblog-flex-cards .option.active  .overlay' => 'background-color: {{VALUE}};',
                ],

            ]
        );
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'premiumblog_flex_card_title_typography',
                'label' => __('Title Typography', 'premium-blog'),
                'scheme' => Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .info .main a',

            ]
        );


        // $this->add_responsive_control(
        //     'premiumblog_flex_card_content_width',
        //     [
        //         'label' => __('Content Width', 'premium-blog'),
        //         'type' => Controls_Manager::SELECT,
        //         'default' => 'boxed',
        //         'options' => [
        //             'boxed' => __('Boxed', 'premium-blog'),
        //             'fullwidth' => __('Full Width', 'premium-blog'),
        //         ],
        //         'prefix_class' => 'premiumblog-flex-card-content-width-',
        //     ]
        // );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'premiumblog_flex_card_border',
                'label' => __('Border', 'premium-blog'),
                'selector' => '{{WRAPPER}} .premiumblog-flex-cards .options .option.active',
            ]
        );

        $this->add_control(
            'premiumblog_flex_card_border_radius',
            [
                'label' => __('Border Radius', 'premium-blog'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .premiumblog-flex-cards .options .option' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .premiumblog-flex-cards .options .option:not(.active)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );



        $this->end_controls_section();
    }
    /**
     * Render the widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     *
     * @access protected
     */
    protected function render()
    {
        $settings  = $this->get_settings_for_display();
        $args = Utilities::premiumblog_get_query_args($settings);

?>
        <div class="premiumblog-flex-cards">
            <div class="options">

                <?php $featured_posts = new \WP_Query($args);


                if ($featured_posts->have_posts()) {
                    while ($featured_posts->have_posts()) :
                        $featured_posts->the_post();
                        if (has_post_thumbnail()) :
                            $thumb_uri = get_the_post_thumbnail_url(get_the_ID(), 'premiumblog-grid-thumb');
                        else :
                            $thumb_uri = PBW_ASSETS_PATH . 'img/thumb-medium.png';
                        endif;
                ?>

                        <div class="option" style="background-image: url(<?php echo esc_url($thumb_uri); ?>);">
                            <!-- <div class="shadow overlay"></div> -->
                            <div class="label">
                                <div class="icon">
                                    <i class="fa fa-angle-left"></i>
                                </div>
                                <div class="info">
                                    <?php if ('yes' === $settings['premiumblog_flex_card_show_title']) { ?>
                                        <div class="main"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></div>
                                    <?php } ?>
                                    <div class="sub"><?php echo Utilities::premiumblog_list_excerpt(5); ?></div>
                                </div>
                            </div>
                        </div>
                <?php
                    endwhile;
                }
                \wp_reset_postdata();
                ?>

            </div>
        </div>

        <script>
            jQuery(document).ready(function($) {
                $(".option:first-child").addClass("active");
                $(".option").click(function() {
                    $(".option").removeClass("active");
                    $(this).addClass("active");

                });
                // var autoScroll = setInterval(function() {
                //     var active = $(".option.active");
                //     var next = active.next(".option");
                //     if (next.length) {
                //         active.removeClass("active").next().addClass("active");
                //     } else {
                //         active.removeClass("active");
                //         $(".option:first-child").addClass("active");
                //     }
                // }, 3000);

            });
        </script>
<?php
    }

    /**
     * Render the widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     *
     * @access protected
     */
}
