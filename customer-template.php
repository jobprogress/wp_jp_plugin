<script type="text/template" id="tpl-hello">
<div>
<span>Hello</span>
<span>{{NAME}}  </span>
</div>
</script>

<script type="text/template" class="additional-phone">
	<div class="form-group form-group-input jobprogress-customer-phone {{className}}">
		<label class="absolute-label">Phone <span class="required-sign">*</span></label>
		<div class="form-combine-select">
			<div class="sm-select">
				<select required="" name="phones[{{ index }}][label]" class="phone-label select-input" aria-required="true" tabindex="{{ index }}" aria-hidden="true">
					<option value="home">Home</option>
					<option value="cell">Cell</option>
					<option value="phone">Phone</option>
					<option value="office">Office</option>
					<option value="fax">Fax</option>
					<option value="other">Other</option>
				</select>
			</div>
			<!-- <span class="select2 select2-container select2-container--default" dir="ltr" style="width: 78px;">
				<span class="selection"><span aria-expanded="false" aria-haspopup="true" role="combobox" class="select2-selection select2-selection--single" tabindex="{{ index }}" aria-labelledby="select2-phones0label-qg-container">
					<span class="select2-selection__rendered" id="select2-phones0label-qg-container" title="Home">Home</span>
					<span role="presentation" class="select2-selection__arrow"><b role="presentation"></b>
					</span>
				</span>
			</span>
			<span aria-hidden="true" class="dropdown-wrapper"></span>
			</span>  -->
		<input type="text"  placeholder="(xxx) xxx-xxxx" name="phones[{{ index }}][number]" class="phones mask-select phone-number-field form-control" aria-required="true" required /> 
		<div class="ext-field">
			<input type="text" placeholder="Extension" name="phones[{{ index }}][ext]" class="extension-field form-control" maxlength="12" aria-required="true">
		</div>
		</div>
		<a title="Remove Additional Phone" class="additional-val jp-tooltip remove remove-additional-phone">
			<img src="<?php echo plugin_dir_url( __FILE__ ); ?>/img/close-icon-red.png" alt="close">
		</a>
		<?php echo $this->get_error_wrapper('phones.{{ index }}.number'); ?>
	</div>	
</script>

<script type="text/template" class="additional-email">
	<div class="form-group form-group-input additional-emails">
		<label class="absolute-label">Additional Email</label>
		<div>
			<input type="text" class="email form-control" placeholder="Additional Email" name="additional_emails[{{index}}]" required/ >
		</div>
		
		<a title="Remove Additional Email" class="additional-val jp-tooltip remove additional-email-remove">
			<img src="<?php echo plugin_dir_url( __FILE__ ); ?>/img/close-icon-red.png" alt="close">
		</a>	
	</div>
</script>
<script type="text/template" class="billing-address">
</script>
