<?php

	/**
	 * Post Type: Events.
	 */

	$labels = [
		"name" => __( "Events", "hello-elementor" ),
		"singular_name" => __( "Event", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Events", "hello-elementor" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "event", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "comments" ],
		"show_in_graphql" => false,
		"menu_icon" => "dashicons-calendar"
	];

	register_post_type( "event", $args );
