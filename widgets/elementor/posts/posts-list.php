<?php

/**
 * Posts List.
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
class premiumblog_Posts_List extends Widget_Base
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

		wp_register_style('premiumblog-posts-list', plugins_url('/assets/css/posts-list.css', PBW_WIDGETS), array(), '1.0.0');
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
		return ' premiumblog_posts_list';
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
		return __('Posts List', 'premium-blog');
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
		return 'pbw-icon premiumblog-icon-posts-list';
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
		return array('premiumblog-posts-list');
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
			'section_layout',
			array(
				'label' => __('Layout', 'premium-blog'),
			)
		);
		$this->add_control(
			'layout',
			array(
				'label'   => __('List Layout', 'premium-blog'),
				'type'    => Controls_Manager::SELECT,
				'default' => __('1', 'premium-blog'),
				'options' => ['1' => 'Layout 1', '2' => 'Layout 2'],
			)
		);
		$this->add_control(
			'show_widget_head',
			array(
				'label'   => __('Widget Heading', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'premium-blog'),
				'label_off' => __('Hide', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->add_control(
			'widget_head_text',
			array(
				'label'   => __('Widget Heading Text', 'premium-blog'),
				'type'    => Controls_Manager::TEXT,
				'default' => __('Posts List', 'premium-blog'),
				'condition' => ['show_widget_head' => 'yes']
			)
		);
		$this->add_control(
			'show_thumb',
			array(
				'label'   => __('Post Thumbnail', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('Show', 'premium-blog'),
				'label_off' => __('Hide', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'yes',
			)
		);
		$this->add_control(
			'thumbnail_width',
			[
				'label' => __('Thumbmnail Width', 'premium-blog'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 500,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 150,
				],
				'selectors' => [
					'{{WRAPPER}} .premiumblog-posts-list.layout-1 .item-thumb' => 'min-width: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'and',
					'terms' => [
						[
							'name' => 'show_thumb',
							'operator' => '==',
							'value' => 'yes'
						],
						[
							'name' => 'layout',
							'operator' => '==',
							'value' => '1'
						]
					]
				]
			]
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
				'default' => 'yes',
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
			'premiumblog_post_list_widget_head',
			[
				'label' => __('Widget Head', 'premium-blog'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
		$this->add_control(
			'premiumblog_post_list_widget_head_bg',
			[
				'label' => __('Widget Head Background', 'premium-blog'),
				'type' => Controls_Manager::COLOR,
				'default' => '#019625',
				'selectors' => [
					'{{WRAPPER}} .premiumblog-widget-head' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .premiumblog-widget-head h3' => 'background-color: {{VALUE}};',
				],

			]
		);
		$this->add_control(
			'premiumblog_post_list_widget_head_text',
			[
				'label' => __('Widget Head Text Color', 'premium-blog'),
				'type' => Controls_Manager::COLOR,
				'default' => '#000000',
				'selectors' => [
					'{{WRAPPER}} .premiumblog-widget-head h3' => 'color: {{VALUE}};',
				],

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
					'{{WRAPPER}} .premiumblog-posts-list .item-meta .post-title a' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .premiumblog-posts-list .item-meta .post-title a:hover' => 'color: {{VALUE}};',
				],

			]
		);
		$this->add_control(
			'premiumblog_post_meta_color',
			[
				'label' => __('Post Meta Color', 'premium-blog'),
				'type' => Controls_Manager::COLOR,
				'default' => '#8F8F8F',
				'selectors' => [
					'{{WRAPPER}} .premiumblog-posts-list .list-item .list-meta-info' => 'color: {{VALUE}};',
					'{{WRAPPER}} .premiumblog-posts-list .list-item .list-meta-info a' => 'color: {{VALUE}};',
					'{{WRAPPER}} .premiumblog-posts-list .list-item .list-meta-info i' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .premiumblog-posts-list .item-meta' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .premiumblog-posts-list .item-meta .post-title' => 'text-align: {{VALUE}};',
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
				'{{WRAPPER}} .premiumblog-posts-list .item-meta .post-title',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'premiumblog_post_list_title_typography_2',
				'label' => __('Post Excerpt', 'premium-blog'),
				'scheme' => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .premiumblog-posts-list .item-meta .post-desc',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'premiumblog_post_list_title_text_shadow',
				'label' => __('Text Shadow', 'premium-blog'),
				'selector' => '{{WRAPPER}} .featured-grid-item .featured-meta-inner h3 a',
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
					'{{WRAPPER}} .premiumblog-posts-list .list-item .grid-post-term span.term-icon' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .premiumblog-posts-list .list-item .grid-post-term span.term-icon' => 'color: {{VALUE}}',
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
					'{{WRAPPER}} .premiumblog-posts-list .list-item .grid-post-term span.term-name' => 'background-color: {{VALUE}}',
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
					'{{WRAPPER}} .premiumblog-posts-list .list-item .grid-post-term span.term-name' => 'color: {{VALUE}}',
				],
				'default' => '#000000',
			]
		);
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
		<div class="premiumblog-posts-list-container">
			<?php
			if ('yes' === $settings['show_widget_head']) { ?>
				<div class="premiumblog-widget-head">
					<h3><?php echo esc_textarea($settings['widget_head_text']) ?></h3>
				</div>
			<?php } ?>
			<div class="premiumblog-posts-list layout-<?php echo esc_attr($layout) ?>">
				<?php
				$list_posts = new \WP_Query($args);
				if ($list_posts->have_posts()) {
					while ($list_posts->have_posts()) :
						$list_posts->the_post();
				?>
						<div class="list-item">
							<?php
							if ('yes' === $settings['show_thumb']) { ?>
								<div class="item-thumb">
									<?php
									if (has_post_thumbnail()) :
										the_post_thumbnail('premiumblog-classic-thumb');
									else :
										echo '<img src="' . PBW_ASSETS_PATH . 'img/thumb-classic.png">';
									endif;
									?>
									<?php
									if ('yes' === $settings['show_term']) {
										Utilities::premiumblog_post_term_box();
									}
									?>
								</div>
							<?php } ?>
							<div class="item-meta">
								<h4 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
								<p class="post-desc">
									<?php
									if ('yes' === $settings['show_excerpt']) {
										echo Utilities::premiumblog_list_excerpt(15);
									}

									?>
								</p>
								<?php
								if ('yes' === $settings['show_meta']) { ?>
									<span class="list-meta-info d-block">
										<?php Utilities::premiumblog_posted_on() ?> <?php Utilities::premiumblog_entry_comments() ?>
									</span>
								<?php } ?>
							</div>
						</div>
				<?php endwhile;
				}
				\wp_reset_postdata();
				?>
			</div>

		</div>
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
