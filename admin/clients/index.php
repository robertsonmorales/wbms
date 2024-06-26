<?php if ($_settings->chk_flashdata('success')) : ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>

<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">List of Clients</h3>
		<div class="card-tools">
			<button class="btn btn-light mr-1 bg-gradient-light border rounded-0" type="button" id="print"><i class="fa fa-print"></i> Print</button>
			<a href="./?page=clients/manage_client" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Create New</a>
		</div>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="25%">
					<col width="25%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Date Created</th>
						<th>Code</th>
						<th>Name</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$qry = $conn->query("SELECT *,concat(lastname, ', ', firstname, ' ', coalesce(middlename,'')) as `name` from `client_list` where delete_flag = 0 order by unix_timestamp(`date_created`) desc ");
					while ($row = $qry->fetch_assoc()) :
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>
							<td><?php echo $row['code'] ?></td>
							<td><?php echo $row['name'] ?></td>
							<td class="text-center">
								<?php
								switch ($row['status']) {
									case 1:
										echo '<span class="badge badge-primary bg-gradient-primary text-sm px-3 rounded-pill">Active</span>';
										break;
									case 2:
										echo '<span class="badge badge-danger bg-gradient-danger text-sm px-3 rounded-pill">Inactive</span>';
										break;
								}
								?>
							</td>
							<td align="center">
								<button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
									Action
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu" role="menu">
									<a class="dropdown-item view_data" href="./?page=clients/view_client&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item edit_data" href="./?page=clients/manage_client&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
								</div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php include('./inc/client.php') ?>
<noscript id="print-header">
	<div>
		<div class="d-flex w-100 align-items-center">
			<div class="col-2 text-center">
				<img src="<?= validate_image($_settings->info('logo')) ?>" alt="" class="img-thumbnail rounded-circle" style="width:5em;height:5em;object-fit:cover;object-position:center center;">
			</div>
			<div class="col-8">
				<div style="line-height:1em">
					<h4 class="text-center"><?= $_settings->info('name') ?></h4>
					<h3 class="text-center">List of Clients</h3>
				</div>
			</div>
		</div>
		<hr>
	</div>
</noscript>

<script>
	$(document).ready(function() {
		$('.delete_data').click(function() {
			_conf("Are you sure to delete this client permanently?", "delete_client", [$(this).attr('data-id')])
		})
		$('#list').dataTable({
			columnDefs: [{
				orderable: false,
				targets: [4]
			}],
			order: [0, 'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	});

	$('#print').click(function() {
		$('.print-client').parent().removeClass('d-none');
		var h = $('head').clone();
		// var p = $('#printout').clone();
		var p = $($('.print-client').html()).clone();
		var ph = $($('noscript#print-header').html()).clone();

		var nw = window.open('', '_blank', 'width=' + ($(window).width() * .80) + ',height=' + ($(window).height() * .90) + ',left=' + ($(window).width() * .1) + ',top=' + ($(window).height() * .05))
		nw.document.querySelector("head").innerHTML = h.html()
		nw.document.querySelector("body").innerHTML = ph[0].outerHTML + p[0].outerHTML
		nw.document.close()

		start_loader()
		setTimeout(() => {
			nw.print()
			setTimeout(() => {
				nw.close()
				end_loader()
			}, 300);
		}, 300);
	});

	function delete_client($id) {
		start_loader();
		$.ajax({
			url: _base_url_ + "classes/Master.php?f=delete_client",
			method: "POST",
			data: {
				id: $id
			},
			dataType: "json",
			error: err => {
				console.log(err)
				alert_toast("An error occured.", 'error');
				end_loader();
			},
			success: function(resp) {
				if (typeof resp == 'object' && resp.status == 'success') {
					location.reload();
				} else {
					alert_toast("An error occured.", 'error');
					end_loader();
				}
			}
		})
	}
</script>