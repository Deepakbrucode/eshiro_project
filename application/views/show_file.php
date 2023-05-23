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
                                <a href="#">File</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>Show File</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                    <a href="<?php echo BASE_URL.$page_url; ?>/add_file" class="btn btn-primary">Add File</a>
                    <?php echo $this->session->flashdata('File'); ?>
                        <div class="col-md-12">
                        <?php //echo "<pre>";print_r($ClientDetails);echo "</pre>"; ?>
                            <table class="table table-striped table-hover table-bordered1 stl_table" id="show_filetb" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th> S.No </th>
                                                <!-- <th>Client </th> -->
                                                <!-- <th> File Type </th> -->
                                                <th> File Name </th>
                                                <th> File Number </th>
                                                <th> Case Type </th>
<!--
                                                <th> Opening Balance </th>
-->
                                                <!-- <th> Physical Address </th> -->
                                                <!-- <th> Postal Address </th>
                                                <th> Telephone No </th> -->
                                                <!-- <th> Cell No </th> -->
                                                <th> Email </th>                                                 
                                               <!--  <th> Status </th> -->
                                                <th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        if($FileDetails) { 
                                            $i=0;
                                            setlocale(LC_MONETARY, 'en_IN');
                                            foreach($FileDetails as $FileDetail) {
                                                $i++;
                                               $ledger_openbal = (Int)$FileDetail->ledger_openbal;
                                                //$format_ledger_openbal = "R".money_format('%!i', $ledger_openbal) ;
                                                $format_ledger_openbal = "R".number_format($ledger_openbal, 2);
                                                ?>
                                            <tr>
                                                <td><?php echo $i; ?>  </td>
                                                <!-- <td><?php echo $FileDetail->firm_name; ?></td> -->
                                               <!--  <td><?php echo $FileDetail->file_type; ?></td> -->
                                                <td><?php echo $FileDetail->file_name; ?></td>
                                                <td><?php echo $FileDetail->file_number; ?></td>
                                                <td><?php echo $FileDetail->case_type; ?></td>
<!--
                                                <td><?php echo $format_ledger_openbal; ?></td>
-->
                                                <!-- <td><?php echo $FileDetail->physical_address; ?></td> -->
                                                <!-- <td><?php echo $FileDetail->postal_address; ?></td>
                                                <td><?php echo $FileDetail->telephone_no; ?></td> -->
                                                <!-- <td><?php echo $FileDetail->cell_no; ?></td> -->
                                                <td><?php echo $FileDetail->email; ?></td>
                                                
                                                <!-- <td><?php echo ($FileDetail->status=='1')?'Active':'In-Active'; ?>  </td> -->
                                                <td >
                                                    <a class="edit" href="<?php echo BASE_URL.$page_url; ?>/add_file?file_id=<?php echo $FileDetail->file_id; ?>"> Edit </a> /
                                                     <a class="client_delete" data-toggle="confirmation" data-title="File" data-singleton="true" data-popout="true" data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-trash" data-btn-ok-class="btn-sm btn-danger" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title="" aria-describedby="confirmation223268" href="<?php echo BASE_URL  ."OpeningBalance/delete_file/" . $FileDetail->file_id; ?>"><span class="color_orange">Delete</span></a> / 
                                                     <a data-id="<?php echo $FileDetail->file_id; ?>" class="accordion-toggle collapsed btn_fileopen" data-toggle="modal" data-target="#modal_fileopen" href="#collapseOne_<?php echo $i; ?>">view Balance</a>
                                                   
                                                </td>

                                            </tr>
                                        <?php 
                                        } 
                                        }
                                        else {
                                            echo "<tr><td colspan='12'>No records found </td></tr>";
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
            <!--  / <a class="client_delete" data-toggle="confirmation" data-title="client details" data-singleton="true" data-popout="true" data-btn-ok-label="In-Active" data-btn-ok-icon="fa fa-trash" data-btn-ok-class="btn-sm btn-danger" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title="" aria-describedby="confirmation223268" href="<?php echo BASE_URL  ."file/delete_file/" . $FileDetail->file_id . '/'.$page_url; ?>"><span class="color_orange">In-Active</span></a> -->



<div class="modal fade" id="modal_fileopen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
<!--
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

   </div>
-->
      <div class="modal-body">
            
                <center><h3>Add File Opening Balance</h3></center>
                <form class="form-horizontal add_fileopen">
					<input type="hidden" class="fileopenid" name="fileopenid" value="">
					<input type="hidden" class="fileid" name="fileid" value="">
					 <div class="form-group">
                           <label class="col-md-3 control-label">Financial Year</label>
                                <div class="col-md-4">
                                       <div class="input-group input-large date-picker input-daterange"  >
											<input type="text" name="opening_bal_from" class="form-control opening_bal_from" value="" required>
											<span class="input-group-addon"> to </span>
											<input type="text" name="opening_bal_to" class="form-control opening_bal_to" value="" required> 
										</div>
                                   </div>
                        </div>
                        <div class="form-group">
                               <label class="col-md-3 control-label">Opening Balance</label>
                               <div class="col-md-4">
                                  <input type="text" name="ledger_openbal" class="form-control ledger_openbal" placeholder="Opening Balance" value="" required>
                                </div>
                         </div> 
                                                        
                    <center><button type="button" class="btn btn-primary btn_savefileopen">Save</button> <button type="button" class="btn btn-default btn_clearopen">Clear</button></center>
                </form>
                <table class="table table-striped table-hover table-bordered table_fileopen">
					<thead>
						<tr>
							<td>S.no</td>
							<td>Financial Year</td>
							<td>Opening Balance</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
					</tbody>
                </table>
      </div>
      <div class="modal-footer">
		  
		  <button type="button" class="btn btn-default modal_fileopenclose"  data-dismiss="modal">Close</button>
<!--
        <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
        <button type="button" class="btn dark" onclick="PrintDiv();" ><i class="fa fa-print"></i> Print</button>
         <button type="button"  class="btn blue-hoki btn_ledgerpdf"><i class="fa fa-file-pdf-o"></i> PDF</button>
         <button type="button"  class="btn green-haze btn_ledgercsv"><i class="fa fa-file-excel-o"></i> CSV</button>
         <button type="button"  class="btn purple-sharp btn_ledgerxls"><i class="fa fa-file-excel-o"></i> EXCEL</button>
         
-->
      </div>
    </div>
  </div>
</div>


            <script type="text/javascript">
jQuery(document).ready(function() {
$('.date-picker').datepicker({
                autoclose: true,
                  format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months",
                orientation: "bottom"
            });

        $('[data-toggle=confirmation]').confirmation({
  rootSelector: '[data-toggle=confirmation]',
  // other options
});
            var table = $('#show_filetb');

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
                { extend: 'print', className: 'btn dark btn-outline',exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8] } },
                { extend: 'pdf', className: 'btn green btn-outline',exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8] } },
                { extend: 'csv', className: 'btn purple btn-outline ',exportOptions: {columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8] } },
                { extend: 'colvis', className: 'btn yellow btn-outline ' },
                
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



