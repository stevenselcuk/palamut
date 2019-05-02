<?php
/**
 * Post Grid for Elementor
 *
 * Widget for Elementor
 *
 * @link https://developers.elementor.com/creating-a-new-widget/
 *
 * @package Palamut
 *
 * @subpackage Elementor Widgets
 * @category Theme Features
 *
 * @version pdwversion
 * @since 1.0.1
 *
 * @author pdwauthor
 * @copyright pdwcopyright
 * @license pdwlicense
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * [Widget_Palamut_grid_posts description]
 */
class Widget_Palamut_Grid_Posts extends Widget_Base {

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
		return __( 'Grid posts', 'palamut' );
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
		return [ 'palamut' ];
	}
	/**
	 * Register Widget Controls
	 *
	 * @method _register_controls
	 *
	 * @since 1.0.1
	 *
	 * @link https://developers.elementor.com/creating-a-new-widget/
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'section_grid_posts',
			[
				'label' => esc_html__( 'Grid Posts', 'palamut' ),
			]
		);

		$this->add_control(
			'num',
			[
				'label'       => esc_html__( 'Posts count', 'palamut' ),
				'description' => esc_html__( 'Enter number of posts to display (Note: Enter -1 to display all posts).', 'palamut' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '6',
			]
		);

		$this->add_control(
			'columns',
			[
				'label'       => esc_html__( 'Posts per row', 'palamut' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select posts count per row.', 'palamut' ),
				'options'     => [
					'span6'     => esc_html__( 'Two', 'palamut' ),
					'span4'     => esc_html__( 'Three', 'palamut' ),
					'span3'     => esc_html__( 'Four', 'palamut' ),
					'one_fifth' => esc_html__( 'Five', 'palamut' ),
					'span2'     => esc_html__( 'Six', 'palamut' ),
				],
				'default'     => 'span4',
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'       => esc_html__( 'Order by', 'palamut' ),
				'type'        => Controls_Manager::SELECT,
				'description' => esc_html__( 'Select how to sort retrieved posts.', 'palamut' ),
				'options'     => [
					'date'          => esc_html__( 'Date', 'palamut' ),
					'modified'      => esc_html__( 'Last modified date', 'palamut' ),
					'comment_count' => esc_html__( 'Popularity', 'palamut' ),
					'title'         => esc_html__( 'Title', 'palamut' ),
					'rand'          => esc_html__( 'Random', 'palamut' ),
					'post__in'      => esc_html__( 'Preserve post ID order', 'palamut' ),
				],
				'default'     => 'date',
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Posts Order', 'palamut' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => [
					'DESC' => [
						'title' => esc_html__( 'descending', 'palamut' ),
						'icon'  => 'fa fa-sort-amount-desc',
					],
					'ASC'  => [
						'title' => esc_html__( 'ascending', 'palamut' ),
						'icon'  => 'fa fa-sort-amount-asc',
					],
				],
				'default' => 'DESC',
			]
		);
		$this->add_control(
			'cat_slug',
			[
				'label'       => esc_html__( 'Category slug', 'palamut' ),
				'description' => esc_html__( 'This help you to retrieve items from specific category. More than one separate by commas.', 'palamut' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			]
		);

		$this->add_control(
			'post_ids',
			[
				'label'       => esc_html__( 'Post IDs', 'palamut' ),
				'description' => esc_html__( 'Enter posts IDs to display only those records (Note: separate values by commas (,)).', 'palamut' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
			]
		);
		$this->add_control(
			'post_style',
			[
				'label'   => __( 'Post Style', 'palamut' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'style_2' => __( 'Boxed', 'palamut' ),
					'style_1' => __( 'Simple', 'palamut' ),
				],
				'default' => 'style_1',
			]
		);
		$image_sizes   = get_intermediate_image_sizes();
		$image_sizes[] = 'full';
		$image_sizes   = array_combine( $image_sizes, $image_sizes );
		$this->add_control(
			'thumbsize',
			[
				'label'       => __( 'Image size', 'palamut' ),
				'type'        => Controls_Manager::SELECT,
				'description' => __( 'Select your image size to use in post.', 'palamut' ),
				'options'     => $image_sizes,
				'default'     => 'medium',
			]
		);
		$this->add_control(
			'excerpt_count',
			[
				'label'       => esc_html__( 'Post excerpt count', 'palamut' ),
				'description' => esc_html__( 'Enter number of words in post excerpt.', 'palamut' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '17',
			]
		);
		$this->add_control(
			'show_categories',
			[
				'label'   => __( 'Show meta categories?', 'palamut' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'true'  => __( 'Show', 'palamut' ),
					'false' => __( 'Hide', 'palamut' ),
				],
				'default' => 'true',
			]
		);
		$this->add_control(
			'show_sharebox',
			[
				'label'   => esc_html__( 'Show share icons', 'palamut' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'true'  => esc_html__( 'Yes', 'palamut' ),
					'false' => esc_html__( 'No', 'palamut' ),
				],
				'default' => 'true',
			]
		);
		$this->add_control(
			'pagination',
			[
				'label'   => esc_html__( 'Pagination', 'palamut' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'true'  => esc_html__( 'Enable', 'palamut' ),
					'false' => esc_html__( 'Disable', 'palamut' ),
				],
				'default' => 'false',
			]
		);
		$this->add_control(
			'ignore_featured',
			[
				'label'       => esc_html__( 'Disable featured posts style', 'palamut' ),
				'description' => esc_html__( 'Disable style for featured posts. Do not highlight them.', 'palamut' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'true'  => esc_html__( 'Enable', 'palamut' ),
					'false' => esc_html__( 'Disable', 'palamut' ),
				],
				'default'     => 'true',
			]
		);
		$this->add_control(
			'ignore_sticky_posts',
			[
				'label'       => esc_html__( 'Ignore sticky posts', 'palamut' ),
				'description' => esc_html__( 'Show sticky posts?', 'palamut' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => [
					'true'  => esc_html__( 'Enable', 'palamut' ),
					'false' => esc_html__( 'Disable', 'palamut' ),
				],
				'default'     => 'true',
			]
		);
		$this->end_controls_section();
	}
	/**
	 * Render Widget
	 *
	 * @method render
	 *
	 * @since 1.0.1
	 *
	 * @link https://developers.elementor.com/creating-a-new-widget/
	 *
	 * @param  array $instance Widget.
	 */
	protected function render( $instance = [] ) {
		$settings = $this->get_settings();

		extract(
			shortcode_atts(
				array(
					'num'                 => '6',
					'columns'             => 'span4',
					'post_style'          => 'style_1',
					'orderby'             => 'date',
					'order'               => 'DESC',
					'cat_slug'            => '',
					'post_ids'            => '',
					'pagination'          => 'false',
					'thumbsize'           => 'medium',
					'excerpt_count'       => '21',
					'show_sharebox'       => 'true',
					'ignore_featured'     => 'true',
					'ignore_sticky_posts' => 'true',
					'show_categories'=> 'true',
				),
				$settings
			)
		);

		echo do_shortcode( '[gridposts num="' . $num . '" columns="' . $columns . '" post_style="' . $post_style . '" orderby="' . $orderby . '" order="' . $order . '" cat_slug="' . $cat_slug . '" post_ids="' . $post_ids . '" pagination="' . $pagination . '" thumbsize="' . $thumbsize . '" show_categories="' . $show_categories . '" show_sharebox="' . $show_sharebox . '" excerpt_count="' . $excerpt_count . '" ignore_featured="' . $ignore_featured . '" ignore_sticky_posts="' . $ignore_sticky_posts . '"]' );
	}
}
