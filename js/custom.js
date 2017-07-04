jQuery(function($) {

	$(window).on('load', function() {
		setTimeout(function() {
			$('#jp-message').slideUp(800);
		}, 4000);
	});
	
	$("body").on("click", "#refreshimg", function(){
		$("#captchaimage").load(plugin_dir_url+"image_req.php", { 'jp_plugin_dir_url':plugin_dir_url });
		return false;
	});
	
	// validate signup form on keyup and submit
	$("#jobprogrssCustomerSignupForm").validate({
		email:true,
		rules: {
			'first_name': {
				"required": true	
			},
			'last_name':  {
				'required': true
			},
			// 'email':{
			// 	email: true
			// },
			'captcha': {
				required: true,
				remote:  plugin_dir_url+"process.php"
			},
			// 'address[country_id]':  {
			// 	required: true
			// }
		},
		messages: {
			first_name: "Please enter the first name.",
			last_name: "Please enter the last name.",
			captcha: "Correct captcha is required. Click the captcha to generate a new one"
		},
		errorPlacement: function(error, element) {
			error.insertAfter( element.parent());
		},
		onkeyup: false
	});

	// default customer type 1 selected first type is commercial
	$("input:checkbox[name='jp_customer_type1']").prop("checked", true);
	$('.billing-address-container').hide();
	
	$(".jobprogress-customer-type").on('change',function(){

		var all_customer_types = "input:checkbox[class='jobprogress-customer-type']";
		if($(this).attr('name') === 'jp_customer_type2') {
			$('.jobprogress-residential-type').hide();
			$('.jobprogress-commercial-type').show();
			$('#first_name-error').hide();
			$('#last_name-error').hide();
			$('#company_name_commercial-error').show();
		} else {
			$('.jobprogress-commercial-type').hide();
			$('.jobprogress-residential-type').show();
			$('#first_name-error').show();
			$('#last_name-error').show();
			$('#company_name_commercial-error').hide();
		}
		$(all_customer_types).prop("checked", false);
		$(this).prop("checked", true);
	});

	$(".select2").select2({
		minimumResultsForSearch: Infinity
	}).on('change', function (e) {
		var input = $(this).parent().find('.extension-field');
// 		if (e.currentTarget.value == "cell") {
// 			input.val(null);
// 			input.attr('disabled', true);
// 		} else {
// 			input.attr('disabled', false);	
// 		}
	});

	$(".jp-trade").select2({
		placeholder: "Select Trade Type"
	}).on('change', function (e) {
		var input = $(this).parent().find('.extension-field');
// 		if (e.currentTarget.value == "cell") {
// 			input.attr('disabled', true);
// 		} else {
// 			input.attr('disabled', false);	
// 		}

		if($.inArray('24', $(this).val()) > -1 ) {
			$('.other-trade-note-container').show();
		} else {
			$('.other-trade-note-container').hide();
		} 
		
	});
	
	$(".jp-referral").select2({
		placeholder: "Select Referral",
	}).on("select2:select", function(e) {
		if($(this).val() == 'other') {
			$('.referred-by-note-block').show();
		} else {
			$('.referred-by-note-block').hide();
		}
	});

	$('.mask-select').mask("(000) 000-0000", {placeholder: "(xxx) xxx-xxxx"});
	$('.form-combine-select input').focus(function(){
		$(this).parent().addClass('active');
	}).focusout(function(){
	  $(this).parent().removeClass('active');
	});

	//additional email
	
	_.templateSettings = {
	  interpolate: /\{\{(.+?)\}\}/g
	};

	// var template = _.template($('.billing-address').html());
	// $("input:checkbox[name='same_as_customer_address']").after(template);

	var y = 1;
	// add first additional email
	$('.start-additional-emails').on('click', function(e) {
		if($('.additional-emails').length === 4) {
			$('.start-additional-emails').css('pointer-events', 'none');
		}
		
		var template = _.template($('.additional-email').html());
		$('.additional-emails').last().after(template({
			index : y
		}));
		y++;
	});
	
	//remove additional email
	$('body').delegate('.additional-email-remove', 'click', function(e) {
		$(this).parent().remove();
		$('.start-additional-emails').css('pointer-events', 'auto');
	});

	/**
	 * additional phones
	 */
	var x = 1;
	$('body').delegate('.add-additional-phone', 'click', function(e) {
		if($('.jobprogress-customer-phone').length === 4) {
			$('.add-additional-phone').css('pointer-events', 'none');
		}
		
		var template = _.template($('.additional-phone').html());

		$('.jobprogress-customer-phone')
			.last()
			.after(
				template({
					index: x,
					className: 'jp-select-' + x
				})
			);

		$('.jp-select-' + x).find('.select-input').select2({
			minimumResultsForSearch: Infinity
		}).on('change', function (e) {
			var input = $(this).parent().find('.extension-field');
// 			if (e.currentTarget.value == "cell") {
// 				input.val(null);
// 				input.attr('disabled', true);
// 			} else {
// 				input.attr('disabled', false);
			}
		});

		x++;

	});

	$('body').delegate('.remove-additional-phone', 'click', function(e) {
		$(this).parent().remove();
		$('.add-additional-phone').css('pointer-events', 'auto');
	});

	$("input:checkbox[name='same_as_customer_address']").on('change', function(){
		$('.billing-address-container').show();
		if( ($("input:checkbox[name='same_as_customer_address']").prop("checked")) ){
			$('.billing-address-container').hide();
		}
	});
});
