
<script type="text/javascript">
	var plugin_dir_url = "<?php echo plugin_dir_url( __FILE__ ); ?>";
</script>
<?php
if(get_transient("jp_form_submitted")): ?>
	<div id="jp-message" class="alert alert-success alert-msg alert-msg-success text-center">
		<?php echo JP_CUSTOMER_FORM_SAVED; ?>
	</div>
<?php 
endif; 
if($this->customer_form_wpdb_error): ?>
<div class="alert alert-danger alert-msg alert-msg-danger text-center"><?php echo $this->customer_form_wpdb_error; ?></div>
<?php endif; 
	$jp_customer_form_fields = get_option('jp_customer_form_fields');

	// Referred Source query string
	$currentURL = $_SERVER['REQUEST_URI'];
	$referSrcParam = 'ref-source';
	$parts = parse_url($currentURL);
	parse_str($parts['query'], $query);
	if(isset($query[$referSrcParam])) {
		$referSrc = $query[$referSrcParam];
	}
?>

<form class="customer-page customer-page-container" method="post" id = "jobprogrssCustomerSignupForm" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
	<div class="jp-customer-form-wrap">
		<?php foreach($jp_customer_form_fields as $field) {
			switch($field['name']) {
				case 'customer_type' : ?>
					<div class="form-group form-group-input jp-customer-form-field">
						<label class="absolute-label">Customer Type</label>
						<div class="form-group-inner">
							<div class="selection-col radio-col">
								<input id="res" class= "jobprogress-customer-type" type="checkbox" value="0" name="jp_customer_type1" checked/>
								<label for="res">Residential</label>
							</div>
							<div class="selection-col radio-col">
								<input id="com" class= "jobprogress-customer-type" type="checkbox" value="1" name="jp_customer_type2"/>
								<label for="com">Commercial</label>
							</div>
							<?php echo $this->get_error_wrapper('customer_type'); ?>
						</div>
					</div>
			<?php 
					break;

				case 'customer_name' : ?>
					<div class="inline-fields-row jp-customer-form-field">
						<div class="inline-fields-col">
							<div class="form-group form-group-input jobprogress-residential-type jp-name">
								<label class="absolute-label">First Name <span class="required-sign">*</span></label>
								<div>
									<input type="text" class="form-control" name="first_name" placeholder="First Name" required/>
									<?php echo $this->get_error_wrapper('first_name'); ?>
								</div>
							</div>
						</div>
						<div class="inline-fields-col">
							<div class="form-group form-group-input jobprogress-residential-type jp-name">
								<label class="absolute-label">Last Name <span class="required-sign">*</span></label>
								<div>
									<input type="text" class="form-control" name="last_name"  placeholder="Last Name" required />
									<?php echo $this->get_error_wrapper('last_name'); ?>
								</div>
							</div>
						</div>
					</div>
					<?php if($field['isCommercial']['isHide'] != 1) { ?>
						<div class="inline-fields-row jobprogress-commercial-type jp-customer-form-field" style="display:none;">
							<div class="inline-fields-col">
								<div class="form-group form-group-input">
									<label class="absolute-label">First Name</label>
									<div>
										<input type="text" class="form-control" name="contact[0][first_name]" placeholder="First Name"/>
										<?php echo $this->get_error_wrapper('contact_first_name'); ?>
									</div>
								</div>
							</div>
							<div class="inline-fields-col">
								<div class="form-group form-group-input">
									<label class="absolute-label">Last Name</label>
									<div>
										<input type="text" class="form-control" name="contact[0][last_name]"  placeholder="Last Name"/>
										<?php echo $this->get_error_wrapper('contact_last_name'); ?>
									</div>
								</div>
							</div>
						</div>
					<?php } 
					break;

				case 'company_name' : 
					if($field['isHide'] != 1) { ?>
						<div class="form-group form-group-input jobprogress-residential-type jp-customer-form-field">
							<label class="absolute-label">Company Name</label>
							<div>
								<input type="text" class="form-control" name="company_name"  placeholder="Company Name" placeholder="Company Name">
							</div>
						</div>
					<?php } ?>
					<div class="form-group form-group-input jobprogress-commercial-type jp-customer-form-field" style="display:none;">
						<label class="absolute-label">Company Name <span class="required-sign">*</span></label>
						<div>
							<input type="text" class="form-control" name="company_name_commercial" placeholder="Company Name" required/>
							<?php echo $this->get_error_wrapper('company_name_commercial'); ?>
						</div>
					</div>
					<?php 
					break;

				case 'customer_phone' : ?>
					<div class="jp-customer-form-field">
						<div class="form-group form-group-input jobprogress-customer-phone main-phone-container">
							<label class="absolute-label">Phone <span class="required-sign">*</span></label>
							<div class="form-combine-select">
								<div class="sm-select">
									<select class="phone-label select2 sm-select main-phone" name="phones[0][label]" required>
										<option value="home">Home</option>
										<option value="cell">Cell</option> 
										<option value="phone">Phone</option>
										<option value="office">Office</option>
										<option value="fax">Fax</option>
										<option value="other">Other</option>
									</select>
								</div>
								<input type="text" class="phones  mask-select phone-number-field form-control" name="phones[0][number]" placeholder="Phone" required/>
								<div class="ext-field">
									<input type="text" maxlength= "12" class="extension-field form-control" name="phones[0][ext]" placeholder="Extension"/>
								</div> 
							</div>
							<?php 
								echo $this->get_error_wrapper('phones.0.label'); 
								echo $this->get_error_wrapper('phones.0.number'); 
							?>
						</div>
						<a class="add-item-repeat additional-val add-additional-phone jp-tooltip" title="Add Additional Phone">
							<span><img src="<?php echo plugin_dir_url( __FILE__ ); ?>/img/plus.svg"> Add Additional Phone</span>
						</a>
					</div>
					<?php 
					break;

				case 'customer_email' : 
					if($field['isHide'] != 1) { ?>
						<div class="jp-customer-form-field">
							<div class="form-group form-group-input additional-emails">
								<label class="absolute-label">Email</label>
								<div>
									<input type="text" class="form-control" placeholder="Email" name="email"/>
									<?php echo $this->get_error_wrapper('email'); ?>
								</div>
								
							</div>
							<a class="add-item-repeat additional-val jp-tooltip start-additional-emails" title="Add Additional Email">
								<span><img src="<?php echo plugin_dir_url( __FILE__ ); ?>/img/plus.svg"> Add Additional Email</span>
							</a>
						</div>
					<?php } 
					break;

				case 'customer_address' : 
					if($field['isHide'] != 1) { ?>
						<div class="jp-customer-form-field">
							<div class="form-group form-group-input">
								<label class="absolute-label">Address <!-- <span class="required-sign">*</span> --></label>
								<div>
									<input type="text" class="form-control" placeholder="Address" name="address[address]" />
									<?php echo $this->get_error_wrapper('address'); ?>
								</div>
							</div>
							<div class="form-group form-group-input">
								<label class="absolute-label">Address Line 2</label>
								<div>
									<input type="text" class="form-control" placeholder="Address Line 2" name="address[address_line_1]"/>
								</div>
							</div>
							<div class="inline-fields-row">
								<div class="inline-fields-col">
									<div class="form-group form-group-input address-field-col">
										<label class="absolute-label">City <!-- <span class="required-sign">*</span> --></label>
										<div>
											<input type="text" class="form-control" placeholder="City" name="address[city]" />
											<?php echo $this->get_error_wrapper('city'); ?>
										</div>
									</div>
								</div>
								<div class="inline-fields-col">
									<div class="form-group form-group-input state-list-container">
										<label class="state absolute-label">State <!-- <span class="required-sign">*</span> --></label>
										<div>
											<select 
												placeholder="Select States"
												name="address[state_id]" id="address-state" class="select2 form-control state-list">
												<?php foreach ($states as $key => $state) : ?>
												<option value="<?php echo $state['id'] .'_'.$state['name']; ?>"><?php echo $state['name']; ?></option>
											<?php endforeach; ?>
											</select>
											<?php echo $this->get_error_wrapper('state_id'); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="inline-fields-row">
								<div class="inline-fields-col">
									<div class="form-group form-group-input address-field-col">
										<label class="absolute-label">Zip <!-- <span class="required-sign">*</span> --></label>
										<div>
											<input type="text" class="form-control" placeholder="Zip" name="address[zip]" maxLength="10" />
											<?php echo $this->get_error_wrapper('zip'); ?>
										</div>
									</div>
								</div>
								<div class="inline-fields-col">
									<div class="form-group form-group-input country-list-container">
										<label class="country absolute-label">Country <!-- <span class="required-sign">*</span> --></label>
										<div>
											<select name="address[country_id]" id="address-country" class="select2 form-control country-list">
												<?php foreach ($countries as $key => $country) : ?>
												<option value="<?php echo $country['id'] .'_'.$country['name']; ?>"><?php echo $country['name']; ?></option>
												<?php endforeach; ?>	
											</select>
											<?php echo $this->get_error_wrapper('country_id'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } 
					break;

				case 'billing_address' : 
					if($field['isHide'] != 1) { ?>
						<div class="jp-customer-form-field">
							<div class="form-group billing-add">
								<label class="billing-label">Billing Address: </label>
								<div class="selection-col checkbox-col">
									<input type="checkbox" id="address" name="same_as_customer_address" value= "true" checked/>
									<label for="address">Same as above</label>
								</div>
							</div>
							<div class="billing-address-container">
								<div class="form-group form-group-input">
									<label class="absolute-label">Address</label>
									<div>
										<input type="text" class="form-control" placeholder="Address" name="billing[address]"/>
									</div>
								</div>
								<div class="form-group form-group-input">
									<label class="absolute-label">Address Line 2</label>
									<div>
										<input type="text" class="form-control" placeholder="Address" name="billing[address_line_1]"/>
									</div>
								</div>
								<div class="inline-fields-row">
									<div class="inline-fields-col">
										<div class="form-group form-group-input address-field-col">
											<label class="absolute-label">City</label>
											<div>
												<input type="text" class="form-control" placeholder="City" name="billing[city]"/ >
											</div>
										</div>
									</div>
									<div class="inline-fields-col">
										<div class="form-group form-group-input billing-state-container">
											<label class="state absolute-label">State</label>
											<div>
												<select name="billing[state_id]" id="billing-state" class="select2 form-control billing-state">
													<option value="0">Select States</option>
													<?php foreach ($states as $key => $state) : ?>
													<option value="<?php echo $state['id'] .'_'.$state['name']; ?>"><?php echo $state['name']; ?></option>
													<?php endforeach; ?>	
												</select>
											</div>
										</div>
									</div>
								</div>
								<div class="inline-fields-row">
									<div class="inline-fields-col">
										<div class="form-group form-group-input address-field-col">
											<label class="absolute-label">zip</label>
											<div>
												<input type="text" class="form-control" placeholder="zip code" name="billing[zip]" maxLength="10" />
											</div>
										</div>
									</div>
									<div class="inline-fields-col">
										<div class="form-group form-group-input billing-country-container">
											<label class="country absolute-label">Country</label>
											<div>
												<select name="billing[country_id]" id="billing-country" class="select2 form-control billing-country">
													<option value="0">Select Country</option>
													<?php foreach ($countries as $key => $country) : ?>
													<option value="<?php echo $country['id'] .'_'.$country['name']; ?>"><?php echo $country['name']; ?></option>
												<?php endforeach; ?>
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } 
					break;

				case 'referred_by' : 
					if($field['isHide'] != 1) { ?>
						<div class="jp-customer-form-field">
							<?php if(isset($query[$referSrcParam])) { ?>
								<div class="form-group form-group-input referred-src-col">
									<label class="absolute-label">Referred By</label>
									<div>
										<input type="hidden" class="form-control" placeholder="Referred Source" name="referred_source" value="<?php echo $referSrc; ?>" />
										<input type="text" disabled class="form-control" placeholder="Referred Source" name="referred_source_value" value="<?php echo $referSrc; ?>" />
									</div>
								</div>
							<?php } ?>
							<?php if(!isset($query[$referSrcParam])) { ?>
								<div class="form-group form-group-input jp-referral-container">
									<label class="absolute-label">Referred By</label>
									<div>
										<select name="referred_by_id" class="jp-referral form-control">
											<option></option>
											<?php if($referrals): ?>
											<?php foreach ($referrals as $key => $referral): ?>
											<option value="<?php echo $referral['id'] ?>"><?php echo $referral['name']; ?></option>
											<?php endforeach; ?>
											<?php endif; ?>
										</select>
										<?php echo $this->get_error_wrapper('referred_by_id'); ?>
									</div>
								</div>
								<div class="form-group form-group-input referred-by-note-block" style="display:none;">
									<label class="absolute-label">Note <span class="required-sign">*</span></label>
									<div>
										<input type="text" class="form-control" name="referred_by_note" placeholder="Note" required/>
										<?php echo $this->get_error_wrapper('referred_by_note'); ?>
									</div>
								</div>
							<?php } ?>
						</div>
					<?php } 
					break;

				case 'trades' : ?>
					<div class="jp-customer-form-field">
						<div class="form-group form-group-input jp-trade-container">
							<label class="absolute-label">Trades <span class="required-sign">*</span></label>
							<div>
								<select name="job[trades][]" class="jp-trade form-control" multiple="multiple" required>
									<?php if($trades): ?>
									<?php foreach ($trades as $key => $trade): ?>
									<option value="<?php echo $trade['id'] ?>"><?php echo $trade['name']; ?></option>
									<?php endforeach; ?>
									<?php endif; ?>
								</select>
								<?php echo $this->get_error_wrapper('job_trades'); ?>
							</div>
						</div>
						<div class="form-group form-group-input other-trade-note-container" style="display:none;">
							<label class="absolute-label">Other Note <span class="required-sign">*</span></label>
							<div>
								<input class="other-trade-note form-control" type="text" name="job[other_trade_type_description]" required/>
								<?php echo $this->get_error_wrapper('other_trade_type_description'); ?>
							</div>
						</div>
					</div>
					<?php  
					break;

				case 'description' : ?>
					<div class="form-group form-group-input jp-customer-form-field">
						<label class="absolute-label">Description <span class="required-sign">*</span></label>
						<div>
							<textarea name="job[description]" rows="5" class="form-control" placeholder="Description" required></textarea>
							<?php echo $this->get_error_wrapper('job_description'); ?>
						</div>
					</div>
			<?php 
					break;
			}
		}  wp_nonce_field( 'submit_jp_customer_form' ); ?>
	</div>
	
	<div style="position: relative;">
		<div class="captcha-wrap form-group form-group-input">
			<label class="absolute-label">Enter Captcha<span class="required-sign">*</span></label>
			<div id="jp_captcha"></div>
			<input type="text" class="form-control captcha-input" placeholder="Enter Captcha" name="cpatchaTextBox" id="cpatchaTextBox"/>
			<span class="refresh-captcha" title="Refresh captcha">
				<img src="<?php echo plugin_dir_url( __FILE__ ); ?>img/sync-alt.svg">
			</span>
		</div>
		<label class="error captcha-invalid"></label>
	</div>

	<div class="text-center form-btn">
		<button type="submit" class="btn btn-sm btn-primary">Save</button>
		<button type="reset" class="btn btn-sm btn-inverse" onclick="location.reload()">Cancel</button>
	</div>
</form>