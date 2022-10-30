<?php

	/**
	 * Post Type: Sources.
	 */

	$labels = [
		"name" => __( "Sources", "hello-elementor" ),
		"singular_name" => __( "Source", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Sources", "hello-elementor" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => 'research',
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "source", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail","custom-fields" ],
		"show_in_graphql" => false,
	];

	register_post_type( "source", $args );
	