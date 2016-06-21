<?php  if($this->customer_form_saved): ?>
	<div class="alert-msg alert-msg-success">
		<?php echo JP_CUSTOMER_FORM_SAVED; ?>
	</div>
<?php endif; ?>
<?php if($this->customer_form_wpdb_error): ?>
<div class="alert-msg alert-msg-danger"><?php echo $this->customer_form_wpdb_error; ?></div>
<?php endif ?>	
<form class="customer-page" method="post" id = "jobprogrssCustomerSignupForm" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>">
	<div class="form-group customer">
		<label>Customer Type</label>
		<input id="res" class= "jobprogress-customer-type" type="checkbox" value="0" name="jp_customer_type1" checked/> <label class="has-outer-label css-label checkbox-label radGroup1" for="res">Residential</label>
		<input id="com" class= "jobprogress-customer-type" type="checkbox" value="1" name="jp_customer_type2" /> <label class="has-outer-label css-label checkbox-label radGroup1" for="com">Commercial</label>
		<?php echo $this->get_error_wrapper('customer_type'); ?>
	</div>
	<div class="form-group jobprogress-residential-type jp-name">
		<label class="customer-name-label">Name <span class="required-sign">*</span></label>
		<div class="customer-name-section">
				<div class="col-5">
					<span>
						<input type="text" name="first_name" placeholder="First Name" required>
						<?php echo $this->get_error_wrapper('first_name'); ?>
					</span>
				</div>
				<div class="col-5">
					<span>
						<input type="text" name="last_name"  placeholder="Last Name"  >
						<?php echo $this->get_error_wrapper('last_name'); ?>
					</span>
				</div>
		</div>
	</div>
	<div class="form-group jobprogress-commercial-type" style="display:none;">
		<label>Company name <span class="required-sign">*</span></label>
		<span>
			<input type="text" name="company_name_commercial" placeholder="Company Name" required>
			<?php echo $this->get_error_wrapper('company_name_commercial'); ?>
		</span>
	</div>
	<div class="form-group jobprogress-residential-type">
		<label>Company name</label>
		<span>
			<input type="text" name="company_name"  placeholder="Company Name" placeholder="Company Name">
		</span>
	</div>

	<div class="form-group jobprogress-customer-phone">
		<label>Phone <span class="required-sign">*</span></label>
		<a class="additional-val add-additional-phone jp-tooltip" title="Add Additional Phone">
			<span>+</span>
		</a>
		<div class="form-combine-select">
			<select class="phone-label select2" name="phones[0][label]" required>
				<option value="home">Home</option>
				<option value="cell">Cell</option>
				<option value="phone">Phone</option>
				<option value="office">Office</option>
				<option value="fax">Fax</option>
				<option value="other">Other</option>
			</select> 
			<input type="text" class="phones  mask-select phone-number-field" name="phones[0][number]" placeholder="Phone" required > 
			<input type="text" maxlength= "8" class="extension-field number" name="phones[0][ext]" placeholder="Extension" >
		</div>
		<?php echo $this->get_error_wrapper('phones.0.label'); ?>
		<?php echo $this->get_error_wrapper('phones.0.number'); ?>
	</div>

	<div class="form-group additional-emails">
		<label>Email</label>
		<span>
			<input type="text" placeholder="Email" name="email" />
			<?php echo $this->get_error_wrapper('email'); ?>
		</span>
		
		<a class="additional-val jp-tooltip start-additional-emails" title="Add Additional Phone">
			<span>+</span>
		</a>
	</div>

	<div class="form-group">
		<label>Address</label>
		<span>
			<input type="text" placeholder="Address" name="address[address]" / >
		</span>
	</div>
	<div class="form-group">
		<label>Address Line 2</label>
		<span>
			<input type="text" placeholder="Address" name="address[address_line_1]" / >
		</span>
	</div>
	<div class="form-group col-5">
		<label>City </label>
		<span>
			<input type="text" placeholder="city" name="address[city]" / >
		</span>
	</div>
	<div class="form-group col-5">
		<label class="state">State </label>
		<span>
			<select name="address[state_id]" id="address-state" class="select2">
				<option value="0">Select States</option>
				<?php foreach ($states as $key => $state) : ?>
				<option value="<?php echo $state['id'] .'_'.$state['name']; ?>"><?php echo $state['name']; ?></option>
			<?php endforeach; ?>	
			</select>
		</span>
	</div>
	<div class="form-group col-5">
		<label>zip </label>
		<span>
			<input type="text" class="number" placeholder="zip" name="address[zip]" minLength="5" / >
		</span>
	</div>
	<div class="form-group col-5">
		<label class="country">Country </label>
		<span>
			<select name="address[country_id]" id="address-country" class="select2">
				<option value="0" >Select Country</option>
				<?php foreach ($countries as $key => $country) : ?>
				<option value="<?php echo $country['id'] .'_'.$country['name']; ?>"><?php echo $country['name']; ?></option>
			<?php endforeach; ?>	
			</select>
		</span>
	</div>

	<div class="form-group">
		<label>Billing Address</label>
		<span>
			<input type="checkbox" name="same_as_customer_address" value= "true" checked/> Same as above
		</span>
	</div>
	<div class="billing-address-container">
	<div class="form-group">
		<label>Address </label>
		<span>
			<input type="text" placeholder="Address" name="billing[address]" / >
		</span>
	</div>
	<div class="form-group">
		<label>Address Line 2</label>
		<span>
			<input type="text" placeholder="Address" name="billing[address_line_1]" / >
		</span>
	</div>
	<div class="form-group col-5">
		<label>City </label>
		<span>
			<input type="text" placeholder="city" name="billing[city]" minLength="5"/ >
		</span>
	</div>
	<div class="form-group col-5">
		<label class="state">State </label>
		<span>
			<select name="billing[state_id]" id="billing-state" class="select2">
				<option value="0">Select States</option>
				<?php foreach ($states as $key => $state) : ?>
				<option value="<?php echo $state['id'] .'_'.$state['name']; ?>"><?php echo $state['name']; ?></option>
			<?php endforeach; ?>	
			</select>
		</span>
	</div>
	<div class="form-group col-5">
		<label>zip </label>
		<span>
			<input type="text" placeholder="zip code" name="billing[zip]" / >
		</span>
	</div>
	<div class="form-group col-5">
		<label class="country">country </label>
		<span>
			<select name="billing[country_id]" id="billing-country" class="select2">
				<option value="0">Select Country</option>
				<?php foreach ($countries as $key => $country) : ?>
				<option value="<?php echo $country['id'] .'_'.$country['name']; ?>"><?php echo $country['name']; ?></option>
			<?php endforeach; ?>	
			</select>
		</span>
	</div>
