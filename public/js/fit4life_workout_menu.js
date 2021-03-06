jQuery(document).ready(function($){
	// set default variables
	var total_weeks = $("input#workout_weeks").val();
	var current_day = 1;
	var current_week = 1;
	var day_id = '#fit4life_week-' + current_week + '-day-' + current_day;	// sets day_id to value of current Day content div ID

	$('.fit4life_workout_day').addClass('hideDay');		// hides all Day content
	$(day_id).removeClass('hideDay');					// unhides current Day content
	$('#1').addClass('activeDay');      				// set activeDay class to day 1 menu li element

    
	// respond to Change Day menu clicks
	$('.fit4life_dayLink a').click(function () {
		var day_clicked = $(this).closest('.fit4life_dayLink').attr('id');
		var current_day = ((current_week * 7) - 6 + parseInt(day_clicked) - 1);
		var day_id = '#fit4life_week-' + current_week + '-day-' + current_day;
		var current_day_li = '#' + day_clicked;

		$('.fit4life_workout_day').addClass('hideDay');		// hides all Day content
		$('.fit4life_dayLink').removeClass('activeDay');    // removes css for all day menu li elements
		$(day_id).removeClass('hideDay');					// unhides clicked Day content
		$(current_day_li).addClass('activeDay');      		// add activeDay class to active day menu li element
	});

    
	// respond to Change Week menu clicks
	$('.fit4life_weekLink a').click(function () {
		var week_direction = $(this).closest('.fit4life_weekLink').attr('id');

		switch (week_direction) {
			case 'fit4life_prev_week':
				if (current_week > 1) {
					current_week = current_week - 1;
				}
				current_day = (current_week * 7 - 6);		                            // calculates current day from current week
				day_id = '#fit4life_week-' + current_week + '-day-' + current_day;
				$('.fit4life_dayLink').removeClass('activeDay');    	                // removes css for all day menu li elements
				$('#1').addClass('activeDay');      									// set activeDay class to day 1 menu li element
				break;
			case 'fit4life_next_week':
				if (current_week < total_weeks) {
					current_week = current_week + 1;
				}
				current_day = (current_week * 7 - 6);		                            // calculates current day from current week
				day_id = '#fit4life_week-' + current_week + '-day-' + current_day;
				$('fit4life_dayLink').removeClass('activeDay');    	                    // removes css for all day menu li elements
				$('#1').addClass('activeDay');      			                        // set activeDay class to day 1 menu li element
				break;
			default:
				break;
		}

		$('.fit4life_workout_day').addClass('hideDay');
		$(day_id).removeClass('hideDay');

	});

});
