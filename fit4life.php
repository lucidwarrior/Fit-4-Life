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
		1.1 - registers all our custom shortcodes on init
		1.2 - registers action to remove admin bar
		1.3 - register Ajax actions
        1.4 - Load external files to public website
        1.5 - register custom admin column headers
        1.6 - register custom admin column data
        1.7 - add filter by author to workout admin page
        1.8 - add filter by author to fitness test admin page
        1.9 - add filter by author to exercise admin page
        1.10 - add filters for Advanced Custom Fields Settings
        1.11 - register our admin pages
	2. SHORTCODES
		2.1 - fit4life_register_shortcodes()
		2.2 - fit4life_register_shortcodes()
		2.3 - fit4life_active_fit_tests_shortcode()
	3. FILTERS
		3.1a - Add workout column headers
		3.1b - Add fit-test column headers
		3.1c - Add exercises column headers
		3.2a - Defining the filter that will be used so we can select posts by 'member'
		3.2b - Defining the filter that will be used so we can select posts by 'member'
		3.2c - Defining the filter that will be used so we can select posts by 'trainer'
		3.3a - Restrict the posts by an additional author filter
		3.3b - Restrict the posts by an additional author filter
		3.3c - Restrict the posts by an additional author filter
        3.4 - fit4life_admin_menus()
	4. EXTERNAL SCRIPTS
		4.1 - Include ACF plugin path
        4.2 - Loads external files into PUBLIC website; fit4life_public_scripts()
        4.3 - Include file to assign template files to custom post types
        4.4 - loads external files into wordpress ADMIN
	5. ACTIONS
		5.1 - fit4life_workout_results()
		5.2 - fit4life_update_fit_test()
		5.3 - remove_admin_bar()
	6. HELPERS
	7. CUSTOM POST TYPES
        7.1 - Include ACF PHP Code
        7.2 - Include CPT PHP Code
	8. ADMIN PAGES
        8.1 - dashboard
        8.2 - Workout admin page
        8.3 - Fitness test admin page
        8.4 - Exercise admin page
	9. SETTINGS
*/


// 1. HOOKS

// 1.1
// hint: registers all our custom shortcodes on init
add_action( 'init', 'fit4life_register_shortcodes' );

// 1.2
// hint: registers action to remove admin bar
add_action( 'after_setup_theme', 'remove_admin_bar' );

// 1.3
// hint: register Ajax actions
add_action( 'wp_ajax_nopriv_fit4life_workout_results','fit4life_workout_results' ); 	// Workout updates for regular website visitor
add_action( 'wp_ajax_fit4life_workout_results','fit4life_workout_results' ); 			// Workout updates for admin user
add_action( 'wp_ajax_nopriv_fit4life_update_fit_test','fit4life_update_fit_test' ); 	// Fit-Test updates for regular website visitor
add_action( 'wp_ajax_fit4life_update_fit_test','fit4life_update_fit_test' ); 			// Fit-Test updates for admin user

// 1.4
// hint: Load external files to public website
add_action( 'wp_enqueue_scripts', 'fit4life_public_scripts' );

// 1.5
// hint: register custom admin column headers
add_filter( 'manage_edit-fit4life_workout_columns','fit4life_workout_column_headers' );
add_filter( 'manage_edit-fit4life_fit_test_columns','fit4life_fit_test_column_headers' );
add_filter( 'manage_edit-fit4life_exercise_columns','fit4life_exercise_column_headers' );

// 1.6
// hint: register custom admin column data
add_filter( 'manage_fit4life_exercise_posts_custom_column','fit4life_exercise_column_data',1,2 );

// 1.7
// hint: add filter by author to workout admin page
add_action('restrict_manage_posts','add_author_filter_to_workout_administration');
add_action('pre_get_posts','add_author_filter_to_workout_query');

// 1.8
// hint: add filter by author to fit test admin page
add_action('restrict_manage_posts','add_author_filter_to_fit_test_administration');
add_action('pre_get_posts','add_author_filter_to_fit_test_query');

// 1.9
// hint: add filter by author to exercise admin page
add_action('restrict_manage_posts','add_author_filter_to_exercise_administration');
add_action('pre_get_posts','add_author_filter_to_exercise_query');

// 1.10
// Advanced Custom Fields Settings
add_filter('acf/settings/path', 'fit4life_acf_settings_path');
function fit4life_acf_settings_path( $path ) {
 
    // update path
    $path = 'http://fit4life.lucidwisdom.com/wp-content/plugins/fit4life/lib/advanced-custom-fields-pro/';
    
    //var_dump($path);
    
    // return
    return $path;
    
}

