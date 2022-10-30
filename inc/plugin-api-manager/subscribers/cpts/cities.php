
<?php

/**
 * Register a custom City type called "City".
 *
 * @see get_City_type_labels() for label keys.
 */
    $labels = array(
        'name'                  => _x( 'cities', 'City type general name', 'textdomain' ),
        'singular_name'         => _x( 'City', 'City type singular name', 'textdomain' ),
        'menu_name'             => _x( 'cities', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'City', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New City', 'textdomain' ),
        'add_new_item'          => __( 'Add New City', 'textdomain' ),
        'new_item'              => __( 'New City', 'textdomain' ),
        'edit_item'             => __( 'Edit City', 'textdomain' ),
        'view_item'             => __( 'View City', 'textdomain' ),
        'all_items'             => __( 'All Cities', 'textdomain' ),
        'search_items'          => __( 'Search cities', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent cities:', 'textdomain' ),
        'not_found'             => __( 'No cities found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No cities found in Trash.', 'textdomain' ),
        'featured_image'        => _x( 'City Cover Image', 'Overrides the “Featured Image” phrase for this City type. Added in 4.3', 'textdomain' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this City type. Added in 4.3', 'textdomain' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this City type. Added in 4.3', 'textdomain' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this City type. Added in 4.3', 'textdomain' ),
        'archives'              => _x( 'City archives', 'The City type archive label used in nav menus. Default “City Archives”. Added in 4.4', 'textdomain' ),
        'insert_into_item'      => _x( 'Insert into City', 'Overrides the “Insert into City”/”Insert into page” phrase (used when inserting media into a City). Added in 4.4', 'textdomain' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this City', 'Overrides the “Uploaded to this City”/”Uploaded to this page” phrase (used when viewing media attached to a City). Added in 4.4', 'textdomain' ),
        'filter_items_list'     => _x( 'Filter cities list', 'Screen reader text for the filter links heading on the City type listing screen. Default “Filter cities list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
        'items_list_navigation' => _x( 'cities list navigation', 'Screen reader text for the pagination heading on the City type listing screen. Default “cities list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
        'items_list'            => _x( 'cities list', 'Screen reader text for the items list heading on the City type listing screen. Default “cities list”/”Pages list”. Added in 4.4', 'textdomain' ),
    );
 
    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => "edit.php?post_type=place",
        'show_in_nav_menus'  => false,
        'show_in_admin_bar'  => false,
        'show_in_rest '      => true,
        'menu_icon '         => 'none',
        'query_var'          => true,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => true,
        'menu_position'      => null,
        'supports'           => ["title","custom-fields"] ,
        'register_meta_box_cb' =>"City_meta_box_cb"
    );
 
    register_post_type( 'city', $args );

function City_Meta_Box_CB($post){
	
}

	