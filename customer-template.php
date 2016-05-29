<script type="text/template" id="tpl-hello">
<div>
<span>Hello</span>
<span>{{NAME}}  </span>
</div>
</script>

<script type="text/template" class="additional-phone">
	<div class="form-group jobprogress-customer-phone">
		<label>Phone <span class="required-sign">*</span></label>
		<a class="additional-val jp-tooltip remove remove-additional-phone" title="Remove Additional Phone">
			<span></span>
		</a>
		<div class="form-combine-select">
			<select required="" name="phones[{{ index }}][label]" class="phone-label select2 select2-hidden-accessible" aria-required="true" tabindex="{{ index }}}" aria-hidden="true">
				<option value="home">Home</option>
				<option value="cell">Cell</option>
				<option value="phone">Phone</option>
				<option value="office">Office</option>
				<option value="fax">Fax</option>
				<option value="other">Other</option>
			</select>
			<span class="select2 select2-container select2-container--default" dir="ltr" style="width: 78px;">
				<span class="selection"><span aria-expanded="false" aria-haspopup="true" role="combobox" class="select2-selection select2-selection--single" tabindex="{{ index }}" aria-labelledby="select2-phones0label-qg-container">
					<span class="select2-selection__rendered" id="select2-phones0label-qg-container" title="Home">Home</span>
					<span role="presentation" class="select2-selection__arrow"><b role="presentation"></b>
					</span>
				</span>
			</span>
			<span aria-hidden="true" class="dropdown-wrapper"></span>
			</span> 
		<input type="text"  placeholder="(xxx) xxx-xxxx" name="phones[{{ index }}][number]" class="phones number mask-select phone-number-field" aria-required="true" required /> 
			<input type="text" placeholder="Extension" name="phones[{{ index }}][ext]" class="extension-field number" maxlength="8" aria-required="true">
		</div>
	</div>	
</script>

<script type="text/template" class="additional-email">
	<div class="form-group additional-emails">
		<label></label>
		<span>
			<input type="text" placeholder="Additional Email" name="additional_emails[]" required/ >
		</span>
		
		<a title="Remove Additional Phone" class="additional-val jp-tooltip remove additional-email-remove">
			<span></span>
		</a>	
	</div>
</script>

<script type="text/template" class="billing-address">

</script>

