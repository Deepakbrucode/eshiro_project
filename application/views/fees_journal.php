<style type="text/css">.fees_pdf{display:none; }</style>        
           
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
                                <span>Fees Journal</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->

                    <div class="row">
                    <?php echo $this->session->flashdata('fees_journal'); ?>
                        <form action="<?php echo BASE_URL ?>reports/fees_journal" method="get">
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
                        <div class="" style="float: right;">
                            <button type="button" class="buttons-print btn dark btn-outline1" onclick="PrintDiv();"><i class="fa fa-print"></i> Print</button>&nbsp;&nbsp;
                            <a href="<?php echo BASE_URL; ?>uploads/feesjournal.pdf" class="btn blue-hoki btn-outline1 cledger_pdfdownload" download ><i class="fa fa-file-pdf-o"></i> PDF</a>&nbsp;&nbsp;
                            <a href="<?php echo BASE_URL; ?>uploads/feesjournal.csv" class="btn green-haze btn-outline1 cledger_csvdownload" download ><i class="fa fa-file-excel-o"></i> CSV</a>&nbsp;&nbsp;
                            <a href="<?php echo BASE_URL; ?>uploads/feesjournal.xls" class="btn purple-sharp  btn-outline1 cledger_xlsdownload" download ><i class="fa fa-file-excel-o"></i> EXCEL</a>&nbsp;&nbsp;&nbsp;&nbsp;

                        </div>
                        <div style="clear:both;margin:10px;"></div>
                        <div class="col-md-12 print_cdiv" id="print_cdiv">
                            <table style="width: 100%;" >
                                <thead>

                                    <tr id="header1">
                                        <td style="border:0px;">
                                            <center><p style="margin:5px 0px;"><span style="font-weight: bold;text-align: center;font-size:19px;"><?php echo $client_name; ?></span></p></center>
                                            <center><p style="margin:5px 0px;"><span style="font-weight: bold;text-align: center;font-size:13px;">Fees Journals</span></p></center>
                                            <center><p style="margin:10px 0px;"><span style="text-align: center;font-size:12px;"><?php echo $date_txt; ?></span></p></center>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                    <td style="border:0px;">
                                        <div id="print_content">
                                            <?php
                                                setlocale(LC_MONETARY, 'en_IN');
                                                if($fees_journals) {
                                                foreach ($fees_journals as $key => $value) {
                                                    $payment_date = $value->payment_date;
                                                    $payment_date = date('d-M-Y', strtotime($payment_date));
                                                    $file_number = $value->file_number;
                                                    $amount = $value->amount;
                                                   // $format_amount = "R".money_format('%!i', $amount);
                                                    $format_amount = "R".number_format((float)$amount, 2);
                                                    //table-striped table-hover table-bordered
                                            ?>
                                            <table class="table stl_table table-hover" style="width:100%;margin-bottom:25px;">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Description</th>
                                                        <th>Dr</th>
                                                        <th>Cr</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $payment_date; ?></td>
                                                        <td>TRF TO BUSINESS</td>
                                                        <td><?php echo $format_amount; ?></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $payment_date; ?></td>
                                                        <td>BANK</td>
                                                        <td></td>
                                                        <td><?php echo $format_amount; ?></td>
                                                        
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="2"></td>
                                                        <th><?php echo $format_amount; ?></th>
                                                        <th><?php echo $format_amount; ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <?php
                                                }
                                            }
                                            else
                                            {
                                                echo "No Records Found";
                                            }
                                            ?>

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

function PrintDiv() {
                        var contents = document.getElementById("print_cdiv").innerHTML;
                        var frame1 = document.createElement('iframe');

                    var htmlToPrint = '' +
                        '<style type="text/css">' +
                        '@page{padding: 120px 20px 0px;min-height:200px;}'+
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
                        frameDoc.document.write('<html><head><title>' + 'Fees Journal' + '<br>sfsdfsfsfsdfsdfds</title>');
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