
          <style>

            .btn-group{
                width: 140px;
                position: relative;
                display: inline-flex;
            }
            .popover.confirmation.fade.top.in{margin-left: -5%;}

             </style>
        
          <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-users"></i>
                                <a href="#">Client</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>Show Clients</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                   <a href="<?php echo BASE_URL; ?>client/add_client" class="btn btn-primary">Add Client</a>
                    <?php echo $this->session->flashdata('showclients'); ?>
                        <div class="col-md-12">
        
 

<table class="table table-striped table-hover table-bordered1 stl_table" id="show_clienttb" style="width:100%">
<thead>
<tr>
<th> S.No </th>
<th> Name </th>
<th> MobileNo </th>
<th> EmailId </th>
<th> Tracking Name </th> 
<th> VAT No </th>
<th> Date of Registration </th>
<th> Approval </th>
<th> Status </th>
<th> Action </th>
</tr>
</thead>
<tbody>
<?php 

if($ClientDetails) { 
$i=0;
setlocale(LC_MONETARY, 'en_IN');
foreach($ClientDetails as $ClientDetail) {
$i++;
$approve=$ClientDetail->status;
$registered_date = $ClientDetail->created_date;
$registered_date = date('d-M-Y',strtotime($registered_date));
?>
<tr>
<td><?php echo $i; ?>  </td>
<td><?php echo $ClientDetail->name; ?>  </td>
<td><?php echo $ClientDetail->phone; ?>  </td>
<td><?php echo $ClientDetail->email; ?>  </td>
<td><?php echo $ClientDetail->trading_name;?></td>
<td><?php echo $ClientDetail->vat_no ;?></td>
<td><?php echo $registered_date; ?>  </td>
<td><?php if($approve == 0){ ?>UnApproved
<?php } else {?>
Approved
<?php }?>

</td>
<?php //echo $ClientDetail->approval; ?>   

<td><?php if($approve == 0){ ?>
<button type="button" class="btn btn-primary btn_approval" client-id="<?php 
echo $ClientDetail->id; ?>">Approve</button> 
<?php } else {?>
	<button type="button" class="btn btn-primary btn_approval" style="display:none" client-id="<?php 
echo $ClientDetail->id; ?>">Approve</button> 
<?php } ?>
</td>
<td>
<a class="edit" href="<?php echo BASE_URL; ?>client/edit?id=<?php echo $ClientDetail->id; ?>"> Edit </a> /<a class="client_delete" data-toggle="confirmation" data-title="client details" data-singleton="true" data-popout="true" data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-trash" data-btn-ok-class="btn-sm btn-danger" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title="" aria-describedby="confirmation223268" href="<?php echo BASE_URL; ?>client/delete_client?id=<?php echo $ClientDetail->id; ?>"> <span class="color_orange">Delete</span></a>

</td>

</tr>
<?php 
} 
}
else {
echo "<tr><td colspan='9'>No records found </td></tr>";
} 
?>                                           
</tbody>
</table>
   </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
            <!--  / <a class="client_delete" data-toggle="confirmation" data-title="client details" data-singleton="true" data-popout="true" data-btn-ok-label="In-Active" data-btn-ok-icon="fa fa-trash" data-btn-ok-class="btn-sm btn-danger" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title="" aria-describedby="confirmation223268" href="<?php echo BASE_URL . "client/delete_client/" . $ClientDetail->client_id; ?>"><span class="color_orange">In-Active</span> 
                                                    </a>-->

<script type="text/javascript">
	
	$(document).on('click','.btn_approval',function(){
	var client_id = $(this).attr('client-id');
	
	
	ajax_approval(client_id);

    // location.reload();
    
	});

function ajax_approval(client_id)
{
	src = '<?php echo BASE_URL; ?>'+'client/updateapprove_submit';
	$.ajax({
	url: src,
	type:'POST',
	dataType: "json",
	data: {'client_id':client_id},
	success: function(data) {
        alert('approved successfully');
        location.reload();
	}
	});
}
	$(document).ready(function() {
        $('[data-toggle=confirmation]').confirmation({
  rootSelector: '[data-toggle=confirmation]',
  // other options
});
            var table = $('#show_clienttb');

        var oTable = table.dataTable({
            // Internationalisation. For more info refer to http://datatables.net/manual/i18n
            "language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "lengthMenu": "_MENU_ entries",
                "search": "Search:",
                "zeroRecords": "No matching records found"
            },
            "scrollX": '100%',
            // Or you can use remote translation file
            //"language": {
            //   url: '//cdn.datatables.net/plug-ins/3cfcc339e89/i18n/Portuguese.json'
            //},

            // setup buttons extentension: http://datatables.net/extensions/buttons/
            buttons: [
                //~ { extend: 'print', className: 'btn dark btn-outline',exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8] } },
                //~ { extend: 'pdf', className: 'btn green btn-outline',exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8] } },
                //~ { extend: 'csv', className: 'btn purple btn-outline ',exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8] } },
                //~ { extend: 'colvis', className: 'btn yellow btn-outline ' },
                
            ],

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: {
                details: {
                   
                }
            },

            "order": [
                [0, 'asc']
            ],
            
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "All"] // change per page values here
            ],
            // set the initial value
            "pageLength": 10,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", 
            // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });



});
            </script>
