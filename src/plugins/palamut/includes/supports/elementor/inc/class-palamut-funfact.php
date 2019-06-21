<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Palamut_Funfact extends Widget_Base {


	public $base;

	/**
	 * Register Widget Name
	 *
	 * @method get_name
	 *
	 * @since 1.0.1
	 *
	 * @link https://developers.elementor.com/creating-a-new-widget/
	 *
	 * @return string   Widget Name
	 */
	public function get_name() {
		return 'palamut-grid-posts';
	}
	/**
	 * Register Widget Title
	 *
	 * @method get_title
	 *
	 * @since 1.0.1
	 *
	 * @link https://developers.elementor.com/creating-a-new-widget/
	 *
	 * @return string Widget Title
	 */
	public function get_title() {
		return __( 'Fun Facts', 'palamut' );
	}
	/**
	 * Choose an Icon for Widget
	 *
	 * @method get_icon
	 *
	 * @since 1.0.1
	 *
	 * @link https://developers.elementor.com/creating-a-new-widget/
	 *
	 * @return string  Icon
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
	}
	/**
	 * Retrieve the list of categories the accordion widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'palamut-elements' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'pala_funfact_section_icon',
			[
				'label' => esc_html__( 'Icon', 'palamut' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'pala_funfact_icon_type',
			[
				'label'   => esc_html__( 'Icon type ', 'palamut' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'icon'       => [
						'title' => esc_html__( 'Icon', 'palamut' ),
						'icon'  => 'fa fa-star',
					],
					'image_icon' => [
						'title' => esc_html__( 'Image', 'palamut' ),
						'icon'  => 'fa fa-image',
					],
					'none'       => [
						'title' => esc_html__( 'None', 'palamut' ),
						'icon'  => 'fa fa-stop-circle',
					],
				],
				'default' => 'icon',
				'toggle'  => true,
			]
		);

		$this->add_control(
			'pala_funfact_icon',
			[
				'label'     => esc_html__( 'Icon', 'palamut' ),
				'type'      => Controls_Manager::ICON,
				'default'   => 'fa fa-amazon',
				'condition' => [
					'pala_funfact_icon_type' => 'icon',
				],
			]
		);

		$this->add_control(
			'pala_funfact_view',
			[
				'label'     => esc_html__( 'View', 'palamut' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'default'   => esc_html__( 'Default', 'palamut' ),
					'fill-icon' => esc_html__( 'Stacked', 'palamut' ),
					'framed'    => esc_html__( 'Framed', 'palamut' ),
				],
				'default'   => 'default',
				'condition' => [
					'icon!'                  => '',
					'pala_funfact_icon_type' => 'icon',

				],
			]
		);
		$this->add_control(
			'pala_funfact_icon_image',
			[
				'label'     => esc_html__( 'Choose Image', 'palamut' ),
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => [
					'active' => true,
				],
				'default'   => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'pala_funfact_icon_type' => 'image_icon',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name'      => 'pala_funfact_thumbnail',
				'default'   => 'thumbnail',
				'separator' => 'none',
				'condition' => [
					'pala_funfact_icon_type' => 'image_icon',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pala_funfact_content_section',
			[
				'label' => esc_html__( 'Content', 'palamut' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'pala_funfact_number',
			[
				'label'       => esc_html__( 'Number ', 'palamut' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '254',
				'placeholder' => esc_html__( 'Enter number', 'palamut' ),
			]
		);

		$this->add_control(
			'pala_funfact_number_suffix',
			[
				'label'       => esc_html__( 'Number Suffix ', 'palamut' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => 'M',
				'placeholder' => esc_html__( 'M+', 'palamut' ),
			]
		);

		$this->add_control(
			'pala_funfact_title_text',
			[
				'label'       => esc_html__( 'Title ', 'palamut' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => esc_html__( 'This is the heading', 'palamut' ),
				'placeholder' => esc_html__( 'Enter your title', 'palamut' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'pala_funfact_super',
			[
				'label'   => esc_html__( 'Enable Super', 'palamut' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$this->add_control(
			'pala_funfact_super_text',
			[
				'label'       => esc_html__( 'Super', 'palamut' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '+',
				'placeholder' => esc_html__( '+', 'palamut' ),
				'condition'   => [ 'pala_funfact_super' => 'yes' ],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pala_funfact_settings_items',
			[
				'label' => esc_html__( 'Settings', 'palamut' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'pala_funfact_text_align',
			[
				'label'   => esc_html__( 'Alignment', 'palamut' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'left'   => [
						'title' => esc_html__( 'Left', 'palamut' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'palamut' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'palamut' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default' => 'center',
				'toggle'  => true,
			]
		);
		$this->add_control(
			'pala_funfact_title_size',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'palamut' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h3',
			]
		);

		$this->add_control(
			'pala_funfact_separetor_one',
			[
				'type'  => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->add_control(
			'pala_funfact_hover_border_bottom',
			[
				'label'   => esc_html__( 'Enable Hover Border Bottom', 'palamut' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$this->add_control(
			'pala_funfact_hover_border_bottom_direction',
			[
				'label'     => esc_html__( 'Hover Direction', 'palamut' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'hover_from_left'  => [
						'title' => esc_html__( 'From Left', 'palamut' ),
						'icon'  => 'fa fa-caret-right',
					],
					'hover_from_right' => [
						'title' => esc_html__( 'From Right', 'palamut' ),
						'icon'  => 'fa fa-caret-left',
					],
				],
				'default'   => 'hover_from_right',
				'toggle'    => true,
				'condition' => [
					'pala_funfact_hover_border_bottom' => 'yes',
				],
			]
		);

		$this->add_control(
			'pala_funfact_hover_border_bottom_direction_hr',
			[
				'type'      => Controls_Manager::DIVIDER,
				'style'     => 'thick',
				'condition' => [
					'pala_funfact_hover_border_bottom' => 'yes',
				],
			]
		);

		$this->add_control(
			'pala_funfact_enable_vertical_border',
			[
				'label'   => esc_html__( 'Enable Vertical Border', 'palamut' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'no',
			]
		);

		$this->add_control(
			'pala_funfact_enable_vertical_border_position',
			[
				'label'     => esc_html__( 'Border Direction', 'palamut' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'border_left_side'  => [
						'title' => esc_html__( 'From Left', 'palamut' ),
						'icon'  => 'fa fa-caret-right',
					],
					'border_right_side' => [
						'title' => esc_html__( 'From Right', 'palamut' ),
						'icon'  => 'fa fa-caret-left',
					],
				],
				'default'   => 'border_right_side',
				'toggle'    => true,
				'condition' => [
					'pala_funfact_enable_vertical_border' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// start Image style section for image
		$this->start_controls_section(
			'pala_funfact_style_section_image',
			[
				'label'     => esc_html__( 'Icon', 'palamut' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pala_funfact_icon!'     => '',
					'pala_funfact_icon_type' => 'image_icon',

				],
			]
		);
		$this->add_responsive_control(
			'pala_funfact_icon_image_space',
			[
				'label'     => esc_html__( 'Margin Bottom', 'palamut' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 10,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact .funfact-icon img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->start_controls_tabs(
			'pala_funfact_style_tabs_image'
		);

		$this->start_controls_tab(
			'pala_funfact_style_img_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'palamut' ),
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'pala_funfact_imge_border_group',
				'label'    => esc_html__( 'Border', 'palamut' ),
				'selector' => '{{WRAPPER}} .palamut-funfact .funfact-icon img',
			]
		);
		$this->add_control(
			'pala_funfact_icon_image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'palamut' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .palamut-funfact .funfact-icon img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'pala_funfact_iamge_box_shadow_group',
				'label'    => esc_html__( 'Box Shadow', 'palamut' ),
				'selector' => '{{WRAPPER}} .palamut-funfact .funfact-icon img',
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pala_funfact_style_img_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'palamut' ),
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'pala_funfact_imge_border_hover_group',
				'label'    => esc_html__( 'Border', 'palamut' ),
				'selector' => '{{WRAPPER}} .palamut-funfact .funfact-icon img:hover',
			]
		);
		$this->add_control(
			'pala_funfact_icon_image_hover_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'palamut' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .palamut-funfact .funfact-icon img:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'pala_funfact_image_box_shadow_hv_group',
				'label'    => esc_html__( 'Box Shadow', 'palamut' ),
				'selector' => '{{WRAPPER}} .palamut-funfact .funfact-icon img:hover',
			]
		);

		$this->add_control(
			'pala_funfact_icon_image_hover_animation',
			[
				'label'    => esc_html__( 'Animation', 'palamut' ),
				'type'     => Controls_Manager::HOVER_ANIMATION,
				'selector' => '{{WRAPPER}} .palamut-funfact .funfact-icon img:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// image style section
		// Icon Style Start
		$this->start_controls_section(
			'pala_funfact_section_style_icon',
			[
				'label'     => esc_html__( 'Icon', 'palamut' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pala_funfact_icon!'     => '',
					'pala_funfact_icon_type' => 'icon',

				],
			]
		);

		$this->start_controls_tabs( 'icon_colors' );

		$this->start_controls_tab(
			'pala_funfact_icon_colors_normal',
			[
				'label' => esc_html__( 'Normal', 'palamut' ),
			]
		);

		$this->add_control(
			'pala_funfact_icon_primary_color',
			[
				'label'     => esc_html__( 'Color', 'palamut' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact .palamut-funfact-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pala_funfact_icon_secondary_color_normal',
			[
				'label'     => esc_html__( 'BG Color', 'palamut' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact .palamut-funfact-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'pala_funfact_border_group',
				'label'    => esc_html__( 'Border', 'palamut' ),
				'selector' => '{{WRAPPER}} .palamut-funfact-icon',
			]
		);

		$this->add_control(
			'pala_funfact_icon_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'palamut' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .palamut-funfact .palamut-funfact-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pala_funfact_icon_colors_hover',
			[
				'label' => esc_html__( 'Hover', 'palamut' ),
			]
		);

		$this->add_control(
			'pala_funfact_hover_primary_color',
			[
				'label'     => esc_html__( 'Primary Color', 'palamut' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact:hover .palamut-funfact-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'pala_funfact_hover_secondary_color',
			[
				'label'     => esc_html__( 'Secondary Color', 'palamut' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact:hover .palamut-funfact-icon' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'pala_funfact_border_icon_group',
				'label'     => esc_html__( 'Border', 'palamut' ),
				'selector'  => '{{WRAPPER}} .palamut-funfact:hover .palamut-funfact-icon',
				'condition' => [
					'pala_funfact_view!' => 'Stacked',
				],
			]
		);
		$this->add_control(
			'pala_funfact_icon_hover_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'palamut' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .palamut-funfact:hover .palamut-funfact-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->add_responsive_control(
			'pala_funfact_icon_size',
			[
				'label'     => esc_html__( 'Size', 'palamut' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'default'   => [
					'size' => 40,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
			]
		);
		$this->add_responsive_control(
			'pala_funfact_icon_space',
			[
				'label'     => esc_html__( 'Margin Bottom', 'palamut' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => -20,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 15,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pala_funfact_icon_padding',
			[
				'label'     => esc_html__( 'Padding', 'palamut' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 15,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_control(
			'pala_funfact_rotate',
			[
				'label'     => esc_html__( 'Rotate', 'palamut' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact-icon' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'pala_funfact_icon_box_shadow_group',
				'selector' => '{{WRAPPER}} .palamut-funfact-icon',
			]
		);

		$this->end_controls_section();
		// end icon style section
		// Content style start
		$this->start_controls_section(
			'pala_funfact_section_style_content',
			[
				'label' => esc_html__( 'Content', 'palamut' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pala_funfact_heading_number',
			[
				'label'     => esc_html__( 'Number Count', 'palamut' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'pala_funfact_description_color',
			[
				'label'     => esc_html__( 'Number Color', 'palamut' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact .funfact-content .number-percentage-wraper' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pala_funfact_number_typography',
				'label'    => esc_html__( 'Typography', 'palamut' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .palamut-funfact .funfact-content .number-percentage-wraper',
			]
		);

		$this->add_responsive_control(
			'pala_funfact_number_count_bottom_space',
			[
				'label'     => esc_html__( 'Spacing', 'palamut' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact .funfact-content .number-percentage-wraper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pala_funfact_number_count_right_space',
			[
				'label'     => esc_html__( 'Right Spacing', 'palamut' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact .funfact-content .number-percentage' => 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pala_funfact_heading_title',
			[
				'label'     => esc_html__( 'Title', 'palamut' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'pala_funfact_title_bottom_space',
			[
				'label'     => esc_html__( 'Spacing', 'palamut' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact .funfact-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pala_funfact_title_color',
			[
				'label'     => esc_html__( 'Color', 'palamut' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact .funfact-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pala_funfact_title_typography',
				'selector' => '{{WRAPPER}} .palamut-funfact .funfact-title',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->add_control(
			'pala_funfact_info_box_padding',
			[
				'label'      => esc_html__( 'Padding', 'palamut' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .palamut-funfact ' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default'    => [
					'size' => 15,
					'unit' => 'px',
				],
			]
		);

		$this->end_controls_section();
		// Content style end
		$this->start_controls_section(
			'pala_funfact_super_controls',
			[
				'label'     => esc_html__( 'Super', 'palamut' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pala_funfact_super' => 'yes',
				],
			]
		);

		$this->add_control(
			'pala_funfact_super_color',
			[
				'label'     => esc_html__( 'Number Color', 'palamut' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact .super' => 'color: {{VALUE}};',
				],
				'scheme'    => [
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_3,
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'pala_funfact_super_typography',
				'label'    => esc_html__( 'Typography', 'palamut' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .palamut-funfact .super',
			]
		);

		$this->add_control(
			'pala_funfact_super_position_top',
			[
				'label'      => esc_html__( 'Top', 'palamut' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => -100,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => -5,
				],
				'selectors'  => [
					'{{WRAPPER}} .palamut-funfact .super' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pala_funfact_super_position_left_right',
			[
				'label'      => esc_html__( 'Horizontal space', 'palamut' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => -5,
						'max'  => 20,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 0,
				],
				'selectors'  => [
					'{{WRAPPER}} .palamut-funfact .super' => 'left: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pala_funfact_super_vertical_position',
			[
				'label'                => esc_html__( 'Vertical Position', 'palamut' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'top'    => [
						'title' => esc_html__( 'Top', 'palamut' ),
						'icon'  => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => esc_html__( 'Middle', 'palamut' ),
						'icon'  => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => esc_html__( 'Bottom', 'palamut' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default'              => 'top',
				'selectors_dictionary' => [
					'top'    => 'super',
					'middle' => 'baseline',
					'bottom' => 'sub',
				],
				'selectors'            => [
					'{{WRAPPER}} .palamut-funfact .super' => 'vertical-align: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		// Background style start
		$this->start_controls_section(
			'pala_funfact_section_background_style',
			[
				'label' => esc_html__( 'Background', 'palamut' ),
				'tab'   => controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'pala_funfact_bg',
				'label'    => esc_html__( 'Background', 'palamut' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .palamut-funfact',
			]
		);

		$this->add_responsive_control(
			'pala_funfact_bg_padding',
			[
				'label'      => esc_html__( 'Padding', 'palamut' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .palamut-funfact .palamut-funfact-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'pala_funfact_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'palamut' ),
				'selector' => '{{WRAPPER}} .palamut-funfact',
			]
		);
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'pala_kit_funfact_border',
				'label'    => esc_html__( 'Border', 'palamut' ),
				'selector' => '{{WRAPPER}} .palamut-funfact',
			]
		);

		$this->add_control(
			'pala_funfact_border_radious',
			[
				'label'      => esc_html__( 'Border Radious', 'palamut' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .palamut-funfact' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pala_funfact_box_ainmation',
			[
				'label'        => esc_html__( 'Entrance Animation', 'palamut' ),
				'type'         => Controls_Manager::ANIMATION,
				'prefix_class' => 'animated ',
			]
		);

		$this->add_control(
			'pala_funfact_show_overly',
			[
				'label'        => esc_html__( 'Enable Overly', 'palamut' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'palamut' ),
				'label_off'    => esc_html__( 'No', 'palamut' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);
		$this->add_control(
			'pala_funfact_bg_ovelry_color',
			[
				'label'     => esc_html__( 'Overly Color', 'palamut' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .palamut-funfact .palamut-funfact-overlay' => 'background: {{VALUE}}',
				],
				'condition' => [
					'pala_funfact_show_overly' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'pala_funfact_divider_tab',
			[
				'label'     => esc_html__( 'Devider', 'palamut' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'pala_funfact_enable_vertical_border' => 'yes',
				],
			]
		);

		$this->add_control(
			'pala_funfact_divider_width',
			[
				'label'      => esc_html__( 'Width', 'palamut' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 3,
				],
				'selectors'  => [
					'{{WRAPPER}} .palamut-funfact .vertical-bar' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pala_funfact_divider_height',
			[
				'label'      => esc_html__( 'Height', 'palamut' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'      => [
					'px' => [
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors'  => [
					'{{WRAPPER}} .palamut-funfact .vertical-bar' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'pala_funfact_divider_background',
				'label'    => esc_html__( 'Background', 'palamut' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .palamut-funfact .vertical-bar',
			]
		);

		$this->add_control(
			'pala_funfact_enable_border_verticaly_position',
			[
				'label'   => esc_html__( 'Border Direction', 'palamut' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'position_top'    => [
						'title' => esc_html__( 'From Top', 'palamut' ),
						'icon'  => 'fa fa-caret-up',
					],
					'position_center' => [
						'title' => esc_html__( 'From Center', 'palamut' ),
						'icon'  => 'fa fa-align-center',
					],
					'position_bottom' => [
						'title' => esc_html__( 'From Down', 'palamut' ),
						'icon'  => 'fa fa-caret-down',
					],
				],
				'default' => 'position_center',
				'toggle'  => true,
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		echo '<div class="pala-wid-con" >';
			$this->render_raw();
		echo '</div>';
	}

	protected function render_raw() {
		$settings = $this->get_settings();

		$text_align = $settings['pala_funfact_text_align'];

		$hover_border_bottom_direction = '';
		$vertically_devider_position   = '';
		$divider_funfact               = '';

		$enable_ovelry_color = $modern_design = $enable_border_bottom = '';

		if ( $settings['pala_funfact_show_overly'] == 'yes' ) {
			$enable_ovelry_color = '<div class="elementor-background-overlay palamut-funfact-overlay"></div>';
		}
		if ( $settings['pala_funfact_hover_border_bottom'] == 'yes' ) {
			$enable_border_bottom          = 'style-border-bottom';
			$hover_border_bottom_direction = $settings['pala_funfact_hover_border_bottom_direction'];
		}

		if ( $settings['pala_funfact_enable_vertical_border'] == 'yes' ) {
			$divider_funfact             = 'divider_funfact';
			$vertically_devider_position = $settings['pala_funfact_enable_border_verticaly_position'];
		}

		// info box style
		$this->add_render_attribute( 'funfact_wrapper', 'class', 'palamut-funfact' . ' text-' . $text_align . ' ' . $enable_border_bottom . ' ' . $modern_design . ' ' . $hover_border_bottom_direction . ' ' . $divider_funfact . ' ' . $vertically_devider_position );

		// for image box
		$image_html = '';
		if ( ! empty( $settings['pala_funfact_icon_image']['url'] ) ) {

			$this->add_render_attribute( 'image', 'src', $settings['pala_funfact_icon_image']['url'] );
			$this->add_render_attribute( 'image', 'alt', Control_Media::get_image_alt( $settings['pala_funfact_icon_image'] ) );

			$image_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'pala_funfact_thumbnail', 'pala_funfact_icon_image' );

		}

		// Icon
		if ( ! empty( $settings['pala_funfact_icon'] ) ) {
			$this->add_render_attribute( 'icon', 'class', $settings['pala_funfact_icon'] . ' palamut-funfact-icon' );
			$this->add_render_attribute( 'icon', 'aria-hidden', 'true' );
		}

		?>

		<div <?php echo wp_kses( $this->get_render_attribute_string( 'funfact_wrapper' ), allowed_html() ); ?>>
			<?php if ( $settings['pala_funfact_enable_vertical_border'] == 'yes' ) : ?>
			<div class="vertical-bar <?php echo esc_attr( $settings['pala_funfact_enable_vertical_border_position'] ); ?>"></div>
			<?php endif; ?>
			<div class="palamut-funfact-inner">
				<?php if ( ( $settings['pala_funfact_icon_type'] == 'image_icon' ) || ( $settings['pala_funfact_icon_type'] == 'icon' ) ) : ?>
				<div class="funfact-icon">
					<?php if ( $settings['pala_funfact_icon_type'] == 'image_icon' ) : ?>
						<?php echo $image_html; ?>
					<?php endif; ?>
					<?php if ( $settings['pala_funfact_icon_type'] == 'icon' ) : ?>
						<i <?php echo wp_kses( $this->get_render_attribute_string( 'icon' ), allowed_html() ); ?>></i>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				<div class="funfact-content">
					<div class="number-percentage-wraper">
						<span class="number-percentage" data-value="<?php echo esc_attr( $settings['pala_funfact_number'] ); ?>" data-animation-duration="3500">0</span><?php echo esc_html( $settings['pala_funfact_number_suffix'] ); ?>
						<?php if ( $settings['pala_funfact_super'] == 'yes' ) : ?>
						<span class="super"><?php echo $settings['pala_funfact_super_text']; ?></span>
						<?php endif; ?>
					</div>
					<<?php echo $settings['pala_funfact_title_size']; ?> class="funfact-title"><?php echo esc_html( $settings['pala_funfact_title_text'] ); ?></<?php echo esc_html( $settings['pala_funfact_title_size'] ); ?>>
					<?php echo $enable_ovelry_color ?>
				</div>
			</div>
		</div>


		<?php

	}
	protected function _content_template() { }
}
