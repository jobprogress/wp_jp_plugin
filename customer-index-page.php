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
					'base'               =>  add_query_arg( 'pagenum', '%#%' ),
					'format'             => '',
					'total'              => $num_of_pages,
					'current'            => $pagenum,
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

						<a href="<?php echo $_SERVER['PHP_SELF'] . "?order=$order&order_by=first_name&page=customers" ?>">
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

					<th class="manage-column column-address column-primary" id="address" scope="col">
						<a href="">
							<span>Address</span>
							<span class="sorting-indicator"></span>
						</a>
					</th>

					<th class="manage-column column-is-sync column-primary" id="is-sync" scope="col">
						<a href="">
							<span>Sync</span>
							<span class="sorting-indicator"></span>
						</a>
					</th>

					<th class="manage-column column-creation-date column-primary" id="creation-date" scope="col">
						<a href="<?php echo $_SERVER['PHP_SELF'] . "?order=$order&order_by=created_at&page=customers" ?>">
							<span>Creation Date</span>
							<span class="sorting-indicator"></span>
						</a>
					</th>
				</tr>
			</thead>

			<tbody id="the-list">
				<?php if(empty($entries)): ?>
				<tr>
					<td colspan="6"><center>No Customer Found.</center></td>
				</tr>
			<?php endif; ?>
			<?php foreach ($entries as $key => $customer) :?>
			<tr class="iedit author-self level-0 post-2 type-page status-publish hentry" id="post-2">
				<td data-colname="Title" class="title column-title has-row-actions column-primary page-title">
					<strong>
						<a class="row-title">
							<?php echo $customer->first_name . ' '. $customer->last_name; ?>
						</a>
					</strong>
				</td>
				<td data-colname="Email" class="email column-email">
					<a><?php echo $customer->email; ?></a>
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
						echo $state[0] .', ';
					}
					if(ine($addressArray, 'zip')) {
						echo $addressArray['zip'] .', ';
					}
					if(ine($addressArray, 'country_id')) {
						$country = explode('_', $addressArray['country_id']);
						echo $country[0] .', ';
					}
					?>
				</a>
			</td>
			<td data-colname="Date" class="date column-date">
				<a>
					<?php 
					if($customer->is_sync == 1) {
						echo 'Yes';
					} else {
						echo 'No';
					}
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

			<a href="<?php echo $_SERVER['PHP_SELF'] . "?order=$order&order_by=first_name&page=customers" ?>">
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

		<th class="manage-column column-address column-primary" id="address" scope="col">
			<a href="">
				<span>Address</span>
				<span class="sorting-indicator"></span>
			</a>
		</th>

		<th class="manage-column column-is-sync column-primary" id="is-sync" scope="col">
			<a href="">
				<span>Sync</span>
				<span class="sorting-indicator"></span>
			</a>
		</th>

		<th class="manage-column column-creation-date column-primary" id="creation-date" scope="col">
			<a href="<?php echo $_SERVER['PHP_SELF'] . "?order=$order&order_by=created_at&page=customers" ?>">
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