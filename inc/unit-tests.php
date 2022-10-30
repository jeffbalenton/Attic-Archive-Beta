<?php
// Manual Creation of Search Filters


$meta = array (
  0 => 
  array (
    'type' => 'search',
    'heading' => '',
    'placeholder' => 'Search …',
    'accessibility_label' => '',
  ),
  1 => 
  array (
    'type' => 'sort_order',
    'input_type' => 'select',
    'heading' => 'Sort By',
    'all_items_label' => '',
    'accessibility_label' => '',
    'sort_options' => 
    array (
      0 => 
      array (
        'sort_by' => 'meta_value',
        'sort_dir' => 'desc',
        'sort_label' => 'Year Taken',
        'meta_key' => '_alternate_names',
        'sort_type' => 'numeric',
      ),
      1 => 
      array (
        'sort_by' => 'date',
        'sort_dir' => 'desc',
        'sort_label' => 'Date Posted New First',
        'meta_key' => '_alternate_names',
        'sort_type' => 'numeric',
      ),
      2 => 
      array (
        'sort_by' => 'date',
        'sort_dir' => 'asc',
        'sort_label' => 'Date Posted Old First',
        'meta_key' => '_alternate_names',
        'sort_type' => 'numeric',
      ),
    ),
  ),
  2 => 
  array (
    'type' => 'post_meta',
    'meta_type' => 'choice',
    'number_input_type' => 'range-slider',
    'number_is_decimal' => 1,
    'choice_input_type' => 'select',
    'date_input_type' => 'date',
    'meta_key_manual_toggle' => 0,
    'combo_box' => 1,
    'no_results_message' => '',
    'show_count' => 1,
    'hide_empty' => 0,
    'input_type' => '',
    'choice_meta_key' => 'photo_album',
    'choice_accessibility_label' => '',
    'choice_get_option_mode' => 'auto',
    'choice_order_option_by' => 'value',
    'choice_order_option_dir' => 'asc',
    'choice_order_option_type' => 'alphabetic',
    'choice_is_acf' => 1,
    'date_accessibility_label' => '',
    'date_meta_key' => '',
    'date_start_meta_key' => '_alternate_names',
    'date_end_meta_key' => '',
    'date_use_same_toggle' => 1,
    'number_accessibility_label' => '',
    'number_start_meta_key' => '_alternate_names',
    'number_end_meta_key' => '',
    'number_use_same_toggle' => 1,
    'heading' => 'Albums',
    'meta_key' => 'photo_album',
    'date_from_prefix' => '',
    'date_from_postfix' => '',
    'date_from_placeholder' => '',
    'date_to_prefix' => '',
    'date_to_postfix' => '',
    'date_to_placeholder' => '',
    'date_use_dropdown_month' => 0,
    'date_use_dropdown_year' => 0,
    'decimal_places' => 0,
    'number_decimal_places' => 2,
    'thousand_seperator' => '',
    'decimal_seperator' => '.',
    'number_values_seperator' => ' - ',
    'number_display_values_as' => 'textinput',
    'number_display_input_as' => 'singlefield',
    'range_min_detect' => 0,
    'range_max_detect' => 0,
    'range_min' => '0',
    'range_max' => '1000',
    'range_step' => '10',
    'range_value_prefix' => '',
    'range_value_postfix' => '',
    'date_input_format' => 'timestamp',
    'date_compare_mode' => 'userrange',
    'number_compare_mode' => 'userrange',
    'date_output_format' => 'd/m/Y',
    'all_items_label' => '',
    'all_items_label_number' => '',
    'operator' => 'and',
    'meta_options' => 
    array (
    ),
  ),
  3 => 
  array (
    'type' => 'post_meta',
    'meta_type' => 'choice',
    'number_input_type' => 'range-slider',
    'number_is_decimal' => 1,
    'choice_input_type' => 'select',
    'date_input_type' => 'date',
    'meta_key_manual_toggle' => 0,
    'combo_box' => 1,
    'no_results_message' => '',
    'show_count' => 1,
    'hide_empty' => 1,
    'input_type' => '',
    'choice_meta_key' => 'photo_people',
    'choice_accessibility_label' => '',
    'choice_get_option_mode' => 'auto',
    'choice_order_option_by' => 'value',
    'choice_order_option_dir' => 'asc',
    'choice_order_option_type' => 'alphabetic',
    'choice_is_acf' => 1,
    'date_accessibility_label' => '',
    'date_meta_key' => '',
    'date_start_meta_key' => '_alternate_names',
    'date_end_meta_key' => '',
    'date_use_same_toggle' => 1,
    'number_accessibility_label' => '',
    'number_start_meta_key' => '_alternate_names',
    'number_end_meta_key' => '',
    'number_use_same_toggle' => 1,
    'heading' => 'People in Photos',
    'meta_key' => 'photo_people',
    'date_from_prefix' => '',
    'date_from_postfix' => '',
    'date_from_placeholder' => '',
    'date_to_prefix' => '',
    'date_to_postfix' => '',
    'date_to_placeholder' => '',
    'date_use_dropdown_month' => 0,
    'date_use_dropdown_year' => 0,
    'decimal_places' => 0,
    'number_decimal_places' => 2,
    'thousand_seperator' => '',
    'decimal_seperator' => '.',
    'number_values_seperator' => ' - ',
    'number_display_values_as' => 'textinput',
    'number_display_input_as' => 'singlefield',
    'range_min_detect' => 0,
    'range_max_detect' => 0,
    'range_min' => '0',
    'range_max' => '1000',
    'range_step' => '10',
    'range_value_prefix' => '',
    'range_value_postfix' => '',
    'date_input_format' => 'timestamp',
    'date_compare_mode' => 'userrange',
    'number_compare_mode' => 'userrange',
    'date_output_format' => 'd/m/Y',
    'all_items_label' => '',
    'all_items_label_number' => '',
    'operator' => 'or',
    'meta_options' => 
    array (
    ),
  ),
  4 => 
  array (
    'type' => 'post_meta',
    'meta_type' => 'choice',
    'number_input_type' => 'range-slider',
    'number_is_decimal' => 1,
    'choice_input_type' => 'select',
    'date_input_type' => 'date',
    'meta_key_manual_toggle' => 0,
    'combo_box' => 1,
    'no_results_message' => '',
    'show_count' => 1,
    'hide_empty' => 1,
    'input_type' => '',
    'choice_meta_key' => 'photo_studio',
    'choice_accessibility_label' => '',
    'choice_get_option_mode' => 'auto',
    'choice_order_option_by' => 'value',
    'choice_order_option_dir' => 'asc',
    'choice_order_option_type' => 'alphabetic',
    'choice_is_acf' => 1,
    'date_accessibility_label' => '',
    'date_meta_key' => '',
    'date_start_meta_key' => '_alternate_names',
    'date_end_meta_key' => '',
    'date_use_same_toggle' => 1,
    'number_accessibility_label' => '',
    'number_start_meta_key' => '_alternate_names',
    'number_end_meta_key' => '',
    'number_use_same_toggle' => 1,
    'heading' => 'Photo Studio',
    'meta_key' => 'photo_studio',
    'date_from_prefix' => '',
    'date_from_postfix' => '',
    'date_from_placeholder' => '',
    'date_to_prefix' => '',
    'date_to_postfix' => '',
    'date_to_placeholder' => '',
    'date_use_dropdown_month' => 0,
    'date_use_dropdown_year' => 0,
    'decimal_places' => 0,
    'number_decimal_places' => 2,
    'thousand_seperator' => '',
    'decimal_seperator' => '.',
    'number_values_seperator' => ' - ',
    'number_display_values_as' => 'textinput',
    'number_display_input_as' => 'singlefield',
    'range_min_detect' => 0,
    'range_max_detect' => 0,
    'range_min' => '0',
    'range_max' => '1000',
    'range_step' => '10',
    'range_value_prefix' => '',
    'range_value_postfix' => '',
    'date_input_format' => 'timestamp',
    'date_compare_mode' => 'userrange',
    'number_compare_mode' => 'userrange',
    'date_output_format' => 'd/m/Y',
    'all_items_label' => '',
    'all_items_label_number' => '',
    'operator' => 'and',
    'meta_options' => 
    array (
    ),
  ),
  5 => 
  array (
    'type' => 'post_meta',
    'meta_type' => 'choice',
    'number_input_type' => 'range-slider',
    'number_is_decimal' => 1,
    'choice_input_type' => 'select',
    'date_input_type' => 'date',
    'meta_key_manual_toggle' => 0,
    'combo_box' => 1,
    'no_results_message' => '',
    'show_count' => 1,
    'hide_empty' => 1,
    'input_type' => '',
    'choice_meta_key' => 'photo_place',
    'choice_accessibility_label' => '',
    'choice_get_option_mode' => 'auto',
    'choice_order_option_by' => 'value',
    'choice_order_option_dir' => 'asc',
    'choice_order_option_type' => 'alphabetic',
    'choice_is_acf' => 1,
    'date_accessibility_label' => '',
    'date_meta_key' => '',
    'date_start_meta_key' => '_alternate_names',
    'date_end_meta_key' => '',
    'date_use_same_toggle' => 1,
    'number_accessibility_label' => '',
    'number_start_meta_key' => '_alternate_names',
    'number_end_meta_key' => '',
    'number_use_same_toggle' => 1,
    'heading' => 'Places In Photos',
    'meta_key' => 'photo_place',
    'date_from_prefix' => '',
    'date_from_postfix' => '',
    'date_from_placeholder' => '',
    'date_to_prefix' => '',
    'date_to_postfix' => '',
    'date_to_placeholder' => '',
    'date_use_dropdown_month' => 0,
    'date_use_dropdown_year' => 0,
    'decimal_places' => 0,
    'number_decimal_places' => 2,
    'thousand_seperator' => '',
    'decimal_seperator' => '.',
    'number_values_seperator' => ' - ',
    'number_display_values_as' => 'textinput',
    'number_display_input_as' => 'singlefield',
    'range_min_detect' => 0,
    'range_max_detect' => 0,
    'range_min' => '0',
    'range_max' => '1000',
    'range_step' => '10',
    'range_value_prefix' => '',
    'range_value_postfix' => '',
    'date_input_format' => 'timestamp',
    'date_compare_mode' => 'userrange',
    'number_compare_mode' => 'userrange',
    'date_output_format' => 'd/m/Y',
    'all_items_label' => '',
    'all_items_label_number' => '',
    'operator' => 'and',
    'meta_options' => 
    array (
    ),
  ),
  6 => 
  array (
    'type' => 'post_meta',
    'meta_type' => 'choice',
    'number_input_type' => 'range-slider',
    'number_is_decimal' => 1,
    'choice_input_type' => 'select',
    'date_input_type' => 'date',
    'meta_key_manual_toggle' => 0,
    'combo_box' => 1,
    'no_results_message' => '',
    'show_count' => 1,
    'hide_empty' => 1,
    'input_type' => '',
    'choice_meta_key' => 'photo_event',
    'choice_accessibility_label' => '',
    'choice_get_option_mode' => 'auto',
    'choice_order_option_by' => 'value',
    'choice_order_option_dir' => 'asc',
    'choice_order_option_type' => 'alphabetic',
    'choice_is_acf' => 1,
    'date_accessibility_label' => '',
    'date_meta_key' => '',
    'date_start_meta_key' => '_alternate_names',
    'date_end_meta_key' => '',
    'date_use_same_toggle' => 1,
    'number_accessibility_label' => '',
    'number_start_meta_key' => '_alternate_names',
    'number_end_meta_key' => '',
    'number_use_same_toggle' => 1,
    'heading' => 'Events In Photos',
    'meta_key' => 'photo_event',
    'date_from_prefix' => '',
    'date_from_postfix' => '',
    'date_from_placeholder' => '',
    'date_to_prefix' => '',
    'date_to_postfix' => '',
    'date_to_placeholder' => '',
    'date_use_dropdown_month' => 0,
    'date_use_dropdown_year' => 0,
    'decimal_places' => 0,
    'number_decimal_places' => 2,
    'thousand_seperator' => '',
    'decimal_seperator' => '.',
    'number_values_seperator' => ' - ',
    'number_display_values_as' => 'textinput',
    'number_display_input_as' => 'singlefield',
    'range_min_detect' => 0,
    'range_max_detect' => 0,
    'range_min' => '0',
    'range_max' => '1000',
    'range_step' => '10',
    'range_value_prefix' => '',
    'range_value_postfix' => '',
    'date_input_format' => 'timestamp',
    'date_compare_mode' => 'userrange',
    'number_compare_mode' => 'userrange',
    'date_output_format' => 'd/m/Y',
    'all_items_label' => '',
    'all_items_label_number' => '',
    'operator' => 'and',
    'meta_options' => 
    array (
    ),
  ),
  7 => 
  array (
    'type' => 'post_meta',
    'meta_type' => 'choice',
    'number_input_type' => 'range-slider',
    'number_is_decimal' => 0,
    'choice_input_type' => 'select',
    'date_input_type' => 'date',
    'meta_key_manual_toggle' => 0,
    'combo_box' => 1,
    'no_results_message' => '',
    'show_count' => 1,
    'hide_empty' => 1,
    'input_type' => '',
    'choice_meta_key' => 'year_taken',
    'choice_accessibility_label' => '',
    'choice_get_option_mode' => 'auto',
    'choice_order_option_by' => 'value',
    'choice_order_option_dir' => 'asc',
    'choice_order_option_type' => 'numeric',
    'choice_is_acf' => 1,
    'date_accessibility_label' => '',
    'date_meta_key' => '',
    'date_start_meta_key' => '_alternate_names',
    'date_end_meta_key' => '',
    'date_use_same_toggle' => 1,
    'number_accessibility_label' => '',
    'number_start_meta_key' => '_alternate_names',
    'number_end_meta_key' => '',
    'number_use_same_toggle' => 1,
    'heading' => 'Year Taken',
    'meta_key' => 'year_taken',
    'date_from_prefix' => '',
    'date_from_postfix' => '',
    'date_from_placeholder' => '',
    'date_to_prefix' => '',
    'date_to_postfix' => '',
    'date_to_placeholder' => '',
    'date_use_dropdown_month' => 0,
    'date_use_dropdown_year' => 0,
    'decimal_places' => 0,
    'number_decimal_places' => 2,
    'thousand_seperator' => '',
    'decimal_seperator' => '.',
    'number_values_seperator' => ' - ',
    'number_display_values_as' => 'textinput',
    'number_display_input_as' => 'singlefield',
    'range_min_detect' => 1,
    'range_max_detect' => 1,
    'range_min' => '0',
    'range_max' => '0',
    'range_step' => '1',
    'range_value_prefix' => '',
    'range_value_postfix' => '',
    'date_input_format' => 'timestamp',
    'date_compare_mode' => 'userrange',
    'number_compare_mode' => 'userrange',
    'date_output_format' => 'd/m/Y',
    'all_items_label' => '',
    'all_items_label_number' => '',
    'operator' => 'and',
    'meta_options' => 
    array (
    ),
  ),
  8 => 
  array (
    'type' => 'reset',
    'heading' => '',
    'input_type' => 'link',
    'submit_form' => 'always',
    'label' => 'Reset Filters',
  ),
);

