<?php

	/**
	 * Post Type: Texts.
	 */

	$labels = [
		"name" => __( "Texts", "hello-elementor" ),
		"singular_name" => __( "Text", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Texts", "hello-elementor" ),
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
		"rewrite" => [ "slug" => "text", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "comments" ],
		"show_in_graphql" => false,
	];

	register_post_type( "text", $args );