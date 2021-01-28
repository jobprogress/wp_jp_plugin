<div class="wrap settings-form-screen">
	<h1>Form Settings</h1>
	<p class="settings-desc">Here you can arrange order of form fields and also hide/show fields for form.</p>
	<form method="post" action="options.php">
		<div class="form-settings-wrap" id="form-sortable">
			<div id="sortable_fields" class="sortable-fields-wrap">
				<?php
					$diabledFields = ['customer_type', 'customer_phone', 'trades', 'description'];
					settings_fields( 'jp_form_settings' ); 
					$count = 1;
					foreach($settings as $setting) {

						switch($setting['name']) {

							case 'customer_name':
							case 'company_name': 
								$disable_name = ($setting['name'] == 'customer_name') ? 'disabled' : '';
								$disable_company = ($setting['name'] == 'company_name') ? 'disabled' : '';
								?>
								<div class="ui-state-default sortable-field-item multi-field-wrap">
									<span class="drag-icon">
										<svg viewBox="0 0 32 32" role="presentation"><path fill-rule="evenodd" clip-rule="evenodd" d="M18 8a2 2 0 104 0 2 2 0 00-4 0zm2 10a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm-8 0a2 2 0 110-4 2 2 0 010 4zm-2-10a2 2 0 104 0 2 2 0 00-4 0zm2-6a2 2 0 110-4 2 2 0 010 4z" fill="currentColor"/></svg>
									</span>
									<div class="multi-field-inner">
										<span class="field-name"><?php echo $setting['title'] ?></span>
										<!-- Residential Type -->
										<div class="multi-field-items-wrap">
											<div class="multi-field-item">
												<div class="field-visibility">
													<input value="<?php echo $setting['name'] ?>" name="jp_customer_form_fields[field<?php echo $count ?>][name]" type="hidden">
													<input value="<?php echo $setting['title'] ?>" name="jp_customer_form_fields[field<?php echo $count ?>][title]" type="hidden">
													<input value="0" name="jp_customer_form_fields[field<?php echo $count ?>][isHide]" type="hidden">
													<div class="field-visiblity-checkbox"><input <?php echo $disable_name ?> type="checkbox" name="jp_customer_form_fields[field<?php echo $count ?>][isHide]" value="1"<?php echo checked( 1, $setting['isHide'], false ) ?> /><span class="checkbox-style"></span></div>
												</div>
												<span class="field-name">Residential</span>
											</div>
											<!-- Commercial Type -->
											<div class="multi-field-item">
												<div class="field-visibility">
													<input value="<?php echo $setting['isCommercial']['name'] ?>" name="jp_customer_form_fields[field<?php echo $count ?>][isCommercial][name]" type="hidden">
													<input value="<?php echo $setting['isCommercial']['title'] ?>" name="jp_customer_form_fields[field<?php echo $count ?>][isCommercial][title]" type="hidden">
													<input value="0" name="jp_customer_form_fields[field<?php echo $count ?>][isCommercial][isHide]" type="hidden">
													<div class="field-visiblity-checkbox"><input <?php echo $disable_company ?> type="checkbox"  name="jp_customer_form_fields[field<?php echo $count ?>][isCommercial][isHide]" value="1"<?php echo checked( 1, $setting['isCommercial']['isHide'], false ) ?> /><span class="checkbox-style"></span></div>
												</div>
												<span class="field-name">Commercial</span>
											</div>
										</div>

									</div>
								</div>
							<?php break;

							default: 
								$disable = in_array($setting['name'], $diabledFields) ? 'disabled' : '';
							?>
								<div class="ui-state-default sortable-field-item">
									<span class="drag-icon">
										<svg viewBox="0 0 32 32" role="presentation"><path fill-rule="evenodd" clip-rule="evenodd" d="M18 8a2 2 0 104 0 2 2 0 00-4 0zm2 10a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm-8 0a2 2 0 110-4 2 2 0 010 4zm-2-10a2 2 0 104 0 2 2 0 00-4 0zm2-6a2 2 0 110-4 2 2 0 010 4z" fill="currentColor"/></svg>
									</span>
									<span class="field-name"><?php echo $setting['title'] ?></span>
									<div class="field-visibility">
										<input value="<?php echo $setting['name'] ?>" name="jp_customer_form_fields[field<?php echo $count ?>][name]" type="hidden">
										<input value="<?php echo $setting['title'] ?>" name="jp_customer_form_fields[field<?php echo $count ?>][title]" type="hidden">
										<input value="0" name="jp_customer_form_fields[field<?php echo $count ?>][isHide]" type="hidden">
										<div class="field-visiblity-checkbox"><input <?php echo $disable ?> type="checkbox" name="jp_customer_form_fields[field<?php echo $count ?>][isHide]" value="1"<?php echo checked( 1, $setting['isHide'], false ) ?> /><span class="checkbox-style"></span></div>
									</div>
									
								</div>
						<?php } ?>
				<?php $count++; } ?>
			</div>
			<div class="form-settings-submit">
				<?php 
				submit_button();
				?>
				<span class="settings-loader">
					<img src="<?php echo plugin_dir_url( __FILE__ ); ?>/img/loader.svg">
				</span>
			</div>
		</div>
	</form>
</div>