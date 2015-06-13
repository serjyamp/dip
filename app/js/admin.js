$(document).ready(function(){
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

    function removeErrorOnKeypress(){
    	$('input').keypress(function(){
    		$(this).removeClass('empty_input');
    	});
    };

    removeErrorOnKeypress();

    $('.search_input_auditorium').mask('9.999');

	// admin menu clicking
	$('.admin_menu li').click(function(){
		$('.fields_controls').hide();
		$('.status_wr').hide().html("");
		$('.content_wr').hide().html("");
		$('.preloader_wr').fadeIn(200);

		if (!$(this).hasClass('am_active')){
			$('.am_active').removeClass('am_active');
			$(this).addClass('am_active');
		};
	});

	// init edit button in row
	function initEditBtn(type){
		$('.cell_edit').click(function(){
			if (type == "groups" || type == "buildings"){
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
			if (type == "teachers" || type == "subjects"){
				$(this).closest('.content_row').find('.content_cell_input:not(.restrict)').removeAttr('readonly').addClass('editing_input');
				$(this).closest('.content_row').find('.content_cell_input').eq(1).focus();
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
				$(closest_row).find('.editing_input').each(function(){
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
					
					$(closest_row).find('.content_cell_input').attr('readonly', 'true').removeClass('editing_input');
					$(closest_row).find('.cell_checkbox').attr('disabled',false);

					var oldVal = $(closest_row).attr('data-val');
					var newVal = $(closest_row).find('.content_cell_input').val();

					$.ajax({
						type: 'POST',
						url: 'php/admin/groups_update.php',
						data: 'oldVal=' + oldVal + '&newVal=' + newVal,
						success: function(data){
							if (data == 'ok'){
								$(closest_row).attr('data-val', newVal);
							} else {
								$(closest_row).find('.content_cell_input').val(oldVal);
								alert('Такий запис в базі даних вже існує.');
							}
						}
					});
					return;
				};


				if (type == 'buildings'){
					$(closest_row).find('.content_cell_input').attr('readonly', 'true').removeClass('editing_input');
					$(closest_row).find('.cell_checkbox').attr('disabled',false);

					var old_NumberOfBuilding = $(closest_row).find('.cci_1').attr('data-val');
					var NumberOfBuilding = $(closest_row).find('.cci_1').val();
					var QuantityOfFloors = $(closest_row).find('.cci_2').val();

					$.ajax({
						type: 'POST',
						url: 'php/admin/buildings_update.php',
						data: 'old_NumberOfBuilding=' + old_NumberOfBuilding + '&NumberOfBuilding=' + NumberOfBuilding + '&QuantityOfFloors=' + QuantityOfFloors,
						success: function(data){
							if (data == 'ok'){
								$(closest_row).find('.cci_1').attr('data-val', NumberOfBuilding);
							} else {
								$(closest_row).find('.cci_1').val(old_NumberOfBuilding);
								alert('Такий запис в базі даних вже існує.');
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
								var err = "Помилка. Неможливо додати аудиторію тому що корпуса з номером <b>" + data + "</b> не існує.";
								alert(err);
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

			    	$('.f_del').click(function(){
			    		var i = 0;

			    		var tableName = 'Groups';
			    		var fieldName = 'NameOfGroup';
			    		var ch = $('.cell_checkbox:checked').length;

			    		$('.cell_checkbox:checked').each(function(){
			    			var fieldValue = $(this).closest('.content_row').find('.content_cell_input').val();
			    			var res = deleteRow(tableName,fieldName,fieldValue);
			    			i++;
			    			if (i == ch){
			    				setTimeout(function(){
				    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
									$(clss).click();
			    				},300);
			    			}
			    		});
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
			$.ajax({
				type: 'POST',
				url: 'php/admin/groups_insert.php',
				data: "fieldValue=" + fieldValue,
				success: function(data){
					$('.am_groups').click();
					setTimeout(function(){
						$('.add_status_wr').html(data).show();
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

			    	$('.f_del').click(function(){
			    		var i = 0;

			    		var tableName = 'Buildings';
			    		var fieldName = 'NumberOfBuilding';
			    		var ch = $('.cell_checkbox:checked').length;

			    		$('.cell_checkbox:checked').each(function(){
			    			var fieldValue = $(this).closest('.content_row').find('.cci_1').val();
			    			var res = deleteRow(tableName,fieldName,fieldValue);
			    			i++;
			    			if (i == ch){
			    				setTimeout(function(){
				    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
									$(clss).click();
			    				},300);
			    			}
			    		});
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
			$.ajax({
				type: 'POST',
				url: 'php/admin/buildings_insert.php',
				data: "field_building_number=" + field_building_number + '&field_building_floors=' + field_building_floors,
				success: function(data){
					$('.am_buildings').click();
					setTimeout(function(){
						$('.add_status_wr').html(data).show();
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

			    	$('.f_del').click(function(){
			    		var i = 0;

			    		var tableName = 'Lessons';
			    		var fieldName = 'CodeOfLesson';
			    		var ch = $('.cell_checkbox:checked').length;

			    		$('.cell_checkbox:checked').each(function(){
			    			var fieldValue = $(this).closest('.content_row').attr('data-val');
			    			console.log(fieldValue);
			    			var res = deleteRow(tableName,fieldName,fieldValue);
			    			i++;
			    			if (i == ch){
			    				setTimeout(function(){
				    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
									$(clss).click();
			    				},300);
			    			}
			    		});
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
			$.ajax({
				type: 'POST',
				url: 'php/admin/lessons_insert.php',
				data: "CodeOfSubject=" + CodeOfSubject + '&CodeOfTeacher=' + CodeOfTeacher + '&NameOfGroup=' + NameOfGroup + '&NumberOfAuditorium=' + NumberOfAuditorium + '&DayOfWeek=' + DayOfWeek + '&NumberOfDoublePeriod=' + NumberOfDoublePeriod + '&Week=' + Week,
				success: function(data){
					$('.am_lessons').click();
					setTimeout(function(){
						$('.add_status_wr').html(data).show();
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

			    	$('.f_del').click(function(){
			    		var i = 0;

			    		var tableName = 'Auditoriums';
			    		var fieldName = 'NumberOfAuditorium';
			    		var ch = $('.cell_checkbox:checked').length;

			    		$('.cell_checkbox:checked').each(function(){
			    			var fieldValue = $(this).closest('.content_row').find('.cci_1').val();
			    			var res = deleteRow(tableName,fieldName,fieldValue);
			    			i++;
			    			if (i == ch){
			    				setTimeout(function(){
				    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
									$(clss).click();
			    				},300);
			    			}
			    		});
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
			$.ajax({
				type: 'POST',
				url: 'php/admin/auditoriums_insert.php',
				data: "f_input_number_of_auditorium=" + f_input_number_of_auditorium + '&f_input_sockets=' + f_input_sockets + '&f_input_workplaces=' + f_input_workplaces + '&projector=' + projector,
				success: function(data){
					$('.am_auditoriums').click();
					setTimeout(function(){
						$('.add_status_wr').html(data).show();
					}, 300);
				}
			});
		} else {
			$th = $(this).parent();
			setErrorOnFieldsInput($th);
		}
	});

	function setErrorOnFieldsInput(th){
		th.find('input').each(function(){
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

			    	$('.f_del').click(function(){
			    		var i = 0;

			    		var tableName = 'Teachers';
			    		var fieldName = 'CodeOfTeacher';
			    		var ch = $('.cell_checkbox:checked').length;

			    		$('.cell_checkbox:checked').each(function(){
			    			var fieldValue = $(this).closest('.content_row').attr('data-val');
			    			var res = deleteRow(tableName,fieldName,fieldValue);
			    			i++;
			    			if (i == ch){
			    				setTimeout(function(){
				    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
									$(clss).click();
			    				},300);
			    			}
			    		});
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
			$.ajax({
				type: 'POST',
				url: 'php/admin/teachers_insert.php',
				data: "lastname=" + lastname + '&name=' + name + '&patronymic=' + patronymic,
				success: function(data){
					$('.am_teachers').click();
					setTimeout(function(){
						$('.add_status_wr').html(data).show();
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

			    	$('.f_del').click(function(){
			    		var i = 0;

			    		var tableName = 'Subjects';
			    		var fieldName = 'CodeOfSubject';
			    		var ch = $('.cell_checkbox:checked').length;

			    		$('.cell_checkbox:checked').each(function(){
			    			var fieldValue = $(this).closest('.content_row').attr('data-val');
			    			var res = deleteRow(tableName,fieldName,fieldValue);
			    			i++;
			    			if (i == ch){
			    				setTimeout(function(){
				    				var clss = '.' + $('.am_active').attr('class').split(' ')[0];
									$(clss).click();
			    				},300);
			    			}
			    		});
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
			$.ajax({
				type: 'POST',
				url: 'php/admin/subjects_insert.php',
				data: "NameOfSubject=" + NameOfSubject,
				success: function(data){
					$('.am_subjects').click();
					setTimeout(function(){
						$('.add_status_wr').html(data).show();
					}, 300);
				}
			});
		} else {
			$th = $(this).parent();
			setErrorOnFieldsInput($th);
		}
	});


});