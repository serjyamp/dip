$(document).ready(function(){
	// menu's list clicking
	$('.menu_list li').click(function(){
		$('.results_wr').fadeOut(150,function(){
			$(this).html("");
		});
		if (!$(this).hasClass('menu_active')){
			$('.menu_active').removeClass('menu_active');
			$(this).addClass('menu_active');
		};
		var th = $(this);
		$('.fb_active').removeClass('fb_active').fadeOut(100, function(){
			var classToShow = "." + $(th).attr('data-fb');
			$(classToShow).fadeIn(100).addClass('fb_active');
		});
	});

	// FIND TEACHER
	$('.fb_teacher .start_btn').click(function(){
		$('.results_wr').fadeOut(150, function(){
			$(this).html("");
			$('.preloader_wr').fadeIn(200);
			var lastname = $('.search_input_teacherLastname').val().trim();
			var name = $('.search_input_teacherName').val().trim();
			var patronymic = $('.search_input_teacherPatronymic').val().trim();
			var day = $('.fb_teacher .day option:selected').text();

			$.ajax({
				type: 'POST',
				url: 'php/client/find_teacher.php',
				data: 'name=' + name + '&patronymic=' + patronymic + '&lastname=' + lastname + '&day=' + day,
				success: function(data){
					$('.preloader_wr').fadeOut(200, function(){
				    	$('.results_wr').html(data).fadeIn(150);
					});
				}
			});
		});
	});

	// FIND GROUP
	$('.fb_group .start_btn').click(function(){
		$('.results_wr').fadeOut(150, function(){
			$(this).html("");
			$('.preloader_wr').fadeIn(200);
			var group = $('.search_input_group').val().trim();
			var day = $('.fb_group .day option:selected').text();

			$.ajax({
				type: 'POST',
				url: 'php/client/find_group.php',
				data: 'group=' + group + '&day=' + day,
				success: function(data){
					$('.preloader_wr').fadeOut(200, function(){
				    	$('.results_wr').html(data).fadeIn(150);
					});
				}
			});
		});
	});

	// SHOW BUFFETS
	$('.menu_buffets_btn').click(function(){
		$('.results_wr').fadeOut(150, function(){
			$(this).html("");
			$('.preloader_wr').fadeIn(200);

			$.ajax({
				type: 'POST',
				url: 'php/client/buffets.php',
				success: function(data){
					$('.preloader_wr').fadeOut(200, function(){
				    	$('.results_wr').html(data).fadeIn(150);
					});
				}
			});
		});
	});

	// SHOW BATHROOMS
	$('.menu_bathrooms_btn').click(function(){
		$('.results_wr').fadeOut(150, function(){
			$(this).html("");
			$('.preloader_wr').fadeIn(200);

			$.ajax({
				type: 'POST',
				url: 'php/client/bathrooms.php',
				success: function(data){
					$('.preloader_wr').fadeOut(200, function(){
				    	$('.results_wr').html(data).fadeIn(150);
					});
				}
			});
		});
	});

	// FIND AUDITORIUM
	$('.search_input_auditorium').mask('9.999');

	$('.fb_auditorium .start_btn').click(function(){
		$('.results_wr').fadeOut(150, function(){
			$(this).html("");
			$('.preloader_wr').fadeIn(200);
			var auditorium = $('.search_input_auditorium').val().trim();
			var day = $('.fb_auditorium .day option:selected').text();

			$.ajax({
				type: 'POST',
				url: 'php/client/find_auditorium.php',
				data: 'auditorium=' + auditorium + '&day=' + day,
				success: function(data){
					$('.preloader_wr').fadeOut(200, function(){
				    	$('.results_wr').html(data).fadeIn(150);
					});
				}
			});
		});
	});

	// digitable input
    function onlyDigitsInput(){
		$(".search_input_digits").keydown(function (e) {
	        // Allow: backspace, delete, tab, escape, enter and .
	        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
	             // Allow: Ctrl+A, Command+A
	            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
	             // Allow: home, end, left, right, down, up
	            (e.keyCode >= 35 && e.keyCode <= 40)) {
	                 // let it happen, don't do anything
	                 return;
	        }
	        // Ensure that it is a number and stop the keypress
	        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	            e.preventDefault();
	        }
	    });
    };

    onlyDigitsInput();

    
	// FIND FREE AUDITORIUM

    $('.fb_free_auditorium .start_btn').click(function(){
		$('.results_wr').fadeOut(150, function(){
			$(this).html("");
			$('.preloader_wr').fadeIn(200);
			var sockets = $('.search_input_sockets').val().trim();
			var workplaces = $('.search_input_workplaces').val().trim();
			var projector = $('.fb_free_auditorium .projector option:selected').val();
			var day = $('.fb_free_auditorium .day option:selected').text();
			var period = $('.fb_free_auditorium .period option:selected').text();

			$.ajax({
				type: 'POST',
				url: 'php/client/find_free_auditorium.php',
				data: 'sockets=' + sockets + '&workplaces=' + workplaces + '&projector=' + projector + '&day=' + day + '&period=' + period,
				success: function(data){
					$('.preloader_wr').fadeOut(200, function(){
				    	$('.results_wr').html(data).fadeIn(150);
					});
				}
			});
		});
	});

	// FIND ROOM
	$('.fb_room .start_btn').click(function(){
		$('.results_wr').fadeOut(150, function(){
			$(this).html("");
			$('.preloader_wr').fadeIn(200);
			var room = $('.search_input_room').val().trim();

			$.ajax({
				type: 'POST',
				url: 'php/client/find_room.php',
				data: 'room=' + room,
				success: function(data){
					$('.preloader_wr').fadeOut(200, function(){
				    	$('.results_wr').html(data).fadeIn(150);
					});
				}
			});
		});
	});
	
});