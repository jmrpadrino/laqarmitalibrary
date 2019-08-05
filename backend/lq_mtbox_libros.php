<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'yourprefix_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

/**
 * Conditionally displays a metabox when used as a callback in the 'show_on_cb' cmb2_box parameter
 *
 * @param  CMB2 $cmb CMB2 object.
 *
 * @return bool      True if metabox should show
 */
function yourprefix_show_if_front_page( $cmb ) {
	// Don't show this metabox if it's not the front page template.
	if ( get_option( 'page_on_front' ) !== $cmb->object_id ) {
		return false;
	}
	return true;
}

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field $field Field object.
 *
 * @return bool              True if metabox should show
 */
function yourprefix_hide_if_no_cats( $field ) {
	// Don't show this field if not in the cats category.
	if ( ! has_tag( 'cats', $field->object_id ) ) {
		return false;
	}
	return true;
}



add_action( 'cmb2_admin_init', 'yourprefix_register_demo_metabox' );
/**
 * Hook in and add a demo metabox. Can only happen on the 'cmb2_admin_init' or 'cmb2_init' hook.
 */
function yourprefix_register_demo_metabox() {
	/**
	 * Sample metabox to demonstrate each field type included
	 */
	$cmb_demo = new_cmb2_box( array(
		'id'            => 'yourprefix_demo_metabox',
		'title'         => esc_html__( 'Test Metabox', 'cmb2' ),
		'object_types'  => array( 'libros' ), // Post type
		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		// 'context'    => 'normal',
		// 'priority'   => 'high',
		// 'show_names' => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // true to keep the metabox closed by default
		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.

		/*
		 * The following parameter is any additional arguments passed as $callback_args
		 * to add_meta_box, if/when applicable.
		 *
		 * CMB2 does not use these arguments in the add_meta_box callback, however, these args
		 * are parsed for certain special properties, like determining Gutenberg/block-editor
		 * compatibility.
		 *
		 * Examples:
		 *
		 * - Make sure default editor is used as metabox is not compatible with block editor
		 *      [ '__block_editor_compatible_meta_box' => false/true ]
		 *
		 * - Or declare this box exists for backwards compatibility
		 *      [ '__back_compat_meta_box' => false ]
		 *
		 * More: https://wordpress.org/gutenberg/handbook/extensibility/meta-box/
		 */
		// 'mb_callback_args' => array( '__block_editor_compatible_meta_box' => false ),
	) );

	$cmb_demo->add_field( array(
		'name'       => esc_html__( 'Test Text', 'cmb2' ),
		'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => 'yourprefix_demo_text',
		'type'       => 'text',
		'show_on_cb' => 'yourprefix_hide_if_no_cats', // function should return a bool value
		// 'sanitization_cb' => 'my_custom_sanitization', // custom sanitization callback parameter
		// 'escape_cb'       => 'my_custom_escaping',  // custom escaping callback parameter
		// 'on_front'        => false, // Optionally designate a field to wp-admin only
		// 'repeatable'      => true,
		// 'column'          => true, // Display field value in the admin post-listing columns
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Text Small', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_demo_textsmall',
		'type' => 'text_small',
		// 'repeatable' => true,
		// 'column' => array(
		// 	'name'     => esc_html__( 'Column Title', 'cmb2' ), // Set the admin column title
		// 	'position' => 2, // Set as the second column.
		// );
		// 'display_cb' => 'yourprefix_display_text_small_column', // Output the display of the column values through a callback.
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Text Medium', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_demo_textmedium',
		'type' => 'text_medium',
	) );

	$cmb_demo->add_field( array(
		'name'       => esc_html__( 'Read-only Disabled Field', 'cmb2' ),
		'desc'       => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'         => 'yourprefix_demo_readonly',
		'type'       => 'text_medium',
		'default'    => esc_attr__( 'Hey there, I\'m a read-only field', 'cmb2' ),
		'save_field' => false, // Disables the saving of this field.
		'attributes' => array(
			'disabled' => 'disabled',
			'readonly' => 'readonly',
		),
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Custom Rendered Field', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_demo_render_row_cb',
		'type' => 'text',
		'render_row_cb' => 'yourprefix_render_row_cb',
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Website URL', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_demo_url',
		'type' => 'text_url',
		// 'protocols' => array('http', 'https', 'ftp', 'ftps', 'mailto', 'news', 'irc', 'gopher', 'nntp', 'feed', 'telnet'), // Array of allowed protocols
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Text Email', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_demo_email',
		'type' => 'text_email',
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Time', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_demo_time',
		'type' => 'text_time',
		// 'time_format' => 'H:i', // Set to 24hr format
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Time zone', 'cmb2' ),
		'desc' => esc_html__( 'Time zone', 'cmb2' ),
		'id'   => 'yourprefix_demo_timezone',
		'type' => 'select_timezone',
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Date Picker', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_demo_textdate',
		'type' => 'text_date',
		// 'date_format' => 'Y-m-d',
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Date Picker (UNIX timestamp)', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_demo_textdate_timestamp',
		'type' => 'text_date_timestamp',
		// 'timezone_meta_key' => 'yourprefix_demo_timezone', // Optionally make this field honor the timezone selected in the select_timezone specified above
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Date/Time Picker Combo (UNIX timestamp)', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_demo_datetime_timestamp',
		'type' => 'text_datetime_timestamp',
	) );

	// This text_datetime_timestamp_timezone field type
	// is only compatible with PHP versions 5.3 or above.
	// Feel free to uncomment and use if your server meets the requirement
	// $cmb_demo->add_field( array(
	// 	'name' => esc_html__( 'Test Date/Time Picker/Time zone Combo (serialized DateTime object)', 'cmb2' ),
	// 	'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
	// 	'id'   => 'yourprefix_demo_datetime_timestamp_timezone',
	// 	'type' => 'text_datetime_timestamp_timezone',
	// ) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Money', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_demo_textmoney',
		'type' => 'text_money',
		// 'before_field' => '£', // override '$' symbol if needed
		// 'repeatable' => true,
	) );

	$cmb_demo->add_field( array(
		'name'    => esc_html__( 'Test Color Picker', 'cmb2' ),
		'desc'    => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'      => 'yourprefix_demo_colorpicker',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
		// 'options' => array(
		// 	'alpha' => true, // Make this a rgba color picker.
		// ),
		// 'attributes' => array(
		// 	'data-colorpicker' => json_encode( array(
		// 		'palettes' => array( '#3dd0cc', '#ff834c', '#4fa2c0', '#0bc991', ),
		// 	) ),
		// ),
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Text Area', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_demo_textarea',
		'type' => 'textarea',
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Text Area Small', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_demo_textareasmall',
		'type' => 'textarea_small',
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Text Area for Code', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_demo_textarea_code',
		'type' => 'textarea_code',
		// 'attributes' => array(
		// 	// Optionally override the code editor defaults.
		// 	'data-codeeditor' => json_encode( array(
		// 		'codemirror' => array(
		// 			'lineNumbers' => false,
		// 			'mode' => 'css',
		// 		),
		// 	) ),
		// ),
		// To keep the previous formatting, you can disable codemirror.
		// 'options' => array( 'disable_codemirror' => true ),
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Title Weeeee', 'cmb2' ),
		'desc' => esc_html__( 'This is a title description', 'cmb2' ),
		'id'   => 'yourprefix_demo_title',
		'type' => 'title',
	) );

	$cmb_demo->add_field( array(
		'name'             => esc_html__( 'Test Select', 'cmb2' ),
		'desc'             => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'               => 'yourprefix_demo_select',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => array(
			'standard' => esc_html__( 'Option One', 'cmb2' ),
			'custom'   => esc_html__( 'Option Two', 'cmb2' ),
			'none'     => esc_html__( 'Option Three', 'cmb2' ),
		),
	) );

	$cmb_demo->add_field( array(
		'name'             => esc_html__( 'Test Radio inline', 'cmb2' ),
		'desc'             => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'               => 'yourprefix_demo_radio_inline',
		'type'             => 'radio_inline',
		'show_option_none' => 'No Selection',
		'options'          => array(
			'standard' => esc_html__( 'Option One', 'cmb2' ),
			'custom'   => esc_html__( 'Option Two', 'cmb2' ),
			'none'     => esc_html__( 'Option Three', 'cmb2' ),
		),
	) );

	$cmb_demo->add_field( array(
		'name'    => esc_html__( 'Test Radio', 'cmb2' ),
		'desc'    => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'      => 'yourprefix_demo_radio',
		'type'    => 'radio',
		'options' => array(
			'option1' => esc_html__( 'Option One', 'cmb2' ),
			'option2' => esc_html__( 'Option Two', 'cmb2' ),
			'option3' => esc_html__( 'Option Three', 'cmb2' ),
		),
	) );

	$cmb_demo->add_field( array(
		'name'     => esc_html__( 'Test Taxonomy Radio', 'cmb2' ),
		'desc'     => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'       => 'yourprefix_demo_text_taxonomy_radio',
		'type'     => 'taxonomy_radio', // Or `taxonomy_radio_inline`/`taxonomy_radio_hierarchical`
		'taxonomy' => 'category', // Taxonomy Slug
		// 'inline'  => true, // Toggles display to inline
		// Optionally override the args sent to the WordPress get_terms function.
		'query_args' => array(
			// 'orderby' => 'slug',
			// 'hide_empty' => true,
		),
	) );

	$cmb_demo->add_field( array(
		'name'     => esc_html__( 'Test Taxonomy Select', 'cmb2' ),
		'desc'     => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'       => 'yourprefix_demo_taxonomy_select',
		'type'     => 'taxonomy_select', // Or `taxonomy_select_hierarchical`
		'taxonomy' => 'category', // Taxonomy Slug
	) );

	$cmb_demo->add_field( array(
		'name'     => esc_html__( 'Test Taxonomy Multi Checkbox', 'cmb2' ),
		'desc'     => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'       => 'yourprefix_demo_multitaxonomy',
		'type'     => 'taxonomy_multicheck', // Or `taxonomy_multicheck_inline`/`taxonomy_multicheck_hierarchical`
		'taxonomy' => 'post_tag', // Taxonomy Slug
		// 'inline'  => true, // Toggles display to inline
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Checkbox', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_demo_checkbox',
		'type' => 'checkbox',
	) );

	$cmb_demo->add_field( array(
		'name'    => esc_html__( 'Test Multi Checkbox', 'cmb2' ),
		'desc'    => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'      => 'yourprefix_demo_multicheckbox',
		'type'    => 'multicheck',
		// 'multiple' => true, // Store values in individual rows
		'options' => array(
			'check1' => esc_html__( 'Check One', 'cmb2' ),
			'check2' => esc_html__( 'Check Two', 'cmb2' ),
			'check3' => esc_html__( 'Check Three', 'cmb2' ),
		),
		// 'inline'  => true, // Toggles display to inline
	) );

	$cmb_demo->add_field( array(
		'name'    => esc_html__( 'Test wysiwyg', 'cmb2' ),
		'desc'    => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'      => 'yourprefix_demo_wysiwyg',
		'type'    => 'wysiwyg',
		'options' => array(
			'textarea_rows' => 5,
		),
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'Test Image', 'cmb2' ),
		'desc' => esc_html__( 'Upload an image or enter a URL.', 'cmb2' ),
		'id'   => 'yourprefix_demo_image',
		'type' => 'file',
	) );

	$cmb_demo->add_field( array(
		'name'         => esc_html__( 'Multiple Files', 'cmb2' ),
		'desc'         => esc_html__( 'Upload or add multiple images/attachments.', 'cmb2' ),
		'id'           => 'yourprefix_demo_file_list',
		'type'         => 'file_list',
		'preview_size' => array( 100, 100 ), // Default: array( 50, 50 )
	) );

	$cmb_demo->add_field( array(
		'name' => esc_html__( 'oEmbed', 'cmb2' ),
		'desc' => sprintf(
			/* translators: %s: link to codex.wordpress.org/Embeds */
			esc_html__( 'Enter a youtube, twitter, or instagram URL. Supports services listed at %s.', 'cmb2' ),
			'<a href="https://codex.wordpress.org/Embeds">codex.wordpress.org/Embeds</a>'
		),
		'id'   => 'yourprefix_demo_embed',
		'type' => 'oembed',
	) );

	$cmb_demo->add_field( array(
		'name'         => 'Testing Field Parameters',
		'id'           => 'yourprefix_demo_parameters',
		'type'         => 'text',
		'before_row'   => 'yourprefix_before_row_if_2', // callback.
		'before'       => '<p>Testing <b>"before"</b> parameter</p>',
		'before_field' => '<p>Testing <b>"before_field"</b> parameter</p>',
		'after_field'  => '<p>Testing <b>"after_field"</b> parameter</p>',
		'after'        => '<p>Testing <b>"after"</b> parameter</p>',
		'after_row'    => '<p>Testing <b>"after_row"</b> parameter</p>',
	) );

}


