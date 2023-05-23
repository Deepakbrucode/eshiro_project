    <style type="text/css">
          .client_ledger_list{display: none;}

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
                                <a href="#">Report</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>Client Ledger</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="row" >

                    <div class="" style="float: right;">

                         <button type="button" class="buttons-print btn dark btn-outline1" onclick="PrintDiv();"><i class="fa fa-print"></i> Print</button>&nbsp;&nbsp;
                        <a href="<?php echo BASE_URL; ?>uploads/clientledger_list.pdf" class="btn blue-hoki btn-outline1 cledger_pdfdownload" download ><i class="fa fa-file-pdf-o"></i> PDF</a>&nbsp;&nbsp;
                      <!--   <a href="<?php echo BASE_URL; ?>uploads/clientledger_list.csv" class="btn green-haze btn-outline1 cledger_csvdownload" download ><i class="fa fa-file-excel-o"></i> CSV</a>&nbsp;&nbsp; -->
                        <a href="<?php echo BASE_URL; ?>uploads/clientledger_list.xls" class="btn purple-sharp  btn-outline1 cledger_xlsdownload" download ><i class="fa fa-file-excel-o"></i> EXCEL</a>&nbsp;&nbsp;&nbsp;&nbsp;
                          
                        </div>
                    

                    <?php echo $this->session->flashdata('client_ledger'); ?>
                    
                    <?php if($FileOpenDetails) { 
						
					//	echo "<pre>";print_r($FileOpenDetails);echo "</pre>"; ?>
					<form action="<?php echo BASE_URL ?>reports/clientledger_list" method="get">
						<div class="form-group">
                                                            <label class="col-md-5 control-label" style="text-align:right">Financial Year:</label>
                                                            <div class="col-md-2">
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
                                                               <!--  <span class="help-block"> A block of help text. </span> -->
                                                            </div>
                                                                                                                    <div class="col-md-2">
															<button type="submit" class="btn btn-info btn_ledgerfilter">Filter</button>
                                                        </div>
                                                        
                                                        </div>
                                                        
                                                        </form>

                                                        <?php
		
					} ?>
					
					
                        <div class="col-md-12" id="div_print">
                            <table style="width: 100%;border:0px;" class="table_top">
                                <thead>
                                    <tr>
                                        <td style="border:0px;"><?php echo $client_ledger_list_header; ?></td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border:0px;"><?php echo $client_ledger_list; ?></td>
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

 

                 function PrintDiv() {
                        var contents = document.getElementById("div_print").innerHTML;
                        var frame1 = document.createElement('iframe');

                    var htmlToPrint = '' +
                        '<style type="text/css">' +
                        '@page{margin:0px 20px;}'+
                        'h1{padding-top:20px;}'+
                        'table th, table td {' +
                        'border:1px solid #ccc;' + 
                        'padding:0.4em;' +
                        'margin-bottom:10px;'+
                        '}' + 
                        'table, td, th{' +
                        ' border-collapse: collapse;'+
                        'width:100%;'+
                        '}' +
                        '</style>';
                        contents += htmlToPrint;
                        
                        frame1.name = "frame1";
                        frame1.style.position = "absolute";
                        frame1.style.top = "-1000000px";
                        document.body.appendChild(frame1);
                        var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
                        frameDoc.document.open();
                        frameDoc.document.write('<html><head><title>' + 'Client Ledger' + '</title>');
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
          
