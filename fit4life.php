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
	2. SHORTCODES
		2.1 - fit4life_register_shortcodes()
		2.2 - fit4life_register_shortcodes()
		2.3 - fit4life_active_fit_tests_shortcode()
	3. FILTERS
		3.0a - add_filter; register custom admin column headers
		3.0b - add_action; add filter by author to workout admin page
		3.0c - add_action; add filter by author to fit test admin page

		3.1a - Add workout column headers
		3.1b - Add fit-test column headers
		3.1c - Add exercises column headers
		3.2a - Add custom exercise column data
		3.3a - Defining the filter that will be used so we can select posts by 'member'
		3.3b - Defining the filter that will be used so we can select posts by 'member'
		3.3c - Defining the filter that will be used so we can select posts by 'trainer'
		3.3d - Defining the filter that will be used so we can select posts by 'Movement'
		3.4a - Restrict the posts by an additional author filter
		3.4b - Restrict the posts by an additional author filter
		3.4c - Restrict the posts by an additional author filter
		3.4d - Restrict the posts by an additional movement filter

		3.5 - Assign single-fit4life_fit_test template to custom post type fit4life_fit_test
		3.6 - Assign single-fit4life_workout template to custom post type fit4life_workout
		3.7 - Assign single-fit4life_exercise template to custom post type fit4life_exercise
	4. EXTERNAL SCRIPTS
		4.1 - Loads external files into PUBLIC website; fit4life_public_scripts()
	5. ACTIONS
		5.1 - fit4life_workout_results()
		5.2 - fit4life_update_fit_test()
		5.3 - remove_admin_bar()
	6. HELPERS
	7. CUSTOM POST TYPES
	8. ADMIN PAGES
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



// include dependencies: admin and public
require_once plugin_dir_path( __FILE__ ) . 'includes/template-filters.php';



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
// hint: Add custom exercise column data
function fit4life_exercise_column_data( $column, $post_id ) {

  // setup our return text
  $output = '';

  switch( $column ) {

    case 'movement':
      // get the custom movement Data
      $movement = the_terms( $post_id, 'fit4life_tax_movement', '', ' / ' );
      $output .= $movement;
      break;

    case 'area':
      // get the custom area Data
      $area = the_terms( $post_id, 'fit4life_tax_area', '', ' / ' );
      $output .= $area;
      break;

  }

  // echo the $output
  echo $output;
}

// 3.3a
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

// 3.3b
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

// 3.3c
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

// 3.4a
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

// 3.4b
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

// 3.4c
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




/* 4. EXTERNAL SCRIPTS */

// 4.1
// hint: Loads external files into PUBLIC website
function fit4life_public_scripts() {

    // register scripts with WordPress's internal library
    wp_register_script('fit4life_workout_update-js-public', plugins_url('/public/js/fit4life_workout_update.js',__FILE__), array('jquery'),'',true);
    wp_register_script('fit4life_workout_menu-js-public', plugins_url('/public/js/fit4life_workout_menu.js',__FILE__), array('jquery'),'',true);
    wp_register_script('fit4life_fit_test-js-public', plugins_url('/public/js/fit4life_fit_test.js',__FILE__), array('jquery'),'',true);
    wp_register_script('fit4life_login-js-public', plugins_url('/public/js/fit4life_login.js',__FILE__), array('jquery'),'',true);
    wp_register_style('fit4life-css-public', plugins_url('/public/css/fit4life_style.css',__FILE__) );

    // add to que of scripts that get loaded into every page
    wp_enqueue_script('fit4life_workout_update-js-public');
    wp_enqueue_script('fit4life_workout_menu-js-public');
    wp_enqueue_script('fit4life_fit_test-js-public');
    wp_enqueue_script('fit4life_login-js-public');
    wp_enqueue_style('fit4life-css-public');

}


/* 5 - ACTIONS */

// 5.1
// hint: Update results value for each exercise from single-fit4life_workout.php
function fit4life_workout_results(){

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

}

add_action( 'init', 'fit4life_workout_results', 0 );

// 5.2
// hint: Update results for each fit-test form from single-fit4life_fit_test.php
function fit4life_update_fit_test(){

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

}

add_action( 'init', 'fit4life_update_fit_test', 0 );

// 5.3
// hint: Removed admin toolbar for all users except administrator
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
}

