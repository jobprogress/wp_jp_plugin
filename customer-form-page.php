<div class="alert-msg alert-msg-success">Well done! You successfully read this important alert message. </div>
<div class="alert-msg alert-msg-danger">Oh snap! Change a few things up and try submitting again. </div>
<form class="customer-page" method="post" id = "jobprogrssCustomerSignupForm" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>">
	<div class="form-group customer">
		<label>Customer Type</label>
		<input id="res" class= "jobprogress-customer-type" type="checkbox" value="0" name="jobprogress_customer_type1" checked/> <label class="has-outer-label css-label checkbox-label radGroup1" for="res">Residential</label>
		<input id="com" class= "jobprogress-customer-type" type="checkbox" value="1" name="jobprogress_customer_type2" /> <label class="has-outer-label css-label checkbox-label radGroup1" for="com">Commercial</label>
		<?php echo $this->get_error_wrapper('customer_type'); ?>
	</div>
	<div class="form-group jobprogress-residential-type">
		<label>Name <span class="required-sign">*</span></label>
		<span>
			<input type="text" name="first_name" placeholder="First Name" required>
			<?php echo $this->get_error_wrapper('first_name'); ?>
		</span>
		<span>
			<input type="text" name="last_name"  placeholder="Last Name"  >
			<?php echo $this->get_error_wrapper('last_name'); ?>
		</span>
	</div>
	<div class="form-group jobprogress-commercial-type" style="display:none;">
		<label>Company name <span class="required-sign">*</span></label>
		<span>
			<input type="text" name="company_name_commercial" placeholder="Company Name" required>
			<?php echo $this->get_error_wrapper('company_name_commercial'); ?>
		</span>
	</div>
	<div class="form-group jobprogress-company-type">
		<label>Company name</label>
		<span>
			<input type="text" name="company_name"  placeholder="Company Name" placeholder="Company Name">
		</span>
	</div>

	<div class="form-group jobprogress-customer-phone">
		<label>Phone <span class="required-sign">*</span></label>
		<a class="additional-val jp-tooltip remove" title="Remove Additional Phone">
			<span></span>
		</a>
		<a class="additional-val jp-tooltip" title="Add Additional Phone">
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
			<input type="text" class="phones number mask-select phone-number-field" name="phones[0][number]" placeholder="Phone" required > 
			<input type="text" maxlength= "8" class="extension-field number" name="phones[0][ext]" placeholder="Extension" required >
		</div>
		<?php echo $this->get_error_wrapper('phones.0.label'); ?>
		<?php echo $this->get_error_wrapper('phones.0.number'); ?>
	</div>

	<div class="form-group jobprogress-customer-phone">
		<label>Phone <span class="required-sign">*</span></label>
		<div class="form-combine-select">
			<select class="phone-label select2" name="phones[1][label]" required>
				<option value="home">Home</option>
				<option value="cell">Cell</option>
				<option value="phone">Phone</option>
				<option value="office">Office</option>
				<option value="fax">Fax</option>
				<option value="other">Other</option>
			</select> 
			<input type="text" class="phones number mask-select phone-number-field" name="phones[1][number]" placeholder="Phone" required>
			<input type="text" maxlength= "8" class="number extension-field" name="phones[1][ext]" placeholder="Extension"/>
		</div>
		<?php echo $this->get_error_wrapper('phones.1.label'); ?>
		<?php echo $this->get_error_wrapper('phones.1.number'); ?>

	</div>

	<div class="form-group">
		<label>Email <span class="required-sign">*</span></label>
		<span>
			<input type="text" placeholder="Email" name="email" required/ >
			<?php echo $this->get_error_wrapper('email'); ?>
		</span>
		<a class="additional-val jp-tooltip remove" title="Remove Additional Phone">
			<span></span>
		</a>
		<a class="additional-val jp-tooltip" title="Add Additional Phone">
			<span>+</span>
		</a>
	</div>

	<div class="form-group additional-email">
		<span>
			<input type="text" placeholder="Additional Email" name="additional_emails[0]" / >
			<?php echo $this->get_error_wrapper('additional_emails.0'); ?>
		</span>
	</div>
	<div class="form-group">
		<label>Address </label>
		<span>
			<input type="text" placeholder="Address" name="address[address]" / >
			<?php echo $this->get_error_wrapper('address.address'); ?>
		</span>
	</div>
	<div class="form-group col-5">
		<label>City </label>
		<span>
			<input type="text" placeholder="city" name="address[city]" / >
			<?php echo $this->get_error_wrapper('address.city'); ?>
		</span>
	</div>
	<div class="form-group col-5">
		<label class="state">State </label>
		<!-- <input type="text" placeholder="State" name="address[state]" / > -->
		<span>
			<select name="address[state_id]" class="select2">
				<option >Select States</option>
				<?php foreach ($states as $key => $state) : ?>
				<option value="<?php echo $state['id'] .'_'.$state['name']; ?>"><?php echo $state['name']; ?></option>
			<?php endforeach; ?>	
			</select>
		
		<?php echo $this->get_error_wrapper('address.state'); ?>
		</span>
	</div>
	<div class="form-group col-5">
		<label>zip </label>
		<span>
			<input type="text" placeholder="zip" name="address[zip]" / >
			<?php echo $this->get_error_wrapper('address.zip'); ?>
		</span>
	</div>
	<div class="form-group col-5">
		<label class="country">Country </label>
		<span>
			<select name="address[country_id]" class="select2">
				<option >Select Country</option>
				<?php foreach ($countries as $key => $country) : ?>
				<option value="<?php echo $country['id'] .'_'.$country['name']; ?>"><?php echo $country['name']; ?></option>
			<?php endforeach; ?>	
			</select>

			<?php echo $this->get_error_wrapper('address.country'); ?>
		</span>
	</div>

	<div class="form-group">
		<label>Billing Address</label>
		<span>
			<input type="checkbox" name="same_as_customer_address" value= "true"/ checked> Same as above
		</span>
	</div>

	<div class="form-group">
		<label>Address </label>
		<span>
			<input type="text" placeholder="Address" name="billing[address]" / >
			<?php echo $this->get_error_wrapper('billing.address'); ?>
		</span>
	</div>
	<div class="form-group col-5">
		<label>City </label>
		<span>
			<input type="text" placeholder="city" name="billing[city]" / >
			<?php echo $this->get_error_wrapper('billing.city'); ?>
		</span>
	</div>
	<div class="form-group col-5">
		<label class="state">State </label>
		<span>
			<select name="billing[state_id]" class="select2">
				<option >Select States</option>
				<?php foreach ($states as $key => $state) : ?>
				<option value="<?php echo $state['id'] .'_'.$state['name']; ?>"><?php echo $state['name']; ?></option>
			<?php endforeach; ?>	
			</select>
			<?php echo $this->get_error_wrapper('billing.state'); ?>
		</span>
	</div>
	<div class="form-group col-5">
		<label>zip </label>
		<span>
			<input type="text" placeholder="zip code" name="billing[zip]" / >
			<?php echo $this->get_error_wrapper('billing.zip'); ?>
		</span>
	</div>
	<div class="form-group col-5">
		<label class="country">country </label>
		<span>
			<select name="billing[country_id]" class="select2">
				<option >Select Country</option>
				<?php foreach ($countries as $key => $country) : ?>
				<option value="<?php echo $country['id'] .'_'.$country['name']; ?>"><?php echo $country['name']; ?></option>
			<?php endforeach; ?>	
			</select>
			<?php echo $this->get_error_wrapper('billing.country'); ?>
		</span>
	</div>
	<div class="form-group">
		<label>Trades <span class="required-sign">*</span></label>
		<span>
			<select name="billing[country_id]" class="select2" multiple="multiple">
				<option >Select Trades</option>
				<?php if($trades): ?>
				<?php foreach ($trades as $key => $trade) : ?>
				<option value="<?php echo $trade['id'] ?>"><?php echo $trade['name']; ?></option>
				<?php endforeach; ?>
				<?php endif; ?>
				<?php echo $this->get_error_wrapper('job_trades'); ?>
			</select>
			<?php echo $this->get_error_wrapper('job_description'); ?>
		</span>
	</div>
	<div class="form-group">
		<label>Description</label>
		<span>
			<textarea name="job[description]" rows="5" placeholder="Description" required></textarea>
		</span>
	</div>
	<div class="text-center">
		<button type="submit" class="btn btn-blue">Save</button>
		<button class="btn btn-grey">Cancel</button>
	</div>
</form>