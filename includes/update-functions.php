<?php  // Fit4Life Update Functions

// exit if file is called directly
if ( ! defined( 'ABSPATH' ) ) {

	exit;

}


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
