<?php

	/**
	 * Post Type: Photo Albums.
	 */

	$labels = [
		'name'                  => _x( 'Photo Album', 'Post type general name', 'recipe' ),
        'singular_name'         => _x( 'Photo Album', 'Post type singular name', 'recipe' ),
        'menu_name'             => _x( 'Photo Album', 'Admin Menu text', 'recipe' ),
        'name_admin_bar'        => _x( 'Photo Album', 'Add New on Toolbar', 'recipe' ),
        'add_new'               => __( 'Add New Photo Album', 'recipe' ),
        'add_new_item'          => __( 'Add Photo Album', 'recipe' ),
        'new_item'              => __( 'New Album', 'recipe' ),
        'edit_item'             => __( 'Edit Photo Album', 'recipe' ),
        'view_item'             => __( 'View Photo Album', 'recipe' ),
        'all_items'             => __( 'Photo Albums', 'recipe' ),
        'search_items'          => __( 'Search Photo Albums', 'recipe' ),
        'parent_item_colon'     => __( 'Parent Person:', 'recipe' ),
        'not_found'             => __( 'No photo albums found.', 'recipe' ),
        'not_found_in_trash'    => __( 'No photo albums found in Trash.', 'recipe' ),
        'featured_image'        => _x( 'Photo Album Cover', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'recipe' ),
        'set_featured_image'    => _x( 'Set photo album cover', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'recipe' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'recipe' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'recipe' ),
        'archives'              => _x( 'Photo Album archive', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'recipe' ),
        'insert_into_item'      => _x( 'Insert into photo album', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'recipe' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this photo album', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'recipe' ),
        'filter_items_list'     => _x( 'Filter photo album list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'recipe' ),
        'items_list_navigation' => _x( 'Photo Album list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'recipe' ),
        'items_list'            => _x( 'Photo Album list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'recipe' ),
	];

	$args = [
		"label" => __( "Photo Albums", "hello-elementor" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => "photo-albums",
		"show_in_menu" => 'materials',
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "photo-album", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "thumbnail", "comments","title","custom-fields" ],
		"show_in_graphql" => false,
	];

	register_post_type( "photo-album", $args );