add_filter('acf/settings/dir', 'fit4life_acf_settings_dir');
function fit4life_acf_settings_dir( $dir ) {
 
    // update path
    $dir = 'http://fit4life.lucidwisdom.com/wp-content/plugins/fit4life/lib/advanced-custom-fields-pro/';
    
    //var_dump($dir);
    
    // return
    return $dir;
    
}

add_filter('acf/settings/show_admin', '__return_false');

// The output using plugin_dir_path( __FILE__ ) for the plugin path; http://fit4life.lucidwisdom.com/home2/gmduqhmy/public_html/fit4life/wp-content/plugins/fit4life/lib/advanced-custom-fields-pro/

// 1.11
// register our admin pages
add_action('admin_menu', 'fit4life_admin_menus');

// 1.12
// hint: load external files in WordPress admin
add_action('admin_enqueue_scripts', 'fit4life_admin_scripts');




// 2. SHORTCODES

// 2.1
// hint: registers all our custom shortcodes
function fit4life_register_shortcodes() {

    add_shortcode( 'fit4life_active_workouts', 'fit4life_active_workouts_shortcode' );
    add_shortcode( 'fit4life_active_fit_tests', 'fit4life_active_fit_tests_shortcode' );

}

// 2.2
// hint: list active program posts using shortcode [fit4life_active_workouts]
function fit4life_active_workouts_shortcode( $args, $content="") {

	// setup our output variable - the form html
	global $post;
    $output = '';
	$current_user = wp_get_current_user();
	$member_name = $current_user->first_name . " " . $current_user->last_name;

	$user_args = array(
		'posts_per_page'   => 15,
		'post_type' => array('fit4life_workout'),
		'author' => $current_user->ID,
		'orderby' => 'post_date',
		'order' => 'ASC',
		'post_status' => 'publish',
	);

	$output = '<div class="member_post_sidebar">';

	$myposts = get_posts( $user_args );

	if($myposts) {

    $output .= '<ul class="prog_active_list">';

		foreach ( $myposts as $post ) : setup_postdata( $post );

			$output .= '<li class="prog_active_item">&#8594; <a href="'. get_permalink() . '">' . get_the_title() . '</a></li>';

		endforeach;

    $output .= '</ul>';

		}

		else {

			$output = 'No Workouts Assigned';

		}

		wp_reset_postdata();

	$output .= '</div>';

	// return our results/html
	return $output;

}

// 2.3
// hint: list active fitness test posts using shortcode [fit4life_active_fit_tests]
function fit4life_active_fit_tests_shortcode( $args, $content="") {

	// setup our output variable - the form html
	global $post;
	$output = '';
	$current_user = wp_get_current_user();
	$member_name = $current_user->first_name . " " . $current_user->last_name;

	$user_args = array(
		'posts_per_page'   => 15,
		'post_type' => array('fit4life_fit_test'),
		'author' => $current_user->ID,
		'orderby' => 'post_date',
		'order' => 'ASC',
		'post_status' => 'publish',
	);

	$output = '<div class="member_post_sidebar">';

	$myposts = get_posts( $user_args );

	if($myposts) {

  	$output .= '<ul class="prog_active_list">';

		foreach ( $myposts as $post ) : setup_postdata( $post );

			$output .= '<li class="prog_active_item">&#8594; <a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';

		endforeach;

    $output .= '</ul>';

		}

		else {

			$output = 'No Fitness Test Assigned';

		}

	wp_reset_postdata();

	$output .= '</div>';

	// return our results/html
	return $output;

}




/* 3. FILTERS */

// 3.1a
// hint: Add workout column headers
function fit4life_workout_column_headers( $columns ) {

	// creating custom column header data
	$columns = array(
		'cb'=>'<input type="checkbox" />',
		'title'=>__('Workout Name'),
		'author' =>__('Member'),
		'date'=>__('Date')
	);

	// returning new columns
	return $columns;

}

// 3.1b
// hint: Add fit-test column headers
function fit4life_fit_test_column_headers( $columns ) {

	// creating custom column header data
	$columns = array(
		'cb'=>'<input type="checkbox" />',
		'title'=>__('Fitness Test Name'),
		'author' =>__('Member'),
		'date'=>__('Date')
	);

	// returning new columns
	return $columns;

}

