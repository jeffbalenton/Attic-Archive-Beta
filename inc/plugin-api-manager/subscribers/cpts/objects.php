<?php

	/**
	 * Post Type: Objects.
	 */

	$labels = [
		"name" => __( "Objects", "hello-elementor" ),
		"singular_name" => __( "Object", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Objects", "hello-elementor" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => 'materials',
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "object", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "comments","custom-fields" ],
		"show_in_graphql" => false,
	];

	register_post_type( "object", $args );
	