$meta2=array (
  'use_template_manual_toggle' => 1,
  'enable_taxonomy_archives' => 0,
  'enable_auto_count' => 1,
  'auto_count_refresh_mode' => 1,
  'auto_count_deselect_emtpy' => 0,
  'template_name_manual' => 'archive-photo.php',
  'page_slug' => '',
  'post_types' => 
  array (
    'photo' => 1,
  ),
  'post_status' => 
  array (
    'publish' => 1,
  ),
  'scroll_to_pos' => 'custom',
  'pagination_type' => 'normal',
  'custom_scroll_to' => '#results',
  'scroll_on_action' => 'all',
  'auto_submit' => 1,
  'display_results_as' => 'archive',
  'update_ajax_url' => 1,
  'only_results_ajax' => 1,
  'ajax_target' => '#main',
  'ajax_links_selector' => '.pagination a',
  'infinite_scroll_container' => '',
  'infinite_scroll_trigger' => '-100',
  'infinite_scroll_result_class' => '',
  'show_infinite_scroll_loader' => 1,
  'results_per_page' => 12,
  'exclude_post_ids' => '',
  'field_relation' => 'and',
  'default_sort_by' => '0',
  'sticky_posts' => '',
  'default_sort_dir' => 'desc',
  'default_meta_key' => '_alternate_names',
  'default_sort_type' => 'numeric',
  'secondary_sort_by' => '0',
  'secondary_sort_dir' => 'desc',
  'secondary_meta_key' => '_alternate_names',
  'secondary_sort_type' => 'numeric',
  'taxonomies_settings' => 
  array (
    'category' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'post_tag' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'post_format' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'wp_theme' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'wp_template_part_area' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'acf-field-group-category' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'occupation' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'cause_of_death' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'document_type' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'ephemera_type' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'topic' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'generation' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'lineage' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'gender' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'status' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'school_type' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'course_of_study' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'degree' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'business_type' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'worship_type' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'privacy_level' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'military_branch' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'photographer' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'text_author' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'place_type' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'event_type' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'source_type' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'person_tags' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
    'relation' => 
    array (
      'include_exclude' => 'include',
      'ids' => '',
    ),
  ),
);
$meta3=home_url('/photos');
global $repository;
$postarr=[
	'post_title'=>'Sample Filter',
	'post_type'=>'search-filter-widget',
	'post_status'=>'publish',
	'meta_input'=>[
		'_search-filter-fields'=>$meta,
		'_search-filter-settings'=>$meta2,
		'_search-filter-results-url'=>$meta3,
		
	],
];
/*$found=$repository->find_one($postarr);
if(!$found):
$repository->save($postarr);
endif; */


//Logic for Importing Custom Fields 



			// Read JSON.
		

			// Check if empty.
		
/*
			// Ensure $json is an array of groups.
			if ( isset( $json['key'] ) ) {
				$json = array( $json );
			}

			// Remeber imported field group ids.
			$ids = array();

			// Loop over json
			foreach ( $json as $field_group ) {

				// Search database for existing field group.
				$post = acf_get_field_group_post( $field_group['key'] );
				if ( $post ) {
					$field_group['ID'] = $post->ID;
				}

				// Import field group.
				$field_group = acf_import_field_group( $field_group );

				// append message
				$ids[] = $field_group['ID'];
			}
*/
