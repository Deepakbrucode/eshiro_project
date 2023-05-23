<style type="text/css">
   /* table, td, th {
         border: 1px solid #ccc;
         padding: 10px;
    }*/
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
                    <div class="row">
                    <a href="<?php echo BASE_URL; ?>uploads/clientledger.pdf" class="cledger_pdfdownload" download style="display: none;">Download</a>
                    <a href="<?php echo BASE_URL; ?>uploads/clientledger.csv" class="cledger_csvdownload" download style="display: none;">Download</a>
                    <a href="<?php echo BASE_URL; ?>uploads/clientledger.xls" class="cledger_xlsdownload" download style="display: none;">Download</a>
                    

                    

                    <?php echo $this->session->flashdata('client_ledger'); ?>
                    <?php if($FileOpenDetails) { 
					//	echo "<pre>";print_r($FileOpenDetails);echo "</pre>"; ?>
						<div class="form-group">
                                                            <label class="col-md-5 control-label" style="text-align:right">Financial Year:</label>
                                                            <div class="col-md-2">
                                                                <select class="form-control financial_year">
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
															<button type="button" class="btn btn-info btn_ledgerfilter">Filter</button>
                                                        </div>
                                                        </div>

                                                        <?php
		
					} ?>
                        <div class="col-md-12">
                            <table class="table table-striped table-hover table-bordered1 clientl_table" id="client_ledger" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th> S.No </th>
                                                <th> Client Name </th>
                                                <th> File Name </th>
                                                <th> File.No </th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php 
                                        if($ClientlDetails){
                                            $k=0;
                                            foreach ($ClientlDetails as $value) {
                                                $k++;
                                               //$client_name = $value->firm_name;
                                               $client_name= $this->session->filtered_client_name;
                                               $client_id = $value->client_id;
                                               $file_number = $value->file_number;
                                               $file_name = $value->file_name;
                                               $file_id = $value->file_id;
                                        ?>
                                            <tr data-finalyear="" data-id="<?php echo $client_id; ?>" data-cname="<?php echo $client_name; ?>" data-fname="<?php echo $file_number; ?>" data-fid="<?php echo $file_id; ?>" data-filename="<?php echo $file_name; ?>">
                                                <td><?php echo $k; ?></td>
                                               <td><?php echo $client_name; ?></td>
                                                <td><?php echo $file_name; ?></td>
                                                <td><?php echo $file_number; ?></td>
                                                <td><a class="accordion-toggle collapsed" data-toggle="collapse" href="#collapseOne_<?php echo $k; ?>"><button type="button" class="btn purple-sharp btn_clientmodal" data-toggle="modal" data-target="#modal_client">view</button></a></td>
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



<div class="modal fade" id="modal_client" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <!-- <h4 class="title" style="text-align:center;">Ledger Details</h4> -->
   </div>
      <div class="modal-body">
            
                <div class=" ledger_details" id="div_print" style="padding: 10px 6px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
        <button type="button" class="btn dark" onclick="PrintDiv();" ><i class="fa fa-print"></i> Print</button>
         <button type="button"  class="btn blue-hoki btn_ledgerpdf"><i class="fa fa-file-pdf-o"></i> PDF</button>
         <button type="button"  class="btn green-haze btn_ledgercsv"><i class="fa fa-file-excel-o"></i> CSV</button>
         <button type="button"  class="btn purple-sharp btn_ledgerxls"><i class="fa fa-file-excel-o"></i> EXCEL</button>
         
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

            var oTable;
jQuery(document).ready(function() {


   /*jQuery(document).on('click',".accordion-toggle.collapsed",function(){

 
            var tr = jQuery(this).closest('tr');
            var tr_id = jQuery(this).closest('tr').attr('data-id');
            var tr_cname = jQuery(this).closest('tr').attr('data-cname');
            var tr_fname = jQuery(this).closest('tr').attr('data-fname');
            console.log(tr_cname);
        var row = oTable.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
           tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(tr_id,tr_cname,tr_fname) ).show();
            tr.addClass('shown');
        }

});*/


 $(document).on('click','.btn_clientmodal', function (event) {
             // $('.btn_clientmodal').on('click', function (event) {

                var tr_id = jQuery(this).closest('tr').attr('data-id');
                var tr_cname = jQuery(this).closest('tr').attr('data-cname');
                var tr_fname = jQuery(this).closest('tr').attr('data-fname');
                var tr_fid = jQuery(this).closest('tr').attr('data-fid');
                var tr_file_name = jQuery(this).closest('tr').attr('data-filename');
                var tr_finalyear = jQuery(this).closest('tr').attr('data-finalyear');
                

                format(tr_id,tr_cname,tr_fname,tr_fid,tr_file_name,tr_finalyear);


             /*$('.btn_clientmodal').on('show.bs.modal', function (event) {  var button = $(event.relatedTarget) // Button that triggered the modal
              var recipient = button.data('whatever') // Extract info from data-* attributes
              // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
              // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
              var modal = $(this)
              //modal.find('.modal-title').text('New message to ' + recipient)
              modal.find('.modal-body input').val(recipient)*/


            });





function format ( client_id,client_name, file_number,fid,file_name,finalyear ) {

var response_value = '';



show_ledgerdetails(client_id,client_name, file_number,fid,file_name,finalyear);

// response_value = '<div class="col-md-12 ledger_details" id="div_print" style="padding: 30px 20px;"></div><div><input name="b_print" type="button" class="ipt"   onClick="printdiv(\'div_print\');" value=" Print "></div>';
   
  //console.log(response_value);
   
   //response_value += '<tr><td>31/03/2015</td><td>CREDIT INTEREST</td><td></td><td></td><td>865.32</td><td>865.32</td></tr>';
  



return response_value;


}

$('.btn_ledgerxls').on('click', function() {


    $('.cledger_xlsdownload')[0].click();


});


$('.btn_ledgercsv').on('click', function() {


    $('.cledger_csvdownload')[0].click();


});

$('.btn_ledgerpdf').on('click', function() {

    var modal_month = jQuery(".modal_month").val();
    var modal_month_name = jQuery(".modal_month_name").val();
    var modal_year = jQuery(".modal_year").val();


$('.cledger_pdfdownload')[0].click();

});


/*jQuery(document).on('click','.view_cashbook',function(){
    var data_month = jQuery(this).attr('data-month');
    var data_month_name = jQuery(this).attr('data-month-name');
    var data_year = jQuery(this).attr('data-year');
    //console.log("data_month = "+data_month+" = data_year = "+data_year )
    show_ledgerdetails(data_month,data_month_name,data_year)
})
*/
function show_ledgerdetails(client_id,client_name, file_number,fid,file_name,finalyear){

 src = '<?php echo BASE_URL; ?>'+'reports/get_ClientLedger';

             $.ajax({
                url: src,
                dataType: "json",
                data: {
                    client_id : client_id, file_id: fid,client_name : client_name, file_number: file_number, file_name: file_name,finalyear:finalyear
                },
                success: function(data) {

                    var Other_details = data['other'];
                    var open_details = data['open'];

                   //response(data);
                    console.log(open_details);
                    //console.log(Other_details);
                    var total_amount = 0;
                     response_value = '<table style="width: 100%;" ><thead><tr><td style="border:0px;"><p style="font-weight: bold;text-align: center;font-size:19px;margin: 0px;">'+client_name+'</p><p style="font-weight: bold;text-align: center;font-size:13px;    margin: 10px 0px;">'+file_name+'</p><p style="font-weight: bold;text-align: center;font-size:13px;    margin: 10px 0px 15px;">'+file_number+'</p></td></tr></thead><tbody><tr><td style="border:0px;"><table style="width:100%;" class="table table-striped table-hover cldetails_table">';
                    
                        //console.log("yrrrrrrrrrrrrrrrrrrrrr");
                         response_value += '<thead><tr><td style="font-weight: bold;">DATE</td><td style="font-weight: bold;">DESCRPTION</td><td style="font-weight: bold;">FILE NO</td><td style="font-weight: bold;text-align:right;">DR</td><td style="font-weight: bold;text-align:right;">CR</td><td style="font-weight: bold;text-align:right;">BALANCE</td></tr></thead>';
                         if(typeof open_details !== 'undefined' && open_details !== null)
                         {
                            jQuery.each(open_details,function(key,value){
                                var file_number = value['file_number'] || '';
                                var amount = value['amount'] || 0;
                                var amount = parseFloat(amount);
                                var format_amount = amount.toFixed(2);
                                 //var format_amount = amount.toLocaleString('en-IN', {minimumFractionDigits: 2});
                                var format_amount = amount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                                response_value += '<tr><td></td><td>Opening Balance</td>';
                                response_value +='<td>'+file_number+'</td>';
                                response_value +='<td></td><td style="text-align:right;">R'+format_amount+'</td><td style="text-align:right;">R'+format_amount+'</td>';
                                total_amount +=amount;
                            });
                         }
                         if(typeof Other_details !== 'undefined' && Other_details !== null ){
                        jQuery.each(Other_details,function(key,value){
                            var val_date = value['date'] || '';
                            var transaction_type = value['transaction_type'] || '';
                            var file_number = value['file_number'] || '';
                            var description = value['description'] || '';
                            var amount = value['amount'] || 0;
                            var trans_txt = '';

                            if(transaction_type == 'deposit'){trans_txt = 'Deposit'; }
                            else if(transaction_type == 'rtd'){trans_txt = 'RTD';  }
                            else if(transaction_type == 'credit_interest'){trans_txt = 'Credit Interest';  }
                            else if(transaction_type == 'refund'){trans_txt = 'Refund'; }
                            else if(transaction_type == 'cost'){trans_txt = 'Cost';  }
                            else if(transaction_type == 'bank_charges'){trans_txt = 'Bank Charges';  }

                            else if(transaction_type == 'fee'){trans_txt = 'Fee';}
                            else {trans_txt='Fee'; }



                            response_value += '<tr><td>'+val_date+'</td><td>'+description+'</td>';
                            response_value +='<td>'+file_number+'</td>';
                            var amount = parseFloat(amount);
                            //var format_amount = amount.toFixed(2);
                            //var format_amount = amount.toLocaleString('en-IN', {minimumFractionDigits: 2});
                           // var format_amount = amount.toLocaleString('en-IN');
                           var format_amount = amount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

                            if(value['ledger_type'] == 'payment')
                            {
                            response_value +='<td style="text-align:right;">R'+format_amount+'</td><td></td>';
                            total_amount +=amount;
                        }
                        if(value['ledger_type'] == 'receipt')
                        {
                            response_value +='<td></td><td style="text-align:right;">R'+format_amount+'</td>';
                            total_amount -=amount;
                        }
                        //var format_total = total_amount.toLocaleString('en-IN');
                        //var format_total = total_amount.toFixed(2);
                        //var format_total = total_amount.toLocaleString('en-IN', {minimumFractionDigits: 2});
                        var format_total = total_amount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                            response_value +='<td style="text-align:right;">R'+format_total+'</td></tr>';
                           // console.log("total_amount = "+total_amount);

                        })
                    }
                    //var format_total = total_amount.toLocaleString('en-IN');
                    //var format_total = total_amount.toFixed(2);
                      //var  format_total = total_amount.toLocaleString('en-IN', {minimumFractionDigits: 2});
                    var format_total = total_amount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
                     response_value += '<tr><td colspan="6" style="text-align:right;font-weight:bold;">R'+format_total+'</td></tr></table></td></tr></table>';
                     jQuery(".ledger_details").html(response_value);
                }
            });
}


oTable = jQuery('#client_ledger').DataTable({ 

        "language": {
            "lengthMenu": "Show _MENU_ Clients",
            "emptyTable": "No data available in table",
                "info": "Showing _START_ to _END_ of _TOTAL_ clients",
                "infoEmpty": "No entries found",
                "infoFiltered": "(filtered1 from _MAX_ total entries)",
                "search": "Search:",
                "zeroRecords": "No matching records found"}, 
        "bDestroy": true,
        buttons: [
                { extend: 'print', className: 'btn dark btn-outline' },
                { extend: 'pdf', className: 'btn green btn-outline' },
                { extend: 'csv', className: 'btn purple btn-outline ' }
            ],
             responsive: {
                details: {
                   
                }
            },
    });

jQuery(".btn_ledgerfilter").click(function(){
//alert("tttttt");
	var financial_year = jQuery(".financial_year").val();
	//if(financial_year !='')
	//{
		var filter_src = '<?php echo BASE_URL; ?>'+'reports/filter_ClientLedger';
		             $.ajax({
                url: filter_src,
                dataType: "html",
                method: 'post',
                data: {
                    financial_year: financial_year
                },
                success: function(data) {
					console.log(data);
					jQuery("#client_ledger").html('');
					jQuery("#client_ledger").html(data);
					//jQuery('#client_ledger').DataTable().destroy();
					//jQuery('#client_ledger').DataTable({});
					
    jQuery('#client_ledger').dataTable().fnDestroy()

        jQuery('#client_ledger').dataTable({ "bDeferRender": false});


                }
            });
	//}
});


});

jQuery(window).load(function(){
jQuery(".btn_ledgerfilter").trigger('click');	
});

  </script>


<script language="javascript">


                 function PrintDiv() {
                        var contents = document.getElementById("div_print").innerHTML;
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
                        frameDoc.document.write("<center><h1>Client Ledger</h1></center>"+contents);
                        frameDoc.document.write('</body></html>');
                        frameDoc.document.close();
                        setTimeout(function () {
                            window.frames["frame1"].focus();
                            window.frames["frame1"].print();
                            document.body.removeChild(frame1);
                        }, 500);
                        return false;
                 }

    


/*

    $(document).ready(function () {
            console.log("HELLO")
            function exportTableToCSV($table, filename) {

                console.log('sssss');
                var $headers = $table.find('tr:has(th)')
                    ,$rows = $table.find('tr:has(td)')
                    // Temporary delimiter characters unlikely to be typed by keyboard
                    // This is to avoid accidentally splitting the actual contents
                    ,tmpColDelim = String.fromCharCode(11) // vertical tab character
                    ,tmpRowDelim = String.fromCharCode(0) // null character
                    // actual delimiter characters for CSV format
                    ,colDelim = '","'
                    ,rowDelim = '"\r\n"';
                    // Grab text from table into CSV formatted string
                    var csv = '"';
                    csv += formatRows($headers.map(grabRow));
                    csv += rowDelim;
                    csv += formatRows($rows.map(grabRow)) + '"';
                    // Data URI
                    var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
                $(this)
                    .attr({
                    'download': filename
                        ,'href': csvData
                        //,'target' : '_blank' //if you want it to open in a new window
                });
                //------------------------------------------------------------
                // Helper Functions 
                //------------------------------------------------------------
                // Format the output so it has the appropriate delimiters
                function formatRows(rows){
                    return rows.get().join(tmpRowDelim)
                        .split(tmpRowDelim).join(rowDelim)
                        .split(tmpColDelim).join(colDelim);
                }
                // Grab and format a row from the table
                function grabRow(i,row){
                     
                    var $row = $(row);
                    //for some reason $cols = $row.find('td') || $row.find('th') won't work...
                    var $cols = $row.find('td'); 
                    if(!$cols.length) $cols = $row.find('th');  
                    return $cols.map(grabCol)
                                .get().join(tmpColDelim);
                }
                // Grab and format a column from the table 
                function grabCol(j,col){
                    var $col = $(col),
                        $text = $col.text();
                    return $text.replace('"', '""'); // escape double quotes
                }
            }
            // This must be a hyperlink
            $(".btn_ledgercsv22").click(function (event) {
                // var outputFile = 'export'
                var outputFile = window.prompt("What do you want to name your output file (Note: This won't have any effect on Safari)") || 'export';
                outputFile = outputFile.replace('.csv','') + '.csv'
                 
                // CSV
                exportTableToCSV.apply(this, [$('#div_print table'), outputFile]);
                
                // IF CSV, don't do event.preventDefault() or return false
                // We actually need this to be a typical hyperlink
            });
        });

*/


     </script>
          
