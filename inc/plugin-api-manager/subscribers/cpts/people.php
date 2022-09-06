<?php
/**
	 * Post Type: People.
	 */

	
	
	
$labels = [
		'name'                  => _x( 'Person', 'Post type general name', 'recipe' ),
        'singular_name'         => _x( 'Person', 'Post type singular name', 'recipe' ),
        'menu_name'             => _x( 'People', 'Admin Menu text', 'recipe' ),
        'name_admin_bar'        => _x( 'Person', 'Add New on Toolbar', 'recipe' ),
        'add_new'               => __( 'Add Person', 'recipe' ),
        'add_new_item'          => __( 'Add Person to Family Tree', 'recipe' ),
        'new_item'              => __( 'New Person', 'recipe' ),
        'edit_item'             => __( 'Edit Person', 'recipe' ),
        'view_item'             => __( 'View Person', 'recipe' ),
        'all_items'             => __( 'All People', 'recipe' ),
        'search_items'          => __( 'Search People', 'recipe' ),
        'parent_item_colon'     => __( 'Parent Person:', 'recipe' ),
        'not_found'             => __( 'No people found.', 'recipe' ),
        'not_found_in_trash'    => __( 'No people found in Trash.', 'recipe' ),
        'featured_image'        => _x( 'Person Profile Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'recipe' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'recipe' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'recipe' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'recipe' ),
        'archives'              => _x( 'People archive', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'recipe' ),
        'insert_into_item'      => _x( 'Insert into recipe', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'recipe' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this recipe', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'recipe' ),
        'filter_items_list'     => _x( 'Filter recipes list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'recipe' ),
        'items_list_navigation' => _x( 'Recipes list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'recipe' ),
        'items_list'            => _x( 'Recipes list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'recipe' ),
	];

	$args = [
		"label" => __( "People", "hello-elementor" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => 'people',
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => true,
		"rewrite" => [ "slug" => "person", "with_front" => true ],
		"query_var" => true,
		"supports" => [  "thumbnail","title","custom-fields" ],
		"show_in_graphql" => false,
		"menu_icon" => "dashicons-groups",
	];

	register_post_type( "person", $args );	
	
	

	