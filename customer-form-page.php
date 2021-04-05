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
	$jp_form_theme = get_option('jp_use_custom_theme');

	// Referred Source query string
	$currentURL = $_SERVER['REQUEST_URI'];
	$referSrcParam = 'ref-source';
	$parts = parse_url($currentURL);
	if(isset($parts['query'])) {
		parse_str($parts['query'], $query);
	}
	if(isset($query[$referSrcParam])) {
		$referSrc = $query[$referSrcParam];
	}
?>

<form class="customer-page customer-page-container" method="post" id = "jobprogrssCustomerSignupForm" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
	<div class="jps-customer-form-wrap <?php echo (($jp_form_theme == '1') ? '' : 'jps-form-ui') ?>">
		<?php foreach($jp_customer_form_fields as $field) {
			switch($field['name']) {
				case 'customer_type' : ?>
					<div class="jps-standard-fieldset jps-field-wrap jps-field-required jps-field--customer-type">
						<label>Customer Type</label>
						<div>
							<div class="jps-selection-col jps-radio-col jps-field--customer-type-res">
								<input id="res" class="jobprogress-customer-type" type="checkbox" value="0" name="jp_customer_type1" checked/>
								<label for="res">Residential</label>
							</div>
							<div class="jps-selection-col jps-radio-col jps-field--customer-type-comm">
								<input id="com" class="jobprogress-customer-type" type="checkbox" value="1" name="jp_customer_type2"/>
								<label for="com">Commercial</label>
							</div>
							<?php echo $this->get_error_wrapper('customer_type'); ?>
						</div>
					</div>
				<?php 
					break;

				case 'customer_name' : ?>
					<div class="jps-field--customer-name-res">
						<div class="jps-fxrow">
							<div class="jps-fxcol-6">
								<div class="jobprogress-residential-type jps-standard-fieldset jps-field-wrap jps-field-required">
									<label>First Name</label>
									<input type="text" class="form-control jps-field--first-name-res" name="first_name" placeholder="First Name" required/>
									<?php echo $this->get_error_wrapper('first_name'); ?>
								</div>
							</div>
							<div class="jps-fxcol-6">
								<div class="jobprogress-residential-type jps-standard-fieldset jps-field-wrap jps-field-required">
									<label>Last Name</label>
									<input type="text" class="form-control jps-field--last-name-res" name="last_name"  placeholder="Last Name" required />
									<?php echo $this->get_error_wrapper('last_name'); ?>
								</div>
							</div>
						</div>
					</div>
					<?php if($field['isCommercial']['isHide'] != 1) { ?>
						<div class="jobprogress-commercial-type jps-field--customer-name-comm" style="display:none;">
							<div class="jps-fxrow">
								<div class="jps-fxcol-6">
									<div class="jps-field-wrap jps-standard-fieldset">
										<label>First Name</label>
										<input type="text" class="form-control jps-field--first-name-comm" name="contact[0][first_name]" placeholder="First Name"/>
										<?php echo $this->get_error_wrapper('contact_first_name'); ?>
									</div>
								</div>
								<div class="jps-fxcol-6">
									<div class="jps-field-wrap jps-standard-fieldset">
										<label>Last Name</label>
										<input type="text" class="form-control jps-field--last-name-comm" name="contact[0][last_name]"  placeholder="Last Name"/>
										<?php echo $this->get_error_wrapper('contact_last_name'); ?>
									</div>
								</div>
							</div>
						</div>
					<?php } 
					break;

				case 'company_name' : 
					if($field['isHide'] != 1) { ?>
						<div class="jps-standard-fieldset jps-field-wrap jobprogress-residential-type jps-field--company-res">
							<label>Company Name</label>
							<input type="text" class="form-control jps-field--company-name-res" name="company_name"  placeholder="Company Name" placeholder="Company Name">
						</div>
					<?php } ?>
						<div class="jps-standard-fieldset jps-field-wrap jps-field-required jobprogress-commercial-type jps-field--company-comm" style="display:none;">
							<label>Company Name</label>
							<input type="text" class="form-control jps-field--company-name-comm" name="company_name_commercial" placeholder="Company Name" required/>
							<?php echo $this->get_error_wrapper('company_name_commercial'); ?>
						</div>
					<?php 
					break;

				case 'customer_phone' : ?>
					<div class="jps-field-wrap jps-field--phone">
						<div class="jps-standard-fieldset jps-field-required jobprogress-customer-phone main-phone-container">
							<label>Phone</label>
							<div class="jps-additional-field">
								<div class="jps-field-left">
									<div class="jps-phone-field">
										<div class="phone-num-type">
											<select class="phone-label select2 form-control main-phone jps-field--phone-type" name="phones[0][label]" required>
												<option value="home">Home</option>
												<option value="cell">Cell</option> 
												<option value="phone">Phone</option>
												<option value="office">Office</option>
												<option value="fax">Fax</option>
												<option value="other">Other</option>
											</select>
										</div>
										<input type="text" class="phones mask-select form-control phone-num jps-field--phone-num" name="phones[0][number]" placeholder="Phone" required/>
										<div class="jps-extension-field">
											<input type="text" maxlength= "12" class="extension-field form-control jps-field--phone-ext" name="phones[0][ext]" placeholder="Extension"/>
										</div> 
									</div>
									<?php 
										echo $this->get_error_wrapper('phones.0.label'); 
										echo $this->get_error_wrapper('phones.0.number'); 
									?>
								</div>
								<a class="jps-field-add add-item-repeat add-additional-phone" title="Add Additional Phone">
									<svg viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
								</a>
							</div>
						</div>
					</div>
					<?php 
					break;

				case 'customer_email' : 
					if($field['isHide'] != 1) { ?>
						<div class="jps-field-wrap jps-field--email">
							<div class="jps-standard-fieldset additional-emails">
								<label>Email</label>
								<div class="jps-additional-field">
									<div class="jps-field-left">
										<input type="text" class="email form-control jps-field--email-text" placeholder="Email" name="email"/>
										<?php echo $this->get_error_wrapper('email'); ?>
									</div>
									<a class="jps-field-add add-item-repeat start-additional-emails" title="Add Additional Email">
										<svg viewBox="0 0 24 24"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
									</a>
								</div>
							</div>
						</div>
					<?php } 
					break;

				case 'customer_address' : 
					if($field['isHide'] != 1) { ?>
						<div class="jps-field--address">
							<div class="jps-standard-fieldset jps-field-wrap">
								<label>Address</label>
								<input type="text" class="form-control jps-field--address-1" placeholder="Address" name="address[address]" />
								<?php echo $this->get_error_wrapper('address'); ?>
							</div>
							<div class="jps-standard-fieldset jps-field-wrap">
								<label>Address Line 2</label>
								<input type="text" class="form-control jps-field--address-2" placeholder="Address Line 2" name="address[address_line_1]"/>
							</div>
							<div class="jps-fxrow">
								<div class="jps-fxcol-6">
									<div class="jps-standard-fieldset jps-field-wrap">
										<label>City</label>
										<input type="text" class="form-control jps-field--address-city" placeholder="City" name="address[city]" />
										<?php echo $this->get_error_wrapper('city'); ?>
									</div>
								</div>
								<div class="jps-fxcol-6">
									<div class="jps-standard-fieldset jps-field-wrap state-list-container">
										<label class="state">State</label>
										<div style="position: relative;">
											<select 
												placeholder="Select States"
												name="address[state_id]" id="address-state" class="select2 form-control state-list jps-field--address-state">
												<?php foreach ($states as $key => $state) : ?>
													<option value="<?php echo $state['id'] .'_'.$state['name']; ?>"><?php echo $state['name']; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
										<?php echo $this->get_error_wrapper('state_id'); ?>
									</div>
								</div>
							</div>
							<div class="jps-fxrow">
								<div class="jps-fxcol-6">
									<div class="jps-standard-fieldset jps-field-wrap">
										<label>Zip</label>
										<input type="text" class="form-control jps-field--address-zip" placeholder="Zip" name="address[zip]" maxLength="10" />
										<?php echo $this->get_error_wrapper('zip'); ?>
									</div>
								</div>
								<div class="jps-fxcol-6">
									<div class="jps-standard-fieldset jps-field-wrap country-list-container">
										<label class="country">Country</label>
										<select name="address[country_id]" id="address-country" class="select2 form-control country-list jps-field--address-country">
											<?php foreach ($countries as $key => $country) : ?>
												<option value="<?php echo $country['id'] .'_'.$country['name']; ?>"><?php echo $country['name']; ?></option>
											<?php endforeach; ?>	
										</select>
										<?php echo $this->get_error_wrapper('country_id'); ?>
									</div>
								</div>
							</div>
							
						</div>
					<?php } 
					break;

				case 'billing_address' : 
					if($field['isHide'] != 1) { ?>
						<div class="jps-standard-fieldset jps-field-wrap billing-address-field jps-field--billing">
							<label>Billing Address: </label>
							<div class="jps-selection-col jps-checkbox-col">
								<input type="checkbox" id="address" name="same_as_customer_address" value= "true" checked class="jps-field--billing-check" />
								<label for="address">Same as above</label>
							</div>
						</div>
						<div class="billing-address-container jps-field--billingAdd">
							<div class="jps-standard-fieldset jps-field-wrap">
								<label>Address</label>
								<input type="text" class="form-control jps-field--billingAdd-1" placeholder="Address" name="billing[address]"/>
							</div>
							<div class="jps-standard-fieldset jps-field-wrap">
								<label>Address Line 2</label>
								<input type="text" class="form-control jps-field--billingAdd-2" placeholder="Address" name="billing[address_line_1]"/>
							</div>
							<div class="jps-fxrow">
								<div class="jps-fxcol-6">
									<div class="jps-standard-fieldset jps-field-wrap">
										<label>City</label>
										<input type="text" class="form-control jps-field--billingAdd-city" placeholder="City" name="billing[city]"/ >
									</div>
								</div>
								<div class="jps-fxcol-6">
									<div class="jps-standard-fieldset jps-field-wrap billing-state-container">
										<label class="state">State</label>
										<select name="billing[state_id]" id="billing-state" class="select2 form-control billing-state jps-field--billingAdd-state">
											<option value="0">Select States</option>
											<?php foreach ($states as $key => $state) : ?>
												<option value="<?php echo $state['id'] .'_'.$state['name']; ?>"><?php echo $state['name']; ?></option>
											<?php endforeach; ?>	
										</select>
									</div>
								</div>
							</div>
							<div class="jps-fxrow">
								<div class="jps-fxcol-6">
									<div class="jps-standard-fieldset jps-field-wrap">
										<label>Zip</label>
										<input type="text" class="form-control jps-field--billingAdd-zip" placeholder="zip code" name="billing[zip]" maxLength="10" />
									</div>
								</div>
								<div class="jps-fxcol-6">
									<div class="jps-standard-fieldset jps-field-wrap billing-country-container">
										<label class="country">Country</label>
										<select name="billing[country_id]" id="billing-country" class="select2 form-control billing-country jps-field--billingAdd-country">
											<option value="0">Select Country</option>
												<?php foreach ($countries as $key => $country) : ?>
											<option value="<?php echo $country['id'] .'_'.$country['name']; ?>"><?php echo $country['name']; ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					<?php } 
					break;

				case 'referred_by' : 
					if($field['isHide'] != 1) { ?>
						<div class="jps-standard-fieldset jps-field-wrap jp-referral-container jps-field--ref">
							<label>Referred By</label>
							<select
								name="referred_by_id" 
								class="jp-referral form-control jps-field--ref-by">
								<?php 
									$jpReferrals = $this->get(JP_REFERRALS_URL);
									foreach ($jpReferrals as $jpReferral) {
										if(isset($referSrc)) {
											if($referSrc == strtolower($jpReferral['name'])) { ?>
												<option value="<?php echo $jpReferral['id'] ?>" selected ><?php echo $jpReferral['name']; ?></option>
											<?php }
										}
										else { ?>
											<option value="<?php echo $jpReferral['id'] ?>" name="<?php echo $jpReferral['name']; ?>"><?php echo $jpReferral['name']; ?></option>
										<?php }
									}
								?>
							</select>
							<?php echo $this->get_error_wrapper('referred_by_id'); ?>
						</div>
						<div class="jps-standard-fieldset jps-field-wrap jps-field-required referred-by-note-block" style="display:none;">
							<label>Note</label>
							<input type="text" class="form-control jps-field--ref-other" name="referred_by_note" placeholder="Note" required/>
							<?php echo $this->get_error_wrapper('referred_by_note'); ?>
						</div>
					<?php } 
					break;

				case 'trades' : ?>
					<div class="jps-standard-fieldset jps-field-wrap jps-field-required jp-trade-container jps-field--trades">
						<label>Trades</label>
						<select name="job[trades][]" class="jp-trade form-control jps-field--trades-list" multiple="multiple" required>
							<?php if($trades): ?>
							<?php foreach ($trades as $key => $trade): ?>
							<option value="<?php echo $trade['id'] ?>"><?php echo $trade['name']; ?></option>
							<?php endforeach; ?>
							<?php endif; ?>
						</select>
						<span class="select-multi-trades">Press `Ctrl + Select` to select multiple trades together.</span>
						<?php echo $this->get_error_wrapper('job_trades'); ?>
					</div>
					<div class="jps-standard-fieldset jps-field-wrap jps-field-required other-trade-note-container" style="display:none;">
						<label>Other Note</label>
						<input class="other-trade-note form-control jps-field--trades-other" type="text" name="job[other_trade_type_description]" required/>
						<?php echo $this->get_error_wrapper('other_trade_type_description'); ?>
					</div>
					<?php  
					break;

				case 'description' : ?>
					<div class="jps-standard-fieldset jps-field-wrap jps-field-required jps-field--desc">
						<label>Description</label>
						<textarea name="job[description]" rows="5" class="form-control jps-field--desc-text" placeholder="Description" required></textarea>
						<?php echo $this->get_error_wrapper('job_description'); ?>
					</div>
			<?php 
					break;
			}
		}  wp_nonce_field( 'submit_jp_customer_form' ); ?>
		<div class="jps-field-wrap jps-standard-fieldset jps-captcha-field jps-field-required">
			<label>Enter Captcha</label>
			<div class="captcha-wrap">
				<div class="jps-captcha-inner">
					<div id="jp_captcha"></div>
					<input type="text" class="form-control captcha-input" placeholder="Enter Captcha" name="cpatchaTextBox" id="cpatchaTextBox"/>
					<span class="refresh-captcha" title="Refresh captcha">
						<img src="<?php echo plugin_dir_url( __FILE__ ); ?>img/sync-alt.svg">
					</span>
				</div>
			</div>
			<label class="error captcha-invalid"></label>
		</div>
		<div class="jps-form-buttons">
			<input type="submit" value="Save">
			<a type="reset" class="btn-form-cancel" onclick="location.reload()">Cancel</a>
		</div>
	</div>

</form>