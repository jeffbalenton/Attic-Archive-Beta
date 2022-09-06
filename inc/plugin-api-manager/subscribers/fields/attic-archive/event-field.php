<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('Archive_EVENT_FIELD') ) :


class Archive_EVENT_FIELD extends acf_field {
	
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct( $settings ) {
		
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		
		$this->name = 'event_date';
		
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		
		$this->label = __('EVENT DATE', 'TEXTDOMAIN');
		
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		
		$this->category = 'Attic Archive';
		
		
		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		
		$this->defaults = array(
			'sub_fields' => array(),
			'layout'     => 'table',
		);
		
			$this->have_rows = 'single';

			// field filters
			$this->add_field_filter( 'acf/prepare_field_for_export', array( $this, 'prepare_field_for_export' ) );
			$this->add_field_filter( 'acf/prepare_field_for_import', array( $this, 'prepare_field_for_import' ) );
		
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('FIELD_NAME', 'error');
		*/
		
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'TEXTDOMAIN'),
		);
		
		
		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/
		
		$this->settings = $settings;
		
		
		// do not delete!
    	parent::__construct();
    	
	}
	
	
	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field_settings( $field ) {
		
		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/
		
			// vars
			$args = array(
				'fields' => $field['sub_fields'],
				'parent' => $field['ID'],
			);

			?>
		<tr class="acf-field acf-field-setting-sub_fields" data-setting="group" data-name="sub_fields">
			<td class="acf-label">
				<label><?php _e( 'Sub Fields', 'acf' ); ?></label>	
			</td>
			<td class="acf-input">
				<?php

				acf_get_view( 'field-group-fields', $args );

				?>
			</td>
		</tr>
			<?php

			// layout
			acf_render_field_setting(
				$field,
				array(
					'label'        => __( 'Layout', 'acf' ),
					'instructions' => __( 'Specify the style used to render the selected fields', 'acf' ),
					'type'         => 'radio',
					'name'         => 'layout',
					'layout'       => 'horizontal',
					'choices'      => array(
						'block' => __( 'Block', 'acf' ),
						'table' => __( 'Table', 'acf' ),
						'row'   => __( 'Row', 'acf' ),
					),
				)
			);

	}
	
	
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field( $field ) {
		
		
		/*
		*  Review the data of $field.
		*  This will show what data is available
		*/
		/*
		echo '<pre>';
			print_r( $field );
		echo '</pre>';
		
		*/
			// bail early if no sub fields
			if ( empty( $field['sub_fields'] ) ) {
				return;
			}

			// load values
			foreach ( $field['sub_fields'] as &$sub_field ) {

				// add value
				if ( isset( $field['value'][ $sub_field['key'] ] ) ) {

					// this is a normal value
					$sub_field['value'] = $field['value'][ $sub_field['key'] ];

				} elseif ( isset( $sub_field['default_value'] ) ) {

					// no value, but this sub field has a default value
					$sub_field['value'] = $sub_field['default_value'];

				}

				// update prefix to allow for nested values
				$sub_field['prefix'] = $field['name'];

				// restore required
				if ( $field['required'] ) {
					$sub_field['required'] = 0;
				}
			}

			// render
			if ( $field['layout'] == 'table' ) {

				$this->render_field_table( $field );

			} else {

				$this->render_field_block( $field );

			}

	}
	
	
	
		/*
		*  render_field_block
		*
		*  description
		*
		*  @type    function
		*  @date    12/07/2016
		*  @since   5.4.0
		*
		*  @param   $post_id (int)
		*  @return  $post_id (int)
		*/

		function render_field_block( $field ) {

			// vars
			$label_placement = ( $field['layout'] == 'block' ) ? 'top' : 'left';

			// html
			echo '<div class="acf-fields -' . $label_placement . ' -border">';

			foreach ( $field['sub_fields'] as $sub_field ) {

				acf_render_field_wrap( $sub_field );

			}

			echo '</div>';

		}


		/*
		*  render_field_table
		*
		*  description
		*
		*  @type    function
		*  @date    12/07/2016
		*  @since   5.4.0
		*
		*  @param   $post_id (int)
		*  @return  $post_id (int)
		*/

		function render_field_table( $field ) {

			?>
<div class="table-responsive-sm">
<table class="table table-sm">
	<thead class='table-dark'>
		<tr>
			<?php
			foreach ( $field['sub_fields'] as $sub_field ) :

				// prepare field (allow sub fields to be removed)
				$sub_field = acf_prepare_field( $sub_field );

				// bail ealry if no field
				if ( ! $sub_field ) {
					continue;
				}

				// vars
				$atts              = array();
				$atts['class']     = '';
				$atts['data-name'] = $sub_field['_name'];
				$atts['data-type'] = $sub_field['type'];
				$atts['data-key']  = $sub_field['key'];

				// Add custom width
				if ( $sub_field['wrapper']['width'] ) {

					$atts['data-width'] = $sub_field['wrapper']['width'];
					$atts['style']      = 'width: ' . $sub_field['wrapper']['width'] . '%;';

				}

				?>
			<th <?php acf_esc_attr_e( $atts ); ?> scope="col">
				<?php acf_render_field_label( $sub_field ); ?>
				<?php acf_render_field_instructions( $sub_field ); ?>
			</th>
			<?php endforeach; ?>
		</tr>
	</thead>
	<tbody>
		<tr class="">
			<?php

			foreach ( $field['sub_fields'] as $sub_field ) {

				acf_render_field_wrap( $sub_field, 'td' );

			}

			?>
		</tr>
	</tbody>
</table>
</div>

			<?php

		}

		
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	
	
	function input_admin_enqueue_scripts() {
		
		// vars
		$url = $this->settings['url'];
		$version = $this->settings['version'];
		
		
		// register & include JS
		wp_register_script('bootstrapJs', "{$url}assets/js/bootstrap.bundle.min.js", array('acf-input'), $version);
		wp_enqueue_script('bootstrapJs');
		
		
		// register & include CSS
		wp_register_style('TEXTDOMAIN', "{$url}assets/css/bootstrap.css", array('acf-input'), $version);
		wp_enqueue_style('TEXTDOMAIN');
		
	}
	
	
	
	
	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_head() {
	
		
		
	}
	
	*/
	
	
	/*
   	*  input_form_data()
   	*
   	*  This function is called once on the 'input' page between the head and footer
   	*  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and 
   	*  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
   	*  seen on comments / user edit forms on the front end. This function will always be called, and includes
   	*  $args that related to the current screen such as $args['post_id']
   	*
   	*  @type	function
   	*  @date	6/03/2014
   	*  @since	5.0.0
   	*
   	*  @param	$args (array)
   	*  @return	n/a
   	*/
   	
   	/*
   	
   	function input_form_data( $args ) {
	   	
		
	
   	}
   	
   	*/
	
	
	/*
	*  input_admin_footer()
	*
	*  This action is called in the admin_footer action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_footer)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_footer() {
	
		
		
	}
	
	*/
	
	
	/*
	*  field_group_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
	*  Use this action to add CSS + JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_enqueue_scripts() {
		
	}
	
	*/

	
	/*
	*  field_group_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is edited.
	*  Use this action to add CSS and JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_head() {
	
	}
	
	*/


	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	
	
	function load_value( $value, $post_id, $field ) {
		
		
			// bail early if no sub fields
			if ( empty( $field['sub_fields'] ) ) {
				return $value;
			}

			// modify names
			$field = $this->prepare_field_for_db( $field );

			// load sub fields
			$value = array();

			// loop
			foreach ( $field['sub_fields'] as $sub_field ) {

				// load
				$value[ $sub_field['key'] ] = acf_get_value( $post_id, $sub_field );

			}
				// return
		return $value;
		
	}
	
	
	
	
	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	
	
	function update_value( $value, $post_id, $field ) {
		
					// bail early if no value
			if ( ! acf_is_array( $value ) ) {
				return null;
			}

			// bail ealry if no sub fields
			if ( empty( $field['sub_fields'] ) ) {
				return null;
			}

			// modify names
			$field = $this->prepare_field_for_db( $field );

			// loop
			foreach ( $field['sub_fields'] as $sub_field ) {

				// vars
				$v = false;

				// key (backend)
				if ( isset( $value[ $sub_field['key'] ] ) ) {

					$v = $value[ $sub_field['key'] ];

					// name (frontend)
				} elseif ( isset( $value[ $sub_field['_name'] ] ) ) {

					$v = $value[ $sub_field['_name'] ];

					// empty
				} else {

					// input is not set (hidden by conditioanl logic)
					continue;

				}

				// update value
				acf_update_value( $v, $post_id, $sub_field );

			}

			// return
			return '';
		
		
		
		
		
	}
	
	
	
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/
		
	
	
	function format_value( $value, $post_id, $field ) {
		
			// bail early if no value
			if ( empty( $value ) ) {
				return false;
			}

			// modify names
			$field = $this->prepare_field_for_db( $field );

			// loop
			foreach ( $field['sub_fields'] as $sub_field ) {

				// extract value
				$sub_value = acf_extract_var( $value, $sub_field['key'] );

				// format value
				$sub_value = acf_format_value( $sub_value, $post_id, $sub_field );

				// append to $row
				$value[ $sub_field['_name'] ] = $sub_value;

			}
		
		// return
		return $value;
	}
	
	
	
	
	/*
	*  validate_value()
	*
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*
	*  @type	filter
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$valid (boolean) validation status based on the value and the field's required setting
	*  @param	$value (mixed) the $_POST value
	*  @param	$field (array) the field array holding all the field options
	*  @param	$input (string) the corresponding input name for $_POST value
	*  @return	$valid
	*/
	
	/*
	
	function validate_value( $valid, $value, $field, $input ){
		
		// Basic usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = false;
		}
		
		
		// Advanced usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = __('The value is too little!','TEXTDOMAIN'),
		}
		
		
		// return
		return $valid;
		
	}
	
	*/
	
		function validate_value( $valid, $value, $field, $input ) {

			// bail early if no $value
			if ( empty( $value ) ) {
				return $valid;
			}

			// bail early if no sub fields
			if ( empty( $field['sub_fields'] ) ) {
				return $valid;
			}

			// loop
			foreach ( $field['sub_fields'] as $sub_field ) {

				// get sub field
				$k = $sub_field['key'];

				// bail early if value not set (conditional logic?)
				if ( ! isset( $value[ $k ] ) ) {
					continue;
				}

				// required
				if ( $field['required'] ) {
					$sub_field['required'] = 1;
				}

				// validate
				acf_validate_value( $value[ $k ], $sub_field, "{$input}[{$k}]" );

			}

			// return
			return $valid;

		}
	
	/*
	*  delete_value()
	*
	*  This action is fired after a value has been deleted from the db.
	*  Please note that saving a blank value is treated as an update, not a delete
	*
	*  @type	action
	*  @date	6/03/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (mixed) the $post_id from which the value was deleted
	*  @param	$key (string) the $meta_key which the value was deleted
	*  @return	n/a
	*/
	
	/*
	
	function delete_value( $post_id, $key ) {
		
		
		
	}
	
	*/
	
	
	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0	
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/
	
	
	
	function load_field( $field ) {
		
		// vars
			$sub_fields = acf_get_fields( $field );

			// append
			if ( $sub_fields ) {

				$field['sub_fields'] = $sub_fields;

			}

			// return
			return $field;

		
	}	
	
	
	
		/*
		*  duplicate_field()
		*
		*  This filter is appied to the $field before it is duplicated and saved to the database
		*
		*  @type    filter
		*  @since   3.6
		*  @date    23/01/13
		*
		*  @param   $field - the field array holding all the field options
		*
		*  @return  $field - the modified field
		*/

		function duplicate_field( $field ) {

			// get sub fields
			$sub_fields = acf_extract_var( $field, 'sub_fields' );

			// save field to get ID
			$field = acf_update_field( $field );

			// duplicate sub fields
			acf_duplicate_fields( $sub_fields, $field['ID'] );

			// return
			return $field;

		}

		/**
		 * prepare_field_for_export
		 *
		 * Prepares the field for export.
		 *
		 * @date    11/03/2014
		 * @since   5.0.0
		 *
		 * @param   array $field The field settings.
		 * @return  array
		 */
		function prepare_field_for_export( $field ) {

			// Check for sub fields.
			if ( ! empty( $field['sub_fields'] ) ) {
				$field['sub_fields'] = acf_prepare_fields_for_export( $field['sub_fields'] );
			}
			return $field;
		}

		/**
		 * prepare_field_for_import
		 *
		 * Returns a flat array of fields containing all sub fields ready for import.
		 *
		 * @date    11/03/2014
		 * @since   5.0.0
		 *
		 * @param   array $field The field settings.
		 * @return  array
		 */
		function prepare_field_for_import( $field ) {

			// Check for sub fields.
			if ( ! empty( $field['sub_fields'] ) ) {
				$sub_fields = acf_extract_var( $field, 'sub_fields' );

				// Modify sub fields.
				foreach ( $sub_fields as $i => $sub_field ) {
					$sub_fields[ $i ]['parent']     = $field['key'];
					$sub_fields[ $i ]['menu_order'] = $i;
				}

				// Return array of [field, sub_1, sub_2, ...].
				return array_merge( array( $field ), $sub_fields );

			}
			return $field;
		}

	
	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/
	
	/*
	
	function update_field( $field ) {
		
		return $field;
		
	}	
	
	*/
	
	
	/*
	*  delete_field()
	*
	*  This action is fired after a field is deleted from the database
	*
	*  @type	action
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	n/a
	*/
	
	
	
	function delete_field( $field ) {
		
		// loop over sub fields and delete them
			if ( $field['sub_fields'] ) {
				foreach ( $field['sub_fields'] as $sub_field ) {
					acf_delete_field( $sub_field['ID'] );
				}
			}
		
	}	
	
	
	/*
		*  prepare_field_for_db
		*
		*  This function will modify sub fields ready for update / load
		*
		*  @type    function
		*  @date    4/11/16
		*  @since   5.5.0
		*
		*  @param   $field (array)
		*  @return  $field
		*/

		function prepare_field_for_db( $field ) {

			// bail early if no sub fields
			if ( empty( $field['sub_fields'] ) ) {
				return $field;
			}

			// loop
			foreach ( $field['sub_fields'] as &$sub_field ) {

				// prefix name
				$sub_field['name'] = $field['name'] . '_' . $sub_field['_name'];

			}

			// return
			return $field;

		}	
			/**
		 * Return the schema array for the REST API.
		 *
		 * @param array $field
		 * @return array
		 */
		public function get_rest_schema( array $field ) {
			$schema = array(
				'type'       => array( 'object', 'null' ),
				'properties' => array(),
				'required'   => ! empty( $field['required'] ),
			);

			foreach ( $field['sub_fields'] as $sub_field ) {
				if ( $sub_field_schema = acf_get_field_rest_schema( $sub_field ) ) {
					$schema['properties'][ $sub_field['name'] ] = $sub_field_schema;
				}
			}

			return $schema;
		}

		/**
		 * Apply basic formatting to prepare the value for default REST output.
		 *
		 * @param mixed      $value
		 * @param int|string $post_id
		 * @param array      $field
		 * @return array|mixed
		 */
		public function format_value_for_rest( $value, $post_id, array $field ) {
			if ( empty( $value ) || ! is_array( $value ) || empty( $field['sub_fields'] ) ) {
				return $value;
			}

			// Loop through each row and within that, each sub field to process sub fields individually.
			foreach ( $field['sub_fields'] as $sub_field ) {

				// Extract the sub field 'field_key'=>'value' pair from the $value and format it.
				$sub_value = acf_extract_var( $value, $sub_field['key'] );
				$sub_value = acf_format_value_for_rest( $sub_value, $post_id, $sub_field );

				// Add the sub field value back to the $value but mapped to the field name instead
				// of the key reference.
				$value[ $sub_field['name'] ] = $sub_value;
			}

			return $value;
		}
}


// initialize
new Archive_EVENT_FIELD( $this->settings );


// class_exists check
endif;

?>