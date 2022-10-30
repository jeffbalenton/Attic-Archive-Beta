<?php

	
	/**
	 * Post Type: Contact Forms.
	 */

	$labels = [
		"name" => __( "Contact Forms", "hello-elementor" ),
		"singular_name" => __( "Contact Form", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Contact Forms", "hello-elementor" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => false,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => 'true',
		"show_in_nav_menus" => false,
		"delete_with_user" => false,
		"exclude_from_search" => true,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => [ "slug" => "contact-form", "with_front" => true ],
		"query_var" => true,
		"supports" => [],
		"show_in_graphql" => false,
	];

	register_post_type( "contact_form", $args );