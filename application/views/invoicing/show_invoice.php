
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
                    <a href="#">Invoicing</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span><?php echo $invoice_txt; ?></span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12" style="text-align:right;"> <a href="<?php echo BASE_URL; ?>invoicing/<?php echo $add_url; ?>" class="btn btn-primary">Add <?php echo $invoice_txt; ?></a></div><br><br>
            <?php echo $this->session->flashdata('invoicing'); ?>
            <?php 
           // if($usertype == '5') { ?>
            <div class="col-md-12">
                <div class="col-md-3" style="text-align: right;"><span><?php echo $inv_usertype_txt; ?> Name</span></div>
                <div class="col-md-4">
                <select name="client_id" class="form-control client_id">
                    <option value="">Select <?php echo $inv_usertype_txt; ?> name</option>
                <?php if($InvClientDetails){
                    foreach($InvClientDetails as $InvClientDetail) { 
                        $selected = ($final_clientid == $InvClientDetail->id)?'selected':'';
                    echo "<option value='".$InvClientDetail->id."' ".$selected.">".$InvClientDetail->name."</option>";

                 } } else {echo "<option value=''>No clients Available</option>";} ?>
                </select>
                </div>
                <div class="col-md-3"><button type="button" class="btn btn-info btn_fcreport">Filter Data</button></div>
                </div>
            <?php //} ?>
            <div class="col-md-12">
                <div class="pdfdiv_div"></div>
                <table class="table table-striped table-hover table-bordered1 stl_table" id="show_reporttb" style="width:100%">
                    <thead>
                        <tr>
                            <th> S.No </th>
                            <th> Invoice Date </th>
                            <th> Due Date </th>
                            <th> Inv No </th>
                            <th> Ref No </th>
                            <th> Amount </th>
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
                        $due_date   =$ReportDetail->due_date    ;
                        $due_date = date('d-m-Y',strtotime($due_date));
                        $inv_no = $ReportDetail->inv_no;
                        $ref_no = $ReportDetail->ref_no;
                        // $description = $ReportDetail->description;
                        // $amount_type = $ReportDetail->amount_type;
                        // $tax_type = $ReportDetail->tax_type;
                        $amount = $ReportDetail->amount;
                        $report_type = $ReportDetail->report_type;

                        $amount = (float)$amount;
                        $amount =  number_format($amount,2);

                        ?>
                        <tr>
                            <td><?php echo $i; ?>  </td>
                            <td><?php echo $report_date	; ?>  </td>
                            <td><?php echo $due_date; ?> </td>
                            <td><?php echo $inv_no; ?>  </td>
                            <td><?php echo $ref_no; ?></td>
                            <td>R <?php echo $amount; ?></td>
                            <td>
                                

                                 <?php if($report_type == '6'){ ?>
                                    <!-- <a class="btn_cquote_ajax" href="javascript:void(0);"  data-invid="<?php echo $ReportDetail->report_id; ?>"> Convert to invoice </a> / -->

                                    <a class="report_delete btn purple" data-toggle="confirmation" data-title="Invoicing details" data-singleton="true" data-popout="true" data-btn-ok-label="Convert" data-btn-ok-icon="fa fa-check-square-o" data-btn-ok-class="btn-sm btn-success" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title=""  href="<?php echo BASE_URL; ?>invoicing/convert_quote_ajax/?report_id=<?php echo $ReportDetail->report_id; ?>&redirect_url=<?php echo $current_menu; ?>"> <span class="color_orange"><i class="fa fa-file-pdf-o"></i> Convert to invoice</span></a> /


                                <?php } ?>

                                <!-- <a class="btn_pdf_ajax" href="javascript:void(0);" data-invid="<?php echo $ReportDetail->report_id; ?>"> View <?php echo $invbtn_txt; ?> </a> / -->

                                <a class="btn_pdf_ajax btn btn-circle btn-icon-only btn-success" href="javascript:void(0);" data-invid="<?php echo $ReportDetail->report_id; ?>"> <i class="fa fa-eye"></i> </a> /

                               
                                <a class="edit btn btn-circle btn-icon-only btn-info" href="<?php echo BASE_URL; ?>invoicing/<?php echo $edit_url; ?>/?id=<?php echo $ReportDetail->report_id; ?>"> <i class="fa fa-edit"></i> </a> /

                                <a class="report_delete btn btn-circle btn-icon-only btn-danger" data-toggle="confirmation" data-title="Invoicing details" data-singleton="true" data-popout="true" data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-trash" data-btn-ok-class="btn-sm btn-danger" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title="" aria-describedby="confirmation223268" href="<?php echo BASE_URL; ?>invoicing/delete_invoice/?report_id=<?php echo $ReportDetail->report_id; ?>&redirect_url=<?php echo $current_menu; ?>"> <span class="color_orange"><i class="fa fa-trash"></i></span></a>


                               



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
    var invoice_menu = "<?php echo $current_menu; ?>";
    location.href = "<?php echo BASE_URL; ?>invoicing/"+invoice_menu+"/?client_id="+client_id;
})


});
   


jQuery(document).on('click','.btn_pdf_ajax',function(){
    var report_id = jQuery(this).attr('data-invid');

              //  var filtered_client_name = "<?php //echo $_SESSION['filtered_client_name']; ?>";
                // jQuery(".modal_month").val(month);
                // jQuery(".modal_month_name").val(month_name);
              //  jQuery(".modal_year").val(year);

                //jQuery(".modal_month").html("As At "+month_name+", "+year);
              //var option_html = '';
              var src = '<?php echo BASE_URL; ?>'+'invoicing/invoice_pdf_ajax';
                 $.ajax({
                    url: src,
                    type:'GET',
                    dataType: "json",
                    // dataType: "html",
                    data: {'report_id':report_id},
                    success: function(data) {
// console.log(data);
// console.log(data.table_content);
$(".pdfdiv_div").html(data.table_content);
$('.invoice_pdfdownload')[0].click();


}
});
          });


jQuery(document).on('click','.btn_cquote_ajax',function(){
    var report_id = jQuery(this).attr('data-invid');

              var src = '<?php echo BASE_URL; ?>'+'invoicing/convert_quote_ajax';
                 $.ajax({
                    url: src,
                    type:'GET',
                    dataType: "json",
                    // dataType: "html",
                    data: {'report_id':report_id},
                    success: function(data) {
        location.reload();


}
});
          });




          </script>
