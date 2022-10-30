<?php

	/**
	 * Post Type: Photos.
	 */

	$labels = [
		"name" => __( "Photos", "hello-elementor" ),
		"singular_name" => __( "Photo", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Photos", "hello-elementor" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => true,
		"show_in_menu" => 'materials',
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "photo", "with_front" => true ],
		"query_var" => true,
		"menu_position" => 25,
		"supports" => [ "thumbnail", "comments" ],
		"show_in_graphql" => false,
	];

	register_post_type( "photo", $args );	



