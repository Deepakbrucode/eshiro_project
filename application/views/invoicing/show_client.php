
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
                                <a href="#"><?php echo $title_txt; ?></a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>Show <?php echo $title_txt; ?></span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                  
                        <div class="col-md-12">
        
  <a href="<?php echo BASE_URL; ?>invoicing/<?php echo $add_url; ?>" class="btn btn-success pull-right" ><i class="fa fa-user-plus"></i> Add <?php echo $title_txt; ?></a>
  <div style="clear:both;"></div>
                    <?php echo $this->session->flashdata('invoicing'); ?>

                    <?php 
            if($usertype == '5') { ?>
            <div class="col-md-12">
                <div class="col-md-3" style="text-align: right;"><span>Client Name</span></div>
                <div class="col-md-4">
                <select name="client_id" class="form-control client_id">
                <?php if($ClientDetails){
                    foreach($ClientDetails as $ClientDetail) { 
                        $selected = ($final_client_id == $ClientDetail->id)?'selected':'';
                    echo "<option value='".$ClientDetail->id."' ".$selected.">".$ClientDetail->name."</option>";

                 } } else {echo "<option value=''>No clients Available</option>";} ?>
                </select>
                </div>
                <div class="col-md-3"><button type="button" class="btn btn-info btn_fcreport">Filter Users</button></div>
                </div>
            <?php } ?>



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

<th> Action </th>
</tr>
</thead>
<tbody>
<?php 

if($InvClientDetails) { 
$i=0;
setlocale(LC_MONETARY, 'en_IN');
foreach($InvClientDetails as $InvClientDetail) {
$i++;
$approve=$InvClientDetail->status;
$registered_date = $InvClientDetail->created_date;
$registered_date = date('d-M-Y',strtotime($registered_date));
?>
<tr>
<td><?php echo $i; ?>  </td>
<td><?php echo $InvClientDetail->name; ?>  </td>
<td><?php echo $InvClientDetail->phone; ?>  </td>
<td><?php echo $InvClientDetail->email; ?>  </td>
<td><?php echo $InvClientDetail->trading_name;?></td>
<td><?php echo $InvClientDetail->vat_no ;?></td>
<td><?php echo $registered_date; ?>  </td>
<td><?php if($approve == 0){ ?>UnApproved
<?php } else {?>
Approved
<?php }?>

</td>
<?php //echo $ClientDetail->approval; ?>   


<td>
<a class="edit btn btn-circle btn-icon-only btn-info" href="<?php echo BASE_URL; ?>invoicing/<?php echo $edit_url; ?>?id=<?php echo $InvClientDetail->id; ?>"> <i class="fa fa-edit"></i> </a> /
<a class="client_delete btn btn-circle btn-icon-only btn-danger" data-toggle="confirmation" data-title="<?php echo $title_txt; ?> details" data-singleton="true" data-popout="true" data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-trash" data-btn-ok-class="btn-sm btn-danger" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title="" aria-describedby="confirmation223268" href="<?php echo BASE_URL; ?>invoicing/delete_client?id=<?php echo $InvClientDetail->id; ?>&redirect_url=<?php echo $redirect_url; ?>"> <span class="color_orange"><i class="fa fa-trash"></i></span></a>

</td>

</tr>
<?php 
} 
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
	alert('approved successfully');
	
	ajax_approval(client_id);

    location.reload();
    
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



jQuery(document).on('click','.btn_fcreport',function(){
    var client_id = jQuery(".client_id").val();
    var redirect_url = "<?php echo $redirect_url; ?>";
    location.href = "<?php echo BASE_URL; ?>invoicing/"+redirect_url+"/?client_id="+client_id;
})
            </script>
