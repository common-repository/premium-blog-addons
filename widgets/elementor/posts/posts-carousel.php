<?php

/**
 * Posts Carousel.
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
use Elementor\Core\Schemes\Color;
use premiumblogWidgets\Classes\Utilities;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * FeaturedGrid widget class.
 *
 * @since 1.0.0
 */
class premiumblog_Carousel_Posts extends Widget_Base
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
		wp_register_style('premiumblog-posts-carousel-style', plugins_url('/assets/css/posts-carousel.css', PBW_WIDGETS), array(), '2.3.4');
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
		return 'premiumblog_posts_carousel';
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
		return __('Carousel', 'premium-blog');
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
		return 'pbw-icon premiumblog-icon-carousel';
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
	 * Enqueue styles and scripts.
	 */
	public function get_style_depends()
	{
		return array('premiumblog-posts-carousel-style', 'premiumblog-posts-carousel-owl-style');
	}
	/* public function get_script_depends() {
        return array( 'premiumblog-posts-carousel-js' );
    } */
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
			'section_layout',
			array(
				'label' => __('Layout', 'premium-blog'),
			)
		);
		$this->add_control(
			'layout',
			array(
				'label'   => __('Carousel Layout', 'premium-blog'),
				'type'    => Controls_Manager::SELECT,
				'default' => __('1', 'premium-blog'),
				'options' => ['1' => 'Layout 1', '2' => 'Layout 2'],
			)
		);
		$this->add_control(
			'overlay',
			array(
				'label'   => __('Overlay Layout', 'premium-blog'),
				'type'    => Controls_Manager::SELECT,
				'default' => __('1', 'premium-blog'),
				'options' => ['0' => 'Disabled', '1' => 'Full', '2' => 'Title Only'],
				'condition' => [
					'layout' => '1',
				],
			)
		);
		$this->add_control(
			'full_grid_link',
			array(
				'label'   => __('Full Item Link', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('ON', 'premium-blog'),
				'label_off' => __('OFF', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'no',
			)
		);
		$this->add_control(
			'show_title',
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
			'show_meta',
			array(
				'label'   => __('Post Meta', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'premium-blog'),
				'label_off' => __('Hide', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'layout' => '2',
				],
			)
		);
		$this->add_control(
			'show_meta_author',
			array(
				'label'   => __('Post Author', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'premium-blog'),
				'label_off' => __('Hide', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'no',
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'show_meta',
							'operator' => '==',
							'value' => 'yes'
						],
						[
							'name' => 'layout',
							'operator' => '==',
							'value' => '2'
						]
					]
				]
			)
		);
		$this->add_control(
			'show_meta_date',
			array(
				'label'   => __('Post Date', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'premium-blog'),
				'label_off' => __('Hide', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'yes',
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'show_meta',
							'operator' => '==',
							'value' => 'yes'
						],
						[
							'name' => 'layout',
							'operator' => '==',
							'value' => '2'
						]
					]
				]
			)
		);
		$this->add_control(
			'show_meta_comments',
			array(
				'label'   => __('Post Comments', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'premium-blog'),
				'label_off' => __('Hide', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'yes',
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'show_meta',
							'operator' => '==',
							'value' => 'yes'
						],
						[
							'name' => 'layout',
							'operator' => '==',
							'value' => '2'
						]
					]
				]
			)
		);
		$this->add_control(
			'show_term',
			array(
				'label'   => __('Post Term', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'premium-blog'),
				'label_off' => __('Hide', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'yes',
				'condition' => [
					'layout' => '2',
				],
			)
		);
		$this->add_control(
			'show_excerpt',
			array(
				'label'   => __('Post Excerpt', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'premium-blog'),
				'label_off' => __('Hide', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'no',
				'condition' => [
					'layout' => '2',
				],
			)
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
				'default' => '4',
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
		 * The Query Tab
		 * 
		 */
		$this->start_controls_section(
			'section_carousel',
			array(
				'label' => __('Carousel', 'premium-blog'),
			)
		);
		$this->add_control(
			'carousel_items',
			array(
				'label'   => __('Items Per Page', 'premium-blog'),
				'type'    => Controls_Manager::SELECT,
				'default' => __('4', 'premium-blog'),
				'options' => ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'],
			)
		);
		$this->add_control(
			'carousel_items_slide',
			array(
				'label'   => __('Slide Items By', 'premium-blog'),
				'type'    => Controls_Manager::SELECT,
				'default' => __('1', 'premium-blog'),
				'options' => ['1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8', '9' => '9', '10' => '10'],
			)
		);
		$this->add_control(
			'carousel_direction',
			array(
				'label'   => __('Direction', 'premium-blog'),
				'type'    => Controls_Manager::SELECT,
				'default' => __('1', 'premium-blog'),
				'options' => ['1' => 'Left', '2' => 'Right'],
			)
		);
		$this->add_control(
			'carousel_autoplay',
			array(
				'label'   => __('Autoplay', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('True', 'premium-blog'),
				'label_off' => __('False', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->add_control(
			'carousel_autoplay_speed',
			[
				'label' => __('Autoplay Speed (milliseconds)', 'premium-blog'),
				'type' => Controls_Manager::NUMBER,
				'default' => '3000',
				'condition' => [
					'carousel_autoplay' => 'yes',
				],
			]
		);
		$this->add_control(
			'carousel_margin',
			[
				'label' => __('Margin Between Items', 'premium-blog'),
				'type' => Controls_Manager::NUMBER,
				'default' => '10',
			]
		);
		$this->add_control(
			'carousel_loop',
			array(
				'label'   => __('Loop', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('True', 'premium-blog'),
				'label_off' => __('False', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->add_control(
			'carousel_lazyload',
			array(
				'label'   => __('LazyLoad', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('True', 'premium-blog'),
				'label_off' => __('False', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->add_control(
			'carousel_center',
			array(
				'label'   => __('Centered Layout', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('True', 'premium-blog'),
				'label_off' => __('False', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'no',
			)
		);
		$this->add_control(
			'carousel_dotnav',
			array(
				'label'   => __('Dot Navigation', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('True', 'premium-blog'),
				'label_off' => __('False', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'no',
			)
		);
		$this->end_controls_section();
		/**
		 * Typography 
		 */
		$this->start_controls_section(
			'premiumblog_section_typography',
			[
				'label' => __('Typography', 'premium-blog'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'premiumblog_post_list_title_style',
			[
				'label' => __('Post Content', 'premium-blog'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'premiumblog_post_list_title_color',
			[
				'label' => __('Post Title Color', 'premium-blog'),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .premiumblog-posts-carousel.layout-2 .premiumblog-carousel .item .item-meta h3 a' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'premiumblog_post_list_title_hover_color',
			[
				'label' => __('Post Title Hover Color', 'premium-blog'),
				'type' => Controls_Manager::COLOR,
				'default' => '#019625',
				'selectors' => [
					'{{WRAPPER}} .premiumblog-posts-carousel .premiumblog-carousel .item .item-meta h3 a:hover' => 'color: {{VALUE}};',
				],

			]
		);
		$this->add_control(
			'premiumblog_post_meta_color',
			[
				'label' => __('Post Meta Color', 'premium-blog'),
				'type' => Controls_Manager::COLOR,
				'default' => '#F0F0F0',
				'selectors' => [
					'{{WRAPPER}} .premiumblog-posts-carousel.layout-2 .premiumblog-carousel .item .extra-meta-small .meta-info' => 'color: {{VALUE}};',
					'{{WRAPPER}} .premiumblog-posts-carousel.layout-2 .premiumblog-carousel .item .extra-meta-small .meta-info a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .premiumblog-posts-carousel.layout-2 .premiumblog-carousel .item .extra-meta-small .meta-info i' => 'color: {{VALUE}};',
				],

			]
		);
		$this->add_responsive_control(
			'premiumblog_post_list_title_alignment',
			[
				'label' => __('Text Alignment', 'premium-blog'),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __('Left', 'premium-blog'),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __('Center', 'premium-blog'),
						'icon' => 'fa fa-align-center',
					],
					'right' => [
						'title' => __('Right', 'premium-blog'),
						'icon' => 'fa fa-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-posts-carousel .premiumblog-carousel .item .item-meta h3' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .premiumblog-posts-carousel .premiumblog-carousel .item .post-desc' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'premiumblog_post_list_title_typography',
				'label' => __('Post Title', 'premium-blog'),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' =>
				'{{WRAPPER}} .premiumblog-posts-carousel .premiumblog-carousel .item .item-meta h3 a',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'premiumblog_post_list_title_typography_2',
				'label' => __('Post Excerpt', 'premium-blog'),
				'scheme' => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .premiumblog-posts-carousel .premiumblog-carousel .item .post-desc',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'premiumblog_post_list_title_text_shadow',
				'label' => __('Text Shadow', 'premium-blog'),
				'selector' => '{{WRAPPER}} .premiumblog-posts-carousel .premiumblog-carousel .item .item-meta h3 a',
			]
		);
		$this->end_controls_section();

		/**
		 * Post Term
		 */
		$this->start_controls_section(
			'premiumblog_section_post_term',
			[
				'label' => __('Post Term', 'premium-blog'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'premiumblog_post_term_icon_bg',
			[
				'label' => __('Term Icon Background', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-carousel .item .grid-post-term span.term-icon' => 'background-color: {{VALUE}}',
				],
				'default' => 'rgba(0, 0, 0, 1)',
			]
		);
		$this->add_control(
			'premiumblog_post_term_icon_color',
			[
				'label' => __('Term Icon Color', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-carousel .item .grid-post-term span.term-icon' => 'color: {{VALUE}}',
				],
				'default' => 'rgba(255, 255, 255, 1)',
			]
		);
		$this->add_control(
			'premiumblog_post_term_name_bg',
			[
				'label' => __('Term Name Background', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-carousel .item .grid-post-term span.term-name' => 'background-color: {{VALUE}}',
				],
				'default' => '#019625',
			]
		);
		$this->add_control(
			'premiumblog_post_term_name_color',
			[
				'label' => __('Term Name Color', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-carousel .item .grid-post-term span.term-name' => 'color: {{VALUE}}',
				],
				'default' => '#000000',
			]
		);
		$this->end_controls_section();

		/**
		 * Navigation
		 */
		$this->start_controls_section(
			'premiumblog_section_carousel_nav',
			[
				'label' => __('Navigation', 'premium-blog'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'premiumblog_carousel_nav_style_heading',
			[
				'label' => __('Arrow Buttons', 'premium-blog'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->start_controls_tabs(
			'carousel_nav_style_tabs'
		);

		$this->start_controls_tab(
			'carousel_nav_normal_tab',
			[
				'label' => __('Normal', 'premium-blog'),
			]
		);

		$this->add_control(
			'carousel_nav_icon_color',
			[
				'label' => __('Icon Color', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-carousel .owl-prev' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .premiumblog-carousel .owl-next' => 'color: {{VALUE}} !important',
				],
				'default' => '#FFFFFF',
			]
		);
		$this->add_control(
			'carousel_nav_icon_bg_color',
			[
				'label' => __('Background Color', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-carousel .owl-prev' => 'background: {{VALUE}} !important',
					'{{WRAPPER}} .premiumblog-carousel .owl-next' => 'background: {{VALUE}} !important',
				],
				'default' => '#000000',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'carousel_nav_hover_tab',
			[
				'label' => __('Hover', 'premium-blog'),
			]
		);
		$this->add_control(
			'carousel_nav_icon_color_hover',
			[
				'label' => __('Icon Color', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-carousel .owl-prev:hover' => 'color: {{VALUE}} !important',
					'{{WRAPPER}} .premiumblog-carousel .owl-next:hover' => 'color: {{VALUE}} !important',
				],
				'default' => '#000000',
			]
		);
		$this->add_control(
			'carousel_nav_icon_bg_color_hover',
			[
				'label' => __('Background Color', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-carousel .owl-prev:hover' => 'background: {{VALUE}} !important',
					'{{WRAPPER}} .premiumblog-carousel .owl-next:hover' => 'background: {{VALUE}} !important',
				],
				'default' => '#019625',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'carousel_nav_spacing',
			[
				'label' => __('Spacing', 'premium-blog'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-posts-carousel.layout-2 .premiumblog-carousel .owl-prev' => 'top: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .premiumblog-posts-carousel.layout-2 .premiumblog-carousel .owl-next' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'carousel_nav_buttons_radius',
			[
				'label' => __('Border Radius', 'premium-blog'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%'],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-posts-carousel.layout-2 .premiumblog-carousel .owl-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .premiumblog-posts-carousel.layout-2 .premiumblog-carousel .owl-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'premiumblog_carousel_dots_style_heading',
			[
				'label' => __('Dots Navigation', 'premium-blog'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'carousel_dots_normal_color',
			[
				'label' => __('Dot Color', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-carousel .owl-dot' => 'background-color: {{VALUE}}',
				],
				'default' => '#dddddd',
			]
		);
		$this->add_control(
			'carousel_dots_active_color',
			[
				'label' => __('Dot Active/Hover', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-carousel .owl-dot:hover' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .premiumblog-carousel .owl-dot.active' => 'background-color: {{VALUE}} !important',
				],
				'default' => '#019625',
			]
		);
		$this->add_control(
			'carousel_dots_spacing',
			[
				'label' => __('Spacing', 'premium-blog'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-carousel .owl-dots' => 'margin-top: {{SIZE}}{{UNIT}};',
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
		$settings = $this->get_settings_for_display();

		$this->add_inline_editing_attributes('layout', 'none');
		$layout = $settings['layout'];
		$args = Utilities::premiumblog_get_query_args($settings);
?>
		<div class="premiumblog-posts-carousel-container">
			<div class="premiumblog-posts-carousel layout-<?php echo esc_attr($layout) ?>">
				<div class="premiumblog-carousel owl-carousel">
					<?php
					$list_posts = new \WP_Query($args);
					if ($list_posts->have_posts()) {
						while ($list_posts->have_posts()) :
							$list_posts->the_post();
							if (has_post_thumbnail()) :
								$thumb_uri = get_the_post_thumbnail_url(get_the_ID(), 'premiumblog-carousel-thumb');
							else :
								$thumb_uri = PBW_ASSETS_PATH . 'img/thumb-carousel.png';
							endif;
					?>
							<?php
							if ('1' === $settings['layout']) {
							?>
								<div class="item" style="background-image: url('<?php $thumb_uri ?>') ">
									<?php
									if ('yes' === $settings['full_grid_link']) { ?>
										<a href="<?php the_permalink() ?>" class="grid-link"></a>
									<?php } ?>
									<?php
									if ('1' === $settings['overlay']) { ?>
										<div class="overlay"></div>
									<?php } ?>
									<div class="item-meta <?php echo esc_attr($settings['overlay'] === '2' ? ' meta-overlay' : '')   ?>">
										<?php
										if ('yes' === $settings['show_title']) { ?>
											<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
										<?php } ?>
										<div class="extra-meta">
											<?php
											if ('yes' === $settings['show_meta']) { ?>
												<div class="meta-info">
													<?php Utilities::premiumblog_posted_by() ?> <?php Utilities::premiumblog_posted_on() ?> <?php Utilities::premiumblog_entry_comments() ?>
												</div>
											<?php } ?>
											<?php
											if ('yes' === $settings['show_excerpt']) { ?>
												<p class="post-desc"><?php echo Utilities::premiumblog_list_excerpt(15); ?></p>
											<?php } ?>
										</div>

									</div>
								</div>
							<?php
							} else {
							?>
								<div class="item">
									<div class="item-thumb">
										<a href="<?php the_permalink() ?>">
											<?php
											if (has_post_thumbnail()) :
												the_post_thumbnail('premiumblog-carousel-thumb-small');
											else :
												echo '<img src="' . PBW_ASSETS_PATH . 'img/thumb-carousel-2.png">';
											endif;
											?>
										</a>
										<?php
										if ('yes' === $settings['show_term']) {
											Utilities::premiumblog_post_term_box();
										}
										?>
									</div>
									<div class="item-meta">
										<?php if ('yes' === $settings['show_meta']) { ?>
											<div class="extra-meta-small">
												<div class="meta-info">
													<?php
													if ('yes' === $settings['show_meta_author']) {
														Utilities::premiumblog_posted_by();
													}
													if ('yes' === $settings['show_meta_date']) {
														Utilities::premiumblog_posted_on();
													}
													if ('yes' === $settings['show_meta_comments']) {
														Utilities::premiumblog_entry_comments();
													}
													?>
												</div>
											</div>
										<?php } ?>
										<?php if ('yes' === $settings['show_title']) { ?>
											<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
										<?php } ?>
										<div class="extra-meta">
											<?php if ('yes' === $settings['show_excerpt']) { ?>
												<p class="post-desc"><?php echo Utilities::premiumblog_list_excerpt(15); ?></p>
											<?php } ?>
										</div>
									</div>
								</div>
					<?php
							}
						endwhile;
					}
					\wp_reset_postdata();
					?>
				</div>
			</div>
		</div>
		<script>
			jQuery(document).ready(function($) {
				var width = jQuery(window).width();
				if (width > 768) {
					$(".premiumblog-carousel").owlCarousel({
						items: <?php echo (esc_attr($settings['carousel_items'])) ?>,
						margin: <?php echo (esc_attr($settings['carousel_margin'])) ?>,
						loop: <?php echo (esc_attr($settings['carousel_loop'] == 'yes' ? 'true' : 'false')) ?>,
						nav: true,
						dots: <?php echo (esc_attr($settings['carousel_dotnav'] == 'yes' ? 'true' : 'false')) ?>,
						center: <?php echo (esc_attr($settings['carousel_center'] == 'yes' ? 'true' : 'false')) ?>,
						rtl: <?php echo (esc_attr($settings['carousel_direction'] == '2' ? 'true' : 'false')) ?>,
						navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
						lazyLoad: <?php echo (esc_attr($settings['carousel_lazyload'] == 'yes' ? 'true' : 'false')) ?>,
						autoplay: <?php echo (esc_attr($settings['carousel_autoplay'] == 'yes' ? 'true' : 'false')) ?>,
						autoplayTimeout: <?php echo (esc_attr($settings['carousel_autoplay_speed'])) ?>,
						autoplayHoverPause: true,
						slideBy: <?php echo (esc_attr($settings['carousel_items_slide'])) ?>,

					});
				} else {
					$(".premiumblog-carousel").owlCarousel({
						items: 1,
						margin: <?php echo (esc_attr($settings['carousel_margin'])) ?>,
						loop: <?php echo (esc_attr($settings['carousel_loop'] == 'yes' ? 'true' : 'false')) ?>,
						nav: true,
						dots: <?php echo (esc_attr($settings['carousel_dotnav'] == 'yes' ? 'true' : 'false')) ?>,
						center: <?php echo (esc_attr($settings['carousel_center'] == 'yes' ? 'true' : 'false')) ?>,
						rtl: <?php echo (esc_attr($settings['carousel_direction'] == '2' ? 'true' : 'false')) ?>,
						navText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
						lazyLoad: <?php echo (esc_attr($settings['carousel_lazyload'] == 'yes' ? 'true' : 'false')) ?>,
						autoplay: <?php echo (esc_attr($settings['carousel_autoplay'] == 'yes' ? 'true' : 'false')) ?>,
						autoplayTimeout: <?php echo (esc_attr($settings['carousel_autoplay_speed'])) ?>,
						autoplayHoverPause: true,
						slideBy: <?php echo (esc_attr($settings['carousel_items_slide'])) ?>,

					});
				}
			});
		</script>
<?php
	}
}