</div>
	<div class="form-group">
		<label>Trades <span class="required-sign">*</span></label>
		<span>
			<select name="job[trades][]" class="jp-trade" multiple="multiple" required>
				<?php if($trades): ?>
				<?php foreach ($trades as $key => $trade) : ?>
				<option value="<?php echo $trade['id'] ?>"><?php echo $trade['name']; ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
				<?php echo $this->get_error_wrapper('job_trades'); ?>
			</select>
			
		</span>
	</div>
	<div class="form-group other-trade-note-container" style="display:none;">
		<label>Other Note <span class="required-sign">*</span></label>
		<span>
			<input class="other-trade-note" type="text" name="job[other_trade_type_description]" required/>
			<?php echo $this->get_error_wrapper('other_trade_type_description'); ?>
		</span>
	</div>
	<?php wp_nonce_field( 'submit_jp_customer_form' ); ?>
	<div class="form-group">
		<label>Description <span class="required-sign">*</span></label>
		<span>
			<textarea name="job[description]" rows="5" placeholder="Description" required></textarea>
			<?php echo $this->get_error_wrapper('job_description'); ?>
		</span>
	</div>
	<div class="text-center">
		<button type="submit" class="btn btn-blue">Save</button>
		<button type="reset" class="btn btn-grey" onclick="location.reload()">Cancel</button>
	</div>
</form>