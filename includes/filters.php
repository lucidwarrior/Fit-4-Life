<?php  // Fit4Life Custom Filters


// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


// 3.0a
// hint: register custom admin column headers
add_filter( 'manage_edit-fit4life_workout_columns','fit4life_workout_column_headers' );
add_filter( 'manage_edit-fit4life_fit_test_columns','fit4life_fit_test_column_headers' );
add_filter( 'manage_edit-fit4life_exercise_columns','fit4life_exercise_column_headers' );

// 3.0b
// hint: add filter by author to workout admin page
add_action('restrict_manage_posts','add_author_filter_to_workout_administration');
add_action('pre_get_posts','add_author_filter_to_workout_query');

// 3.0c
// hint: add filter by author to fit test admin page
add_action('restrict_manage_posts','add_author_filter_to_fit_test_administration');
add_action('pre_get_posts','add_author_filter_to_fit_test_query');

// 3.0d
// hint: register custom admin column data
add_filter( 'manage_fit4life_posts_custom_column','fit4life_column_data',1,2 );

// 3.0e
// hint: Assign template files to custom post types
add_filter( 'single_template', 'get_fit4life_fit_test_template' );
add_filter( 'single_template', 'get_fit4life_workout_template' );
add_filter( 'single_template', 'get_fit4life_exercise_template' );

add_filter( 'archive_template', 'get_fit4life_exercise_archive' );
add_filter( 'archive_template', 'get_fit4life_workout_archive' );

//add_filter( 'archive_template', 'get_fit4life_tax_area_template' );
//add_filter( 'archive_template', 'get_fit4life_tax_concentration_template' );
//add_filter( 'single_template', 'get_fit4life_tax_focus_template' );
//add_filter( 'single_template', 'get_fit4life_tax_membership_template' );
//add_filter( 'single_template', 'get_fit4life_tax_movement_template' );
//add_filter( 'single_template', 'get_fit4life_tax_purpose_template' );
//add_filter( 'single_template', 'get_fit4life_tax_usage_template' );


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
    'movement'=>__('Movement'),
    'area'=>__('Area'),
		'date'=>__('Date')
	);

	// returning new columns
	return $columns;

}


// 3.2a
// hint: defining the filter that will be used so we can select posts by 'author'
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
// hint: defining the filter that will be used so we can select posts by 'author'
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


// 3.4
// hint: Add custom column data
function fit4life_column_data( $column, $post_id ) {

  // setup our return text
  $output = '';

  switch( $column ) {

    case 'movement':
      // get the custom movement Data
      $movement = get_fields( 'fit4life_tax_movement', $post_id );
      $output .= $movement;
      break;

    case 'area':
      // get the custom area Data
      $area = get_fields( 'fit4life_tax_area', $post_id );
      $output .= $area;
      break;

  }

  // echo the $output
  echo $output;
}


// 3.5
// hint: Assign template to custom post type
if( !function_exists('get_fit4life_fit_test_template') ):

  function get_fit4life_fit_test_template($single_template) {

     global $post;

     if ($post->post_type == 'fit4life_fit_test') {
          $single_template = plugin_dir_path(__FILE__) . '../single-fit4life_fit_test.php';
     }
   return $single_template;
  }

endif;


// 3.6
// hint: Assign template to custom post type
if( !function_exists('get_fit4life_workout_template') ):

  function get_fit4life_workout_template($single_template) {

     global $post;

     if ($post->post_type == 'fit4life_workout') {
          $single_template = plugin_dir_path(__FILE__) . '../single-fit4life_workout.php';
     }
   return $single_template;
  }

endif;


// 3.7
// hint: Assign template to custom post type
if( !function_exists('get_fit4life_exercise_template') ):

  function get_fit4life_exercise_template($single_template) {

     global $post;

     if ($post->post_type == 'fit4life_exercise') {
          $single_template = plugin_dir_path(__FILE__) . '../single-fit4life_exercise.php';
     }
   return $single_template;
  }

endif;


// 3.8
// hint: Assign template to custom archive
if( !function_exists('get_fit4life_exercise_archive') ):

  function get_fit4life_exercise_archive($archive_template) {

     global $post;

     if (is_post_type_archive ( 'fit4life_exercise' ) ) {
          $archive_template = plugin_dir_path(__FILE__) . '../archive-fit4life_exercise.php';
     }
   return $archive_template;
  }

endif;


// 3.9
// hint: Assign template to custom post type
if( !function_exists('get_fit4life_workout_archive') ):

  function get_fit4life_workout_archive($archive_template) {

     global $post;

     if (is_post_type_archive ( 'fit4life_workout' ) ) {
          $archive_template = plugin_dir_path(__FILE__) . '../archive-fit4life_workout.php';
     }
   return $archive_template;
  }

endif;