//add_action( 'cmb2_admin_init', 'yourprefix_register_repeatable_group_field_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function yourprefix_register_repeatable_group_field_metabox() {

	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box( array(
		'id'           => 'yourprefix_group_metabox',
		'title'        => esc_html__( 'Repeating Field Group', 'cmb2' ),
		'object_types' => array( 'page' ),
	) );

	// $group_field_id is the field id string, so in this case: 'yourprefix_group_demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => 'yourprefix_group_demo',
		'type'        => 'group',
		'description' => esc_html__( 'Generates reusable form entries', 'cmb2' ),
		'options'     => array(
			'group_title'    => esc_html__( 'Entry {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'     => esc_html__( 'Add Another Entry', 'cmb2' ),
			'remove_button'  => esc_html__( 'Remove Entry', 'cmb2' ),
			'sortable'       => true,
			// 'closed'      => true, // true to have the groups closed by default
			// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', 'cmb2' ), // Performs confirmation before removing group.
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => esc_html__( 'Entry Title', 'cmb2' ),
		'id'         => 'title',
		'type'       => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name'        => esc_html__( 'Description', 'cmb2' ),
		'description' => esc_html__( 'Write a short description for this entry', 'cmb2' ),
		'id'          => 'description',
		'type'        => 'textarea_small',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => esc_html__( 'Entry Image', 'cmb2' ),
		'id'   => 'image',
		'type' => 'file',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => esc_html__( 'Image Caption', 'cmb2' ),
		'id'   => 'image_caption',
		'type' => 'text',
	) );

}


