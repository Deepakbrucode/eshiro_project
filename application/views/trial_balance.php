        <style type="text/css">.trial_pdf{display:none; }</style>        

           
            <!-- BEGIN CONTENT -->
            <div class="page-content-wrapper">
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEADER-->
                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <i class="fa fa-users"></i>
                                <a href="#">Report</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>Trial Balance</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row">
                    <?php echo $this->session->flashdata('trial_balance'); ?>
                        <form action="<?php echo BASE_URL ?>reports/trial_balance" method="get">
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group col-md-12">
                                    <label class="col-md-2 control-label">Date</label>
                                    <div class="col-md-10">
                                        <div class="input-group input-large date-picker input-daterange"  >
                                            <input type="text" name="opening_bal_from" class="form-control">
                                            <span class="input-group-addon"> to </span>
                                            <input type="text" name="opening_bal_to" class="form-control"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary" >Select</button>
                            </div>
                            </div>
                            </form>
                            
                            <form action="<?php echo BASE_URL ?>reports/trial_balance" method="get">
                        <div class="col-md-12">
                            <div class="col-md-5">
                                <div class="form-group col-md-12">
                                    <label class="col-md-2 control-label">Financial Year:</label>
                                    <div class="col-md-10">
                                        <select class="form-control financial_year" name="financial_year">
<!--
																	<option value=''>Financial year</option>
-->
																	<?php foreach($FileOpenDetails as $FileOpenDetail) { 
																		$financial_start = $FileOpenDetail->financial_start;
							$financial_end = $FileOpenDetail->financial_end;
							$final_value = $financial_start.",".$financial_end;
							if($financial_start !='' && $financial_end !='') {
							?>
																	<option value="<?php echo $final_value; ?>"><?php echo $financial_start." - ".$financial_end; ?></option>
																	<?php } } ?>
                                                                </select>
                                                                
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary" >Filter</button>
                            </div>
                            </div>
                            </form>
                            
                            <div class="">
                            
                      


                             <div class="" style="float: right;">
                                <button type="button" class="buttons-print btn dark btn-outline1" onclick="Print();"><i class="fa fa-print"></i> Print</button>&nbsp;&nbsp;
                                <a href="<?php echo BASE_URL; ?>uploads/trialbal.pdf" class="btn blue-hoki btn-outline1 cledger_pdfdownload" download ><i class="fa fa-file-pdf-o"></i> PDF</a>&nbsp;&nbsp;
                                 <a href="<?php echo BASE_URL;?>uploads/trialbal.csv" class="btn green-haze btn-outline1 cledger_csvdownload" download ><i class="fa fa-file-excel-o"></i> CSV</a>&nbsp;&nbsp;
                                <a href="<?php echo BASE_URL; ?>uploads/trialbal.xls" class="btn purple-sharp  btn-outline1 cledger_xlsdownload" download ><i class="fa fa-file-excel-o"></i> EXCEL</a>&nbsp;&nbsp;&nbsp;&nbsp;
 
                            </div>
                        </div>
                        <div style="clear:both;margin:10px;"></div>
                        <div class="col-md-12 print_cdiv" id="print_div">
                        <table style="width: 100%;" class="table_top">
                                <thead>
                                     <tr id="header1">
                                        <td style="border:0px;">

                                            <center><p style="margin:5px 0px;"><span style="font-weight: bold;text-align: center;font-size:19px;"><?php   echo $client_name; ?></span></p></center>
                                             <center><p style="margin:5px 0px;"><span style="font-weight: bold;text-align: center;font-size:13px;">Trial Balance</span></p></center>
                                             <center><p style="margin:10px 0px;"><span style="text-align: center;font-size:12px;"><?php  echo $date; ?></span></p></center> 
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border:0px;">
                                            <div id="print_content">
                                                <table class="table table-striped table-hover table-bordered trial_table" id="trial_balance" style="width:100%">

                                                    <thead>
                                                        <tr>
                                                            <th> S.No </th>
                                                            <th> Name </th>
                                                            <th> File No </th>
                                                            <th class="align_right"> Dr</th>
                                                            <th class="align_right"> Cr </th>
                                                            <!-- <th class="align_right"> Balance </th> -->
                                                        </tr>
                                                    </thead>
                                                    <?php 
                                                    setlocale(LC_MONETARY, 'en_IN');
                                                        $i=0;
                                                        $total_balance = 0;
                                                        $open_bal_amt = 'R 0.00';
                                                        ?>
                                                    <tbody>
                                                        <?php 
                                                        //echo "<pre>";print_r($trial_balance);echo "</pre>";
                                                        if($trial_balance) {
                                                            foreach ($trial_balance as $key => $value) {
                                                                $i++;
                                                                $file_id = $value['file_id'];
                                                                $ledger_openbalss = (float)$value['ledger_openbalss'];
                                                                $file_name = $value['file_name'];
                                                                $file_number = $value['file_number'];
                                                                $payment_total = (float) $value['payment_total'];
                                                                $receipt_total = (float)$value['receipt_total'];
                                                                //$payment_total_amt = "R".money_format('%!i', $payment_total);
                                                                //$receipt_total_amt = "R".money_format('%!i', $receipt_total);
                                                                $payment_total_amt = "R".number_format($payment_total,2);
                                                                $receipt_total_amt = "R".number_format($receipt_total,2);
                                                                $balancess =  $receipt_total - $payment_total;
                                                               // $balancess =  $payment_total - $receipt_total;
                                                               $balancess =  $balancess + $ledger_openbalss;
                                                               // echo "<br>";
                                                                $total_balance += $balancess;
                                                                //$balance_amt = "R".money_format('%!i', $balance);
                                                                $balance_amt = "R".number_format($balancess,2);
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $i; ?></td>
                                                                    <td><?php echo $file_name; ?></td>
                                                                    <td><?php echo $file_number; ?></td>
                                                                    <td></td>
                                                                    <!-- <td class="align_right"><?php echo $payment_total_amt; ?></td>
                                                                    <td class="align_right"><?php echo $receipt_total_amt; ?></td> -->
                                                                    <td class="align_right"><?php echo $balance_amt; ?></td>
                                                                </tr>
                                                                <?php
                                                            }

                                                        }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>

                                                        <tr>
                                                            <?php
                                                            $open_bal = 0;
                                                            //$total_balance_amt = "R".money_format('%!i', $total_balance);
                                                            $total_balance_amt = "R".number_format($total_balance,2);

                                                            $total_balance = $total_balance;
                                                            //$open_bal_amt = "R".money_format('%!i', $Open_total);
                                                            $open_bal_amt = "R".number_format($Open_total,2);
                                                            $Open_total =  $Open_total;
                                                            $remaining= $total_balance - $Open_total;
                                                            
                                                            //$remaining_amt = "R".money_format('%!i', $remaining);
                                                            //$remaining = 10;
                                                            $remaining_amt = "R".number_format($remaining,2);
                                                            if($remaining_amt == 'R-0.00'){$remaining_amt = 'R0.00';}
                                                            ?>
                                                            <th></th>
                                                            <th>BALANCE PER BANK STATEMENT</th>
                                                            <th></th>
                                                            <th class="align_right"><?php echo $open_bal_amt; ?></th>
                                                            <!-- <th></th> -->
                                                            <th class="align_right"><?php echo $total_balance_amt; ?></th>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3"></td>
                                                            <td colspan="2" class="align_right" style="border-top:1px solid #000;border-bottom:1px solid #000;"><?php echo $remaining_amt; ?></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                                    

                        </div>
                    </div>
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
             <!--  / <a class="payments_delete" data-toggle="confirmation" data-title="payments details" data-singleton="true" data-popout="true" data-btn-ok-label="In-Active" data-btn-ok-icon="fa fa-trash" data-btn-ok-class="btn-sm btn-danger" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title="" href="<?php echo BASE_URL . "payments/delete_payment/" . $paymentDetail->payment_id; ?>"><span class="color_orange">In-Active</span>
                                                    </a> -->


            
