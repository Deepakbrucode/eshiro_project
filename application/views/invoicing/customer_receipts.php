
<style>
    .btn-group{
        /*width: 140px;*/
        width: auto;
        position: relative;
        display: inline-flex;
    }
    .popover.confirmation.fade.top.in{margin-left: -5%;}
    .form-control.tform{display: inline-block;    width: 150px;}
    .receipt_error{display: none;    margin: 0px;
    color: red;}

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
                    <span>Customers Receipts</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">
            
            <?php echo $this->session->flashdata('invoicing'); ?>
            <?php 
           // if($usertype == '5') { ?>
            <div class="col-md-12">
                <div class="col-md-3" style="text-align: right;"><span>Customer Name</span></div>
                <div class="col-md-4">
                <select name="client_id" class="form-control client_id">
                    <option value="">Select Customer name</option>
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
                <form method="post" id="saveform">
                    <?php //echo "<pre>";print_r($ReportDetails);echo "</pre>"; ?>
                    <button type="submit" name="btn_receipt" class="btn btn-lg btn-success" style="float: right;">Save Receipt</button>
                <table class="table table-striped table-hover table-bordered1 stl_table" id="show_reporttb" style="width:100%">
                    <thead>
                        <tr>
                            <th> S.No </th>
                            <th> Invoice Date </th>
                            <th> Due Date </th>
                            <th> Inv No </th>
                            <th> Ref No </th>
                            <th> Inv.Amount </th>
                            <th> Balance Amount </th>
                            <th> Receipt </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 

                        if($ReportDetails) { 
                        $i=0;
                        setlocale(LC_MONETARY, 'en_IN');
                        foreach($ReportDetails as $ReportDetail) {
                       
                        $report_date    =$ReportDetail->report_date ;
                        $report_date = date('d-m-Y',strtotime($report_date));
                        $due_date   =$ReportDetail->due_date    ;
                        $due_date = date('d-m-Y',strtotime($due_date));
                        $inv_no = $ReportDetail->inv_no;
                        $ref_no = $ReportDetail->ref_no;
                        $credit = $ReportDetail->credit;
                        $debit = $ReportDetail->debit;

                        $credit = (float)$credit;
                        $balance = $credit - (float)$debit;

                        // $amount =  number_format($credit,2);

                        // $balance =  number_format($balance,2);

                        if($balance<=0)
                            continue;
                         $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?>  </td>
                            <td><?php echo $report_date	; ?>  </td>
                            <td><?php echo $due_date; ?> </td>
                            <td><?php echo $inv_no; ?>  </td>
                            <td><?php echo $ref_no; ?></td>
                            <td>R <?php echo number_format($credit,2); ?></td>
                            <td>R <?php echo number_format($balance,2); ?></td>
                            <td>
                                <input type="hidden" name="receipt_data[<?= $i; ?>][balance]" class="balance_amt" value="<?= $balance; ?>">
                                <input type="hidden" name="receipt_data[<?= $i; ?>][report_id]" value="<?= $ReportDetail->report_id; ?>">
                                <input type="hidden" name="receipt_data[<?= $i; ?>][user_id]" value="<?= $ReportDetail->user_id; ?>">
                                <input type="hidden" name="receipt_data[<?= $i; ?>][inv_user_id]" value="<?= $ReportDetail->inv_user_id; ?>">
                                <input type="hidden" name="receipt_data[<?= $i; ?>][inv_no]" value="<?= $inv_no; ?>">
                                <input type="hidden" name="receipt_data[<?= $i; ?>][ref_no]" value="<?= $ref_no; ?>">
                                <input type="hidden" name="receipt_data[<?= $i; ?>][cost_id]" value="<?= $ReportDetail->cost_id; ?>">
                                <input type="hidden" name="receipt_data[<?= $i; ?>][amount_type]" value="<?= $ReportDetail->amount_type; ?>">
                                <input type="hidden" name="receipt_data[<?= $i; ?>][category_id]" value="<?= $ReportDetail->category_id; ?>">
                                <input type="hidden" name="receipt_data[<?= $i; ?>][subcategory_id]" value="<?= $ReportDetail->subcategory_id; ?>">


                                <input type="text" name="receipt_data[<?= $i; ?>][rdata]" class="form-control tform rdata" placeholder="Receipt Date">
                                <input type="number" name="receipt_data[<?= $i; ?>][amount]" class="form-control tform recpt_amt" min="0" max="<?= $balance; ?>" placeholder="Receipt Amount">
                                <p class="receipt_error">Receipt amount should be less than or equal to balance amount</p>
                            </td>

                        </tr>
                        <?php 
                        } 
                        }
                        
                        ?>                                           
                    </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->


<script type="text/javascript">

$(document).on('change','.recpt_amt',function(){
    $('.receipt_error').hide();
    var this_val = $(this);
    this_val.closest('tr').find('.receipt_error').hide();
    var recpt_amt = $(this).val() || 0;
    var balance_amt = $(this).closest('tr').find('.balance_amt').val() || 0;
    if(parseFloat(recpt_amt) > parseFloat(balance_amt))
    {
        this_val.closest('tr').find('.receipt_error').show();
        this_val.val(balance_amt);
    }
        
})

	
$(document).ready(function() {

    jQuery(".rdata").datepicker({ format: 'dd-mm-yyyy'});

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
                 // { extend: 'print', className: 'btn dark btn-outline' },
                 // { extend: 'pdf', className: 'btn green btn-outline'},
                // { extend: 'csv', className: 'btn purple btn-outline ' },
                // { extend: 'colvis', className: 'btn yellow btn-outline ' },
                
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
            "pageLength": 5,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", 
            // horizobtal scrollable datatable

        });




jQuery(document).on('click','.btn_fcreport',function(){
    var client_id = jQuery(".client_id").val();
    var invoice_menu = "<?php echo $current_menu; ?>";
    location.href = "<?php echo BASE_URL; ?>invoicing/"+invoice_menu+"/?client_id="+client_id;
})

   






   jQuery('#saveform').on('submit', function(e){
      var form = this;

      // Encode a set of form elements from all pages as an array of names and values
      var params = table.$('input,select,textarea').serializeArray();

      // Iterate over all form elements
      $.each(params, function(){
         // If element doesn't exist in DOM
         if(!$.contains(document, form[this.name])){
            // Create a hidden element
            jQuery(form).append(
               jQuery('<input>')
                  .attr('type', 'hidden')
                  .attr('name', this.name)
                  .val(this.value)
            );
         }
      });

      var src = '<?php echo BASE_URL; ?>'+'invoicing/savereceipt';

      $.ajax({
        url: src,
        type:'POST',
        dataType: "html",
        data: $('#saveform').serialize(),
        success: function(data) {
            location.reload();
        },
        error: function(){
            alert("Something went wrong. Please try again later");
            location.reload();
        }
    });


//e.preventDefault();
return false;
      
   });

});

          </script>