// 3.1c
// hint: Add exercises column headers
function fit4life_exercise_column_headers( $columns ) {

	// creating custom column header data
	$columns = array(
		'cb'=>'<input type="checkbox" />',
		'title'=>__('Exercise Name'),
		'author' =>__('Trainer'),
    'movement'=>__('Movement'),
    'area'=>__('Area'),
		'date'=>__('Date')
	);

	// returning new columns
	return $columns;

}

// 3.2a
// hint: defining the filter that will be used so we can select posts by 'member'
function add_author_filter_to_workout_administration(){

    //execute only on the 'post' content type
    global $post_type;
    if($post_type == 'fit4life_workout'){

        //get a listing of all users that are 'author' or above
        $user_args = array(
            'show_option_all'   => 'All Members',
            'orderby'           => 'display_name',
            'order'             => 'ASC',
            'name'              => 'author_admin_filter',
            'who'               => 'authors',
            'include_selected'  => true
        );

        //determine if we have selected a user to be filtered by already
        if(isset($_GET['author_admin_filter'])){
            //set the selected value to the value of the author
            $user_args['selected'] = (int)sanitize_text_field($_GET['author_admin_filter']);
        }

        //display the users as a drop down
        wp_dropdown_users($user_args);
    }

}

// 3.2b
// hint: defining the filter that will be used so we can select posts by 'member'
function add_author_filter_to_fit_test_administration(){

    //execute only on the 'post' content type
    global $post_type;
    if($post_type == 'fit4life_fit_test'){

        //get a listing of all users that are 'author' or above
        $user_args = array(
            'show_option_all'   => 'All Members',
            'orderby'           => 'display_name',
            'order'             => 'ASC',
            'name'              => 'author_admin_filter',
            'who'               => 'authors',
            'include_selected'  => true
        );

        //determine if we have selected a user to be filtered by already
        if(isset($_GET['author_admin_filter'])){
            //set the selected value to the value of the author
            $user_args['selected'] = (int)sanitize_text_field($_GET['author_admin_filter']);
        }

        //display the users as a drop down
        wp_dropdown_users($user_args);
    }

}

// 3.2c
// hint: defining the filter that will be used so we can select posts by 'trainer'
function add_author_filter_to_exercise_administration(){

    //execute only on the 'post' content type
    global $post_type;
    if($post_type == 'fit4life_exercise'){

        //get a listing of all users that are 'author' or above
        $user_args = array(
            'show_option_all'   => 'All Trainers',
            'orderby'           => 'display_name',
            'order'             => 'ASC',
            'name'              => 'author_admin_filter',
            'who'               => 'authors',
            'include_selected'  => true
        );

        //determine if we have selected a user to be filtered by already
        if(isset($_GET['author_admin_filter'])){
            //set the selected value to the value of the author
            $user_args['selected'] = (int)sanitize_text_field($_GET['author_admin_filter']);
        }

        //display the users as a drop down
        wp_dropdown_users($user_args);
    }

}

// 3.3a
// hint: restrict the posts by an additional author filter
function add_author_filter_to_workout_query($query){

    global $post_type, $pagenow;

    //if we are currently on the edit screen of the post type listings
    if($pagenow == 'edit.php' && $post_type == 'fit4life_workout'){

        if(isset($_GET['author_admin_filter'])){

            //set the query variable for 'author' to the desired value
            $author_id = sanitize_text_field($_GET['author_admin_filter']);

            //if the author is not 0 (meaning all)
            if($author_id != 0){
                $query->query_vars['author'] = $author_id;
            }

        }
    }
}

// 3.3b
// hint: restrict the posts by an additional author filter
function add_author_filter_to_fit_test_query($query){

    global $post_type, $pagenow;

    //if we are currently on the edit screen of the post type listings
    if($pagenow == 'edit.php' && $post_type == 'fit4life_fit_test'){

        if(isset($_GET['author_admin_filter'])){

            //set the query variable for 'author' to the desired value
            $author_id = sanitize_text_field($_GET['author_admin_filter']);

            //if the author is not 0 (meaning all)
            if($author_id != 0){
                $query->query_vars['author'] = $author_id;
            }

        }
    }
}

// 3.3c
// hint: restrict the posts by an additional author filter
function add_author_filter_to_exercise_query($query){

    global $post_type, $pagenow;

    //if we are currently on the edit screen of the post type listings
    if($pagenow == 'edit.php' && $post_type == 'fit4life_exercise'){

        if(isset($_GET['author_admin_filter'])){

            //set the query variable for 'author' to the desired value
            $author_id = sanitize_text_field($_GET['author_admin_filter']);

            //if the author is not 0 (meaning all)
            if($author_id != 0){
                $query->query_vars['author'] = $author_id;
            }

        }
    }
}

