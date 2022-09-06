<?php

	/**
	 * Post Type: Tasks.
	 */

	$labels = [
		"name" => __( "Tasks", "hello-elementor" ),
		"singular_name" => __( "Task", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Tasks", "hello-elementor" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" =>'tasks',
		"show_in_menu" => 'research',
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "task", "with_front" => true ],
		"query_var" => true,
		"supports" => [  ],
		"show_in_graphql" => false,
	];

	register_post_type( "task", $args );