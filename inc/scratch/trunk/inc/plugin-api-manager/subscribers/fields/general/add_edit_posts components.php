<?php

function add_edit_field( $field ) {
	
		

				$posts_template = \Elementor\Plugin::$instance->templates_manager->get_source( 'local' )->get_items( [
					'type' => 'post_form',
				] );
		
				$templates_options = ['none' => __( 'Default', 'acf-frontend-form-element' ) ];
		
				foreach ( $posts_template as $template ) {
					$templates_options[ $template['template_id'] ] = esc_html( $template['title'] );
				}
				acf_render_field_setting( $field, array(
					'label'			=> __('Post Form Template'),
					'name'			=> 'post_form_template',
					'instructions'  => '<div>' . sprintf( __( 'Select one or go ahead and <a target="_blank" href="%s">create one</a> now.', 'elementor' ), admin_url( 'edit.php?post_type=elementor_library&tabs_group=library&elementor_library_type=post_form' ) ) . '</div>',
					'type'			=> 'select',
					'choices'		=> $templates_options,
					'ui'			=> 1,
					'conditions'	=> [
						[
							'field'		=> 'add_edit_post',
							'operator'	=> '==',
							'value'		=> '1'
						]
					]
				) ); 
			
		}

/** Template Manager */
	
/**
	 * Registered template sources.
	 *
	 * Holds a list of all the supported sources with their instances.
	 *
	 * @access protected
	 *
	 * @var Source_Base[]
	 */
	protected $_registered_sources = [];

/**
	 * Register template source.
	 *
	 * Used to register new template sources displayed in the template library.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $source_class The name of source class.
	 * @param array  $args         Optional. Class arguments. Default is an
	 *                             empty array.
	 *
	 * @return \WP_Error|true True if the source was registered, `WP_Error`
	 *                        otherwise.
	 */
	public function register_source( $source_class, $args = [] ) {
		if ( ! class_exists( $source_class ) ) {
			return new \WP_Error( 'source_class_name_not_exists' );
		}

		$source_instance = new $source_class( $args );

		if ( ! $source_instance instanceof Source_Base ) {
			return new \WP_Error( 'wrong_instance_source' );
		}

		$source_id = $source_instance->get_id();

		if ( isset( $this->_registered_sources[ $source_id ] ) ) {
			return new \WP_Error( 'source_exists' );
		}

		$this->_registered_sources[ $source_id ] = $source_instance;

		return true;
	}



	/**
	 * Get registered template sources.
	 *
	 * Retrieve registered template sources.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return Source_Base[] Registered template sources.
	 */
	public function get_registered_sources() {
		return $this->_registered_sources;
	}


/**
	 * Get template source.
	 *
	 * Retrieve single template sources for a given template ID.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $id The source ID.
	 *
	 * @return false|Source_Base Template sources if one exist, False otherwise.
	 */
	public function get_source( $id ) {
		$sources = $this->get_registered_sources();

		if ( ! isset( $sources[ $id ] ) ) {
			return false;
		}

		return $sources[ $id ];
	}

/** End of template manager */

const CPT = 'elementor_library';
const TYPE_META_KEY = '_elementor_template_type';

/**
	 * Get local template.
	 *
	 * Retrieve a single local template saved by the user on his site.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param int $template_id The template ID.
	 *
	 * @return array Local template.
	 */

	public function get_item( $template_id ) {
		$post = get_post( $template_id );

		$user = get_user_by( 'id', $post->post_author );

		$page = SettingsManager::get_settings_managers( 'page' )->get_model( $template_id );

		$page_settings = $page->get_data( 'settings' );

		$date = strtotime( $post->post_date );

		$data = [
			'template_id' => $post->ID,
			'source' => $this->get_id(),
			'type' => self::get_template_type( $post->ID ),
			'title' => $post->post_title,
			'thumbnail' => get_the_post_thumbnail_url( $post ),
			'date' => $date,
			'human_date' => date_i18n( get_option( 'date_format' ), $date ),
			'human_modified_date' => date_i18n( get_option( 'date_format' ), strtotime( $post->post_modified ) ),
			'author' => $user->display_name,
			'status' => $post->post_status,
			'hasPageSettings' => ! empty( $page_settings ),
			'tags' => [],
			'export_link' => $this->get_export_link( $template_id ),
			'url' => get_permalink( $post->ID ),
		];

		/**
		 * Get template library template.
		 *
		 * Filters the template data when retrieving a single template from the
		 * template library.
		 *
		 * @since 1.0.0
		 *
		 * @param array $data Template data.
		 */
		$data = apply_filters( 'elementor/template-library/get_template', $data );

		return $data;
	}