// 3.4
// hint: register custom plugin admin menus
function fit4life_admin_menus() {
    
    /* Main Menu */
    
        $top_menu_item = 'fit4life_dashboard_admin_page';
    
        add_menu_page( '', 'Fit 4 Life', 'manage_options', 'fit4life_dashboard_admin_page', 'fit4life_dashboard_admin_page', 'dashicons-universal-access-alt', 3);
    
    /* Sub Menu Items */
    
        // dashboard
        add_submenu_page( $top_menu_item, '', 'Dashboard', 'manage_options', $top_menu_item, $top_menu_item );
    
        // workouts
        add_submenu_page( $top_menu_item, '', 'Workouts', 'manage_options', 'edit.php?post_type=fit4life_workout' );
    
        // fitness tests
        add_submenu_page( $top_menu_item, '', 'Fitness Tests', 'manage_options', 'edit.php?post_type=fit4life_fit_test' );
    
        // exercises
        add_submenu_page( $top_menu_item, '', 'Exercises', 'manage_options', 'edit.php?post_type=fit4life_exercise' );
    
        // plugin options
        add_submenu_page( $top_menu_item, '', 'Plugin Options', 'manage_options', 'fit4life_options_admin_page', 'fit4life_options_admin_page' );
    
}


/* 4. EXTERNAL SCRIPTS */

// 4.1
// Include ACF
include_once( plugin_dir_path( __FILE__ ) . '/lib/advanced-custom-fields-pro/acf.php');

// 4.2
// hint: Loads external files into PUBLIC website
function fit4life_public_scripts() {

    // register scripts with WordPress's internal library
    wp_register_script('fit4life_workout_update-js-public', plugins_url('/public/js/fit4life_workout_update.js',__FILE__), array('jquery'),'',true);
    wp_register_script('fit4life_workout_menu-js-public', plugins_url('/public/js/fit4life_workout_menu.js',__FILE__), array('jquery'),'',true);
    wp_register_script('fit4life_fit_test_update-js-public', plugins_url('/public/js/fit4life_fit_test_update.js',__FILE__), array('jquery'),'',true);
    wp_register_script('fit4life_login-js-public', plugins_url('/public/js/fit4life_login.js',__FILE__), array('jquery'),'',true);
    wp_register_style('fit4life-css-public', plugins_url('/public/css/fit4life_style.css',__FILE__) );

    // add to que of scripts that get loaded into every page
    wp_enqueue_script('fit4life_workout_update-js-public');
    wp_enqueue_script('fit4life_workout_menu-js-public');
    wp_enqueue_script('fit4life_fit_test_update-js-public');
    wp_enqueue_script('fit4life_login-js-public');
    wp_enqueue_style('fit4life-css-public');

}

// 4.3
// Include dependencies: admin and public
require_once plugin_dir_path( __FILE__ ) . 'includes/template-filters.php';

// 4.4
// hint: loads external files into wordpress ADMIN
function fit4life_admin_scripts() {
    
    // register scripts with WordPress's internal library
    wp_register_script('fit4life-js-private', plugins_url('/private/js/fit4life.js', __FILE__),array('jquery'),'',true);
    
    // add to queue of scripts that get loaded into every admin page
    wp_enqueue_script('fit4life-js-private');
}


/* 5 - ACTIONS */

// 5.1
// hint: Update results value for each exercise from single-fit4life_workout.php
function fit4life_workout_results(){

	try {
    
        if(isset($_POST)) {

            $count = count($_POST) - 2;
            $post_id = $_POST['program_id'];        //passing post_id from workout form
            $day = $_POST['fit4life_day_num'];      //passing day number from workout form

            //update_sub_field(array('gf_workout_programs', 1, 'gf_exercises', 4, 'gf_exercise_results'), 'Test Data', 2565);

            $exercise = 1;

            while($exercise <= $count) {
                $results = $_POST['fit4life_exercise_results_' . $exercise];
                update_sub_field(array('fit4life_workout_program', $day, 'fit4life_exercises', $exercise, 'fit4life_exercise_results'), $results, $post_id);
                $exercise++;
            }

        }
        
    } catch ( Exception $e ) {
		
	}

}

add_action( 'init', 'fit4life_workout_results', 0 );

