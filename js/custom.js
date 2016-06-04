jQuery(function($) {
	// validate signup form on keyup and submit
	$("#jobprogrssCustomerSignupForm").validate({
		email:true,
		rules: {
			first_name: "required",
			last_name: "required",
			email:{
				email: true
			},
		},
		messages: {
			first_name: "Please enter the first name.",
			last_name: "Please enter the last name.",
		},
		errorPlacement: function(error, element) {
			error.insertAfter( element.parent().parent());
		 }


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
	});
	//$('.mask-select').mask("(xxx) xxx-xxxx", {selectOnFocus: true});
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

	var template = _.template($('.billing-address').html());
	$("input:checkbox[name='same_as_customer_address']").parent().parent().after(template);

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

		$('.jobprogress-customer-phone').last().after(template(
			{
				index: x
			}));
		x++;

	});

	$('body').delegate('.remove-additional-phone', 'click', function(e) {
		$(this).parent().remove();
		$('.add-additional-phone').css('pointer-events', 'auto');
	});

	$("input:checkbox[name='same_as_customer_address']").on('change', function(){
		$('.billing-address-container').hide();
		if(! ($("input:checkbox[name='same_as_customer_address']").prop("checked")) ){
			address = $("input:text[name='address[address]']").val();
			city = $("input:text[name='address[city]']").val();
			country_id = $("#address-country").select2("val");
			console.log(country_id);
			state_id = $("#address-state").select2("val");
			zip = $("input:text[name='address[zip]']").val();
			
			$('#billing-country').val(country_id).trigger("change");
			$("input:text[name='billing[address]']").val(address);
			$("input:text[name='billing[city]']").val(city);
			$("input:checkbox[name='billing[state_id]']").val();
			$("#billing-state").val(state_id).trigger("change");
			$("input:text[name='billing[zip]']").val(zip);
			$('.billing-address-container').show();
		}
	});
	
});