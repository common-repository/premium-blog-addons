<?php

/**
 * Posts Slider.
 *
 * @category   Class
 * @package    premiumblogWidgets
 * @subpackage WordPress
 */

namespace premiumblogWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Responsive\Responsive;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Color;
use Elementor\Core\Schemes\Typography;
use premiumblogWidgets\Classes\Utilities;

// Security Note: Blocks direct access to the plugin PHP files.
defined('ABSPATH') || die();

/**
 * FeaturedGrid widget class.
 *
 * @since 1.0.0
 */
class premiumblog_mailchimp_form extends Widget_Base
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
		wp_register_style('premiumblog-mailchimp-form-style', plugins_url('/assets/css/mailchimp-form.css', PBW_WIDGETS), array(), '1.0.0');
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
		return 'premiumblog_mailchimp_form';
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
		return __('Mailchimp', 'premium-blog');
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
		return 'pbw-icon eicon-mailchimp';
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
		
		return array('premiumblog-mailchimp-form-style');
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
	protected function register_controls() {

		// Tab: Content ==============
		// Section: Settings ----------
		$this->start_controls_section(
			'section_mailchimp_settings',
			[
				'label' => esc_html__( 'Settings', 'premius-blog' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		//Utilities::pbw_library_buttons( $this, Controls_Manager::RAW_HTML );

		$this->add_control(
			'maichimp_audience',
			[
				'label' => esc_html__( 'Select Audience', 'premius-blog' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'def',
				'options' => Utilities::get_mailchimp_lists(),
			]
		);

		
		$this->end_controls_section(); // End Controls Section

		// Tab: Content ==============
		// Section: General ----------
		$this->start_controls_section(
			'section_mailchimp_general',
			[
				'label' => esc_html__( 'General', 'premius-blog' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_form_header',
			[
				'label' => esc_html__( 'Show Form Header', 'premius-blog' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'form_title',
			[
				'label' => esc_html__( 'Form Title', 'premius-blog' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Join the family!',
				'condition' => [
					'show_form_header' => 'yes',
				]
			]
		);

		$this->add_control(
			'form_description',
			[
				'label' => esc_html__( 'Form Description', 'premius-blog' ),
				'type' => Controls_Manager::TEXTAREA,
				'default' => 'Sign up for a Newsletter.',
				'condition' => [
					'show_form_header' => 'yes',
				]
			]
		);

		$this->add_control(
			'form_icon',
			[
				'label' => esc_html__( 'Select Icon', 'premius-blog' ),
				'type' => Controls_Manager::ICONS,
				'skin' => 'inline',
				'label_block' => false,
				'default' => [
					'value' => 'far fa-envelope',
					'library' => 'fa-regular',
				],
				'condition' => [
					'show_form_header' => 'yes',
				]
			]
		);

		$this->add_control(
			'form_icon_display',
			[
				'label' => esc_html__( 'Icon Position', 'premius-blog' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => [
					'top' => esc_html__( 'Top', 'premius-blog' ),
					'left' => esc_html__( 'Left', 'premius-blog' ),
				],
				'selectors_dictionary' => [
					'top' => 'display: block;',
					'left' => 'display: inline; margin-right: 5px;'
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-header i' => '{{VALUE}}',
				],
				'condition' => [
					'show_form_header' => 'yes',
				]
			]
		);

		$this->add_control(
			'email_label',
			[
				'label' => esc_html__( 'Email Label', 'premius-blog' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Email',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'email_placeholder',
			[
				'label' => esc_html__( 'Email Placeholder', 'premius-blog' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'sample@mail.com',
			]
		);

		$this->add_control(
			'subscribe_btn_text',
			[
				'label' => esc_html__( 'Button Text', 'premius-blog' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Subscribe',
			]
		);

		$this->add_control(
			'subscribe_button_loading_text',
			[
				'label' => esc_html__( 'Button Loading Text', 'premius-blog' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Subscribing...',
				'separator' => 'after'
			]
		);

		$this->add_control(
			'success_message',
			[
				'label' => esc_html__( 'Success Message', 'premius-blog' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'You have been successfully Subscribed!',
			]
		);

		$this->add_control(
			'error_message',
			[
				'label' => esc_html__( 'Error Message', 'premius-blog' ),
				'type' => Controls_Manager::TEXT,
				'default' => 'Ops! Something went wrong, please try again.',
			]
		);

		

		$this->end_controls_section(); 


//		Utilities::pbw_add_section_request_feature( $this, Controls_Manager::RAW_HTML, '' );

		$this->start_controls_section(
			'section_style_container',
			[
				'label' => esc_html__( 'Container', 'premius-blog' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

	

		// add responsive control
		$this->add_responsive_control(
			'container_align',
			[
				'label' => esc_html__( 'Alignment', 'premius-blog' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'hr',
				'options' => [
					'hr' => [
						'title' => esc_html__( 'Horizontal', 'premius-blog' ),
						
					],
					'vr' => [
						'title' => esc_html__( 'Vertical', 'premius-blog' ),
						'icon' => 'fa fa-arrows-v',
					],
				],
				'prefix_class' => 'pbw-mailchimp-layout-',
				'render_type' => 'template',
				'separator' => 'after'
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'container_background',
				'label' => esc_html__( 'Background', 'premius-blog' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'default' => '',
					],
				],
				'selector' => '{{WRAPPER}} .pbw-mailchimp-form'
			]
		);

		$this->add_control(
			'container_border_color',
			[
				'label' => esc_html__( 'Border Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E8E8E8',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-form' => 'border-color: {{VALUE}}',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'container_box_shadow',
				'selector' => '{{WRAPPER}} .pbw-mailchimp-form',
			]
		);

		$this->add_control(
			'container_border_type',
			[
				'label' => esc_html__( 'Border Type', 'premius-blog' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'premius-blog' ),
					'solid' => esc_html__( 'Solid', 'premius-blog' ),
					'double' => esc_html__( 'Double', 'premius-blog' ),
					'dotted' => esc_html__( 'Dotted', 'premius-blog' ),
					'dashed' => esc_html__( 'Dashed', 'premius-blog' ),
					'groove' => esc_html__( 'Groove', 'premius-blog' ),
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-form' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'container_border_width',
			[
				'label' => esc_html__( 'Border Width', 'premius-blog' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-form' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'container_border_type!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label' => esc_html__( 'Padding', 'premius-blog' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-form' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'container_radius',
			[
				'label' => esc_html__( 'Border Radius', 'premius-blog' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); 

		$this->start_controls_section(
			'section_style_header',
			[
				'label' => esc_html__( 'Form Header', 'premius-blog' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'header_align',
			[
				'label' => esc_html__( 'Alignment', 'premius-blog' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'premius-blog' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'premius-blog' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'premius-blog' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-header' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'header_align_divider',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'header_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#019625',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-header i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .pbw-mailchimp-header svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'header_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'premius-blog' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],				
				'default' => [
					'unit' => 'px',
					'size' => 28,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-header i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .pbw-mailchimp-header svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after'
			]
		);

		$this->add_control(
			'header_title_color',
			[
				'label' => esc_html__( 'Title Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#424242',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-header h3' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'header_title_typography',
				'scheme' => Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .pbw-mailchimp-header h3',
			]
		);

		$this->add_control(
			'header_description_color',
			[
				'label' => esc_html__( 'Description Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#606060',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-header p' => 'color: {{VALUE}}',
				],
				'separator' => 'before'
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'header_description_typography',
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .pbw-mailchimp-header p',
			]
		);

		$this->add_responsive_control(
			'header_title_distance',
			[
				'label' => esc_html__( 'Title Bottom Distance', 'premius-blog' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],				
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-header h3' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'header_desc_distance',
			[
				'label' => esc_html__( 'Description Bottom Distance', 'premius-blog' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],				
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-header' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section(); 
	
		$this->start_controls_section(
			'section_style_labels',
			[
				'label' => esc_html__( 'Labels', 'premius-blog' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'labels_color',
			[
				'label' => esc_html__( 'Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#818181',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields label' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'labels_typography',
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .pbw-mailchimp-fields label',
			]
		);

		$this->add_responsive_control(
			'labels_spacing',
			[
				'label' => esc_html__( 'Spacing', 'premius-blog' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 25,
					],
				],				
				'default' => [
					'unit' => 'px',
					'size' => 4,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section(); 

		$this->start_controls_section(
			'section_style_inputs',
			[
				'label' => esc_html__( 'Fields', 'premius-blog' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->start_controls_tabs( 'tabs_forms_inputs_style' );

		$this->start_controls_tab(
			'tab_inputs_normal',
			[
				'label' => esc_html__( 'Normal', 'premius-blog' ),
			]
		);

		$this->add_control(
			'input_color',
			[
				'label' => esc_html__( 'Text Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#474747',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields input' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'input_placeholder_color',
			[
				'label' => esc_html__( 'Placeholder Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ADADAD',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields input::placeholder' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'input_background_color',
			[
				'label' => esc_html__( 'Background Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields input' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'input_border_color',
			[
				'label' => esc_html__( 'Border Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#e8e8e8',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields input' => 'border-color: {{VALUE}}',
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_inputs_hover',
			[
				'label' => esc_html__( 'Focus', 'premius-blog' ),
			]
		);

		$this->add_control(
			'input_color_fc',
			[
				'label' => esc_html__( 'Text Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields input:focus' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'input_placeholder_color_fc',
			[
				'label' => esc_html__( 'Placeholder Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields input:focus::placeholder' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'input_background_color_fc',
			[
				'label' => esc_html__( 'Background Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields input:focus' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'input_border_color_fc',
			[
				'label' => esc_html__( 'Border Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#e8e8e8',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields input:focus' => 'border-color: {{VALUE}}',
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'input_box_shadow',
				'selector' => '{{WRAPPER}} .pbw-mailchimp-fields input',
				'separator' => 'after',
			]
		);

		$this->add_control(
			'input_transition_duration',
			[
				'label' => esc_html__( 'Transition Duration', 'premius-blog' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.1,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields input' => 'transition-duration: {{VALUE}}s',
				],
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'input_typography',
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .pbw-mailchimp-fields input',
			]
		);

		$this->add_responsive_control(
			'input_height',
			[
				'label' => esc_html__( 'Input Height', 'premius-blog' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 100,
					],
				],				
				'default' => [
					'unit' => 'px',
					'size' => 45,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields input' => 'height: {{SIZE}}px; line-height: {{SIZE}}px;',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'input_spacing',
			[
				'label' => esc_html__( 'Gutter', 'premius-blog' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],				
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}}.pbw-mailchimp-layout-vr .pbw-mailchimp-email, {{WRAPPER}}.pbw-mailchimp-layout-vr .pbw-mailchimp-first-name, {{WRAPPER}}.pbw-mailchimp-layout-vr .pbw-mailchimp-last-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.pbw-mailchimp-layout-hr .pbw-mailchimp-email, {{WRAPPER}}.pbw-mailchimp-layout-hr .pbw-mailchimp-first-name, {{WRAPPER}}.pbw-mailchimp-layout-hr .pbw-mailchimp-last-name' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after'
			]
		);

		$this->add_control(
			'input_border_type',
			[
				'label' => esc_html__( 'Border Type', 'premius-blog' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'premius-blog' ),
					'solid' => esc_html__( 'Solid', 'premius-blog' ),
					'double' => esc_html__( 'Double', 'premius-blog' ),
					'dotted' => esc_html__( 'Dotted', 'premius-blog' ),
					'dashed' => esc_html__( 'Dashed', 'premius-blog' ),
					'groove' => esc_html__( 'Groove', 'premius-blog' ),
				],
				'default' => 'solid',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields input' => 'border-style: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'input_border_width',
			[
				'label' => esc_html__( 'Border Width', 'premius-blog' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields input' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'input_border_type!' => 'none',
				],
			]
		);

		$this->add_responsive_control(
			'input_padding',
			[
				'label' => esc_html__( 'Padding', 'premius-blog' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 0,
					'right' => 15,
					'bottom' => 0,
					'left' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'input_radius',
			[
				'label' => esc_html__( 'Border Radius', 'premius-blog' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 2,
					'right' => 2,
					'bottom' => 2,
					'left' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-fields input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section(); 
		$this->start_controls_section(
			'section_style_subscribe_btn',
			[
				'label' => esc_html__( 'Button', 'premius-blog' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'subscribe_btn_align',
			[
				'label' => esc_html__( 'Alignment', 'premius-blog' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'premius-blog' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'premius-blog' ),
						'icon' => 'eicon-text-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'premius-blog' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}}.pbw-mailchimp-layout-vr .pbw-mailchimp-subscribe' => 'align-self: {{VALUE}};',
				],
				'condition' => [
					'container_align' => 'vr'
				]
			]
		);

		$this->add_control(
			'subscribe_btn_divider1',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
				'condition' => [
					'container_align' => 'vr'
				]
			]
		);

		$this->start_controls_tabs( 'tabs_subscribe_btn_style' );

		$this->start_controls_tab(
			'tab_subscribe_btn_normal',
			[
				'label' => esc_html__( 'Normal', 'premius-blog' ),
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'subscribe_btn_bg_color',
				'label' => esc_html__( 'Background', 'premius-blog' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'default' => '#019625',
					],
				],
				'selector' => '{{WRAPPER}} .pbw-mailchimp-subscribe-btn'
			]
		);

		$this->add_control(
			'subscribe_btn_color',
			[
				'label' => esc_html__( 'Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-subscribe-btn' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'subscribe_btn_border_color',
			[
				'label' => esc_html__( 'Border Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#E6E2E2',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-subscribe-btn' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'subscribe_btn_box_shadow',
				'selector' => '{{WRAPPER}} .pbw-mailchimp-subscribe-btn',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_subscribe_btn_hover',
			[
				'label' => esc_html__( 'Hover', 'premius-blog' ),
			]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'subscribe_btn_bg_color_hr',
				'label' => esc_html__( 'Background', 'premius-blog' ),
				'types' => [ 'classic', 'gradient' ],
				'fields_options' => [
					'color' => [
						'default' => '#019625',
					],
				],
				'selector' => '{{WRAPPER}} .pbw-mailchimp-subscribe-btn:hover'
			]
		);

		$this->add_control(
			'subscribe_btn_color_hr',
			[
				'label' => esc_html__( 'Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-subscribe-btn:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'subscribe_btn_border_color_hr',
			[
				'label' => esc_html__( 'Border Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-subscribe-btn:hover' => 'border-color: {{VALUE}}',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'subscribe_btn_box_shadow_hr',
				'selector' => '{{WRAPPER}} .pbw-mailchimp-subscribe-btn:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'subscribe_btn_divider2',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'subscribe_btn_transition_duration',
			[
				'label' => esc_html__( 'Transition Duration', 'premius-blog' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 0.1,
				'min' => 0,
				'max' => 5,
				'step' => 0.1,
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-subscribe-btn' => 'transition-duration: {{VALUE}}s',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'subscribe_btn_typography',
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .pbw-mailchimp-subscribe-btn'
			]
		);

		$this->add_responsive_control(
			'subscribe_btn_width',
			[
				'label' => esc_html__( 'Width', 'premius-blog' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px', '%'],
				'range' => [
					'px' => [
						'min' => 30,
						'max' => 300,
					],
				],				
				'default' => [
					'unit' => 'px',
					'size' => 130,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-subscribe' => 'width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'subscribe_btn_height',
			[
				'label' => esc_html__( 'Height', 'premius-blog' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],				
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-subscribe-btn' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'subscribe_btn_spacing',
			[
				'label' => esc_html__( 'Top Distance', 'premius-blog' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],				
				'default' => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors' => [
					'{{WRAPPER}}.pbw-mailchimp-layout-vr .pbw-mailchimp-subscribe-btn' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'container_align' => 'vr'
				]
			]
		);

		$this->add_control(
			'subscribe_btn_border_type',
			[
				'label' => esc_html__( 'Border Type', 'premius-blog' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'none' => esc_html__( 'None', 'premius-blog' ),
					'solid' => esc_html__( 'Solid', 'premius-blog' ),
					'double' => esc_html__( 'Double', 'premius-blog' ),
					'dotted' => esc_html__( 'Dotted', 'premius-blog' ),
					'dashed' => esc_html__( 'Dashed', 'premius-blog' ),
					'groove' => esc_html__( 'Groove', 'premius-blog' ),
				],
				'default' => 'none',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-subscribe-btn' => 'border-style: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'subscribe_btn_border_width',
			[
				'label' => esc_html__( 'Border Width', 'premius-blog' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-subscribe-btn' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'subscribe_btn_border_type!' => 'none',
				],
			]
		);

		$this->add_control(
			'subscribe_btn_radius',
			[
				'label' => esc_html__( 'Border Radius', 'premius-blog' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'top' => 2,
					'right' => 2,
					'bottom' => 2,
					'left' => 2,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-subscribe-btn' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_message',
			[
				'label' => esc_html__( 'Message', 'premius-blog' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);

		$this->add_control(
			'success_message_color',
			[
				'label' => esc_html__( 'Success Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-success-message' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'error_message_color',
			[
				'label' => esc_html__( 'Error Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FF348B',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-error-message' => 'color: {{VALUE}}',
				]
			]
		);

		$this->add_control(
			'message_color_bg',
			[
				'label' => esc_html__( 'Background Color', 'premius-blog' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#FFFFFF',
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-message' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'message_typography',
				'scheme' => Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .pbw-mailchimp-message',
			]
		);

		$this->add_responsive_control(
			'message_padding',
			[
				'label' => esc_html__( 'Padding', 'premius-blog' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'default' => [
					'top' => 0,
					'right' => 0,
					'bottom' => 0,
					'left' => 0,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-message' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'message_spacing',
			[
				'label' => esc_html__( 'Spacing', 'premius-blog' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],				
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .pbw-mailchimp-message' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before'
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
	protected function render() {
		// Get Settings
		$settings = $this->get_settings();

		?>

		<form class="pbw-mailchimp-form" id="pbw-mailchimp-form-<?php echo esc_attr( $this->get_id() ); ?>" method="POST" data-api-key="<?php echo esc_attr(get_option('pbw_mailchimp_api_key')); ?>" data-list-id="<?php echo esc_attr($settings['maichimp_audience']); ?>">
			<!-- Form Header -->
			<?php if ( 'yes' === $settings['show_form_header'] ) : ?>
			<div class="pbw-mailchimp-header">
				<?php $form_icon = '' !== $settings['form_icon']['value'] ? '<i class="'. esc_attr($settings['form_icon']['value']) .'"></i>' : ''; ?>
				<h3>
					<?php
					echo ''. $form_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					echo esc_html($settings['form_title']);
					?>
				</h3>
				<p><?php echo wp_kses( $settings['form_description'], [ 'br' => [], 'em' => [], 'strong' => [], ] ); ?></p>
			</div>
			<?php endif; ?>

			<div class="pbw-mailchimp-fields">
				<!-- Email Input -->
				<div class="pbw-mailchimp-email">
					<?php echo '' !== $settings['email_label'] ? '<label>'. esc_html($settings['email_label']) .'</label>' : ''; ?>
					<input type="email" name="pbw_mailchimp_email" placeholder="<?php echo esc_attr($settings['email_placeholder']); ?>" required="required">
				</div>

				
				<!-- Subscribe Button -->
				<div class="pbw-mailchimp-subscribe">
					<button type="submit" id="pbw-subscribe-<?php echo esc_attr( $this->get_id() ); ?>" class="pbw-mailchimp-subscribe-btn" data-loading="<?php echo esc_attr($settings['subscribe_button_loading_text']); ?>">
				  		<?php echo esc_html($settings['subscribe_btn_text']); ?>
					</button>
				</div>
			</div>

			<!-- Success/Error Message -->
			<div class="pbw-mailchimp-message">
				<span class="pbw-mailchimp-success-message"><?php echo esc_html($settings['success_message']); ?></span>
				<span class="pbw-mailchimp-error-message"><?php echo esc_html($settings['error_message']); ?></span>
			</div>
		</form>

		<?php
	}
	
}
