<form class="jp-btn-connect" method="post" action="<?php echo esc_url( $_SERVER['REQUEST_URI'] ) ?>">
<input type="hidden" name="disconnect" value = "1"/>
<input class="btn btn-red" type="submit" value="Disconnect">
</form>

<div class="subsDetail-container">
	<div class="profile-header">
		<div class="address-container">
			<div class="pull-right address-container-profile-pic">
				<div class="company-image-viewer profile-pic" image-url="https://staging.jobprogress.com/api/public/uploads/company/users/2_1450702741.jpg"><img class="img-thumbnail" alt="Logo" src="https://staging.jobprogress.com/api/public/uploads/company/users/2_1450702741.jpg?file=1464068664563"></div>
			</div>
			<div class="address-bar address-bar-section-first">
				<div class="subscriber-info">
					<h3>SUBSCRIBER DETAILS</h3>
					<div class="info-label">
						<label>Address: </label>
						<span>
							<span class="">173 Route 46, Mine Hill Township, New Jersey, <br>07803, United States</span>
						</span>
					</div>
					<div class="info-label " style="">
						<label>Address 2: </label>
						<span class="">Dummy</span>
					</div>
					<div class="info-label ">
						<label class="">Phone: </label>
						<span class="">
							(121) 222-3232 - Office
							<span ng-if="phone.extension" class="userData-extension  ">Extension: 121</span>
						</span>
					</div>
					<div class="info-label">
						<label>Email: </label>
						<span><a href="javascript:void(0)" class="">rajan.kumar@logicielsolutions.co.in</a></span>
					</div>
				</div>
			</div>

			<div class="address-bar address-bar-section-second">
				<div class="subscriber-info">
					<h3>COMPANY DETAILS</h3>
					<div class="info-label " style="">
						<label>Address: </label>
						<span>
							<span class="">173 Route 46, Mine Hill Township, New Jersey, <br>07803, United States</span>
						</span>
					</div>
					<div class="info-label ">
						<label>Address 2: </label>
						<span class="">dummy</span>
					</div>
					<div class="info-label">
						<label>Phone: </label>
						<span class="">(111) 222-3333</span>
					</div>
					<div class="info-label">
						<label>Email: </label>
						<span><a href="javascript:void(0)" class="">rajan.kumar@logicielsolutions.co.in</a></span>
					</div>
					<div class="info-label ">
						<label>Fax: </label>
						<span class="">(111) 222-3334</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>