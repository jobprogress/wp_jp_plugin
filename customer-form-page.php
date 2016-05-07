
<form method="post" id = "jobprogrssCustomerSignupForm" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>">
	<div class="form-group customer">
		Customer Type
		<input class= "jobprogress-customer-type" type="checkbox" value="0" name="jobprogress_customer_type1" checked/> Residential
		<input class= "jobprogress-customer-type" type="checkbox" value="1" name="jobprogress_customer_type2" /> Commercial
		<?php echo $this->get_error_wrapper('customer_type'); ?>
	</div>
	<div class="form-group jobprogress-residential-type">
		<label>Name *</label>
		<input type="text" name="first_name" placeholder="First Name" >
		<?php echo $this->get_error_wrapper('first_name'); ?>
		<input type="text" name="last_name"  placeholder="Last Name"  >
		<?php echo $this->get_error_wrapper('last_name'); ?>
	</div>
	<div class="form-group jobprogress-commercial-type" style="display:none;">
		<label>Company name *</label>
		<input type="text" name="company_name_commercial" placeholder="Company Name" >
		<?php echo $this->get_error_wrapper('company_name_commercial'); ?>
	</div>
	<div class="form-group jobprogress-residential-type">
		<label>Company name</label>
		<input type="text" name="company_name"  placeholder="Company Name" placeholder="Company Name">
	</div>

	<div class="form-group jobprogress-customer-phone">
		<label>Phone *</label>

		<select class="phone-label" name="phones[0][label]">
			<option value="home">Home</option>
			<option value="cell">Cell</option>
			<option value="phone">Phone</option>
			<option value="office">Office</option>
			<option value="fax">Fax</option>
			<option value="other">Other</option>
		</select> 
		<input type="text" maxlength= "10" class="phones number" name="phones[0][number]" placeholder="Phone" > 
		<input type="text" maxlength= "8" class="number" name="phones[0][ext]" placeholder="Extension" >
		<?php echo $this->get_error_wrapper('phones.0.label'); ?>
		<?php echo $this->get_error_wrapper('phones.0.number'); ?>
	</div>

	<div class="form-group jobprogress-customer-phone">
		<label>Phone *</label>
		<select class="phone-label" name="phones[1][label]">
			<option value="home">Home</option>
			<option value="cell">Cell</option>
			<option value="phone">Phone</option>
			<option value="office">Office</option>
			<option value="fax">Fax</option>
			<option value="other">Other</option>
		</select> 

		<input type="text" maxlength= "10" class="phones number" name="phones[1][number]" placeholder="Phone" >
		<input type="text" maxlength= "8" class="number" name="phones[1][ext]" placeholder="Extension"/>
		<?php echo $this->get_error_wrapper('phones.1.label'); ?>
		<?php echo $this->get_error_wrapper('phones.1.number'); ?>
	</div>

	<div class="form-group">
		<label>Email *</label>
		<input type="text" placeholder="Email" name="email" / >
		<?php echo $this->get_error_wrapper('email'); ?>
	</div>

	<div class="form-group">
		<input type="text" placeholder="Additional Email" name="additional_emails[0]" / >
		<?php echo $this->get_error_wrapper('additional_emails.0'); ?>
	</div>
	<div class="form-group">
		<label>Address *</label>
		<input type="text" placeholder="Address" name="address[address]" / >
		<?php echo $this->get_error_wrapper('address.address'); ?>
	</div>
	<div class="form-group">
		<label>City *</label>
		<input type="text" placeholder="city" name="address[city]" / >
		<?php echo $this->get_error_wrapper('address.city'); ?>
	</div>
	<div class="form-group">
		<label>State *</label>
		<!-- <input type="text" placeholder="State" name="address[state]" / > -->
		<select name="address[state_id]">
			<option >select states</option>
			<?php foreach ($states as $key => $state) : ?>
			<option value="<?php echo $state['id'] ?>"><?php echo $state['name']; ?></option>
		<?php endforeach; ?>	
	</select>
	<?php echo $this->get_error_wrapper('address.state'); ?>
</div>
<div class="form-group">
	<label>zip *</label>
	<input type="text" placeholder="zip" name="address[zip]" / >
	<?php echo $this->get_error_wrapper('address.zip'); ?>
</div>
<div class="form-group">
	<label>Country *</label>
	<select name="address[country_id]">
		<option >select country</option>
		<?php foreach ($countries as $key => $country) : ?>
		<option value="<?php echo $country['id'] ?>"><?php echo $country['name']; ?></option>
	<?php endforeach; ?>	
</select>

<?php echo $this->get_error_wrapper('address.country'); ?>
</div>

<div class="form-group">
	<label>Billing Address</label>
	<input type="checkbox" name="same_as_customer_address" value= "true"/ checked> Same as above

</div>

<div class="form-group">
	<label>Address *</label>
	<input type="text" placeholder="Address" name="billing[address]" / >
	<?php echo $this->get_error_wrapper('billing.address'); ?>
</div>
<div class="form-group">
	<label>City *</label>
	<input type="text" placeholder="city" name="billing[city]" / >
	<?php echo $this->get_error_wrapper('billing.city'); ?>
</div>
<div class="form-group">
	<label>State *</label>
	<select name="billing[state]">
		<option >select states</option>
		<?php foreach ($states as $key => $state) : ?>
		<option value="<?php echo $state['id'] ?>"><?php echo $state['name']; ?></option>
	<?php endforeach; ?>	
</select>
<?php echo $this->get_error_wrapper('billing.state'); ?>
</div>
<div class="form-group">
	<label>zip *</label>
	<input type="text" placeholder="zip code" name="billing[zip]" / >
	<?php echo $this->get_error_wrapper('billing.zip'); ?>
</div>
<div class="form-group">
	<label>country *</label>
	<select name="billing[country]">
		<option >select country</option>
		<?php foreach ($countries as $key => $country) : ?>
		<option value="<?php echo $country['id'] ?>"><?php echo $country['name']; ?></option>
	<?php endforeach; ?>	
</select>
<?php echo $this->get_error_wrapper('billing.country'); ?>
</div>
<div class="form-group">
	<label>Trades *</label>
	<div>
		<?php if($trades): ?>
		<?php foreach ($trades as $key => $trade) : ?>
		<input type="checkbox" name="job[trades][]" value="<?php echo $trade['id'] ?>"> <?php echo $trade['name']; ?><br>
		<?php endforeach; ?>
		<?php endif; ?>
		<?php echo $this->get_error_wrapper('job_trades'); ?>
</div>
<input type="text" name="job[description]" placeholder="Description"/>
<?php echo $this->get_error_wrapper('job_description'); ?>
</div>
<button type="submit" class="btn btn-default">Save</button>
<button class="btn btn-default">Cancel</button>
</form>