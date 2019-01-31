(function( $ ) {

	$( document ).ready(function() {

		// Define all variables
		let infosection = $( "#aital-info-notification-message" );
		let checkButton = $( "#aital_check_index" );
		let addIndexButton = $( "#aital_add_index" );
		let removeIndexButton = $( "#aital_remove_index" );
		let sheduleButtonOn = $( ".aital-scheduler-switch-on" );
		let sheduleButtonOff = $( ".aital-scheduler-switch-off" );
		let schedulerInfosection = $( "#aital-scheduler-info-notification-message" );
		let scheduleButtonSet = $( "#aital_add_schedule" );
		let scheduleButtonDelete = $( "#aital_delete_schedule" );
		let schedulerConfig = $( "#aital-scheduler-options" );

		// The function to be called to load the main plugin page
		function aital_init() {
			check_index();
			check_scheduler();
		}


		/*
		* Main Plugin Settings
		* Here all the functions and actions are defined to check, add and remove the index
		* on the autoload field of the options table
		*/

		// The function to check if the index exists or not
		function check_index() {
			checkButton.css("pointer-events", "none");
			infosection.empty();
			let randomNum = Math.floor(Math.random() * 26) + Date.now();
			let uniquespinnerid = "aital-spinner-id-" + randomNum + "";
			let spinner = "<span id='"+ uniquespinnerid +"' class='aital-spinner'></span>";

			// Deactivate the check button and display the spinner
			checkButton.text( aital_check_index_settings.checking_label );
			$( infosection ).append(spinner);

			// When called the button and spinner revert to
			function aital_setback_button_spinner() {
				checkButton.text( aital_check_index_settings.check_label );
				$( "#" + uniquespinnerid + "" ).remove();
			}

			// The data to call the PHP-function that checks if the index exists
			const data = {
				'action' : 'aital_check',
				'nonce'  : aital_check_index_settings.nonce
			};

			// Call the aital_check() function and query the response
			$.ajax({
				type: 'POST',
				url: aital_check_index_settings.ajax_url,
				data: data,
				dataType: 'json',
				success: function( response ) {

					if (response.success === true) {
						if ( response.data.code === 'aital-check-index-success-message-no-index') {
							infosection.append('<p class="aital-red ' + response.data.code + '">' + response.data.message + '</p>')
						}
						else {
							infosection.append('<p class="aital-green ' + response.data.code + '">' + response.data.message + '</p>')
						}
					}
					else {
						infosection.append('<p class="aital-red '+ response.data[0].code +'">' + response.data[0].message + '</p>')
					}

					aital_setback_button_spinner();
					checkButton.css("pointer-events", "auto");

				},
				error: function() {
					aital_setback_button_spinner();
					infosection.append('<p class="aital-red">' + aital_check_index_settings.ajax_check_failed + '</p>');
					checkButton.css("pointer-events", "auto");
				}
			});
		}

		// The function to check if the scheduler has a hook
		function check_scheduler() {
			let randomNum = Math.floor(Math.random() * 26) + Date.now();
			let uniquespinnerid = "aital-spinner-id-" + randomNum + "";
			let spinner = "<span id='"+ uniquespinnerid +"' class='aital-spinner' style='display: inline-block; margin-left: 25px;'></span>";
			$( "#aital-scheduler-header > h2" ).append(spinner);


			// The data to call the PHP-function that checks if the there is a scheduled hook
			const data = {
				'action' : 'aital_check_if_scheduler_exists',
				'nonce'  : aital_check_schedule_settings.nonce
			};

			// Call the aital_check_if_scheduler_exists() function and query the response
			$.ajax({
				type: 'POST',
				url: aital_check_schedule_settings.ajax_url,
				data: data,
				dataType: 'json',
				success: function( response ) {
					if (response.success === true) {
						if ( response.data.exists === true) {
							sheduleButtonOn.fadeIn(100, function () {
								schedulerConfig.slideDown(400);
							});
						}
						else {
							sheduleButtonOff.fadeIn(100);
						}
					}
					$( "#" + uniquespinnerid + "" ).remove();
				},
				error: function() {
					infosection.append('<p class="aital-red">' + aital_check_schedule_settings.ajax_check_failed + '</p>');
					$( "#" + uniquespinnerid + "" ).remove();
				}
			});
		}

		// Checks via click of the index is there
		checkButton.on( "click", function() {
			check_index();
		} );

		// The function to add the index to the autoload field
		addIndexButton.on( "click", function() {
			addIndexButton.css("pointer-events", "none");
			infosection.empty();
			let randomNum = Math.floor(Math.random() * 26) + Date.now();
			let uniquespinnerid = "aital-spinner-id-" + randomNum + "";
			let spinner = "<span id='"+ uniquespinnerid +"' class='aital-spinner'></span>";

			// Deactivate the check button and display the spinner
			$( this ).text( aital_add_index_settings.adding_label );
			$( infosection ).append(spinner);

			// When called the button and spinner revert to
			function aital_setback_button_spinner() {
				addIndexButton.text( aital_add_index_settings.add_label );
				$( "#" + uniquespinnerid + "" ).remove();
			}

			// The data to call the PHP-function that checks if the index exists
			const data = {
				'action' : 'aital_add_index',
				'nonce'  : aital_add_index_settings.nonce
			};

			// Call the aital_add_index() function and query the response
			$.ajax({
				type: 'POST',
				url: aital_add_index_settings.ajax_url,
				data: data,
				dataType: 'json',
				success: function( response ) {

					if (response.success === true) {
						infosection.append('<p class="aital-green '+ response.data.code +'">' + response.data.message + '</p>')
					}
					else {
						infosection.append('<p class="aital-red '+ response.data[0].code +'">' + response.data[0].message + '</p>')
					}

					aital_setback_button_spinner();
					addIndexButton.css("pointer-events", "auto");
				},
				error: function() {
					aital_setback_button_spinner();
					infosection.append('<p class="aital-red">' + aital_add_index_settings.ajax_check_failed + '</p>');
					addIndexButton.css("pointer-events", "auto");
				}
			});

		} );

		// The function to remove the index from the autoload field
		removeIndexButton.on( "click", function() {
			removeIndexButton.css("pointer-events", "none");
			infosection.empty();
			let randomNum = Math.floor(Math.random() * 26) + Date.now();
			let uniquespinnerid = "aital-spinner-id-" + randomNum + "";
			let spinner = "<span id='"+ uniquespinnerid +"' class='aital-spinner'></span>";

			// Deactivate the check button and display the spinner
			$( this ).text( aital_remove_index_settings.removing_label );
			$( infosection ).append(spinner);

			// When called the button and spinner revert to
			function aital_setback_button_spinner() {
				removeIndexButton.text( aital_remove_index_settings.remove_label );
				$( "#" + uniquespinnerid + "" ).remove();
			}

			// The data to call the PHP-function that checks if the index exists
			const data = {
				'action' : 'aital_remove_index',
				'nonce'  : aital_remove_index_settings.nonce
			};

			// Call the aital_remove_index() function and query the response
			$.ajax({
				type: 'POST',
				url: aital_remove_index_settings.ajax_url,
				data: data,
				dataType: 'json',
				success: function( response ) {

					if (response.success === true) {
						infosection.append('<p class="aital-orange '+ response.data.code +'">' + response.data.message + '</p>')
					}
					else {
						infosection.append('<p class="aital-red '+ response.data[0].code +'">' + response.data[0].message + '</p>')
					}

					aital_setback_button_spinner();
					removeIndexButton.css("pointer-events", "auto");

				},
				error: function() {
					aital_setback_button_spinner();
					infosection.append('<p class="aital-red">' + aital_remove_index_settings.ajax_check_failed + '</p>');
					removeIndexButton.css("pointer-events", "auto");
				}
			});

		} );


		/*
		* Scheduler settings
		* Here all the functions and actions are defined to manage the schedulers
		* settings and options
		*/

		// The function to show the aital-schedulder
		sheduleButtonOff.on( "click", function () {
			sheduleButtonOff.fadeOut(200, function () {
				sheduleButtonOn.fadeIn(200)
			});
			schedulerConfig.slideDown(200, function () {
				$('html, body').animate({
					scrollTop:$(schedulerConfig).offset().top
				},400);
			});

		});

		// The function to delete the wp-cronjob that checks for the index
		function aital_delete_schedule() {
			// The data to call the PHP-function that checks if the index exists
			const data = {
				'action' : 'aital_schedule_index_check',
				'delete' : true,
				'period' : 0,
				'nonce'  : aital_schedule_index_check_settings.nonce
			};

			// Call the aital_remove_index() function and query the response
			$.ajax({
				type: 'POST',
				url: aital_schedule_index_check_settings.ajax_url,
				data: data,
				dataType: 'json',
				success: function( response ) {
					if (response.success === true) {
						if (response.data.deleted === false) {
							schedulerInfosection.append('<p class="aital-red ' + response.data.code + '">' + response.data.message + '</p>')
						}
						else {
							schedulerInfosection.append('<p class="aital-orange ' + response.data.code + '">' + response.data.message + '</p>')
						}
					}

					scheduleButtonDelete.css("pointer-events", "auto");

				},
				error: function() {
					scheduleButtonDelete.css("pointer-events", "auto");
				}
			});
		}

		// The function to show the aital-schedulder - It also deletes the wp-cronjob that checks for the index
		sheduleButtonOn.on( "click", function () {
			sheduleButtonOn.fadeOut(200, function () {
				sheduleButtonOff.fadeIn(200)
			});
			schedulerConfig.slideUp(200, function () {
				schedulerConfig.hide();
			});

			aital_delete_schedule();
		});

		// Sets the wp-cronjob that checks for the index
		scheduleButtonSet.on( "click", function () {
			schedulerInfosection.empty();
			let period = $('#aital-scheduler-config-period').val();
			scheduleButtonSet.css("pointer-events", "none");

			// The data to call the PHP-function that checks if the index exists
			const data = {
				'action' : 'aital_schedule_index_check',
				'delete' : false,
				'period' : period,
				'nonce'  : aital_schedule_index_check_settings.nonce
			};

			// Call the aital_remove_index() function and query the response
			$.ajax({
				type: 'POST',
				url: aital_schedule_index_check_settings.ajax_url,
				data: data,
				dataType: 'json',
				success: function( response ) {

					if (response.success === true) {
						if (response.data.added === true) {
							schedulerInfosection.append('<p class="aital-green ' + response.data.code + '">' + response.data.message + '</p>')
						}
					}
					else {
						schedulerInfosection.append('<p class="aital-red '+ response.data[0].code +'">' + response.data[0].message + '</p>')
					}

					scheduleButtonSet.css("pointer-events", "auto");

				},
				error: function() {
					scheduleButtonSet.css("pointer-events", "auto");
				}
			});
		});

		// Deletes the wp-cronjob that checks for the index
		scheduleButtonDelete.on( "click", function () {
			schedulerInfosection.empty();
			scheduleButtonDelete.css("pointer-events", "none");

			aital_delete_schedule()
		});


		// Run the initial functions at plugin-page load
		aital_init();

	});

})( jQuery );