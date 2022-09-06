<?php

	/**
	 * Post Type: Bookmarks.
	 */

		$labels = [
        'name'                  => _x( 'Bookmark', 'Post type general name', 'Bookmark' ),
        'singular_name'         => _x( 'Bookmark', 'Post type singular name', 'Bookmark' ),
        'menu_name'             => _x( 'Bookmarks', 'Admin Menu text', 'Bookmark' ),
        'name_admin_bar'        => _x( 'Bookmark', 'Add New on Toolbar', 'Bookmark' ),
        'add_new'               => __( 'Add Bookmark', 'Bookmark' ),
        'add_new_item'          => __( 'Create Bookmark', 'Bookmark' ),
        'new_item'              => __( 'New Bookmark', 'Bookmark' ),
        'edit_item'             => __( 'Edit Bookmark', 'Bookmark' ),
        'view_item'             => __( 'View Bookmark', 'Bookmark' ),
        'all_items'             => __( 'Bookmarks', 'Bookmark' ),
        'search_items'          => __( 'Search Bookmarks', 'Bookmark' ),
        'parent_item_colon'     => __( 'Parent Bookmark:', 'Bookmark' ),
        'not_found'             => __( 'No Bookmarks found.', 'Bookmark' ),
        'not_found_in_trash'    => __( 'No Bookmarks found in Trash.', 'Bookmark' ),
        'featured_image'        => _x( 'Bookmark Profile Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'Bookmark' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'Bookmark' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'Bookmark' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'Bookmark' ),
        'archives'              => _x( 'Bookmarks archive', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'Bookmark' ),
        'insert_into_item'      => _x( 'Insert into Bookmark', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'Bookmark' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this Bookmark', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'Bookmark' ),
        'filter_items_list'     => _x( 'Filter Bookmarks list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'Bookmark' ),
        'items_list_navigation' => _x( 'Bookmarks list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'Bookmark' ),
        'items_list'            => _x( 'Bookmarks list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'Bookmark' ),
	];

	$args = [
		"label" => __( "Bookmarks", "hello-elementor" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => 'bookmarks',
		"show_in_menu" => 'research',
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "bookmark", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail" ],
		"show_in_graphql" => false,
	];

	register_post_type( "bookmark", $args );