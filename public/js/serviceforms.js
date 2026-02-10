$(document).ready(function () {
	// 1. REGISTER CUSTOM VALIDATION METHODS
	$.validator.addMethod("filesize", function (value, element, param) {
		if (!element.files.length) return true; // Optional field
		return element.files[0].size <= param;
	}, "File size must be less than {0} bytes");

	// Custom method for file type validation
	$.validator.addMethod("filetype", function (value, element, param) {
		if (!element.files.length) return true; // Optional
		var ext = value.split('.').pop().toLowerCase();
		return $.inArray(ext, param) !== -1;
	}, "Invalid file type.");

	// 2. HISTORY BOOKING FORM VALIDATION
	$("#historyBooking").validate({
		errorElement: 'span',
		errorClass: 'text-danger small',
		highlight: function (element) {
			$(element).addClass('is-invalid');
		},
		unhighlight: function (element) {
			$(element).removeClass('is-invalid');
		},
		submitHandler: function (form) {
			/* const turnstileResponse = $('[name="cf-turnstile-response"]').val();
			if (!turnstileResponse) {
				if ($('#turnstile-error').length === 0) {
					$('.cf-turnstile').after('<div id="turnstile-error" class="text-danger small mt-1">Please complete the security check.</div>');
				}
				return false;
			}
			$('#turnstile-error').remove();
			$(form).find('button[type="submit"]').prop('disabled', true).text('Processing...'); */
			form.submit();
		},
		rules: {
			customer_name: { required: true, minlength: 3 },
			customer_mobile: { required: true, minlength: 7, maxlength: 20 },
			rc_photo: {
				required: true,
				filetype: ["jpeg", "jpg", "png", "gif", "pdf"],

				filesize: 2097152
			},
			insurance_photo: {
				required: true,
				filetype: ["jpeg", "jpg", "png", "gif", "pdf"],
				filesize: 2097152
			}
		},
		messages: {
			rc_photo: { fileExtension: "Only JPG, PNG, or PDF files are allowed" },
			insurance_photo: { fileExtension: "Only JPG, PNG, or PDF files are allowed" }
		},
		errorPlacement: function (error, element) {
			if (element.attr("type") === "file") {
				error.insertAfter(element.closest('.form-group').find('.small, .form-control').last());
			} else {
				error.insertAfter(element);
			}
		}
	});

	// 3. PDI BOOKING FORM VALIDATION
	$("#pdiBooking").validate({
		errorElement: 'span',
		errorClass: 'text-danger small',
		highlight: function (element) { $(element).addClass('is-invalid'); },
		unhighlight: function (element) { $(element).removeClass('is-invalid'); },
		submitHandler: function (form) {
			const turnstileResponse = $('[name="cf-turnstile-response"]').val();
			if (!turnstileResponse) {
				$('#turnstile-error').show();
				return false;
			}
			$('#turnstile-error').hide();
			form.submit();
		},
		rules: {
			customer_name: { required: true, minlength: 3 },
			customer_mobile: { required: true, minlength: 7, maxlength: 20 },
			customer_email: { required: true, email: true },
			vehicle_name: { required: true, minlength: 3 },
			pdi_date: { required: true, digits: true, minlength: 6, maxlength: 6 },
			pdi_location: { required: true }
		}
	});

	// 4. SELL CAR FORM VALIDATION
	$("#sellCar").validate({
		errorElement: 'span',
		errorClass: 'text-danger small',
		highlight: function (element) { $(element).addClass('is-invalid'); },
		unhighlight: function (element) { $(element).removeClass('is-invalid'); },
		submitHandler: function (form) {
			const turnstileResponse = $('[name="cf-turnstile-response"]').val();
			if (!turnstileResponse) {
				$('#turnstile-error').show();
				return false;
			}
			$('#turnstile-error').hide();
			form.submit();
		},
		rules: {
			vehicle_name: { required: true, minlength: 3 },
			year: { required: true, digits: true, minlength: 4, maxlength: 4 },
			kms_driven: { required: true, number: true },
			no_of_owners: { required: true, digits: true },
			registration_number: { required: true, minlength: 4 },
			car_location: { required: true },
			customer_name: { required: true, minlength: 3 },
			customer_mobile: { required: true, minlength: 7, maxlength: 20 },
			car_photos: { fileExtension: "jpg|jpeg|png", filesize: 2097152 }
		}
	});

	// 5. HELPER FUNCTIONS (Scroll, Placeholders, Multi-step)
	if ($('#sell-car-success').length) {
		$('html, body').animate({
			scrollTop: $('#sell-car-success').offset().top - 100
		}, 600);
	}

	function updateRunningPlaceholder() {
		let pattern = $('input[name="running_pattern"]:checked').val();
		let placeholderText = (pattern === 'Everyday') ? "km/day" : (pattern === 'Monthly') ? "km/month" : (pattern === 'Yearly') ? "km/year" : "km";
		$('input[name="running_km"]').attr('placeholder', placeholderText);
	}

	$('input[name="running_pattern"]').on('change', updateRunningPlaceholder);
	updateRunningPlaceholder();

	// 6. MULTI-STEP FORM (carForm)
	let currentStepNum = 1;
	var validator = $("#carForm").validate({
		errorElement: 'span',
		errorClass: 'text-danger small',
		rules: {
			name: { required: true, minlength: 3 },
			mobile: { required: true, minlength: 7, maxlength: 20 },
			budget: { required: true, min: 100000 },
			confirm: "required"
		}
	});

	function goToStep(step) {
		$(".step").removeClass("active");
		$('.step[data-step="' + step + '"]').addClass("active");
		currentStepNum = step;
		$(window).scrollTop($(".contact-form").offset().top - 100);
	}

	$(".next").click(function (e) {
		e.preventDefault();
		let fieldsInStep = $('.step[data-step="' + currentStepNum + '"]').find('input, select, textarea');
		let stepIsValid = true;
		fieldsInStep.each(function () {
			if (!validator.element(this)) stepIsValid = false;
		});

		if (stepIsValid) {

			if (currentStepNum === 4 && $("input[name='service']:checked").val() === "New Car Consultation") {
				goToStep(6);
				return;
			}
			if (currentStepNum < 6) goToStep(currentStepNum + 1);
		}
	});

	$(".prev").click(function (e) {
		e.preventDefault();
		if (currentStepNum === 6 && $("input[name='service']:checked").val() === "New Car Consultation") {
			goToStep(4);
			return;
		}
		if (currentStepNum > 1) goToStep(currentStepNum - 1);
	});
});