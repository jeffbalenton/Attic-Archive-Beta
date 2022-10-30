<?php

	/**
	 * Post Type: Audio Recordings.
	 */

	$labels = [
		"name" => __( "Audio Recordings", "hello-elementor" ),
		"singular_name" => __( "Audio Recording", "hello-elementor" ),
	];

	$args = [
		"label" => __( "Audio Recordings", "hello-elementor" ),
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
		"rewrite" => [ "slug" => "audio", "with_front" => true ],
		"query_var" => true,
		"supports" => [ "title", "editor", "thumbnail", "comments" ],
		"show_in_graphql" => false,
	];

	register_post_type( "audio", $args );
	