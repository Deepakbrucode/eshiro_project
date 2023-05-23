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
                                <a href="#">Receipt</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>Show Receipts</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                    <a href="<?php echo BASE_URL; ?>/receipts/deposit?txn_type=deposit" class="btn btn-primary">Add Deposit</a>
                    <?php echo $this->session->flashdata('receipts'); ?>
                        <div class="col-md-12">
                            <table class="table table-striped table-hover table-bordered1 stl_table" id="show_paymenttb" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th> S.No </th>
                                                <th> Date </th>
                                                <!-- <th> Client </th> -->
                                                <th> File Name </th>
                                                <th> File </th>
                                                <th> Details </th>
                                                <th> Amount </th>
                                                <!-- <th> Bank </th> -->
                                                <th> Transaction Type </th>
                                                <!-- <th> Status </th> -->
                                                <th> Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                         $i=0;
                                         
                                        if($OpanBalDetails){
                                            foreach ($OpanBalDetails as $OpanBalDetail) {
                                              $i++;
                                              $openbal_date = $OpanBalDetail->openbal_date;
                                                $client_name = $OpanBalDetail->firm_name;
                                                $openbal_date = date('d-M-Y', strtotime($openbal_date));
                                                //$openbal_date = date('m/d/Y', strtotime($openbal_date));
                                                $tran_txt = 'Opening Balance';
                                                /*if($transaction_type == 'deposit'){$tran_txt = 'Deposit';}
                                                else if($transaction_type == 'rtd'){$tran_txt = 'RTD'; }
                                                else {$tran_txt='Credit Interest';}*/
                                                $amount =$OpanBalDetail->amount;
                                                setlocale(LC_MONETARY, 'en_IN');
                                                if($amount !='')
                                                {
                                                //$OpanBalDetail_amount = "R".money_format('%!i', $amount) ;
                                                $OpanBalDetail_amount = "R".number_format((float)$amount, 2);
                                            }
                                            else
                                                $OpanBalDetail_amount = 0;
                                                //$OpanBalDetail_amount = "R".number_format($amount,2);
                                              ?>
                                              <tr>
                                                <td><?php echo $i; ?>  </td>
                                                <td><?php echo $openbal_date; ?>  </td>
                                                <!-- <td><?php echo $client_name; ?>  </td> -->
                                                <td><?php echo $OpanBalDetail->file_name; ?>  </td>
                                                <td><?php echo $OpanBalDetail->file_number; ?>  </td>
                                                <td> </td>
                                                <td><?php echo $OpanBalDetail_amount; ?>  </td>
                                               <!--  <td><?php echo $OpanBalDetail->bank; ?>  </td> -->
                                                <td><?php echo $tran_txt; ?>  </td>
                                                <!-- <td><?php echo ($OpanBalDetail->status=='1')?'Active':'In-Active'; ?>  </td> -->
                                                <td>
                                                    <a class="edit" href="<?php echo BASE_URL; ?>receipts/opening_balance/?openbal_id=<?php echo $OpanBalDetail->id; ?>"> Edit </a> 
                                                  
                                                </td>

                                            </tr>
                                            <?php

                                            }
                                        }
                                        if($ReceiptDetails) { 
                                           
                                            foreach($ReceiptDetails as $receiptDetail) {
                                                $i++;
                                                $receipt_date = $receiptDetail->receipt_date;
                                                $client_name = $receiptDetail->firm_name;
                                                $receipt_datenew = date('d-M-Y', strtotime($receipt_date));
                                                //$receipt_datenew = date('d/m/Y', strtotime($receipt_date));
                                                $transaction_type = $receiptDetail->transaction_type;
                                                if($transaction_type == 'deposit'){$tran_txt = 'Deposit';}
                                                else if($transaction_type == 'rtd'){$tran_txt = 'RTD'; }
                                                else {$tran_txt='Credit Interest';}
                                                $amount =$receiptDetail->amount;
                                                setlocale(LC_MONETARY, 'en_IN');
                                                if($amount !='')
                                                {
                                                //$receiptDetail_amount = "R".money_format('%!i', $amount) ;
                                                $receiptDetail_amount = "R".number_format((float)$amount, 2);
                                            }
                                            else
                                                $receiptDetail_amount = 0;
                                                //$receiptDetail_amount = "R".number_format($amount,2);
                                                ?>
                                            <tr>
                                                <td><?php echo $i; ?>  </td>
                                                <td><?php echo $receipt_datenew; ?>  </td>
                                                <!-- <td><?php echo $client_name; ?>  </td> -->
                                                <td><?php echo $receiptDetail->file_name; ?>  </td>
                                                <td><?php echo $receiptDetail->file_number; ?>  </td>
                                                <td><?php echo $receiptDetail->details; ?>  </td>
                                                <td><?php echo $receiptDetail_amount; ?>  </td>
                                               <!--  <td><?php echo $receiptDetail->bank; ?>  </td> -->
                                                <td><?php echo $tran_txt; ?>  </td>
                                                <!-- <td><?php echo ($receiptDetail->status=='1')?'Active':'In-Active'; ?>  </td> -->
                                                <td>
                                                    <a class="edit" href="<?php echo BASE_URL; ?>receipts/edit?txn_type=<?php echo $receiptDetail->transaction_type; ?>&receipt_id=<?php echo $receiptDetail->receipt_id; ?>"> Edit </a>  /
                                                     <a class="client_delete" data-toggle="confirmation" data-title="Receipt" data-singleton="true" data-popout="true" data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-trash" data-btn-ok-class="btn-sm btn-danger" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title="" aria-describedby="confirmation223268" href="<?php echo BASE_URL  ."OpeningBalance/delete_receipt/" . $receiptDetail->receipt_id.'/'.$receipt_date; ?>"><span class="color_orange">Delete</span></a>
                                                  
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
             <!--  / <a class="receipts_delete" data-toggle="confirmation" data-title="Receipts Details" data-singleton="true" data-popout="true" data-btn-ok-label="In-Active" data-btn-ok-icon="fa fa-trash" data-btn-ok-class="btn-sm btn-danger" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title="" href="<?php echo BASE_URL . "receipts/delete_receipt/" . $receiptDetail->receipt_id; ?>"><span class="color_orange">In-Active</span>
                                                    </a> -->

            <script type="text/javascript">
jQuery(document).ready(function() {

    $('[data-toggle=confirmation]').confirmation({
  rootSelector: '[data-toggle=confirmation]',
  // other options
});

            var table = $('#show_paymenttb');

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
                { extend: 'print', className: 'btn dark btn-outline',exportOptions: {columns: [ 0, 1, 2, 3, 4, 5,6] } },
                { extend: 'pdf', className: 'btn green btn-outline',exportOptions: {columns: [ 0, 1, 2, 3, 4, 5,6] } },
                { extend: 'csv', className: 'btn purple btn-outline ',exportOptions: {columns: [ 0, 1, 2, 3, 4, 5,6] } },
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



});
            </script>



            
    