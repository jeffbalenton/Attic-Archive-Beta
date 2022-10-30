
	<?php

/**
 * Register a custom Place type called "Place".
 *
 * @see get_Place_type_labels() for label keys.
 */
    $labels = array(
        'name'                  => _x( 'Places', 'Place type general name', 'textdomain' ),
        'singular_name'         => _x( 'Place', 'Place type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Places', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Place', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New Place', 'textdomain' ),
        'add_new_item'          => __( 'Add New Place', 'textdomain' ),
        'new_item'              => __( 'New Place', 'textdomain' ),
        'edit_item'             => __( 'Edit Place', 'textdomain' ),
        'view_item'             => __( 'View Place', 'textdomain' ),
        'all_items'             => __( 'All Places', 'textdomain' ),
        'search_items'          => __( 'Search Places', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Places:', 'textdomain' ),
        'not_found'             => __( 'No Places found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No Places found in Trash.', 'textdomain' ),
        'featured_image'        => _x( 'Place Cover Image', 'Overrides the “Featured Image” phrase for this Place type. Added in 4.3', 'textdomain' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this Place type. Added in 4.3', 'textdomain' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this Place type. Added in 4.3', 'textdomain' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this Place type. Added in 4.3', 'textdomain' ),
        'archives'              => _x( 'Place archives', 'The Place type archive label used in nav menus. Default “Place Archives”. Added in 4.4', 'textdomain' ),
        'insert_into_item'      => _x( 'Insert into Place', 'Overrides the “Insert into Place”/”Insert into page” phrase (used when inserting media into a Place). Added in 4.4', 'textdomain' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this Place', 'Overrides the “Uploaded to this Place”/”Uploaded to this page” phrase (used when viewing media attached to a Place). Added in 4.4', 'textdomain' ),
        'filter_items_list'     => _x( 'Filter Places list', 'Screen reader text for the filter links heading on the Place type listing screen. Default “Filter Places list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
        'items_list_navigation' => _x( 'Places list navigation', 'Screen reader text for the pagination heading on the Place type listing screen. Default “Places list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
        'items_list'            => _x( 'Places list', 'Screen reader text for the items list heading on the Place type listing screen. Default “Places list”/”Pages list”. Added in 4.4', 'textdomain' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'show_in_nav_menus'  => false,
        'show_in_admin_bar'  => false,
        'show_in_rest '      => true,
        'menu_icon '         => 'none',
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => true,
        'menu_position'      => null,
        'supports'           => [] ,
        'register_meta_box_cb' =>"Place_meta_box_cb"
    );
 
    register_post_type( 'Place', $args );

function Place_Meta_Box_CB($post){
	
}

	