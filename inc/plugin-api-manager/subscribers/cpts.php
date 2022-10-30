<?php


if ( !class_exists( 'CustomPostTypesSubscriber' ) ):

  class CustomPostTypesSubscriber
implements SubscriberInterface {

  /**
   * @var string
   */
  public $version = '1.5.0';

  /* * * * * * * * * *
   * Class constructor
   * * * * * * * * * */
  public function __construct() {

    //$this->includes();

  }

  public static function get_subscribed_hooks() {
    return [
      //'init' => '_includes',
      'init' =>['cptui_register_my_cpts',25] ,
      // 'wp_loaded' => 'cptui_custom_taxonomies',
      'wp_loaded' => ['cptui_register_my_taxonomies',25], 
     // 'wp_loaded' =>'archive_importer_init',
    ];
  }
   function archive_importer_init() {
	//load_plugin_textdomain( 'wordpress-importer' );

	/**
	 * WordPress Importer object for registering the import callback
	 * @global WP_Import $wp_import
	 */
	$archive_import = new Archive_Import();
		  	 $import_check = get_option( 'import-check' );
    if ( $import_check != 'done' ):
      $file = get_template_directory() . '/inc/starter-content/starter-content.xml';
	$archive_import->import($file);
		      update_option( 'import-check', 'done' );
    endif;
   }
  public function _includes() {

  }

  public function cptui_custom_taxonomies() {
    // register_taxonomy_for_object_type( 'category', 'person' );
    // register_taxonomy_for_object_type( 'post_tag', 'person' );
    register_taxonomy_for_object_type( 'category', 'event' );
    register_taxonomy_for_object_type( 'post_tag', 'event' );
  }

  public function cptui_register_my_taxonomies() {


    /**
     * Taxonomy: Occupations.
     */

    $labels = [
      "name" => __( "Occupations", "hello-elementor" ),
      "singular_name" => __( "Occupation", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Occupations", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'occupation', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "occupation",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => true,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "occupation", [ "person" ], $args );

    /**
     * Taxonomy: Causes of Death.
     */

    $labels = [
      "name" => __( "Causes of Death", "hello-elementor" ),
      "singular_name" => __( "Cause of Death", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Causes of Death", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'cause_of_death', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "cause_of_death",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "cause_of_death", [ "person"], $args );

    /**
     * Taxonomy: Document Types.
     */

    $labels = [
      "name" => __( "Document Types", "hello-elementor" ),
      "singular_name" => __( "Document Type", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Document Types", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'document_type', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "document_type",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "document_type", [ "document" ], $args );

    /**
     * Taxonomy: Types of Ephemera.
     */

    $labels = [
      "name" => __( "Types of Ephemera", "hello-elementor" ),
      "singular_name" => __( "Type of Ephemera", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Types of Ephemera", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'ephemera_type', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "ephemera_type",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "ephemera_type", [ "ephemera" ], $args );

    /**
     * Taxonomy: Topics.
     */

    $labels = [
      "name" => __( "Topics", "hello-elementor" ),
      "singular_name" => __( "Topic", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Topics", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'topic', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "topic",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "topic", [ "post", "letter", "photo", "article", "story", "person", "audio", "video", "document", "collection", "ephemera", "task", "text", "bookmark" ], $args );

    /**
     * Taxonomy: Generations.
     */

    $labels = [
      "name" => __( "Generations", "hello-elementor" ),
      "singular_name" => __( "Generation", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Generations", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'generation', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "generation",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => true,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "generation", [ "person" ], $args );

    /**
     * Taxonomy: Lineages.
     */

    $labels = [
      "name" => __( "Lineages", "hello-elementor" ),
      "singular_name" => __( "Lineage", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Lineages", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'lineage', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "lineage",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => true,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "lineage", [ "person" ], $args );

    /**
     * Taxonomy: Genders.
     */

    $labels = [
      "name" => __( "Genders", "hello-elementor" ),
      "singular_name" => __( "Gender", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Genders", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'gender', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "gender",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "gender", [ "person" ], $args );
    wp_insert_term( 'Male', 'gender' );
    wp_insert_term( 'Female', 'gender' );
    wp_insert_term( 'Trans', 'gender' );

	   /**
     * Taxonomy:Status.
     */

    $labels = [
      "name" => __( "Status", "hello-elementor" ),
      "singular_name" => __( "Status", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Status", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'status', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "gender",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "status", [ "person" ], $args );
    wp_insert_term( 'Living', 'status' );
    wp_insert_term( 'Deceased', 'status' );



    /**
     * Taxonomy: Types of School.
     */

    $labels = [
      "name" => __( "Types of School", "hello-elementor" ),
      "singular_name" => __( "Type of School", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Types of School", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'school_type', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "school_type",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "school_type", [ "place" ], $args );

    /**
     * Taxonomy: Courses of Study.
     */

    $labels = [
      "name" => __( "Courses of Study", "hello-elementor" ),
      "singular_name" => __( "Course of Study", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Courses of Study", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'course_of_study', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "course_of_study",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "course_of_study", [ "event" ], $args );

    /**
     * Taxonomy: Degrees.
     */

    $labels = [
      "name" => __( "Degrees", "hello-elementor" ),
      "singular_name" => __( "Degree", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Degrees", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'degree', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "degree",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "degree", [ "event" ], $args );

    /**
     * Taxonomy: Types of Business.
     */

    $labels = [
      "name" => __( "Types of Business", "hello-elementor" ),
      "singular_name" => __( "Type of Business", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Types of Business", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'business_type', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "business_type",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "business_type", [ "place" ], $args );

    /**
     * Taxonomy: Types of Worship.
     */

    $labels = [
      "name" => __( "Types of Worship", "hello-elementor" ),
      "singular_name" => __( "Type of Worship", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Types of Worship", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'worship_type', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "worship_type",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "worship_type", [ "place" ], $args );

    /**
     * Taxonomy: Privacy Levels.
     */

    $labels = [
      "name" => __( "Privacy Levels", "hello-elementor" ),
      "singular_name" => __( "Privacy Level", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Privacy Levels", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'privacy_level', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "privacy_level",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "privacy_level", [ "letter", "photo", "article", "story", "person", "audio", "video", "photo_album", "event", "document", "collection", "ephemera", "text", "bookmark", "object" ], $args );

    wp_insert_term( 'Private', 'privacy_level' );

    wp_insert_term( 'Public', 'privacy_level' );
  wp_insert_term( 'Family', 'privacy_level' );

    /**
     * Taxonomy: Branches of Military.
     */

    $labels = [
      "name" => __( "Branches of Military", "hello-elementor" ),
      "singular_name" => __( "Branch of Military", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Branches of Military", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'military_branch', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "military_branch",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "military_branch", [ "person",], $args );

    /**
     * Taxonomy: Photographers.
     */

    $labels = [
      "name" => __( "Photographers", "hello-elementor" ),
      "singular_name" => __( "Photographer", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Photographers", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'photographer', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "photographer",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "photographer", [ "photo", "photo_studio", "photo_album" ], $args );

    /**
     * Taxonomy: Text Authors.
     */

    $labels = [
      "name" => __( "Text Authors", "hello-elementor" ),
      "singular_name" => __( "Text Author", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Text Authors", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'text_author', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "text_author",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "text_author", [ "text" ], $args );

    /**
     * Taxonomy: Types of Place.
     */

    $labels = [
      "name" => __( "Types of Place", "hello-elementor" ),
      "singular_name" => __( "Type of Place", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Types of Place", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'place_type', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "place_type",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "place_type", [ "place" ], $args );

	  /**
     * Taxonomy: Status Types.
     */

    $labels = [
      "name" => __( " Task Status", "hello-elementor" ),
      "singular_name" => __( "Status", "hello-elementor" ),
    ];


    $args = [
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => false,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'status', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "task_status",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "task_status", [ "task" ], $args );  
	  
	  $tasks=['To Do','In Progress','Completed'];
	  
	  foreach ($tasks as $task):
	  wp_insert_term($task,'task_status');
	  endforeach;
	  
	   /**
     * Taxonomy: Task Types.
     */

    $labels = [
      "name" => __( " Task Types", "hello-elementor" ),
      "singular_name" => __( "Task Type", "hello-elementor" ),
    ];


    $args = [
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => false,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'type', 'with_front' => true, ],
      "show_admin_column" => true,
      "show_in_rest" => true,
      "rest_base" => "task_type",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "task_type", [ "task" ], $args ); 
	  
	  
	  $taskTypes=['Research','Lookup','Contact','Transcribe','Scan','Edit'];
	  
	  foreach ($taskTypes as $type):
	  wp_insert_term($type,'task_type');
	  endforeach;
    /**
     * Taxonomy: Event Types.
     */

    $labels = [
      "name" => __( "Event Types", "hello-elementor" ),
      "singular_name" => __( "Event Type", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Event Types", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => true,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'event_type', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "event_type",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "event_type", [ "event" ], $args );
	  
	  $event_types=['Baptism','Birth','Confirmation','Death','Funeral','Graduation','Relocation','Military Service','Primary Birth','Primary 
	  Death','Vacation','Other','Work','Special Occasion','Religious'];
	  foreach ($event_types as $event):
	   wp_insert_term($event,'event_type');
	  endforeach;
	 

    /**
     * Taxonomy: Source Types.
     */

    $labels = [
      "name" => __( "Source Types", "hello-elementor" ),
      "singular_name" => __( "Source Type", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Source Types", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => true,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'source_type', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "source_type",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => false,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "source_type", [ "source" ], $args );

	
    $labels = [
      "name" => __( "Bookmark Types", "hello-elementor" ),
      "singular_name" => __( "Bookmark Type", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Bookmark Types", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => true,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'bookmark_type', 'with_front' => true, ],
      "show_admin_column" => true,
      "show_in_rest" => true,
      "rest_base" => "bookmark_type",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => true,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "bookmark_type", [ "bookmark" ], $args );
	  
  $bookmarks=['Historical Society','Research Website,Genealogy', 'Blog','Database','Library','Museum','Misc Website','Document','Original Source','Family Tree','Ancestry Profile','Find A Grave Profile','Family Search Profile','Fold3 Profile','Facebook Page','Facebook Group','Social Media Post','Place to Visit'];
	  
	  foreach($bookmarks as $bookmark):
	  wp_insert_term($bookmark,'bookmark_type');
	  endforeach;
	  
	  
    /**
     * Taxonomy: Person Tags.
     */

    $labels = [
      "name" => __( "Person Tags", "hello-elementor" ),
      "singular_name" => __( "Person Tag", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Person Tags", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'person_tags', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "person_tags",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => true,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "person_tags", [ "person" ], $args );

    /**
     * Taxonomy: Relations.
     */

    $labels = [
      "name" => __( "Relations", "hello-elementor" ),
      "singular_name" => __( "Relation to Base Person", "hello-elementor" ),
    ];


    $args = [
      "label" => __( "Relations", "hello-elementor" ),
      "labels" => $labels,
      "public" => true,
      "publicly_queryable" => true,
      "hierarchical" => false,
      "show_ui" => true,
      "show_in_menu" => true,
      "show_in_nav_menus" => true,
      "query_var" => true,
      "rewrite" => [ 'slug' => 'relation', 'with_front' => true, ],
      "show_admin_column" => false,
      "show_in_rest" => true,
      "rest_base" => "relation",
      "rest_controller_class" => "WP_REST_Terms_Controller",
      "show_in_quick_edit" => true,
      "show_in_graphql" => false,
    ];
    register_taxonomy( "relation", [ "person" ], $args );

    flush_rewrite_rules();
  }

  public function cptui_register_my_cpts() {


    include_once( 'cpts\people.php' );
    include_once( 'cpts\events.php' );
    include_once( 'cpts\places.php' );
	include_once( 'cpts\cities.php' );

    //materials
    include_once( 'cpts\photos.php' );
    include_once( 'cpts\letters.php' );
    include_once( 'cpts\articles.php' );
    include_once( 'cpts\audio-recordings.php' );
    include_once( 'cpts\texts.php' );
    include_once( 'cpts\ephemera.php' );
    include_once( 'cpts\objects.php' );
    include_once( 'cpts\stories.php' );

    //Research
    include_once( 'cpts\documents.php' );
    include_once( 'cpts\bookmarks.php' );
    include_once( 'cpts\tasks.php' );
    include_once( 'cpts\sources.php' );
    include_once( 'cpts\citations.php' );
    //Organizations

    include_once( 'cpts\locations.php' );
    include_once( 'cpts\collections.php' );
    include_once( 'cpts\photo-albums.php' );

    include_once( 'cpts\updates.php' );

    include_once( 'cpts\contact-forms.php' );
  }


  public function my_rewrite_flush() {

    flush_rewrite_rules();
  }

  /**
   * Load CPTs
   *
   * @since 1.0.0
   * @version 1.0.2
   */

  public static function Load() {

    new self();
  }


} // End Of Class.
endif;