jQuery(document).on('click','.btn_fileopen',function(){
	
	var src = '<?php echo BASE_URL; ?>'+'file/show_fileopen';
	var file_id=jQuery(this).attr('data-id');
	//alert(file_id);
	$('.add_fileopen')[0].reset();
	jQuery(".fileopenid").val('');
	jQuery(".fileid").val('');
	jQuery.ajax({
		url: src,
                    type:'POST',
                    dataType: "json",
                    data: {file_id:file_id},
                    success: function(data) {
						console.log(data);
						var tbody = '';
						var kk=0;
						if(data)
						{
							jQuery.each(data,function(key,value){
								kk++;
								var financial_start = value['financial_start'];
								var financial_end = value['financial_end'];
								var file_openid = value['file_openid'];
								var opening_balance = value['opening_balance'];
								var file_id = value['file_id'];
								
								tbody +='<tr><td>'+kk+'</td><td>'+financial_start+' - '+financial_end+'</td><td>'+opening_balance+'</td><td dataid="'+file_openid+'" datastart="'+financial_start+'" dataend="'+financial_end+'" dataopen="'+opening_balance+'" fileid="'+file_id+'"><button type="button" class="btn btn-info btn_openedit">Edit</button><button class="btn btn-danger btn_openclear">Clear Balance</button></td></tr>';
							});
						}
						else
						{
							tbody = "<tr><td colspan='5'>No Records Found</td></tr>";
						}
						jQuery(".fileid").val(file_id);
						jQuery(".table_fileopen tbody").html(tbody);
					}
		
	});
	
});

jQuery(document).on('click','.btn_openedit',function(){
	var dataid = jQuery(this).parent('td').attr('dataid');
	var datastart = jQuery(this).parent('td').attr('datastart');
	var dataend = jQuery(this).parent('td').attr('dataend');
	var dataopen = jQuery(this).parent('td').attr('dataopen');
	var fileid = jQuery(this).parent('td').attr('fileid');
	
	jQuery(".opening_bal_from").val(datastart);
	jQuery(".opening_bal_to").val(dataend);
	jQuery(".ledger_openbal").val(dataopen);
	jQuery(".fileopenid").val(dataid);
	jQuery(".fileid").val(fileid);
	
});

jQuery(document).on('click','.btn_clearopen',function(){
	$('.add_fileopen')[0].reset();
	jQuery(".fileopenid").val('');
	//jQuery(".fileid").val('');
});

jQuery(document).on('click','.btn_openclear',function(){
	var dataid = jQuery(this).parent('td').attr('dataid');
	var datastart = jQuery(this).parent('td').attr('datastart');
	var dataend = jQuery(this).parent('td').attr('dataend');
	var dataopen = jQuery(this).parent('td').attr('dataopen');
	var fileid = jQuery(this).parent('td').attr('fileid');
	
	
	var src = '<?php echo BASE_URL; ?>'+'file/clear_fileopen';

	jQuery.ajax({
		url: src,
                    type:'POST',
                    dataType: "html",
                    data: {fileid:fileid,fileopenid:dataid},
                    success: function(data) {

						alert("Cleared Opening Balance");
						jQuery(".modal_fileopenclose").trigger('click');
					}
		
	});

	
});



jQuery(document).on('click','.btn_savefileopen',function(){
	var fileopenid = jQuery(".fileopenid").val();
	var opening_bal_from = jQuery(".opening_bal_from").val();
	var opening_bal_to = jQuery(".opening_bal_to").val();
	var ledger_openbal = jQuery(".ledger_openbal").val();
	var fileid = jQuery(".fileid").val();
	var src = '<?php echo BASE_URL; ?>'+'file/add_fileopen';
	if(opening_bal_from =='' || opening_bal_to =='')
	{
		alert("Please enter the financial date")
	}
	else if(ledger_openbal == '')
	{
		alert("Please enter the opening balance");
	}
	else
	{
	jQuery.ajax({
		url: src,
                    type:'POST',
                    dataType: "html",
                    data: {fileid:fileid,fileopenid:fileopenid,opening_bal_from:opening_bal_from,opening_bal_to:opening_bal_to,ledger_openbal:ledger_openbal},
                    success: function(data) {
						alert(data);
						jQuery(".modal_fileopenclose").trigger('click');
					}
		
	});
}
	
});



});
            </script>



            
    
