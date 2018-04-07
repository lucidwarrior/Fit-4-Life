<?php  // Settings register page

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


// register plugin settings
function fit4life_register_settings() {

	/*

	register_setting(
		string   $option_group,
		string   $option_name,
		callable $sanitize_callback
	);

	*/

	register_setting(
		'fit4life_options',
		'fit4life_options',
		'fit4life_callback_validate_options'
	);

	/*

	add_settings_section(
		string   $id,
		string   $title,
		callable $callback,
		string   $page
	);

	*/

	add_settings_section(
		'fit4life_section_login',
		'Customize Login Page',
		'fit4life_callback_section_login',
		'fit4life'
	);

	add_settings_section(
		'fit4life_section_admin',
		'Customize Admin Area',
		'fit4life_callback_section_admin',
		'fit4life'
	);

	/*

	add_settings_field(
    	string   $id,
		string   $title,
		callable $callback,
		string   $page,
		string   $section = 'default',
		array    $args = []
	);

	*/

	add_settings_field(
		'custom_url',
		'Custom URL',
		'fit4life_callback_field_text',
		'fit4life',
		'fit4life_section_login',
		[ 'id' => 'custom_url', 'label' => 'Custom URL for the login logo link' ]
	);

	add_settings_field(
		'custom_title',
		'Custom Title',
		'fit4life_callback_field_text',
		'fit4life',
		'fit4life_section_login',
		[ 'id' => 'custom_title', 'label' => 'Custom title attribute for the logo link' ]
	);

	add_settings_field(
		'custom_style',
		'Custom Style',
		'fit4life_callback_field_radio',
		'fit4life',
		'fit4life_section_login',
		[ 'id' => 'custom_style', 'label' => 'Custom CSS for the Login screen' ]
	);

	add_settings_field(
		'custom_message',
		'Custom Message',
		'fit4life_callback_field_textarea',
		'fit4life',
		'fit4life_section_login',
		[ 'id' => 'custom_message', 'label' => 'Custom text and/or markup' ]
	);

	add_settings_field(
		'custom_footer',
		'Custom Footer',
		'fit4life_callback_field_text',
		'fit4life',
		'fit4life_section_admin',
		[ 'id' => 'custom_footer', 'label' => 'Custom footer text' ]
	);

	add_settings_field(
		'custom_toolbar',
		'Custom Toolbar',
		'fit4life_callback_field_checkbox',
		'fit4life',
		'fit4life_section_admin',
		[ 'id' => 'custom_toolbar', 'label' => 'Remove new post and comment links from the Toolbar' ]
	);

	add_settings_field(
		'custom_scheme',
		'Custom Scheme',
		'fit4life_callback_field_select',
		'fit4life',
		'fit4life_section_admin',
		[ 'id' => 'custom_scheme', 'label' => 'Default color scheme for new users' ]
	);

}
add_action( 'admin_init', 'fit4life_register_settings' );
