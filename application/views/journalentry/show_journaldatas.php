
<style>
    .btn-group{
        /*width: 140px;*/
        width: auto;
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
                    <a href="#">Journal entries</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Journal Datas</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12" style="text-align:right;"> <a href="<?php echo BASE_URL; ?>journalentry/bulk_insert" class="btn btn-primary">Add a Journal</a></div><br><br>
            <?php echo $this->session->flashdata('report'); ?>
            <?php 
            if($usertype == '5') { ?>
            <div class="col-md-12">
                <div class="col-md-3" style="text-align: right;"><span>Client Name</span></div>
                <div class="col-md-4">
                <select name="client_id" class="form-control client_id">
                <?php if($ClientDetails){
                    foreach($ClientDetails as $ClientDetail) { 
                        $selected = ($fclient_id == $ClientDetail->id)?'selected':'';
                    echo "<option value='".$ClientDetail->id."' ".$selected.">".$ClientDetail->name."</option>";

                 } } else {echo "<option value=''>No clients Available</option>";} ?>
                </select>
                </div>
                <div class="col-md-3"><button type="button" class="btn btn-info btn_fcreport">Filter Report</button></div>
                </div>
            <?php } ?>
            <div class="col-md-12">
                <table class="table table-striped table-hover table-bordered1 stl_table" id="show_reporttb" style="width:100%">
                    <thead>
                        <tr>
                            <th> S.No </th>
                            <th> Date </th>
                            <!-- <th> Inv No </th> -->
                            <!-- <th> Ref No </th> -->
                            <th> Description </th>
                            <th> DR </th>
                            <th> CR </th>
                            <th> LEDGER </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                        if($ReportDetails) { 
                        $i=0;
                        setlocale(LC_MONETARY, 'en_IN');
                        foreach($ReportDetails as $ReportDetail) {
                        $i++;
                        $report_date	=$ReportDetail->report_date	;
                        $report_date = date('d-m-Y',strtotime($report_date));
                        $inv_no = $ReportDetail->inv_no;
                        // $ref_no = $ReportDetail->ref_no;
                        $description = $ReportDetail->description;
                        $amount_type = $ReportDetail->amount_type;
                        $tax_type = $ReportDetail->tax_type;
                        $amount = $ReportDetail->amount;
                        $ledger_type = $ReportDetail->ledger_type;
                        $ledger_typedis ='';
                        if($ledger_type!='' || $ledger_type!=' '):
                            if($ledger_type == 1) $ledger_typedis='Invoice';elseif($ledger_type == 2) $ledger_typedis='Bank';  
                        endif;
                         
                        ?>
                        <tr>
                            <td><?php echo $i; ?>  </td>
                            <td><?php echo $report_date	; ?>  </td>
                            <!-- <td><?php echo $inv_no; ?>  </td> -->
                            <!-- <td><?php echo $ref_no; ?></td> -->
                            <td><?php echo $description; ?></td>
                            <?php
                            if($amount_type == 'sales') {
                            	echo "<td>$amount</td><td></td>";
                            }
                            else
                            {
                            	echo "<td></td><td>$amount</td>";
                            	}?>
                                <td>  <?php echo $ledger_typedis;?>
                                </td>
                            <td>
                               

                                <a class="edit" href="<?php echo BASE_URL; ?>journalentry/edit_journaldatas/<?php echo $ReportDetail->report_id; ?>"> Edit </a> /

                                <a class="report_delete" data-toggle="confirmation" data-title="report details" data-singleton="true" data-popout="true" data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-trash" data-btn-ok-class="btn-sm btn-danger" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title="" aria-describedby="confirmation223268" href="<?php echo BASE_URL; ?>journalentry/delete_report/<?php echo $ReportDetail->report_id; ?>"> <span class="color_orange">Delete</span></a>

                            </td>

                        </tr>
                        <?php 
                        } 
                        }
                        else {
                       // echo "<tr><td colspan='7'>No records found </td></tr>";
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


<script type="text/javascript">
	
$(document).ready(function() {
    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
        // other options
    });

    var table = $('#show_reporttb');

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
                 { extend: 'print', className: 'btn dark btn-outline' },
                 { extend: 'pdf', className: 'btn green btn-outline'},
                { extend: 'csv', className: 'btn purple btn-outline ' },
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


jQuery(document).on('click','.btn_fcreport',function(){
    var client_id = jQuery(".client_id").val();
    location.href = "<?php echo BASE_URL; ?>banktransactions/?client_id="+client_id;
})


});
            </script>
