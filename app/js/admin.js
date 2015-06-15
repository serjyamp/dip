$(document).ready(function(){
    // digitable input
    function onlyDigitsInput(){
		$(".search_input_digits").keydown(function (e) {
	        // Allow: backspace, delete, tab, escape, enter and .
	        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
	            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
	            (e.keyCode == 67 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
	            (e.keyCode == 82 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
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

    function removeErrorOnKeypress(){
    	$('input').keypress(function(){
    		$(this).removeClass('empty_input');
    	}).keydown(function(e){
    		if (e.keyCode == 86 && (e.ctrlKey === true || e.metaKey === true)) {
    			$(this).removeClass('empty_input');
    		};
    	});
    };

    removeErrorOnKeypress();

    $('.search_input_auditorium').mask('9.999');

	// admin menu clicking
	$('.admin_menu li').click(function(){
		hideElementsBeforeLoaded();

		if (!$(this).hasClass('am_active')){
			$('.am_active').removeClass('am_active');
			$(this).addClass('am_active');
		};
	});

	function hideElementsBeforeLoaded(noclean){
		$('.fields_controls').hide();
		$('.fields_active').hide();
		$('.preloader_wr').fadeIn(200);
		$('.status_wr').hide().html("");

		if (noclean == 'noclean'){
			$('.content_wr').hide();
		} else {
			$('.content_wr').hide().html("");
		}
	}

	// init edit button in row
	function initEditBtn(type){
		$('.cell_edit').click(function(){
			if (type == "groups" || type == "buffets" || type == "rooms"){
				$(this).closest('.content_row').find('.content_cell_input').removeAttr('readonly').addClass('editing_input');
				$(this).closest('.content_row').find('.content_cell_input').first().focus();
				$(this).closest('.content_row').find('.cell_checkbox').attr('checked',false).attr('disabled',true);
			};
			if (type == "lessons" || type == "auditoriums"){
				$(this).closest('.content_row').find('.content_cell_input').removeAttr('readonly').addClass('editing_input');
				$(this).closest('.content_row').find('select').removeAttr('disabled').addClass('editing_input');
				$(this).closest('.content_row').find('.content_cell_input').first().focus();
				$(this).closest('.content_row').find('.cell_checkbox').attr('checked',false).attr('disabled',true);
			};
			if (type == "teachers" || type == "subjects" || type == "bathrooms" || "buildings"){
				$(this).closest('.content_row').find('.content_cell_input:not(.restrict)').removeAttr('readonly').addClass('editing_input');
				$(this).closest('.content_row').find('.content_cell_input').eq(1).focus();
				$(this).closest('.content_row').find('.cell_checkbox').attr('checked',false).attr('disabled',true);
			};
			if (type == "bathrooms"){
				$(this).closest('.content_row').find('.content_cell_input:not(.restrict)').removeAttr('readonly').addClass('editing_input');
				$(this).closest('.content_row').find('.content_cell_input').first().focus();
				$(this).closest('.content_row').find('.cell_checkbox').attr('checked',false).attr('disabled',true);
			};
		});
	};
	
	// init set button in row
	function initSetBtn(type){
		$('.cell_set').click(function(){
			var closest_row = $(this).closest('.content_row');

			if ($(closest_row).find('.editing_input').length != 0){

				var error = false;
				$(closest_row).find('.editing_input:not(.can_be_empty)').each(function(){
					if ($(this).val().trim().length == 0){
						$(this).addClass('empty_input');
						error = true;
					};
				});

				if (error == true){
					removeErrorOnKeypress();
					return;
				}

				if (type == 'groups'){
					var old_NameOfGroup = $(closest_row).attr('data-val');
					var NameOfGroup = $(closest_row).find('.cci_1').val();

					$.ajax({
						type: 'POST',
						url: 'php/admin/groups_update.php',
						data: 'old_NameOfGroup=' + old_NameOfGroup + '&NameOfGroup=' + NameOfGroup,
						success: function(data){
							if (data == 'ok'){
								$(closest_row).find('.content_cell_input').attr('readonly', 'true').removeClass('editing_input');
								$(closest_row).find('.cell_checkbox').attr('disabled',false);

								$(closest_row).attr('data-val', NameOfGroup);
							} else {
								alert('Такий запис в базі даних вже існує.');
							}
						}
					});
					return;
				};

				if (type == 'buildings'){
					var old_NumberOfBuilding = $(closest_row).attr('data-val');
					var QuantityOfFloors = $(closest_row).find('.cci_2').val();

					$.ajax({
						type: 'POST',
						url: 'php/admin/buildings_update.php',
						data: 'old_NumberOfBuilding=' + old_NumberOfBuilding + '&QuantityOfFloors=' + QuantityOfFloors,
						success: function(data){
							if (data == 'ok'){
								$(closest_row).find('.content_cell_input').attr('readonly', 'true').removeClass('editing_input');
								$(closest_row).find('.cell_checkbox').attr('disabled',false);
							} else {
								alert('Помилка. Повторіть операцію.');
							}
						}
					});
					return;
				};


				if (type == 'lessons'){
					var CodeOfLesson = $(closest_row).attr('data-val');
					var CodeOfSubject = $(closest_row).find('.cci_1').val();
					var CodeOfTeacher= $(closest_row).find('.cci_2').val();
					var NameOfGroup= $(closest_row).find('.cci_3').val();
					var NumberOfAuditorium= $(closest_row).find('.cci_4').val();
					var DayOfWeek= $(closest_row).find('.ccs_5').val();
					var NumberOfDoublePeriod= $(closest_row).find('.ccs_6').val();
					var Week= $(closest_row).find('.ccs_7').val();

					$.ajax({
						type: 'POST',
						url: 'php/admin/lessons_update.php',
						data: 'CodeOfLesson=' + CodeOfLesson + '&CodeOfSubject=' + CodeOfSubject + '&CodeOfTeacher=' + CodeOfTeacher + '&NameOfGroup=' + NameOfGroup + '&NumberOfAuditorium=' + NumberOfAuditorium + '&DayOfWeek=' + DayOfWeek + '&NumberOfDoublePeriod=' + NumberOfDoublePeriod + '&Week=' + Week,
						success: function(data){
							console.log(data);
							if (data == 'ok'){
								$(closest_row).find('.content_cell_input').attr('readonly', 'true').removeClass('editing_input');
								$(closest_row).find('select').attr('disabled', 'true').removeClass('editing_input');
								$(closest_row).find('.cell_checkbox').attr('disabled',false);
							} else {
								$('.fields_lessons .set_status_wr').html(data).show();
								$("html, body").animate({ scrollTop: 0 });
							}
						}
					});
					return;
				};

				if (type == 'auditoriums'){
					var old_NumberOfAuditorium = $(closest_row).attr('data-val');
					var NumberOfAuditorium = $(closest_row).find('.cci_1').val();
					var QuantityOfSockets = $(closest_row).find('.cci_2').val();
					var QuantityOfSeats = $(closest_row).find('.cci_3').val();
					var PresenceOfProjector = $(closest_row).find('.ccs_4').val();

					$.ajax({
						type: 'POST',
						url: 'php/admin/auditoriums_update.php',
						data: 'old_NumberOfAuditorium=' + old_NumberOfAuditorium + '&NumberOfAuditorium=' + NumberOfAuditorium + '&QuantityOfSockets=' + QuantityOfSockets + '&QuantityOfSeats=' + QuantityOfSeats + '&PresenceOfProjector=' + PresenceOfProjector,
						success: function(data){
							if (data == 'ok'){
								$(closest_row).find('.content_cell_input').attr('readonly', 'true').removeClass('editing_input');
								$(closest_row).find('select').attr('disabled', 'true').removeClass('editing_input');
								$(closest_row).find('.cell_checkbox').attr('disabled',false);

								$(closest_row).attr('data-val', NumberOfAuditorium);
							} else if (data == 'error'){
								var err = "Помилка. Мабуть така аудиторія вже існує."
								alert(err);
							} else {
								alert(data);
							};
						}
					});
					return;
				};

				if (type == 'teachers'){
					var CodeOfTeacher = $(closest_row).attr('data-val');
					var LastnameOfTeacher = $(closest_row).find('.cci_2').val();
					var NameOfTeacher = $(closest_row).find('.cci_3').val();
					var PatronymicOfTeacher = $(closest_row).find('.cci_4').val();

					$.ajax({
						type: 'POST',
						url: 'php/admin/teachers_update.php',
						data: 'CodeOfTeacher=' + CodeOfTeacher + '&LastnameOfTeacher=' + LastnameOfTeacher + '&NameOfTeacher=' + NameOfTeacher + '&PatronymicOfTeacher=' + PatronymicOfTeacher,
						success: function(data){
							if (data == 'ok'){
								$(closest_row).find('.content_cell_input').attr('readonly', 'true').removeClass('editing_input');
								$(closest_row).find('.cell_checkbox').attr('disabled',false);
							} else {
								alert('Такий запис в базі даних вже існує.');
							}
						}
					});
					return;
				};

				if (type == 'subjects'){
					var CodeOfSubject = $(closest_row).attr('data-val');
					var NameOfSubject = $(closest_row).find('.cci_2').val().trim();

					$.ajax({
						type: 'POST',
						url: 'php/admin/subjects_update.php',
						data: 'CodeOfSubject=' + CodeOfSubject + '&NameOfSubject=' + NameOfSubject,
						success: function(data){
							if (data == 'ok'){
								$(closest_row).find('.content_cell_input').attr('readonly', 'true').removeClass('editing_input');
								$(closest_row).find('.cell_checkbox').attr('disabled',false);
							} else if (data == 'error') {
								alert('Такий запис в базі даних вже існує.');
							} else {
								alert(data);
							};
						}
					});
					return;
				};

				if (type == 'buffets'){
					var CodeOfBuffet = $(closest_row).attr('data-val');
					var NameOfBuffet = $(closest_row).find('.cci_1').val().trim();
					var BusinessHours = $(closest_row).find('.cci_2').val().trim();
					var NumberOfBuilding = $(closest_row).find('.cci_3').val().trim();
					var Floor = $(closest_row).find('.cci_4').val().trim();

					$.ajax({
						type: 'POST',
						url: 'php/admin/buffets_update.php',
						data: 'CodeOfBuffet=' + CodeOfBuffet + '&NameOfBuffet=' + NameOfBuffet + '&BusinessHours=' + BusinessHours + '&NumberOfBuilding=' + NumberOfBuilding + '&Floor=' + Floor,
						success: function(data){
							if (data == 'ok'){
								$(closest_row).find('.content_cell_input').attr('readonly', 'true').removeClass('editing_input');
								$(closest_row).find('.cell_checkbox').attr('disabled',false);
							} else if (data == 'error') {
								alert('Помилка. Повторіть операцію.');
							} else {
								alert(data);
							};
						}
					});
					return;
				};

				if (type == 'bathrooms'){
					var CodeOfBathroom = $(closest_row).attr('data-val');
					var NumberOfBuilding = $(closest_row).find('.cci_1').val().trim();
					var Floor = $(closest_row).find('.cci_2').val().trim();
					var ForMenOrWomen = $(closest_row).find('.cci_3').val().trim();
					var HowManyBathrooms = $(closest_row).find('.cci_4').val().trim();

					$.ajax({
						type: 'POST',
						url: 'php/admin/bathrooms_update.php',
						data: 'CodeOfBathroom=' + CodeOfBathroom + '&NumberOfBuilding=' + NumberOfBuilding + '&Floor=' + Floor + '&ForMenOrWomen=' + ForMenOrWomen + '&HowManyBathrooms=' + HowManyBathrooms,
						success: function(data){
							if (data == 'ok'){
								$(closest_row).find('.content_cell_input').attr('readonly', 'true').removeClass('editing_input');
								$(closest_row).find('.cell_checkbox').attr('disabled',false);
							} else if (data == 'error') {
								alert('Помилка. Повторіть операцію.');
							} else {
								alert(data);
							};
						}
					});
					return;
				};

				if (type == 'rooms'){
					var CodeOfRoom = $(closest_row).attr('data-val');
					var NameOfRoom = $(closest_row).find('.cci_1').val().trim();
					var Contacts = $(closest_row).find('.cci_2').val().trim();
					var NumberOfAuditorium = $(closest_row).find('.cci_3').val().trim();

					$.ajax({
						type: 'POST',
						url: 'php/admin/rooms_update.php',
						data: 'CodeOfRoom=' + CodeOfRoom + '&NameOfRoom=' + NameOfRoom + '&Contacts=' + Contacts + '&NumberOfAuditorium=' + NumberOfAuditorium,
						success: function(data){
							if (data == 'ok'){
								$(closest_row).find('.content_cell_input').attr('readonly', 'true').removeClass('editing_input');
								$(closest_row).find('.cell_checkbox').attr('disabled',false);
							} else if (data == 'error') {
								alert('Помилка. Повторіть операцію.');
							} else {
								alert(data);
							};
						}
					});
					return;
				};

			};

		});
	};

	// delete row query
	function deleteRow(tableName,fieldName,fieldValue){
		$.ajax({
			type: 'POST',
			url: 'php/admin/delete.php',
			data: "tableName=" + tableName + "&fieldName=" + fieldName + "&fieldValue=" + fieldValue,
			success: function(data){
				setTimeout(function(){
					$('.del_status_wr').html(data).show();
					console.log(tableName);
				}, 300);
			}
		});
	};
	// delete row query in BUILDINGS
	function deleteRow_Buildings(tableName,fieldName,fieldValue){
		$.ajax({
			type: 'POST',
			url: 'php/admin/delete_buildings.php',
			data: "tableName=" + tableName + "&fieldName=" + fieldName + "&fieldValue=" + fieldValue,
			success: function(data){
				setTimeout(function(){
					$('.del_status_wr').html(data).show();
					console.log(tableName);
				}, 300);
			}
		});
	};
	// delete row query in ROOMS
	function deleteRow_Rooms(tableName,fieldName,fieldValue){
		$.ajax({
			type: 'POST',
			url: 'php/admin/delete_rooms.php',
			data: "tableName=" + tableName + "&fieldName=" + fieldName + "&fieldValue=" + fieldValue,
			success: function(data){
				setTimeout(function(){
					$('.del_status_wr').html(data).show();
					console.log(tableName);
				}, 300);
			}
		});
	};

	// clicking not on element hides status line
	function initUnfocusStatus(){
		$(document).click(function(event) {
		    if ($(event.target).closest(".status_wr").length) return;
		    $(".status_wr").hide().html("");
		    event.stopPropagation();
	  	});
	};

	// ===========================

	// === GROUPS ===
	$('.am_groups').click(function(){
		$('.fields_active').hide();
		$.ajax({
			type: 'POST',
			url: 'php/admin/groups_main.php',
			success: function(data){
				$('.preloader_wr').fadeOut(200,function(){
					$('.fields_groups').show().addClass('fields_active');

				    if (data != 0){
				    	$('.content_wr').html(data).show();
					} else {
						var empty = "<span class='gray'>Таблиця порожня.</span>";
						$('.content_wr').html(empty).show();
					};

			    	initEditBtn('groups');
			    	initSetBtn('groups');
			    	initUnfocusStatus();

			    	$('.f_del').unbind('click').click(function(){
			    		var i = 0;

			    		var tableName = 'Groups';
			    		var fieldName = 'NameOfGroup';
			    		var ch = $('.cell_checkbox:checked').length;

			    		if (ch != 0){
			    			hideElementsBeforeLoaded('noclean');

				    		$('.cell_checkbox:checked').each(function(){
				    			var fieldValue = $(this).closest('.content_row').find('.content_cell_input').val();
				    			var res = deleteRow(tableName,fieldName,fieldValue);
				    			i++;
				    			if (i == ch){
				    				setTimeout(function(){
					    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
										$(clss).click();
				    				},1000);
				    			}
				    		});
			    		};
			    	});

			    	if (data != 0){
			    		$('.fields_controls').show();
			    	};
				});
			}
		});
	});

	$('.fields_groups .f_add').click(function(){
		var fieldValue = $('.f_input_group').val().trim();
		if (fieldValue.length != 0){
			hideElementsBeforeLoaded();

			$.ajax({
				type: 'POST',
				url: 'php/admin/groups_insert.php',
				data: "fieldValue=" + fieldValue,
				success: function(data){
					setTimeout(function(){
						$('.am_groups').click();
						setTimeout(function(){
							$('.add_status_wr').html(data).show();
						}, 300);
					}, 300);
				}
			});
		} else {
			$th = $(this).parent();
			setErrorOnFieldsInput($th);
		}
	});

	// === BUILDINGS ===
	$('.am_buildings').click(function(){
		$('.fields_active').hide();
		$.ajax({
			type: 'POST',
			url: 'php/admin/buildings_main.php',
			success: function(data){
				$('.preloader_wr').fadeOut(200,function(){
					$('.fields_buildings').show().addClass('fields_active');

				    if (data != 0){
				    	$('.content_wr').html(data).show();
					} else {
						var empty = "<span class='gray'>Таблиця порожня.</span>";
						$('.content_wr').html(empty).show();
					};

			    	initEditBtn('buildings');
			    	initSetBtn('buildings');
			    	initUnfocusStatus();
			    	onlyDigitsInput();

			    	$('.f_del').unbind('click').click(function(){
			    		var i = 0;

			    		var tableName = 'Buildings';
			    		var fieldName = 'NumberOfBuilding';
			    		var ch = $('.cell_checkbox:checked').length;

			    		if (ch != 0){
			    			hideElementsBeforeLoaded('noclean');

				    		$('.cell_checkbox:checked').each(function(){
				    			var fieldValue = $(this).closest('.content_row').find('.cci_1').val();
				    			var res = deleteRow_Buildings(tableName,fieldName,fieldValue);
				    			i++;
				    			if (i == ch){
				    				setTimeout(function(){
					    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
										$(clss).click();
				    				},1000);
				    			}
				    		});
				    	};
			    	});

			    	if (data != 0){
			    		$('.fields_controls').show();
			    	};
				});
			}
		});
	});

	$('.fields_buildings .f_add').click(function(){
		var field_building_number = $('.f_input_building_number').val().trim();
		var field_building_floors = $('.f_input_building_floors').val().trim();

		if (field_building_number.length != 0 && field_building_floors.length != 0)
		{
			hideElementsBeforeLoaded();

			$.ajax({
				type: 'POST',
				url: 'php/admin/buildings_insert.php',
				data: "field_building_number=" + field_building_number + '&field_building_floors=' + field_building_floors,
				success: function(data){
					setTimeout(function(){
						$('.am_buildings').click();
						setTimeout(function(){
							$('.add_status_wr').html(data).show();
						}, 300);
					}, 300);
				}
			});
		} else {
			$th = $(this).parent();
			setErrorOnFieldsInput($th);
		}
	});

	// === LESSONS ===
	$('.am_lessons').click(function(){
		$('.fields_active').hide();
		$.ajax({
			type: 'POST',
			url: 'php/admin/lessons_main.php',
			success: function(data){
				$('.preloader_wr').fadeOut(200,function(){
					$('.fields_lessons').show().addClass('fields_active');

					if (data != 0){
				    	$('.content_wr').html(data).show();
					} else {
						var empty = "<span class='gray'>Таблиця порожня.</span>";
						$('.content_wr').html(empty).show();
					};

				    $('.search_input_auditorium').mask('9.999');
			    	initEditBtn('lessons');
			    	initSetBtn('lessons');
			    	initUnfocusStatus();
			    	onlyDigitsInput();

			    	$('.f_del').unbind('click').click(function(){
			    		var i = 0;

			    		var tableName = 'Lessons';
			    		var fieldName = 'CodeOfLesson';
			    		var ch = $('.cell_checkbox:checked').length;

			    		if (ch != 0){
			    			hideElementsBeforeLoaded('noclean');

				    		$('.cell_checkbox:checked').each(function(){
				    			var fieldValue = $(this).closest('.content_row').attr('data-val');
				    			console.log(fieldValue);
				    			var res = deleteRow(tableName,fieldName,fieldValue);
				    			i++;
				    			if (i == ch){
				    				setTimeout(function(){
					    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
										$(clss).click();
				    				},1000);
				    			}
				    		});
				    	};
			    	});

			    	if (data != 0){
			    		$('.fields_controls').show();
			    	};

				});
			}
		});
	});

	$('.fields_lessons .f_add').click(function(){
		var CodeOfSubject = $('.fields_lessons .f_input_code_of_subject').val().trim();
		var CodeOfTeacher = $('.fields_lessons .f_input_code_of_teacher').val().trim();
		var NameOfGroup = $('.fields_lessons .f_input_name_of_group').val().trim();
		var NumberOfAuditorium = $('.fields_lessons .f_input_number_of_auditorium').val().trim();
		var DayOfWeek = $('.fields_lessons .day option:selected').val();
		console.log(DayOfWeek);
		var NumberOfDoublePeriod = $('.fields_lessons .period option:selected').val();
		var Week = $('.fields_lessons .week option:selected').val();

		if (CodeOfSubject.length != 0 && CodeOfTeacher.length != 0 && NameOfGroup.length != 0 && NumberOfAuditorium.length != 0 && DayOfWeek.length != 0 && NumberOfDoublePeriod.length != 0 && Week.length != 0) {

			hideElementsBeforeLoaded();

			$.ajax({
				type: 'POST',
				url: 'php/admin/lessons_insert.php',
				data: "CodeOfSubject=" + CodeOfSubject + '&CodeOfTeacher=' + CodeOfTeacher + '&NameOfGroup=' + NameOfGroup + '&NumberOfAuditorium=' + NumberOfAuditorium + '&DayOfWeek=' + DayOfWeek + '&NumberOfDoublePeriod=' + NumberOfDoublePeriod + '&Week=' + Week,
				success: function(data){
					setTimeout(function(){
						$('.am_lessons').click();
						setTimeout(function(){
							$('.add_status_wr').html(data).show();
						}, 300);
					}, 300);
				}
			});
		} else {
			$th = $(this).parent();
			setErrorOnFieldsInput($th);
		}
	});

	// === AUDITORIUMS ===
	$('.am_auditoriums').click(function(){
		$('.fields_active').hide();
		$.ajax({
			type: 'POST',
			url: 'php/admin/auditoriums_main.php',
			success: function(data){
				$('.preloader_wr').fadeOut(200,function(){
					$('.fields_auditoriums').show().addClass('fields_active');

				    if (data != 0){
				    	$('.content_wr').html(data).show();
					} else {
						var empty = "<span class='gray'>Таблиця порожня.</span>";
						$('.content_wr').html(empty).show();
					};

			    	initEditBtn('auditoriums');
			    	initSetBtn('auditoriums');
			    	initUnfocusStatus();
			    	onlyDigitsInput();

			    	$('.search_input_auditorium').mask('9.999');

			    	$('.f_del').unbind('click').click(function(){
			    		var i = 0;

			    		var tableName = 'Auditoriums';
			    		var fieldName = 'NumberOfAuditorium';
			    		var ch = $('.cell_checkbox:checked').length;

			    		if (ch != 0){
			    			hideElementsBeforeLoaded('noclean');

				    		$('.cell_checkbox:checked').each(function(){
				    			var fieldValue = $(this).closest('.content_row').attr('data-val');
				    			var res = deleteRow(tableName,fieldName,fieldValue);
				    			i++;
				    			if (i == ch){
				    				setTimeout(function(){
					    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
										$(clss).click();
				    				},1000);
				    			}
				    		});
				    	};
			    	});

			    	if (data != 0){
			    		$('.fields_controls').show();
			    	};
				});
			}
		});
	});

	$('.fields_auditoriums .f_add').click(function(){
		var f_input_number_of_auditorium = $('.fields_auditoriums .f_input_number_of_auditorium').val().trim();
		var f_input_sockets = $('.fields_auditoriums .f_input_sockets').val().trim();
		var f_input_workplaces = $('.fields_auditoriums .f_input_workplaces').val().trim();
		var projector = $('.fields_auditoriums .projector option:selected').val();

		if (f_input_number_of_auditorium.length != 0 && f_input_sockets.length != 0 && f_input_workplaces.length != 0)
		{
			hideElementsBeforeLoaded();

			$.ajax({
				type: 'POST',
				url: 'php/admin/auditoriums_insert.php',
				data: "f_input_number_of_auditorium=" + f_input_number_of_auditorium + '&f_input_sockets=' + f_input_sockets + '&f_input_workplaces=' + f_input_workplaces + '&projector=' + projector,
				success: function(data){
					setTimeout(function(){
						$('.am_auditoriums').click();
						setTimeout(function(){
							$('.add_status_wr').html(data).show();
						}, 300);
					}, 300);
				}
			});
		} else {
			$th = $(this).parent();
			setErrorOnFieldsInput($th);
		}
	});

	function setErrorOnFieldsInput(th){
		th.find('input:not(.can_be_empty)').each(function(){
			if ($(this).val().trim().length == 0){
				$(this).addClass('empty_input');
			};
		});
	};

	// === TEACHERS ===
	$('.am_teachers').click(function(){
		$('.fields_active').hide();
		$.ajax({
			type: 'POST',
			url: 'php/admin/teachers_main.php',
			success: function(data){
				$('.preloader_wr').fadeOut(200,function(){
					$('.fields_teachers').show().addClass('fields_active');

				    if (data != 0){
				    	$('.content_wr').html(data).show();
					} else {
						var empty = "<span class='gray'>Таблиця порожня.</span>";
						$('.content_wr').html(empty).show();
					};

			    	initEditBtn('teachers');
			    	initSetBtn('teachers');
			    	initUnfocusStatus();

			    	$('.f_del').unbind('click').click(function(){
			    		var i = 0;

			    		var tableName = 'Teachers';
			    		var fieldName = 'CodeOfTeacher';
			    		var ch = $('.cell_checkbox:checked').length;

			    		if (ch != 0){
			    			hideElementsBeforeLoaded('noclean');

				    		$('.cell_checkbox:checked').each(function(){
				    			var fieldValue = $(this).closest('.content_row').attr('data-val');
				    			var res = deleteRow(tableName,fieldName,fieldValue);
				    			i++;
				    			if (i == ch){
				    				setTimeout(function(){
					    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
										$(clss).click();
				    				},1000);
				    			}
				    		});
				    	};
			    	});

			    	if (data != 0){
			    		$('.fields_controls').show();
			    	};
				});
			}
		});
	});

	$('.fields_teachers .f_add').click(function(){
		var lastname = $('.fields_teachers .f_input_lastname').val().trim();
		var name = $('.fields_teachers .f_input_name').val().trim();
		var patronymic = $('.fields_teachers .f_input_patronymic').val().trim();

		if (lastname.length != 0 && name.length != 0 && patronymic.length != 0)
		{
			hideElementsBeforeLoaded();

			$.ajax({
				type: 'POST',
				url: 'php/admin/teachers_insert.php',
				data: "lastname=" + lastname + '&name=' + name + '&patronymic=' + patronymic,
				success: function(data){
					setTimeout(function(){
						$('.am_teachers').click();
						setTimeout(function(){
							$('.add_status_wr').html(data).show();
						}, 300);
					}, 300);
				}
			});
		} else {
			$th = $(this).parent();
			setErrorOnFieldsInput($th);
		}
	});

	// === SUBJECTS ===
	$('.am_subjects').click(function(){
		$('.fields_active').hide();
		$.ajax({
			type: 'POST',
			url: 'php/admin/subjects_main.php',
			success: function(data){
				$('.preloader_wr').fadeOut(200,function(){
					$('.fields_subjects').show().addClass('fields_active');

				    if (data != 0){
				    	$('.content_wr').html(data).show();
					} else {
						var empty = "<span class='gray'>Таблиця порожня.</span>";
						$('.content_wr').html(empty).show();
					};

			    	initEditBtn('subjects');
			    	initSetBtn('subjects');
			    	initUnfocusStatus();

			    	$('.f_del').unbind('click').click(function(){
			    		var i = 0;

			    		var tableName = 'Subjects';
			    		var fieldName = 'CodeOfSubject';
			    		var ch = $('.cell_checkbox:checked').length;

			    		if (ch != 0){
			    			hideElementsBeforeLoaded('noclean');

				    		$('.cell_checkbox:checked').each(function(){
				    			var fieldValue = $(this).closest('.content_row').attr('data-val');
				    			var res = deleteRow(tableName,fieldName,fieldValue);
				    			i++;
				    			if (i == ch){
				    				setTimeout(function(){
					    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
										$(clss).click();
				    				},1000);
				    			}
				    		});
				    	};
			    	});

			    	if (data != 0){
			    		$('.fields_controls').show();
			    	};
				});
			}
		});
	});

	$('.fields_subjects .f_add').click(function(){
		var NameOfSubject = $('.fields_subjects .f_input_name_of_subject').val().trim();

		if (NameOfSubject.length != 0)
		{
			hideElementsBeforeLoaded();

			$.ajax({
				type: 'POST',
				url: 'php/admin/subjects_insert.php',
				data: "NameOfSubject=" + NameOfSubject,
				success: function(data){
					setTimeout(function(){
						$('.am_subjects').click();
						setTimeout(function(){
							$('.add_status_wr').html(data).show();
						}, 300);
					}, 300);
				}
			});
		} else {
			$th = $(this).parent();
			setErrorOnFieldsInput($th);
		}
	});

	// === BUFFETS ===
	$('.am_buffets').click(function(){
		$('.fields_active').hide();
		$.ajax({
			type: 'POST',
			url: 'php/admin/buffets_main.php',
			success: function(data){
				$('.preloader_wr').fadeOut(200,function(){
					$('.fields_buffets').show().addClass('fields_active');

				    if (data != 0){
				    	$('.content_wr').html(data).show();
					} else {
						var empty = "<span class='gray'>Таблиця порожня.</span>";
						$('.content_wr').html(empty).show();
					};

			    	initEditBtn('buffets');
			    	initSetBtn('buffets');
			    	initUnfocusStatus();
			    	onlyDigitsInput();

			    	$('.f_del').unbind('click').click(function(){
			    		var i = 0;

			    		var tableName = 'Buffets';
			    		var fieldName = 'CodeOfBuffet';
			    		var ch = $('.cell_checkbox:checked').length;

			    		if (ch != 0){
			    			hideElementsBeforeLoaded('noclean');

				    		$('.cell_checkbox:checked').each(function(){
				    			var fieldValue = $(this).closest('.content_row').attr('data-val');
				    			var res = deleteRow(tableName,fieldName,fieldValue);
				    			i++;
				    			if (i == ch){
				    				setTimeout(function(){
					    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
										$(clss).click();
				    				},1000);
				    			}
				    		});
				    	};
			    	});

			    	if (data != 0){
			    		$('.fields_controls').show();
			    	};
				});
			}
		});
	});

	$('.fields_buffets .f_add').click(function(){
		var NameOfBuffet = $('.fields_buffets .f_input_name_of_buffet').val().trim();
		var BusinessHours = $('.fields_buffets .f_input_name_business').val().trim();
		var NumberOfBuilding = $('.fields_buffets .f_input_number_of_building').val().trim();
		var Floor = $('.fields_buffets .f_input_floor').val().trim();

		if (NameOfBuffet.length != 0 && BusinessHours.length != 0 && NumberOfBuilding.length != 0 && Floor.length != 0)
		{
			hideElementsBeforeLoaded();

			$.ajax({
				type: 'POST',
				url: 'php/admin/buffets_insert.php',
				data: "NameOfBuffet=" + NameOfBuffet + "&BusinessHours=" + BusinessHours + "&NumberOfBuilding=" + NumberOfBuilding + "&Floor=" + Floor,
				success: function(data){
					setTimeout(function(){
						$('.am_buffets').click();
						setTimeout(function(){
							$('.add_status_wr').html(data).show();
						}, 300);
					}, 300);
				}
			});
		} else {
			$th = $(this).parent();
			setErrorOnFieldsInput($th);
		}
	});

	// === BATHROOMS ===
	$('.am_bathrooms').click(function(){
		$('.fields_active').hide();
		$.ajax({
			type: 'POST',
			url: 'php/admin/bathrooms_main.php',
			success: function(data){
				$('.preloader_wr').fadeOut(200,function(){
					$('.fields_bathrooms').show().addClass('fields_active');

				    if (data != 0){
				    	$('.content_wr').html(data).show();
					} else {
						var empty = "<span class='gray'>Таблиця порожня.</span>";
						$('.content_wr').html(empty).show();
					};

			    	initEditBtn('bathrooms');
			    	initSetBtn('bathrooms');
			    	initUnfocusStatus();
			    	onlyDigitsInput();

			    	$('.f_del').unbind('click').click(function(){
			    		var i = 0;

			    		var tableName = 'Bathrooms';
			    		var fieldName = 'CodeOfBathroom';
			    		var ch = $('.cell_checkbox:checked').length;

			    		if (ch != 0){
			    			hideElementsBeforeLoaded('noclean');

				    		$('.cell_checkbox:checked').each(function(){
				    			var fieldValue = $(this).closest('.content_row').attr('data-val');
				    			var res = deleteRow(tableName,fieldName,fieldValue);
				    			i++;
				    			if (i == ch){
				    				setTimeout(function(){
					    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
										$(clss).click();
				    				},1000);
				    			}
				    		});
				    	};
			    	});

			    	if (data != 0){
			    		$('.fields_controls').show();
			    	};
				});
			}
		});
	});

	$('.fields_bathrooms .f_add').click(function(){
		var HowManyBathrooms = $('.fields_bathrooms .f_input_how_many_bathrooms').val().trim();
		var ForMenOrWomen = $('.fields_bathrooms .bathrooms_type').val();
		var NumberOfBuilding = $('.fields_bathrooms .f_input_number_of_building').val().trim();
		var Floor = $('.fields_bathrooms .f_input_floor').val().trim();

		if (HowManyBathrooms.length != 0 && ForMenOrWomen.length != 0 && NumberOfBuilding.length != 0 && Floor.length != 0)
		{
			hideElementsBeforeLoaded();
			
			$.ajax({
				type: 'POST',
				url: 'php/admin/bathrooms_insert.php',
				data: "HowManyBathrooms=" + HowManyBathrooms + "&ForMenOrWomen=" + ForMenOrWomen + "&NumberOfBuilding=" + NumberOfBuilding + "&Floor=" + Floor,
				success: function(data){
					setTimeout(function(){
						$('.am_bathrooms').click();
						setTimeout(function(){
							$('.add_status_wr').html(data).show();
						}, 300);
					}, 300);
				}
			});
		} else {
			$th = $(this).parent();
			setErrorOnFieldsInput($th);
		}
	});

	// === ROOMS ===
	$('.am_rooms').click(function(){
		$('.fields_active').hide();
		$.ajax({
			type: 'POST',
			url: 'php/admin/rooms_main.php',
			success: function(data){
				$('.preloader_wr').fadeOut(200,function(){
					$('.fields_rooms').show().addClass('fields_active');

				    if (data != 0){
				    	$('.content_wr').html(data).show();
					} else {
						var empty = "<span class='gray'>Таблиця порожня.</span>";
						$('.content_wr').html(empty).show();
					};

					$('.search_input_auditorium').mask('9.999');
			    	initEditBtn('rooms');
			    	initSetBtn('rooms');
			    	initUnfocusStatus();
			    	onlyDigitsInput();

			    	$('.f_del').unbind('click').click(function(){
			    		var i = 0;

			    		var tableName = 'Rooms';
			    		var fieldName = 'NameOfRoom';
			    		var ch = $('.cell_checkbox:checked').length;

			    		if (ch != 0){
			    			hideElementsBeforeLoaded('noclean');

				    		$('.cell_checkbox:checked').each(function(){
				    			var fieldValue = $(this).closest('.content_row').find('.cci_1').val();
				    			var res = deleteRow_Rooms(tableName,fieldName,fieldValue);
				    			i++;
				    			if (i == ch){
				    				setTimeout(function(){
					    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
										$(clss).click();
				    				},1000);
				    			}
				    		});
				    	};
			    	});

			    	if (data != 0){
			    		$('.fields_controls').show();
			    	};
				});
			}
		});
	});

	$('.fields_rooms .f_add').click(function(){
		var NameOfRoom = $('.fields_rooms .f_input_name_of_room').val().trim();
		var Contacts = $('.fields_rooms .f_input_contacts').val().trim();
		var NumberOfAuditorium = $('.fields_rooms .f_input_number_of_auditorium').val().trim();

		if (NameOfRoom.length != 0 && NumberOfAuditorium.length != 0)
		{
			hideElementsBeforeLoaded();
			
			$.ajax({
				type: 'POST',
				url: 'php/admin/rooms_insert.php',
				data: "NameOfRoom=" + NameOfRoom + "&Contacts=" + Contacts + "&NumberOfAuditorium=" + NumberOfAuditorium,
				success: function(data){
					setTimeout(function(){
						$('.am_rooms').click();
						setTimeout(function(){
							$('.add_status_wr').html(data).show();
						}, 300);
					}, 300);
				}
			});
		} else {
			$th = $(this).parent();
			setErrorOnFieldsInput($th);
		}
	});

});