<div class="wrap settings-form-screen">
	<h1>Form Settings</h1>
	<p class="settings-desc">Here you can arrange order of form fields and also hide/show fields for form.</p>
	<form method="post" action="options.php">
		<div class="form-settings-wrap" id="form-sortable">
			<?php
				$diabledFields = ['first_name', 'last_name', 'phone'];
				settings_fields( 'jp_form_settings' ); 
					foreach($settings as $setting) { 
						$count = 1; ?>
						<div class="ui-state-default sortable-field-item" field-index=0>
						<span class="drag-icon">
							<svg viewBox="0 0 32 32" role="presentation"><path fill-rule="evenodd" clip-rule="evenodd" d="M18 8a2 2 0 104 0 2 2 0 00-4 0zm2 10a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm-8 0a2 2 0 110-4 2 2 0 010 4zm-2-10a2 2 0 104 0 2 2 0 00-4 0zm2-6a2 2 0 110-4 2 2 0 010 4z" fill="currentColor"/></svg>
						</span>
						<span class="field-name"><?php echo $setting['title'] ?></span>
						<div class="field-visibility">
							<?php 
								$class = in_array($diabledFields, $setting['disableed']) ? 'Disabled' : '';
								// $custTypeIndex = ($settings['customer_type']['position'] != "") ? $settings['customer_type']['position'] : "0";
								echo '<input value="'.$setting['name'].'" name="jp_customer_form_fields[field"'.$count.'"][name]" type="hidden">';
								echo '<input value="'.$setting['title'].'" name="jp_customer_form_fields[field"'.$count.'"][title]" type="hidden">';
								echo '<input value="'.$setting['order'].'" name="jp_customer_form_fields[field"'.$count.'"][order]" class="field-position-input" type="hidden">';
								echo '<input value="'.$setting['isActive'].'" name="jp_customer_form_fields[field"'.$count.'"][isActive]" type="hidden">';
								echo '<div class="field-visiblity-checkbox"><input type="checkbox"  name="jp_customer_form_fields[field"'.$count.'"][isActive]" value="1"' . checked( 1, $setting['isActive'], false ) . '/><span class="checkbox-style"></span></div>'; 
							?>
						</div>
					</div>
					<?php $count++; }
				?>
				<div id="sortable_fields" class="sortable-fields-wrap">
					<div class="ui-state-default sortable-field-item" field-index=0>
						<span class="drag-icon">
							<svg viewBox="0 0 32 32" role="presentation"><path fill-rule="evenodd" clip-rule="evenodd" d="M18 8a2 2 0 104 0 2 2 0 00-4 0zm2 10a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm-8 0a2 2 0 110-4 2 2 0 010 4zm-2-10a2 2 0 104 0 2 2 0 00-4 0zm2-6a2 2 0 110-4 2 2 0 010 4z" fill="currentColor"/></svg>
						</span>
						<span class="field-name">Customer Type</span>
						<div class="field-visibility">
							<?php 
								// $custTypeIndex = ($settings['customer_type']['position'] != "") ? $settings['customer_type']['position'] : "0";
								echo '<input value="customer_type" name="jp_customer_form_fields[field1][name]" type="hidden">';
								echo '<input value="Customer Type" name="jp_customer_form_fields[field1][title]" type="hidden">';
								echo '<input value="0" name="jp_customer_form_fields[field1][order]" class="field-position-input" type="hidden">';
								echo '<input value="0" name="jp_customer_form_fields[field1][isActive]" type="hidden">';
								echo '<div class="field-visiblity-checkbox"><input type="checkbox"  name="jp_customer_form_fields[field1][isActive]" value="1"' . checked( 1, $settings['isActive'], false ) . '/><span class="checkbox-style"></span></div>'; 
							?>
						</div>
					</div>
					<div class="ui-state-default sortable-field-item multi-field-wrap" field-index=1>
						<span class="drag-icon">
							<svg viewBox="0 0 32 32" role="presentation"><path fill-rule="evenodd" clip-rule="evenodd" d="M18 8a2 2 0 104 0 2 2 0 00-4 0zm2 10a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm-8 0a2 2 0 110-4 2 2 0 010 4zm-2-10a2 2 0 104 0 2 2 0 00-4 0zm2-6a2 2 0 110-4 2 2 0 010 4z" fill="currentColor"/></svg>
						</span>
						<div class="multi-field-inner">
							<span class="field-name">Customer Name</span>
							<!-- Residential Customer Type -->
							<div class="multi-field-items-wrap">
								<div class="multi-field-item">
									<div class="field-visibility">
										<?php 
											$custNameIndex = ($settings['customer_name']['position'] != "") ? $settings['customer_name']['position'] : "1";
											echo '<input value="'. $custNameIndex .'" name="jp_customer_form_fields[customer_name][position]" class="field-position-input" type="hidden">';
											echo '<input value="0" name="jp_customer_form_fields[customer_name][isActive]" type="hidden">';
											echo '<div class="field-visiblity-checkbox"><input type="checkbox" disabled name="jp_customer_form_fields[customer_name][isActive]" value="1"' . checked( 1, $settings['customer_name']['isActive'], false ) . '/><span class="checkbox-style"></span></div>'; 
										?>
									</div>
									<span class="field-name">Residential</span>
								</div>
								<!-- Commercial Customer Type -->
								<div class="multi-field-item">
									<div class="field-visibility">
										<?php 
											$custNameIndex = ($settings['customer_name']['position'] != "") ? $settings['customer_name']['position'] : "1";
											echo '<input value="'. $custNameIndex .'" name="jp_customer_form_fields[customer_name_commercial][position]" class="field-position-input" type="hidden">';
											echo '<input value="0" name="jp_customer_form_fields[customer_name_commercial][isActive]" type="hidden">';
											echo '<div class="field-visiblity-checkbox"><input type="checkbox" name="jp_customer_form_fields[customer_name_commercial][isActive]" value="1"' . checked( 1, $settings['customer_name_commercial']['isActive'], false ) . '/><span class="checkbox-style"></span></div>'; 
										?>
									</div>
									<span class="field-name">Commercial</span>
								</div>
							</div>
						</div>
					</div>
					<div class="ui-state-default sortable-field-item" field-index=0>
						<span class="drag-icon">
							<svg viewBox="0 0 32 32" role="presentation"><path fill-rule="evenodd" clip-rule="evenodd" d="M18 8a2 2 0 104 0 2 2 0 00-4 0zm2 10a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm-8 0a2 2 0 110-4 2 2 0 010 4zm-2-10a2 2 0 104 0 2 2 0 00-4 0zm2-6a2 2 0 110-4 2 2 0 010 4z" fill="currentColor"/></svg>
						</span>
						<span class="field-name">Customer Name</span>
						<div class="field-visibility">
							<?php 
								// $custTypeIndex = ($settings['customer_type']['position'] != "") ? $settings['customer_type']['position'] : "0";
								echo '<input value="customer_name" name="jp_customer_form_fields[field2][name]" type="hidden">';
								echo '<input value="Customer Name" name="jp_customer_form_fields[field2][title]" type="hidden">';
								echo '<input value="1" name="jp_customer_form_fields[field2][order]" class="field-position-input" type="hidden">';
								echo '<input value="0" name="jp_customer_form_fields[field2][isActive]" type="hidden">';
								echo '<div class="field-visiblity-checkbox"><input type="checkbox" disabled name="jp_customer_form_fields[field2][isActive]" value="1"' . checked( 1, $settings['isActive'], false ) . '/><span class="checkbox-style"></span></div>'; 
							?>
						</div>
					</div>
					<div class="ui-state-default sortable-field-item" field-index=0>
						<span class="drag-icon">
							<svg viewBox="0 0 32 32" role="presentation"><path fill-rule="evenodd" clip-rule="evenodd" d="M18 8a2 2 0 104 0 2 2 0 00-4 0zm2 10a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm-8 0a2 2 0 110-4 2 2 0 010 4zm-2-10a2 2 0 104 0 2 2 0 00-4 0zm2-6a2 2 0 110-4 2 2 0 010 4z" fill="currentColor"/></svg>
						</span>
						<span class="field-name">Company Name</span>
						<div class="field-visibility">
							<?php 
								// $custTypeIndex = ($settings['customer_type']['position'] != "") ? $settings['customer_type']['position'] : "0";
								echo '<input value="company_name" name="jp_customer_form_fields[field3][name]" type="hidden">';
								echo '<input value="Company Name" name="jp_customer_form_fields[field3][title]" type="hidden">';
								echo '<input value="2" name="jp_customer_form_fields[field3][order]" class="field-position-input" type="hidden">';
								echo '<input value="0" name="jp_customer_form_fields[field3][isActive]" type="hidden">';
								echo '<div class="field-visiblity-checkbox"><input type="checkbox" disabled name="jp_customer_form_fields[field3][isActive]" value="1"' . checked( 1, $settings['isActive'], false ) . '/><span class="checkbox-style"></span></div>'; 
							?>
						</div>
					</div>
				</div>
				<?php 
				submit_button();
			?>
		</div>
	</form>
</div>