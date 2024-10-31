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
use Elementor\Core\Schemes\Color;
use premiumblogWidgets\Classes\Utilities;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * FeaturedGrid widget class.
 *
 * @since 1.0.0
 */
class STBFeaturedGrid extends Widget_Base
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

		wp_register_style('premiumblog-featured-grid', plugins_url('/assets/css/featured-grid.css', PBW_WIDGETS), array(), '1.0.0');
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
		return 'featuredgrid';
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
		return __('Posts Grid', 'premium-blog');
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
		return 'pbw-icon premiumblog-icon-posts-grid';
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
		return array('premiumblog-featured-grid');
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
				'label'   => __('Grid Layout', 'premium-blog'),
				'type'    => Controls_Manager::SELECT,
				'default' => __('1', 'premium-blog'),
				'options' => ['1' => 'Layout 1', '2' => 'Layout 2', '3' => 'Layout 3', '4' => 'Layout 4'],
			)
		);
		$this->add_control(
			'overlay',
			array(
				'label'   => __('Overlay Layout', 'premium-blog'),
				'type'    => Controls_Manager::SELECT,
				'default' => __('1', 'premium-blog'),
				'options' => ['0' => 'Disabled', '1' => 'Full', '2' => 'Title Only'],
			)
		);
		$this->add_control(
			'grid-item-height',
			[
				'label' => __('Grid Items Height', 'premium-blog'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 250,
				],
				'selectors' => [
					'{{WRAPPER}} .featured-grid-layout-5 .featured-grid-item' => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .featured-grid-layout-6 .featured-grid-item' => 'height: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
					'relation' => 'or',
					'terms' => [
						[
							'name' => 'layout',
							'operator' => '==',
							'value' => '5'
						],
						[
							'name' => 'layout',
							'operator' => '==',
							'value' => '6'
						]
					]
				]
			]
		);
		$this->add_control(
			'show_term',
			array(
				'label'   => __( 'Post Term', 'premium-blog' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'premium-blog' ),
				'label_off' => __( 'Hide', 'premium-blog' ),
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
			'full_grid_link',
			array(
				'label'   => __('Full Grid Link', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __('ON', 'premium-blog'),
				'label_off' => __('OFF', 'premium-blog'),
				'return_value' => 'yes',
				'default' => 'no',
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

		// Section: Request New Feature

		Utilities::pbw_add_section_request_feature($this, Controls_Manager::RAW_HTML, '');
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
			'premiumblog_post_grid_title_style',
			[
				'label' => __('Title Style', 'premium-blog'),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'premiumblog_post_grid_title_color',
			[
				'label' => __('Title Color', 'premium-blog'),
				'type' => Controls_Manager::COLOR,
				'default' => '#F0F0F0',
				'selectors' => [
					'{{WRAPPER}} .featured-grid-item .featured-meta-inner h3 a' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_control(
			'premiumblog_post_grid_title_hover_color',
			[
				'label' => __('Title Hover Color', 'premium-blog'),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .featured-grid-item .featured-meta-inner h3 a:hover' => 'color: {{VALUE}};',
				],

			]
		);

		$this->add_responsive_control(
			'premiumblog_post_grid_title_alignment',
			[
				'label' => __('Title Alignment', 'premium-blog'),
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
					'{{WRAPPER}} .featured-grid-item .featured-meta-inner' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .featured-grid-item .featured-meta-inner h3' => 'text-align: {{VALUE}};',
					'{{WRAPPER}} .featured-grid-item .featured-meta-inner .grid-meta-info' => 'text-align: {{VALUE}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'premiumblog_post_grid_title_typography',
				'label' => __('Typography (Large Grids)', 'premium-blog'),
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' =>
				'{{WRAPPER}} .featured-grid-layout-1 .featured-grid-item.grid-item-1 .featured-meta-inner h3 a, {{WRAPPER}} .featured-grid-layout-2  .featured-grid-item.grid-item-1 .featured-meta-inner h3 a, {{WRAPPER}} .featured-grid-layout-4  .featured-grid-item.grid-item-1 .featured-meta-inner h3 a',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'premiumblog_post_grid_title_typography_2',
				'label' => __('Typography (Small Grids)', 'premium-blog'),
				'scheme' => Typography::TYPOGRAPHY_2,
				'selector' => '{{WRAPPER}} .featured-grid-item.small-grid .featured-meta-inner h3, {{WRAPPER}} .featured-grid-item.small-grid .featured-meta-inner h3 a, {{WRAPPER}} .featured-grid-layout-6 .featured-grid-item .featured-meta-inner h3 a',
			]
		);
		$this->add_responsive_control(
			'premiumblog_post_grid_title_margin',
			[
				'label' => __('Title Margin', 'premium-blog'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .featured-grid-item .featured-meta-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Text_Shadow::get_type(),
			[
				'name' => 'premiumblog_post_grid_title_text_shadow',
				'label' => __('Text Shadow', 'premium-blog'),
				'selector' => '{{WRAPPER}} .featured-grid-item .featured-meta-inner h3 a',
			]
		);
		$this->end_controls_section();
		/**
		 * Grid Overlay
		 */
		$this->start_controls_section(
			'premiumblog_section_grid_items',
			[
				'label' => __('Grid Items', 'premium-blog'),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'premiumblog_grid_overlay',
			[
				'label' => __('Overlay Color', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .featured-grid-item .overlay' => 'background: {{VALUE}}',
					'{{WRAPPER}} .featured-grid-item .featured-meta.meta-overlay .featured-meta-inner' => 'background: linear-gradient(0deg, {{VALUE}} 0%, {{VALUE}} 50%, rgba(255,255,255,0) 100%)',
				],
				'default' => 'rgba(0, 0, 0, 0.7)',
			]
		);
		$this->add_control(
			'premiumblog_grid_overlay_hover',
			[
				'label' => __('Overlay (Hover) Color', 'premium-blog'),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .featured-grid-item:hover .overlay' => 'background: {{VALUE}}',
					'{{WRAPPER}} .featured-grid-item:hover .featured-meta.meta-overlay .featured-meta-inner' => 'background: linear-gradient(0deg, {{VALUE}} 0%, {{VALUE}} 50%, rgba(255,255,255,0) 100%)'
				],
				'default' => 'rgba(0, 0, 0, 0.4)',
			]
		);
		$this->add_responsive_control(
			'premiumblog_post_grid_item_gap',
			[
				'label' => __('Grid Items Gap', 'premium-blog'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', '%', 'em'],
				'selectors' => [
					'{{WRAPPER}} .featured-grid-item ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '5px',
					'right' => '5px',
					'bottom' => '5px',
					'left' => '5px',
					'isLinked' => true,
				]
			]
		);
		$this->end_controls_section();
		/**
		 * Post Term
		 */
		$this->start_controls_section(
		    'premiumblog_section_grid_term',
		    [
		        'label' => __('Post Term', 'premium-blog'),
		        'tab' => Controls_Manager::TAB_STYLE,
		    ]
		);
		
		
		$this->add_control(
			'premiumblog_post_term_name_color',
			[
				'label' => __( 'Term Name Color', 'premium-blog' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'scheme' => [
					'type' => Color::get_type(),
					'value' => Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} .featured-grid-item .grid-post-term span.term-name' => 'color: {{VALUE}}',
				],
				'default' => '#fff',
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
		<div class="fetured-grid-container">
			<div class="featured-layout-row row ml-0 mr-0">
				<?php
				$featured_posts = new \WP_Query($args);
				$i = 1;
				?>
				<div class="featured-grid-layout-<?php echo esc_attr($layout) ?>">
					<?php
					if ($featured_posts->have_posts()) {
						while ($featured_posts->have_posts()) :
							$featured_posts->the_post();
							if (has_post_thumbnail()) :
								$thumb_uri = get_the_post_thumbnail_url(get_the_ID(), 'premiumblog-grid-thumb');
							else :
								$thumb_uri = PBW_ASSETS_PATH . 'img/thumb-medium.png';
							endif;
					?>
							<div class="featured-grid-item grid-item-<?php echo esc_attr($i) ?><?php Utilities::premiumblog_small_grid_class($layout, $i) ?>">
								<div class="grid-item-inner" style="background-image:url(<?php echo esc_url($thumb_uri) ?>)">
									<?php
									if ('yes' === $settings['full_grid_link']) { ?>
										<a href="<?php the_permalink() ?>" class="grid-link"></a>
									<?php } ?>
									<?php
									if ('1' === $settings['overlay']) { ?>
										<div class="overlay"></div>
									<?php } ?>
									<div class="featured-meta<?php echo ($settings['overlay'] === '2' ? ' meta-overlay' : '')   ?>">
										<div class="featured-meta-inner">
											<?php
													if ('yes' === $settings['show_term']) {
														Utilities::premiumblog_post_term_box();
													}
													?>
											<h3><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>
											<?php
											if ('yes' === $settings['show_meta']) { ?>
												<span class="grid-meta-info d-block">
													<?php Utilities::premiumblog_posted_on() ?>
													<?php Utilities::premiumblog_entry_comments() ?>
												</span>
											<?php } ?>
										</div>

									</div>
								</div>
							</div>
					<?php
							$i++;
						endwhile;
					}
					\wp_reset_postdata();
					?>
				</div>

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
