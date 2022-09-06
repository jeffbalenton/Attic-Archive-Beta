<?php

	
	/**
	 * Post Type: Photo Studios.
	 */

	$labels = [
		"name" => __( "Photo Studios", "hello-elementor" ),
		"singular_name" => __( "Photo Studio", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Photo Studios", "hello-elementor" ),
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
		"rewrite" => [ "slug" => "photo_studio", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "comments" ],
		"show_in_graphql" => false,
	];

	register_post_type( "photo_studio", $args );
