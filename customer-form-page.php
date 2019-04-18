
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
<?php endif; ?>

<form class="customer-page customer-page-container" method="post" id = "jobprogrssCustomerSignupForm" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>">
	<div class="form-group form-group-input">
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
	<div class="row inline-fields-row">
		<div class="col-sm-6 inline-fields-col">
			<div class="form-group form-group-input jobprogress-residential-type jp-name">
				<label class="absolute-label">First Name <span class="required-sign">*</span></label>
				<div>
					<input type="text" class="form-control" name="first_name" placeholder="First Name" required/>
					<?php echo $this->get_error_wrapper('first_name'); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-6 inline-fields-col">
			<div class="form-group form-group-input jobprogress-residential-type jp-name">
				<label class="absolute-label">Last Name <span class="required-sign">*</span></label>
				<div>
					<input type="text" class="form-control" name="last_name"  placeholder="Last Name" required />
					<?php echo $this->get_error_wrapper('last_name'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row inline-fields-row">
		<div class="col-sm-6 inline-fields-col">
			<div class="form-group form-group-input jobprogress-commercial-type" style="display:none;">
				<label class="absolute-label">First Name</label>
				<div>
					<input type="text" class="form-control" name="contact[0][first_name]" placeholder="First Name"/>
					<?php echo $this->get_error_wrapper('contact_first_name'); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-6 inline-fields-col">
			<div class="form-group form-group-input jobprogress-commercial-type" style="display:none;">
				<label class="absolute-label">Last Name</label>
				<div>
					<input type="text" class="form-control" name="contact[0][last_name]"  placeholder="Last Name"/>
					<?php echo $this->get_error_wrapper('contact_last_name'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="form-group form-group-input jobprogress-commercial-type" style="display:none;">
		<label class="absolute-label">Company Name <span class="required-sign">*</span></label>
		<div>
			<input type="text" class="form-control" name="company_name_commercial" placeholder="Company Name" required/>
			<?php echo $this->get_error_wrapper('company_name_commercial'); ?>
		</div>
	</div>
	<div class="form-group form-group-input jobprogress-residential-type">
		<label class="absolute-label">Company Name</label>
		<div>
			<input type="text" class="form-control" name="company_name"  placeholder="Company Name" placeholder="Company Name">
		</div>
	</div>

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
			<input type="text" class="form-control" placeholder="Address" name="address[address_line_1]"/>
		</div>
	</div>
	<div class="row inline-fields-row">
		<div class="col-sm-6 inline-fields-col">
			<div class="form-group form-group-input address-field-col">
				<label class="absolute-label">City <!-- <span class="required-sign">*</span> --></label>
				<div>
					<input type="text" class="form-control" placeholder="City" name="address[city]" />
					<?php echo $this->get_error_wrapper('city'); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-6 inline-fields-col">
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
	<div class="row inline-fields-row">
		<div class="col-sm-6 inline-fields-col">
			<div class="form-group form-group-input address-field-col">
				<label class="absolute-label">zip <!-- <span class="required-sign">*</span> --></label>
				<div>
					<input type="text" class="number form-control" placeholder="zip" name="address[zip]" maxLength="5" />
					<?php echo $this->get_error_wrapper('zip'); ?>
				</div>
			</div>
		</div>
		<div class="col-sm-6 inline-fields-col">
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
		<div class="row inline-fields-row">
			<div class="col-sm-6 inline-fields-col">
				<div class="form-group form-group-input address-field-col">
					<label class="absolute-label">City</label>
					<div>
						<input type="text" class="form-control" placeholder="City" name="billing[city]"/ >
					</div>
				</div>
			</div>
			<div class="col-sm-6 inline-fields-col">
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
		<div class="row inline-fields-row">
			<div class="col-sm-6 inline-fields-col">
				<div class="form-group form-group-input address-field-col">
					<label class="absolute-label">zip</label>
					<div>
						<input type="text" class="form-control" placeholder="zip code" name="billing[zip]" maxLength="5" />
					</div>
				</div>
			</div>
			<div class="col-sm-6 inline-fields-col">
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

	<?php wp_nonce_field( 'submit_jp_customer_form' ); ?>
	<div class="form-group form-group-input">
		<label class="absolute-label">Description <span class="required-sign">*</span></label>
		<div>
			<textarea name="job[description]" rows="5" class="form-control" placeholder="Description" required></textarea>
			<?php echo $this->get_error_wrapper('job_description'); ?>
		</div>
	</div>
	
	<div style="position: relative;">
		<div class="form-group form-group-input">
			<label class="absolute-label">Enter Captcha<span class="required-sign">*</span></label>
			<div id="captchaimage">
				<a href="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" id="refreshimg" title="Click to refresh image"><img src="<?php echo plugin_dir_url( __FILE__ ); ?>captcha_image/image.php?<?php echo time(); ?>" width="132" height="46"></a>
			</div>
			<input type="text" class="form-control captcha-input" maxlength="6" name="captcha" id="captcha" placeholder="Enter Captcha" required>
		</div>
	</div>

	<div class="text-center form-btn">
		<button type="submit" class="btn btn-sm btn-primary">Save</button>
		<button type="reset" class="btn btn-sm btn-inverse" onclick="location.reload()">Cancel</button>
	</div>
</form>