//add_action( 'cmb2_admin_init', 'yourprefix_register_taxonomy_metabox' );
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function yourprefix_register_taxonomy_metabox() {

	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb_term = new_cmb2_box( array(
		'id'               => 'yourprefix_term_edit',
		'title'            => esc_html__( 'Category Metabox', 'cmb2' ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( 'category', 'post_tag' ), // Tells CMB2 which taxonomies should have these fields
		// 'new_term_section' => true, // Will display in the "Add New Category" section
	) );

	$cmb_term->add_field( array(
		'name'     => esc_html__( 'Extra Info', 'cmb2' ),
		'desc'     => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'       => 'yourprefix_term_extra_info',
		'type'     => 'title',
		'on_front' => false,
	) );

	$cmb_term->add_field( array(
		'name' => esc_html__( 'Term Image', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_term_avatar',
		'type' => 'file',
	) );

	$cmb_term->add_field( array(
		'name' => esc_html__( 'Arbitrary Term Field', 'cmb2' ),
		'desc' => esc_html__( 'field description (optional)', 'cmb2' ),
		'id'   => 'yourprefix_term_term_text_field',
		'type' => 'text',
	) );

}

/**
 * Only show this box in the CMB2 REST API if the user is logged in.
 *
 * @param  bool                 $is_allowed     Whether this box and its fields are allowed to be viewed.
 * @param  CMB2_REST_Controller $cmb_controller The controller object.
 *                                              CMB2 object available via `$cmb_controller->rest_box->cmb`.
 *
 * @return bool                 Whether this box and its fields are allowed to be viewed.
 */
function yourprefix_limit_rest_view_to_logged_in_users( $is_allowed, $cmb_controller ) {
	if ( ! is_user_logged_in() ) {
		$is_allowed = false;
	}

	return $is_allowed;
}

//add_action( 'cmb2_init', 'yourprefix_register_rest_api_box' );
/**
 * Hook in and add a box to be available in the CMB2 REST API. Can only happen on the 'cmb2_init' hook.
 * More info: https://github.com/CMB2/CMB2/wiki/REST-API
 */
function yourprefix_register_rest_api_box() {
	$cmb_rest = new_cmb2_box( array(
		'id'            => 'yourprefix_rest_metabox',
		'title'         => esc_html__( 'REST Test Box', 'cmb2' ),
		'object_types'  => array( 'page' ), // Post type
		'show_in_rest' => WP_REST_Server::ALLMETHODS, // WP_REST_Server::READABLE|WP_REST_Server::EDITABLE, // Determines which HTTP methods the box is visible in.
		// Optional callback to limit box visibility.
		// See: https://github.com/CMB2/CMB2/wiki/REST-API#permissions
		// 'get_box_permissions_check_cb' => 'yourprefix_limit_rest_view_to_logged_in_users',
	) );

	$cmb_rest->add_field( array(
		'name'       => esc_html__( 'REST Test Text', 'cmb2' ),
		'desc'       => esc_html__( 'Will show in the REST API for this box and for pages.', 'cmb2' ),
		'id'         => 'yourprefix_rest_text',
		'type'       => 'text',
	) );

	$cmb_rest->add_field( array(
		'name'       => esc_html__( 'REST Editable Test Text', 'cmb2' ),
		'desc'       => esc_html__( 'Will show in REST API "editable" contexts only (`POST` requests).', 'cmb2' ),
		'id'         => 'yourprefix_rest_editable_text',
		'type'       => 'text',
		'show_in_rest' => WP_REST_Server::EDITABLE,// WP_REST_Server::ALLMETHODS|WP_REST_Server::READABLE, // Determines which HTTP methods the field is visible in. Will override the cmb2_box 'show_in_rest' param.
	) );
}
