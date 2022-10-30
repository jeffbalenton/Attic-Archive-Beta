<?php

	/**
	 * Post Type: Citations.
	 */

	$labels = [
		"name" => __( "Citations", "hello-elementor" ),
		"singular_name" => __( "Citation", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Citations", "hello-elementor" ),
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
		"rewrite" => [ "slug" => "citation", "with_front" => true ],
		"query_var" => true,
		"show_in_graphql" => false,
		"supports"=>["custom-fields"]
	];

	register_post_type( "citation", $args );

	