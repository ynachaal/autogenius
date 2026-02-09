$(document).ready(function () {
	// Scroll to success message if it exists
	if ($('#pdi-success').length) { // Changed to match the PDI success ID from previous step
		$('html, body').animate({
			scrollTop: $('#pdi-success').offset().top - 100
		}, 600);
	}



	// Define filesize method BEFORE validate()
	if ($.validator && !$.validator.methods.filesize) {
		$.validator.addMethod("filesize", function (value, element, param) {
			if (element.files && element.files.length) {
				return element.files[0].size <= param;
			}
			return true;
		}, "File size must be under 2MB");
	}

	$("#pdiBooking").validate({
		errorElement: 'span',
		errorClass: 'text-danger small',
		highlight: function (element) {
			$(element).addClass('is-invalid');
		},
		unhighlight: function (element) {
			$(element).removeClass('is-invalid');
		},
		submitHandler: function (form) {
			// Check for Turnstile token before submitting
			const turnstileResponse = $('[name="cf-turnstile-response"]').val();
			if (!turnstileResponse) {
				$('#turnstile-error').show();
				return false;
			}
			$('#turnstile-error').hide();

			form.submit();
		},
		rules: {
			customer_name: {
				required: true,
				minlength: 3
			},
			customer_mobile: {
				required: true,
				minlength: 7,
				maxlength: 20
			},
			customer_email: {
				required: true,
				email: true // Ensures valid email format
			},
			vehicle_name: {
				required: true,
				minlength: 3
			},
			pdi_date: {
				required: true,
				digits: true,
				minlength: 6,
				maxlength: 6
			},
			pdi_location: {
				required: true
			}
		},
		messages: {
			customer_email: {
				required: "Please enter your email address",
				email: "Please enter a valid email address"
			},
			pdi_date: {
				digits: "Please enter only numbers for the date",
				minlength: "Date must be exactly 6 digits (DDMMYY)"
			}
		}
	});
	if ($('#sell-car-success').length) {
		$('html, body').animate({
			scrollTop: $('#sell-car-success').offset().top - 100
		}, 600);
	}


	// Define filesize method BEFORE validate()
	if ($.validator && !$.validator.methods.filesize) {
		$.validator.addMethod("filesize", function (value, element, param) {
			if (element.files && element.files.length) {
				return element.files[0].size <= param;
			}
			return true;
		}, "File size must be under 2MB");
	}

	$("#sellCar").validate({
		errorElement: 'span',
		errorClass: 'text-danger small',
		highlight: function (element) {
			$(element).addClass('is-invalid');
		},
		unhighlight: function (element) {
			$(element).removeClass('is-invalid');
		},
		submitHandler: function (form) {
			// Check for Turnstile token before submitting
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
			mobcustomer_mobileile: { required: true, minlength: 7, maxlength: 20 },
			car_photos: { extension: "jpg|jpeg|png", filesize: 2097152 }
		},

	});
	function updateRunningPlaceholder() {
		let pattern = $('input[name="running_pattern"]:checked').val();
		let placeholderText = "km";

		switch (pattern) {
			case 'Everyday': // Handling both potential values
				placeholderText = "km/day";
				break;
			case 'Monthly':
				placeholderText = "km/month";
				break;
			case 'Yearly':
				placeholderText = "km/year";
				break;
			default:
				placeholderText = "km";
		}
		$('input[name="running_km"]').attr('placeholder', placeholderText);
	}
	// 1. Trigger on Change
	$('input[name="running_pattern"]').on('change', function () {
		updateRunningPlaceholder();
	});
	// 2. Trigger on Page Load (to handle "old" or pre-filled values)
	updateRunningPlaceholder();
	let currentStepNum = 1;

	// 1. Initialize jQuery Validation
	var validator = $("#carForm").validate({
		errorElement: 'span',
		errorClass: 'text-danger small',
		highlight: function (element) { $(element).addClass('is-invalid'); },
		unhighlight: function (element) { $(element).removeClass('is-invalid'); },
		rules: {
			name: { required: true, minlength: 3 },
			mobile: { required: true, minlength: 7, maxlength: 20 },
			city: "required",
			service: "required",
			contact: "required",
			budget: { required: true, min: 100000 },
			ownership: "required",
			usage: "required",
			running_pattern: "required",
			//Colour: "required",
			// Existing: "required",
			confirm: "required"
		},
		errorPlacement: function (error, element) {
			if (element.attr("type") == "radio" || element.attr("type") == "checkbox") {
				error.appendTo(element.closest(".form-group"));
			} else {
				error.insertAfter(element);
			}
		},
		submitHandler: function (form) {
			 // Check for Turnstile token before submitting
			const turnstileResponse = $('[name="cf-turnstile-response"]').val();
			if (!turnstileResponse) {
				$('#turnstile-error').show();
				return false;
			}
			$('#turnstile-error').hide(); 

			form.submit();
		}
	});

	// 2. Navigation Function
	function goToStep(step) {
		$(".step").removeClass("active");
		$('.step[data-step="' + step + '"]').addClass("active");
		currentStepNum = step;
		$(window).scrollTop($(".contact-form").offset().top - 100); // Smooth scroll to top of form
	}

	// 3. Next Button Logic
	$(".next").click(function (e) {
	
		e.preventDefault();

		// Validate ONLY the inputs in the current visible step
		let fieldsInStep = $('.step[data-step="' + currentStepNum + '"]').find('input, select, textarea');
		let stepIsValid = true;

		fieldsInStep.each(function () {
			if (!validator.element(this)) {
				stepIsValid = false;
			}
		});

		if (stepIsValid) {
			// ACTION: Save Lead on Step 1 Completion
			if (currentStepNum === 1) {
				$.post("save-lead.php", $("#carForm").serialize());
			}

			// LOGIC: Skip Step 5 if "New Car" is selected
			if (currentStepNum === 4) {
				let service = $("input[name='service']:checked").val();
				if (service === "New Car Consultation") {
					goToStep(6);
					return;
				}
			}

			// Proceed to next step if not at the end
			if (currentStepNum < 6) {
				goToStep(currentStepNum + 1);
			}
		}
	});
	// 4. Back Button Logic
	$(".prev").click(function (e) {
		e.preventDefault();
		// LOGIC: If going back from Final Step and it was a New Car, jump to Step 4
		if (currentStepNum === 6) {
			let service = $("input[name='service']:checked").val();
			if (service === "New Car Consultation") {
				goToStep(4);
				return;
			}
		}
		if (currentStepNum > 1) {
			goToStep(currentStepNum - 1);
		}
	});
});