/**
	 * Get local templates.
	 *
	 * Retrieve local templates saved by the user on his site.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param array $args Optional. Filter templates based on a set of
	 *                    arguments. Default is an empty array.
	 *
	 * @return array Local templates.
	 */
	public function get_items( $args = [] ) {
		$template_types = array_values( self::$template_types );

		if ( ! empty( $args['type'] ) ) {
			$template_types = $args['type'];
			unset( $args['type'] );
		}

		$defaults = [
			'post_type' => self::CPT,
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'meta_query' => [
				[
					'key' => Document::TYPE_META_KEY,
					'value' => $template_types,
				],
			],
		];

		$query_args = wp_parse_args( $args, $defaults );

		$templates_query = new \WP_Query( $query_args );

		$templates = [];

		if ( $templates_query->have_posts() ) {
			foreach ( $templates_query->get_posts() as $post ) {
				$templates[] = $this->get_item( $post->ID );
			}
		}

		return $templates;
	}



function register_data() {
		$labels = [
			'name' => _x( 'My Templates', 'Template Library', 'elementor' ),
			'singular_name' => _x( 'Template', 'Template Library', 'elementor' ),
			'add_new' => _x( 'Add New', 'Template Library', 'elementor' ),
			'add_new_item' => _x( 'Add New Template', 'Template Library', 'elementor' ),
			'edit_item' => _x( 'Edit Template', 'Template Library', 'elementor' ),
			'new_item' => _x( 'New Template', 'Template Library', 'elementor' ),
			'all_items' => _x( 'All Templates', 'Template Library', 'elementor' ),
			'view_item' => _x( 'View Template', 'Template Library', 'elementor' ),
			'search_items' => _x( 'Search Template', 'Template Library', 'elementor' ),
			'not_found' => _x( 'No Templates found', 'Template Library', 'elementor' ),
			'not_found_in_trash' => _x( 'No Templates found in Trash', 'Template Library', 'elementor' ),
			'parent_item_colon' => '',
			'menu_name' => _x( 'Templates', 'Template Library', 'elementor' ),
		];

		$args = [
			'labels' => $labels,
			'public' => true,
			'rewrite' => false,
			'menu_icon' => 'dashicons-admin-page',
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => false,
			'exclude_from_search' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'supports' => [ 'title', 'thumbnail', 'author', 'elementor' ],
		];

		/**
		 * Register template library post type args.
		 *
		 * Filters the post type arguments when registering elementor template library post type.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Arguments for registering a post type.
		 */
		$args = apply_filters( 'elementor/template_library/sources/local/register_post_type_args', $args );

		$this->post_type_object = register_post_type( self::CPT, $args );

		$args = [
			'hierarchical' => false,
			'show_ui' => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'query_var' => is_admin(),
			'rewrite' => false,
			'public' => false,
			'label' => _x( 'Type', 'Template Library', 'elementor' ),
		];

		/**
		 * Register template library taxonomy args.
		 *
		 * Filters the taxonomy arguments when registering elementor template library taxonomy.
		 *
		 * @since 1.0.0
		 *
		 * @param array $args Arguments for registering a taxonomy.
		 */
		$args = apply_filters( 'elementor/template_library/sources/local/register_taxonomy_args', $args );

		$cpts_to_associate = apply_filters( 'elementor/template_library/sources/local/register_taxonomy_cpts', [ self::CPT ] );

		register_taxonomy( self::TAXONOMY_TYPE_SLUG, $cpts_to_associate, $args );

		/**
		 * Categories
		 */
		$args = [
			'hierarchical' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'query_var' => is_admin(),
			'rewrite' => false,
			'public' => false,
			'labels' => [
				'name' => _x( 'Categories', 'Template Library', 'elementor' ),
				'singular_name' => _x( 'Category', 'Template Library', 'elementor' ),
				'all_items' => _x( 'All Categories', 'Template Library', 'elementor' ),
			],
		];

		/**
		 * Register template library category args.
		 *
		 * Filters the category arguments when registering elementor template library category.
		 *
		 * @since 2.4.0
		 *
		 * @param array $args Arguments for registering a category.
		 */
		$args = apply_filters( 'elementor/template_library/sources/local/register_category_args', $args );

		register_taxonomy( self::TAXONOMY_CATEGORY_SLUG, self::CPT, $args );
	}







/**
	 * On template save.
	 *
	 * Run this method when template is being saved.
	 *
	 * Fired by `save_post` action.
	 *
	 * @since 1.0.1
	 * @access public
	 *
	 * @param int      $post_id Post ID.
	 * @param \WP_Post $post    The current post object.
	 */
	public function on_save_post( $post_id, WP_Post $post ) {
		if ( self::CPT !== $post->post_type ) {
			return;
		}

		if ( self::get_template_type( $post_id ) ) { // It's already with a type
			return;
		}

		/*// Don't save type on import, the importer will do it.
		if ( did_action( 'import_start' ) ) {
			return;
		} */

		$this->save_item_type( $post_id, 'page' );
	}

	/**
	 * Save item type.
	 *
	 * When saving/updating templates, this method is used to update the post
	 * meta data and the taxonomy.
	 *
	 * @since 1.0.1
	 * @access private
	 *
	 * @param int    $post_id Post ID.
	 * @param string $type    Item type.
	 */
	private function save_item_type( $post_id, $type ) {
		update_post_meta( $post_id, Document::TYPE_META_KEY, $type );

		wp_set_object_terms( $post_id, $type, self::TAXONOMY_TYPE_SLUG );
	}