// 5.2
// hint: Update results for each fit-test form from single-fit4life_fit_test.php
function fit4life_update_fit_test(){

    try {
    
        if ( ! empty( $_POST ) && ! empty( $_POST['program_id'] ) ) {
        $post_id = $_POST['program_id'];

            if ( ! empty( $_POST['fit4life_test_start_date'] ) ) {
                update_field( 'fit4life_test_start_date', $_POST['fit4life_test_start_date'], $post_id );
            }

            if ( ! empty( $_POST['fit4life_test_end_date'] ) ) {
                update_field( 'fit4life_test_end_date', $_POST['fit4life_test_end_date'], $post_id );
            }

            if ( ! empty( $_POST['fit4life_coach_notes'] ) ) {
                update_field( 'fit4life_coach_notes', $_POST['fit4life_coach_notes'], $post_id );
            }

            $tests = get_field('fit4life_movement_performance_tests', $post_id);
            if ( ! empty( $tests ) ) {

              $checks = array();
              if ( ! empty( $_POST['fit4life_can_you_perform'] ) ) {
                  $checks = $_POST['fit4life_can_you_perform'];
              }

              foreach( $tests as $row_index => &$row ) {
                if ( in_array( $row_index, $checks ) ) {
                    $row['fit4life_can_you_perform'] = 'yes';
                }
                else
                {
                    $row['fit4life_can_you_perform'] = '';
                }
              }
              update_field('fit4life_movement_performance_tests',$tests, $post_id);

            }

            $exercises = get_field('fit4life_maximum_performance_tests', $post_id);
            if ( ! empty( $exercises ) ) {

                $starting_values = array();
                if ( ! empty( $_POST['fit4life_starting_value'] ) )
                {
                    $starting_values = $_POST['fit4life_starting_value'];
                }

                $ending_values = array();
                if ( ! empty( $_POST['fit4life_ending_value'] ) )
                {
                    $ending_values = $_POST['fit4life_ending_value'];
                }

                foreach ( $exercises as $row_index => &$exercise )
                {
                    if ( isset( $starting_values[$row_index] ) )
                    {
                        $exercise['fit4life_starting_value'] = $starting_values[$row_index];
                    }
                    if ( isset( $ending_values[$row_index] ) )
                    {
                        $exercise['fit4life_ending_value']   = $ending_values[$row_index];
                    }
                }

                update_field('fit4life_maximum_performance_tests',$exercises, $post_id);
            }

        }

    } catch ( Exception $e ) {
		
	}

}

add_action( 'init', 'fit4life_update_fit_test', 0 );

// 5.3
// hint: Removed admin toolbar for all users except administrator
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
}


/* 7. CUSTOM POST TYPES */

// 7.1 ACF code
include_once plugin_dir_path( __FILE__ ) . 'includes/acf_code.php';

// 7.2 CPT Code
include_once plugin_dir_path( __FILE__ ) . 'includes/cpt_code.php';




/* 8. ADMIN PAGES */

// 8.1
// hint: dashboard admin page
function fit4life_dashboard_admin_page() {
    
    $output = '
        <div class="wrap">
            
            <h2>Fit 4 Life</h2>
            
            <p>The Fit 4 Life plugin for WordPress. Build custom workouts, create exercise libraries, set up fitness tests, for your personal fitness students.</p>
            
        </div>
            
    ';
    
    
    echo $output;
    
}

// 8.2
// hint: workout admin page
function fit4life_workout_admin_page() {
    
    $output = '
        <div class="wrap">
        
            <h2>Fit 4 Life Workout Options</h2>
            
            <p>Page description...</p>
            
        </div>  
    
    ';
    
    echo $output;
    
}
 
// 8.3
// hint: fitness test admin page
function fit4life_fit_test_admin_page() {
    
    $output = '
        <div class="wrap">
        
            <h2>Fit 4 Life Fitness Test Options</h2>
            
            <p>Page description...</p>
            
        </div>  
    
    ';
    
    echo $output;
    
}

// 8.4
// hint: exercise admin page
function fit4life_exercise_admin_page() {
    
    $output = '
        <div class="wrap">
        
            <h2>Fit 4 Life Exercise Options</h2>
            
            <p>Page description...</p>
            
        </div>  
    
    ';
    
    echo $output;
    
}

// 8.5
// hint: plugin options admin page
function fit4life_options_admin_page() {
    
    $output = '
        <div class="wrap">
        
            <h2>Fit 4 Life Plugin Options</h2>
            
            <p>Page description...</p>
            
        </div>  
    
    ';
    
    echo $output;
    
}

