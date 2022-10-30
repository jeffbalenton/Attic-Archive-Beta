<?php

	/**
	 * Post Type: Stories.
	 */

	$labels = [
		"name" => __( "Stories", "hello-elementor" ),
		"singular_name" => __( "Story", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Stories", "hello-elementor" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => "stories",
		"show_in_menu" => 'materials',
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "story", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "thumbnail", "excerpt", "comments","custom-fields" ],
		"show_in_graphql" => false,
	];

	register_post_type( "story", $args );

	