<script type="text/javascript">
jQuery(document).ready(function() {

       $('.date-picker').datepicker({
                autoclose: true,
                 /* format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months",*/
                orientation: "bottom"
            });

 
});

       
                
        function Print() {
                        var contents = document.getElementById("print_div").innerHTML;
                        var frame1 = document.createElement('iframe');

                    var htmlToPrint = '' +
                        '<style type="text/css">' +
                        '@page{margin:0px 20px;}'+
                        'h1{padding-top:20px;}'+
                        'table th, table td {' +
                        'border:1px solid #ccc;' + 
                        'padding:0.5em;' +
                        '}' + 
                        'table, td, th{' +
                        ' border-collapse: collapse;'+
                        '}' +
                        '  th{' +
                        ' font-weight:bold;'+
                        '}' +
                        '</style>';
                        contents += htmlToPrint;
                        
                        frame1.name = "frame1";
                        frame1.style.position = "absolute";
                        frame1.style.top = "-1000000px";
                        document.body.appendChild(frame1);
                        var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
                        frameDoc.document.open();
                        frameDoc.document.write('<html><head><title>' + 'Trial Balance' + '</title>');
                        frameDoc.document.write('</head><body>');
                        frameDoc.document.write("<center><h1></h1></center>"+contents);
                        frameDoc.document.write('</body></html>');
                        frameDoc.document.close();
                        setTimeout(function () {
                            window.frames["frame1"].focus();
                            window.frames["frame1"].print();
                            document.body.removeChild(frame1);
                        }, 500);
                        return false;
                 }

            </script>
