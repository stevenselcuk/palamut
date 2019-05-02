<?php
/**
 * { Document title }
 *
 * { Document descriptions will be add. }
 *
 * @link to be defined
 *
 * @package pdwname
 *
 * @subpackage Template Functions
 * @category Theme Framework
 *
 * @version pdwversion
 * @since 1.0.1
 *
 * @author pdwauthor
 * @copyright pdwcopyright
 * @license pdwlicense
 */

/**
 * [Palamut_Templater description]
 */
class Palamut_Templater {

	/**
	 * [private description]
	 *
	 * @var [type]
	 */
	private static $instance;

	/**
	 * [protected description]
	 *
	 * @var [type]
	 */
	protected $templates;

	/**
	 * Returns an instance of this class.
	 */
	public static function get_instance() {
		if ( null == self::$instance ) {
			self::$instance = new Palamut_Templater();
		}
		return self::$instance;
	}


	/**
	 * [__construct description]
	 *
	 * @method __construct
	 *
	 * @since
	 *
	 * @link
	 *
	 * @see
	 */
	private function __construct() {
		$this->templates = array();

		if ( version_compare( floatval( get_bloginfo( 'version' ) ), '4.7', '<' ) ) {

			add_filter(
				'page_attributes_dropdown_pages_args',
				array( $this, 'register_project_templates' )
			);
		} else {

			add_filter(
				'theme_page_templates',
				array( $this, 'add_new_template' )
			);
		}

		add_filter(
			'wp_insert_post_data',
			array( $this, 'register_project_templates' )
		);

		add_filter(
			'template_include',
			array( $this, 'view_project_template' )
		);
		$this->templates = array(
			plugin_dir_path( dirname( __FILE__ ) ) . '/includes/templates/blog-page.php' => 'Blog Page',
		);
	}

	/**
	 * [add_new_template description]
	 *
	 * @method add_new_template
	 *
	 * @since
	 *
	 * @link
	 *
	 * @see
	 *
	 * @param  [type]           $posts_templates
	 */
	public function add_new_template( $posts_templates ) {
		$posts_templates = array_merge( $posts_templates, $this->templates );
		return $posts_templates;
	}

	/**
	 * [register_project_templates description]
	 *
	 * @method register_project_templates
	 *
	 * @since
	 *
	 * @link
	 *
	 * @see
	 *
	 * @param  [type]                     $atts
	 *
	 * @return [type]
	 */
	public function register_project_templates( $atts ) {

		$cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );

		$templates = wp_get_theme()->get_page_templates();
		if ( empty( $templates ) ) {
			$templates = array();
		}

		wp_cache_delete( $cache_key, 'themes' );

		$templates = array_merge( $templates, $this->templates );

		wp_cache_add( $cache_key, $templates, 'themes', 1800 );
		return $atts;
	}

	/**
	 * [view_project_template description]
	 *
	 * @method view_project_template
	 *
	 * @since
	 *
	 * @link
	 *
	 * @see
	 *
	 * @param  [type]                $template
	 *
	 * @return [type]
	 */
	public function view_project_template( $template ) {

		if ( is_search() ) {
			return $template;
		}

		global $post;

		if ( ! $post ) {
			return $template;
		}

		if ( ! isset(
			$this->templates[ get_post_meta(
				$post->ID,
				'_wp_page_template',
				true
			) ]
		) ) {
			return $template;
		}

		$filepath = apply_filters( 'page_templater_plugin_dir_path', plugin_dir_path( __FILE__ ) );
		$file     = $filepath . get_post_meta(
			$post->ID,
			'_wp_page_template',
			true
		);

		if ( file_exists( $file ) ) {
			return $file;
		} else {
			echo $file;
		}

		return $template;
	}
}
add_action( 'plugins_loaded', array( 'Palamut_Templater', 'get_instance' ) );
