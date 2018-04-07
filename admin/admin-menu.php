<?php  // Fit4Life Admin Page

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


// add top-level administrative menu
function fit4life_add_toplevel_menu() {

	/*
		add_menu_page(
			string   $page_title,
			string   $menu_title,
			string   $capability,
			string   $menu_slug,
			callable $function = '',
			string   $icon_url = '',
			int      $position = null
		)
	*/

	add_menu_page(
		'Fit4Life Settings',
		'Fit4Life',
		'manage_options',
		'fit4life',
		'fit4life_display_settings_page',
		'dashicons-smiley',
		null
	);

}
add_action( 'admin_menu', 'fit4life_add_toplevel_menu' );
