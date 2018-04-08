<?php
/*
Plugin Name:  Fit-4-Life Personal Trainer
Plugin URI:   https://lucidwisdom.com
Description:  Fitness management application for personal trainers who want to build and manage custom workouts and fitness tests for their clients.
Version:      1.0
Author:       David Cook @ Lucid Wisdom Digital
Author URI: htts://lucidwisdom.com
License:      GPL v2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.txt
Text Domain:  fit4life
Domain Path:  /languages
*/


// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


/* TABLE OF CONTENTS */
/*
	1. HOOKS
	2. SHORTCODES
		2.1 - add_action; registers all our custom shortcodes on init
		2.2 - add_shortcode; registers all our custom shortcodes
		2.3 - fit4life_register_shortcodes()
		2.3 - fit4life_active_fit_tests_shortcode
		>> See includes/shortcode.php
	3. FILTERS
		3.0a - add_filter; register custom admin column headers
		3.0b - add_action; add filter by author to workout admin page
		3.0c - add_action; add filter by author to fit test admin page
		3.1a - Add workout column headers; fit4life_workout_column_headers()
		3.1b - Add fit-test column headers; fit4life_fit_test_column_headers()
		3.2a - Defining the filter that will be used so we can select posts by 'author'; add_author_filter_to_workout_administration()
		3.2b - Defining the filter that will be used so we can select posts by 'author'; add_author_filter_to_fit_test_administration()
		3.3a - Restrict the posts by an additional author filter; add_author_filter_to_workout_query()
		3.3b - Restrict the posts by an additional author filter; add_author_filter_to_fit_test_query()
		3.4 - Add custom column data for exercise custom post type
		3.5 - Assign single-fit4life_fit_test template to custom post type fit4life_fit_test
		3.6 - Assign single-fit4life_workout template to custom post type fit4life_workout
		3.7 - Assign single-fit4life_exercise template to custom post type fit4life_exercise
		>> See includes/filters.php
	4. EXTERNAL SCRIPTS
		4.1 - add_action; Load external files to public website
		4.2 - Loads external files into PUBLIC website; fit4life_public_scripts()
	5. ACTIONS
	6. HELPERS
	7. CUSTOM POST TYPES
	8. ADMIN PAGES
	9. SETTINGS
*/


// if admin area
if ( is_admin() ) {

    // include dependencies
    require_once plugin_dir_path( __FILE__ ) . 'admin/admin-menu.php';
    require_once plugin_dir_path( __FILE__ ) . 'admin/settings-page.php';
		require_once plugin_dir_path( __FILE__ ) . 'admin/settings-register.php';
		require_once plugin_dir_path( __FILE__ ) . 'admin/settings-callback.php';
		require_once plugin_dir_path( __FILE__ ) . 'admin/settings-validate.php';

}


// include dependencies: admin and public
require_once plugin_dir_path( __FILE__ ) . 'includes/core-functions.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/filters.php';


// default plugin options
function fit4life_options_default() {

	return array(
		'custom_url'     => 'https://wordpress.org/',
		'custom_title'   => 'Powered by WordPress',
		'custom_style'   => 'disable',
		'custom_message' => '<p class="custom-message">My custom message</p>',
		'custom_footer'  => 'Special message for users',
		'custom_toolbar' => false,
		'custom_scheme'  => 'default',
	);

}


/* 4. EXTERNAL SCRIPTS */

// 4.1
// hint: Load external files to public website
add_action( 'wp_enqueue_scripts', 'fit4life_public_scripts' );

// 4.2 Loads external files into PUBLIC website
function fit4life_public_scripts() {

    // register scripts with WordPress's internal library
		wp_register_script('fit4life-workout-js-public', 'http://fit4life.lucidwisdom.com/wp-content/plugins/fit4life/public/js/fit4life_workout_js.js', array('jquery'),'',true);
    wp_register_script('fit4life-fittest-js-public', plugin_dir_path(__FILE__) . 'public/js/fit4life_fit_test_js.js', array('jquery'),'',true);
		wp_register_script('fit4life-login-js-public', plugin_dir_path(__FILE__) . 'public/js/fit4life_login.js', array('jquery'),'',true);
    wp_register_style('fit4life-css-public', 'http://fit4life.lucidwisdom.com/wp-content/plugins/fit4life/public/css/fit4life_style.css');

    // add to que of scripts that get loaded into every page
    wp_enqueue_script('fit4life-workout-js-public');
	  wp_enqueue_script('fit4life-fittest-js-public');
		wp_enqueue_script('fit4life-login-js-public');
		wp_enqueue_style('fit4life-css-public');

}
