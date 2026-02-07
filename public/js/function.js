$(document).ready(function () {
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
(function ($) {
	"use strict";

	var $window = $(window);
	var $body = $('body');

	/* Preloader Effect */
	$window.on('load', function () {
		$(".preloader").fadeOut(600);
	});

	/* Sticky Header */
	if ($('.active-sticky-header').length) {
		$window.on('resize', function () {
			setHeaderHeight();
		});

		function setHeaderHeight() {
			$("header.active-sticky-header").css("height", $('header.active-sticky-header .header-sticky').outerHeight());
		}

		$window.on("scroll", function () {
			var fromTop = $(window).scrollTop();
			setHeaderHeight();
			var headerHeight = $('header.active-sticky-header .header-sticky').outerHeight()
			$("header.active-sticky-header .header-sticky").toggleClass("hide", (fromTop > headerHeight + 100));
			$("header.active-sticky-header .header-sticky").toggleClass("active", (fromTop > 600));
		});
	}

	/* Slick Menu JS */
	$('#menu').slicknav({
		label: '',
		prependTo: '.responsive-menu'
	});

	if ($("a[href='#top']").length) {
		$(document).on("click", "a[href='#top']", function () {
			$("html, body").animate({ scrollTop: 0 }, "slow");
			return false;
		});
	}

	/* Company Logo Slider JS */
	if ($('.company-logo-slider').length) {
		const hero_slider_ultimate = new Swiper('.company-logo-slider .swiper', {
			slidesPerView: 2,
			speed: 1000,
			spaceBetween: 50,
			loop: true,
			autoplay: {
				delay: 5000,
			},
			breakpoints: {
				768: {
					slidesPerView: 4,
				},
				991: {
					slidesPerView: 5,
				}
			}
		});
	}

	/* testimonial Slider JS */
	if ($('.testimonial-slider').length) {
		const testimonial_slider = new Swiper('.testimonial-slider .swiper', {
			slidesPerView: 1,
			speed: 1000,
			spaceBetween: 30,
			loop: true,
			autoplay: {
				delay: 5000,
			},
			pagination: {
				el: '.testimonial-pagination',
				clickable: true,
			},
			navigation: {
				nextEl: '.testimonial-btn-next',
				prevEl: '.testimonial-btn-prev',
			},
			breakpoints: {
				768: {
					slidesPerView: 2,
				},
				991: {
					slidesPerView: 2,
				},
				1366: {
					slidesPerView: 3,
				}
			}
		});
	}

	/* Hero Slider Ultimate JS */
	if ($('.hero-slider-ultimate').length) {
		const hero_slider_ultimate = new Swiper('.hero-slider-ultimate .swiper', {
			slidesPerView: 2,
			speed: 1000,
			spaceBetween: 40,
			loop: true,
			autoplay: {
				delay: 5000,
			},
			breakpoints: {
				768: {
					slidesPerView: 3,
				},
				991: {
					slidesPerView: 3,
				},
				1024: {
					slidesPerView: 3,
				}
			}
		});
	}

	/* testimonial Slider Ultimate JS */
	if ($('.testimonial-slider-ultimate').length) {
		const testimonial_slider_ultimate = new Swiper('.testimonial-slider-ultimate .swiper', {
			slidesPerView: 1,
			speed: 1000,
			spaceBetween: 30,
			loop: true,
			autoplay: {
				delay: 5000,
			},
			pagination: {
				el: '.testimonial-pagination-royal',
				clickable: true,
			},
			navigation: {
				nextEl: '.testimonial-btn-next',
				prevEl: '.testimonial-btn-prev',
			},
			breakpoints: {
				768: {
					slidesPerView: 2,
				},
				991: {
					slidesPerView: 2,
				},
				1366: {
					slidesPerView: 3,
				}
			}
		});
	}

	/* testimonial Slider Prime JS */
	if ($('.testimonial-slider-prime').length) {
		const testimonial_slider_prime = new Swiper('.testimonial-slider-prime .swiper', {
			slidesPerView: 1,
			speed: 1000,
			spaceBetween: 30,
			loop: true,
			autoplay: {
				delay: 5000,
			},
			pagination: {
				el: '.testimonial-pagination-prime',
				clickable: true,
			},
			navigation: {
				nextEl: '.testimonial-btn-next',
				prevEl: '.testimonial-btn-prev',
			},
			breakpoints: {
				1366: {
					slidesPerView: 1,
				}
			}
		});
	}

	/* Skill Bar */
	if ($('.skills-progress-bar').length) {
		$('.skills-progress-bar').waypoint(function () {
			$('.skillbar').each(function () {
				$(this).find('.count-bar').animate({
					width: $(this).attr('data-percent')
				}, 2000);
			});
		}, {
			offset: '70%'
		});
	}

	/* Youtube Background Video JS */
	if ($('#herovideo').length) {
		var myPlayer = $("#herovideo").YTPlayer();
	}

	/* Init Counter */
	if ($('.counter').length) {
		$('.counter').counterUp({ delay: 6, time: 3000 });
	}

	/* Image Reveal Animation */
	if ($('.reveal').length) {
		gsap.registerPlugin(ScrollTrigger);
		let revealContainers = document.querySelectorAll(".reveal");
		revealContainers.forEach((container) => {
			let image = container.querySelector("img");
			let tl = gsap.timeline({
				scrollTrigger: {
					trigger: container,
					toggleActions: "play none none none"
				}
			});
			tl.set(container, {
				autoAlpha: 1
			});
			tl.from(container, 1, {
				xPercent: -100,
				ease: Power2.out
			});
			tl.from(image, 1, {
				xPercent: 100,
				scale: 1,
				delay: -1,
				ease: Power2.out
			});
		});
	}

	/* Text Effect Animation */
	function initHeadingAnimation() {

		if ($('.text-effect').length) {
			var textheading = $(".text-effect");

			if (textheading.length === 0) return; gsap.registerPlugin(SplitText); textheading.each(function (index, el) {

				el.split = new SplitText(el, {
					type: "lines,words,chars",
					linesClass: "split-line"
				});

				if ($(el).hasClass('text-effect')) {
					gsap.set(el.split.chars, {
						opacity: .3,
						x: "-7",
					});
				}
				el.anim = gsap.to(el.split.chars, {
					scrollTrigger: {
						trigger: el,
						start: "top 92%",
						end: "top 60%",
						markers: false,
						scrub: 1,
					},

					x: "0",
					y: "0",
					opacity: 1,
					duration: .7,
					stagger: 0.2,
				});

			});
		}

		if ($('.text-anime-style-1').length) {
			let staggerAmount = 0.05,
				translateXValue = 0,
				delayValue = 0.5,
				animatedTextElements = document.querySelectorAll('.text-anime-style-1');

			animatedTextElements.forEach((element) => {
				let animationSplitText = new SplitText(element, { type: "chars, words" });
				gsap.from(animationSplitText.words, {
					duration: 1,
					delay: delayValue,
					x: 20,
					autoAlpha: 0,
					stagger: staggerAmount,
					scrollTrigger: { trigger: element, start: "top 85%" },
				});
			});
		}

		if ($('.text-anime-style-2').length) {
			let staggerAmount = 0.03,
				translateXValue = 20,
				delayValue = 0.1,
				easeType = "power2.out",
				animatedTextElements = document.querySelectorAll('.text-anime-style-2');

			animatedTextElements.forEach((element) => {
				let animationSplitText = new SplitText(element, { type: "chars, words" });
				gsap.from(animationSplitText.chars, {
					duration: 1,
					delay: delayValue,
					x: translateXValue,
					autoAlpha: 0,
					stagger: staggerAmount,
					ease: easeType,
					scrollTrigger: { trigger: element, start: "top 85%" },
				});
			});
		}

		if ($('.text-anime-style-3').length) {
			let animatedTextElements = document.querySelectorAll('.text-anime-style-3');

			animatedTextElements.forEach((element) => {
				//Reset if needed
				if (element.animation) {
					element.animation.progress(1).kill();
					element.split.revert();
				}

				element.split = new SplitText(element, {
					type: "lines,words,chars",
					linesClass: "split-line",
				});
				gsap.set(element, { perspective: 400 });

				gsap.set(element.split.chars, {
					opacity: 0,
					x: "50",
				});

				element.animation = gsap.to(element.split.chars, {
					scrollTrigger: { trigger: element, start: "top 90%" },
					x: "0",
					y: "0",
					rotateX: "0",
					opacity: 1,
					duration: 1,
					ease: Back.easeOut,
					stagger: 0.02,
				});
			});
		}
	}

	if (document.fonts && document.fonts.ready) {
		document.fonts.ready.then(() => {
			initHeadingAnimation();
		});
	} else {
		window.addEventListener("load", initHeadingAnimation);
	}

	/* Parallaxie js */
	var $parallaxie = $('.parallaxie');
	if ($parallaxie.length && ($window.width() > 1024)) {
		if ($window.width() > 768) {
			$parallaxie.parallaxie({
				speed: 0.55,
				offset: 0,
			});
		}
	}

	/* Zoom Gallery screenshot */
	$('.gallery-items').magnificPopup({
		delegate: 'a',
		type: 'image',
		closeOnContentClick: false,
		closeBtnInside: false,
		mainClass: 'mfp-with-zoom',
		image: {
			verticalFit: true,
		},
		gallery: {
			enabled: true
		},
		zoom: {
			enabled: true,
			duration: 300, // don't foget to change the duration also in CSS
			opener: function (element) {
				return element.find('img');
			}
		}
	});











	/* Animated Wow Js */
	new WOW().init();

	/* Popup Video */
	if ($('.popup-video').length) {
		$('.popup-video').magnificPopup({
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: true
		});
	}

	/* Why Choose Card Active JS Start */
	if ($('.why-choose-card-btn').length) {
		$('.why-choose-card-btn').on('click', function () {
			var $cardItem = $(this).closest('.why-choose-card-item');
			$('.why-choose-card-item').removeClass('active');
			$cardItem.addClass('active');
		});
	}


	/* Image Coparision JS Start */
	if ($('.transformation_image').length) {
		$(".transformation_image").twentytwenty({
			no_overlay: true,
		});
	}
	/* Image Coparision JS End */

})(jQuery);