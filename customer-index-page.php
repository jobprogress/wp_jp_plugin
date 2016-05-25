<?php 
// $this->get_customers();
if($order == 'asc') {
	$order = 'desc';
} else {
	$order ='asc';
}
?>
<div class="wrap">
	<h1>Customers
		<!-- <a class="page-title-action" href="http://localhost/jobprogress/wordpress/2016/04/27/hello-world/">
			Add New
		</a> -->
	</h1>

	<h2 class="screen-reader-text">Filter pages list</h2>
	<ul class="subsubsub">
		<li class="all">
			<a class="current" href="edit.php?post_type=page">All 
				<span class="count">(<?php echo $total ?>)</span>
			</a>
		</li>
	</ul>
	<form method="get" id="posts-filter" action="<?php echo $_SERVER['PHP_SELF'] . "?page=customers" ?>">
		<input type="hidden" value="customers" name="page">
		

		
		<div class="tablenav top">

			<div class="alignleft actions">
				<label class="screen-reader-text" for="filter-by-date">Filter by date</label>
				<select id="filter-by-date" name="date">
					<option value="0" selected="selected">All dates</option>
					<?php $datetime = new DateTime() ?>
					<option value="<?php echo $datetime->format('Y\-m\-d'); ?>"><?php echo $datetime->format('F Y'); ?></option>
				</select>
				<input type="submit" value="Filter" class="button" id="post-query-submit" name="filter_action">
				<?php $args = array(
					'base'               =>  add_query_arg( 'page_num', '%#%' ),
					'format'             => '',
					'total'              => $num_of_pages,
					'current'            => $page_num,
					'show_all'           => false,
					'end_size'           => 2,
					'mid_size'           => 2,
					'prev_next'          => true,
					'prev_text'          => __('« Previous'),
					'next_text'          => __('Next »'),
					'type'               => 'plain',
					'add_args'           => false,
					'add_fragment'       => '',
					'before_page_number' => '',
					'after_page_number'  => ''
					); ?>
				<?php $page_links = paginate_links( $args ); 
				if ( $page_links ) {
					echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
				}
				?>

			</div>

			<br class="clear">
		</div>
		<h2 class="screen-reader-text">Pages list</h2>
		<table class="wp-list-table widefat fixed striped pages">
			<thead>
				<tr>
					
					
					<th class="manage-column column-title column-primary sortable desc" id="title" scope="col">

						<a href="<?php echo $_SERVER['PHP_SELF'] . "?order=$order&order_by=first_name&page=jp_customer-page" ?>">
							<span>Full Name</span>
							<span class="sorting-indicator"></span>
						</a>
					</th>

					<th class="manage-column column-email column-primary" id="email" scope="col">
						<a href="">
							<span>Email</span>
							<span class="sorting-indicator"></span>
						</a>
					</th>

					<th class="manage-column column-company-name column-primary" id="company-name" scope="col">
						<a href="">
							<span>Comany Name</span>
							<span class="sorting-indicator"></span>
						</a>
					</th>

					<th class="manage-column column-address column-primary" id="address" scope="col">
						<a href="">
							<span>Address</span>
							<span class="sorting-indicator"></span>
						</a>
					</th>

					<th class="manage-column column-is-commercial column-primary" id="is-commercial" scope="col">
						<a href="">
							<span>Commercial</span>
							<span class="sorting-indicator"></span>
						</a>
					</th>

					<th class="manage-column column-creation-date column-primary" id="creation-date" scope="col">
						<a href="<?php echo $_SERVER['PHP_SELF'] . "?order=$order&order_by=created_at&page=jp_customer-page" ?>">
							<span>Creation Date</span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
				</tr>
			</thead>

			<tbody id="the-list">
				<?php if(empty($customers)): ?>
				<tr>
					<td colspan="5"><center><b>No Customer Found.</b></center></td>
				</tr>
			<?php endif; ?>
			<?php foreach ($customers as $key => $customer) :?>
			<tr class="iedit author-self level-0 post-2 type-page status-publish hentry" id="post-2">
				<td data-colname="Title" class="title column-title has-row-actions column-primary page-title">
					<strong>
						<a class="row-title">

							<?php if(! $customer->is_commercial) {
								echo $customer->first_name . ' '. $customer->last_name; 
							}
							?>
						</a>
					</strong>
				</td>
				<td data-colname="Email" class="email column-email">
					<a><?php echo $customer->email; ?></a>
				</td>
				<td data-colname="company-name" class="company-name column-company-name has-row-actions column-primary">
					<strong>
						<a class="row-title">
							<?php
							if(! $customer->is_commercial) {
								echo $customer->company_name; 
							} else{
								echo $customer->first_name; 
							}
							?>
						</a>
					</strong>
				</td>
				<td data-colname="Address" class="address column-address">

					<a>	<?php  

					$address = json_decode($customer->address, true);
					$addressArray = $address['address'];
					if(ine($addressArray, 'address')) {
						echo $addressArray['address'] . ', ';
					}
					if(ine($addressArray, 'city')) {
						echo $addressArray['city'].', ';
					}
					if(ine($addressArray, 'state_id')) {
						$state = explode('_', $addressArray['state_id']);
						echo $state[1] .', ';
					}
					if(ine($addressArray, 'zip')) {
						echo $addressArray['zip'] .', ';
					}
					if(ine($addressArray, 'country_id')) {
						$country = explode('_', $addressArray['country_id']);
						echo $country[1] .', ';
					}
					?>
				</a>
			</td>
			<td class="date column-is-commercial">
				<a>
					<?php 
					echo $customer->is_commercial;
					?>
				</a>
			</td>
			<td data-colname="Creation Time" class="date column-created-at">
				<abbr><?php echo $customer->created_at; ?></abbr>
			</td>	
		</tr>
	<?php endforeach; ?>

</tbody>

<tfoot>
	<tr>
		<th class="manage-column column-title column-primary sortable desc" id="title" scope="col">

			<a href="<?php echo $_SERVER['PHP_SELF'] . "?order=$order&order_by=first_name&page=jp_customer-page" ?>">
				<span>Full Name</span>
				<span class="sorting-indicator"></span>
			</a>
		</th>

		<th class="manage-column column-email column-primary" id="email" scope="col">
			<a href="">
				<span>Email</span>
				<span class="sorting-indicator"></span>
			</a>
		</th>

		<th class="manage-column column-company-name column-primary" id="company-name" scope="col">
			<a href="">
				<span>Comany Name</span>
				<span class="sorting-indicator"></span>
			</a>
		</th>

		<th class="manage-column column-address column-primary" id="address" scope="col">
			<a href="">
				<span>Address</span>
				<span class="sorting-indicator"></span>
			</a>
		</th>

		<th class="manage-column column-is-commercial column-primary" id="is-commercial" scope="col">
						<a href="">
							<span>Commercial</span>
							<span class="sorting-indicator"></span>
						</a>
					</th>

		<th class="manage-column column-creation-date column-primary" id="creation-date" scope="col">
			<a href="<?php echo $_SERVER['PHP_SELF'] . "?order=$order&order_by=created_at&page=jp_customer-page" ?>">
				<span>Creation Date</span>
				<span class="sorting-indicator"></span>
			</a>
		</th>
	</tr>
</tfoot>

</table>


</form>



<div id="ajax-response"></div>
<br class="clear">
</div>