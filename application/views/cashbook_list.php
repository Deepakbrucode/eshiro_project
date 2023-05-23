
        <style type="text/css">

.cashbook_details table {
    table-layout: fixed;
    width: 100%;   
}

        .cashbook_details th,.cashbook_details td {

    word-wrap: break-word;
}

            .cashbook_details table td,.cashbook_details table th{
                   
                  text-align: center;
                }
           
            .cashbook_details .table>tbody>tr>td,.cashbook_details .table>tbody>tr>th {
                font-size: 12px;
                width: 70%;
            }
            .cashbook_details .table > tfoot > tr > td {
                padding:10px 7px!important;
                 
                
                }
              /*  .table>tbody>tr>th {
                font-size: 12px;
                width: 18%;
            }*/
                @media print {
                 
                              .cashbook_details h1 {
                    font-size: 12pt;
                }

            }


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
                                <span>Cashbook</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="cashbook_details1" >
                    <div class="row">
                    <a href="<?php echo BASE_URL; ?>/uploads/cashbook_list.pdf" class="cash_pdfdownload" download style="display: none;">Download</a>
                    <!-- <a href="<?php echo BASE_URL; ?>uploads/cashbook_list.csv" class="cash_csvdownload" download style="display: none;">Download</a> -->
                    <a href="<?php echo BASE_URL; ?>uploads/cashbook_list.xls" class="cash_xlsdownload" download style="display: none;">Download</a>
                     <?php //echo "<pre>"; print_r(($financial_array));echo "</pre>"; ?>
                    <?php echo $this->session->flashdata('cashbook'); ?>
                        <div class="col-md-12">
                                <table class="table table-striped table-hover table-bordered1 cashbook_table" id="cash_details" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th> S.no </th>
                                            <th> Month & Year </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>                                        
                                    <tbody>
                                        <?php
                                       //echo "<pre>"; print_r($CashDetails);echo "</pre>";
                                        if($financial_array)
                                       // print_r($financial_array);exit;
                                        {
                                            $kk=0;
                                            foreach ($financial_array as $financial) {
                                                $kk++;
                                                // $cash_month = $CashDetail->cash_month;
                                                // $cash_month_name = $CashDetail->cash_month_name;
                                                // $cash_year = $CashDetail->cash_year;
                                               // $cash_month_name =  date('M', strtotime($cash_month . '1'));
                                               //echo "<tr><td>".$kk."</td><td>".$cash_month_name."-".$cash_year."</td><td><button class='btn purple btn-outline sbold view_cashbook' data-month-name='".$cash_month_name."' data-month='".$cash_month."' data-year='".$cash_year."'>View</button></td></tr>";
                                                ?>
                                          
                                        <tr>
                                            <td><?php echo $kk; ?></td>
                                            <td><?php echo $financial; ?></td>
                                             <td><button class='btn purple btn-outline sbold view_cashbookyear' data-year='<?php echo $financial; ?>'>View</button> 
                                                   
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
                    


                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->


            <div class="modal bs-modal-lg fade cashbook_details" id="modal_cashbook" tabindex="-1" role="modal_cashbook" aria-hidden="true">
            <div id="editor"></div>

                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header" style="text-align: right;">
                            <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> -->
                                                        <!--  <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button> -->
                            <button type="button" class="btn dark" onclick="printDiv('body_cashbook');" ><i class="fa fa-print"></i> Print</button>
                             <button type="button"  class="btn blue-hoki btn_cashbookpdf"><i class="fa fa-file-pdf-o"></i> PDF</button>
                             <!-- <button type="button"  class="btn green-haze btn_cashbookcsv"><i class="fa fa-file-excel-o"></i> CSV</button> -->
                             <button type="button"  class="btn purple-sharp btn_cashbookxls"><i class="fa fa-file-excel-o"></i> EXCEL</button>
                             <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>


                            <!-- <center><h4 class="modal-title">Cash Book</h4></center> -->
                        </div>
                        <div class="modal-body" id="body_cashbook"> 
                            <div class="row">
                                <div class="modal_headd"></div>

                                <input type="hidden" class="modal_month" >
                                <input type="hidden" class="modal_month_name" >
                                <input type="hidden" class="modal_year" >
                                <div class="col-md-12 cbd_div">
                                    <!-- <table class="table table-striped table-hover table-bordered cbd_table">
                                        <thead>
                                            <tr>
                                                <td>Date</td>
                                                <td>Details</td>
                                                <td>File No</td>
                                                <td>File Name</td>
                                                <td>Dr</td>
                                                <td>Cr</td>
                                                <td>Balance</td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>

                                    </table> -->
                                </div>



                               <!--  <input type="hidden" class="modal_month" >
                                <input type="hidden" class="modal_month_name" >
                                <input type="hidden" class="modal_year" > -->
                                <!-- <div class="col-md-12"> 
                                    <div class="col-md-6">
                                      <div class="col-md-12" style="text-align:center;font-weight:bold;">RECEIPTS SIDE</div>
                                        <table class="table table-striped table-hover table-bordered" id="creceipt_table" style="width:100%">
                                        <thead>


                                           <tr>
                                                <th> Date </th>
                                                <th> Details </th>
                                                <th> File No </th>
                                                <th> Sundry </th>
                                                <th> Client </th>
                                                <th> Bank </th>
                                            </tr>
                                        </thead>   
                                          <tfoot>
                                       
                                        </tfoot>                                      
                                        <tbody>
                                        
                                        </tbody>

                                      
                                     </table>
                                    </div>
                                    <div class="col-md-6">

                                    <div class="col-md-12" style="text-align:center;font-weight:bold;">PAYMENT SIDE</div>
                                         <table class="table table-striped table-hover table-bordered" id="cpayment_table" style="width:100%">
                                        <thead>

                                            <tr>
                                                <th> Date </th>
                                                <th> Details </th>
                                                <th> File No </th>
                                                <th> Sundry </th>
                                                <th> Client </th>
                                                <th> Bank </th>

                                            </tr>
                                        </thead>
                                         <tfoot>
                                      
                                        </tfoot> 
                                        <tbody>
                                    
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                 <div class="col-md-12 cash_bank">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8 col-sm-8" style="margin:0px auto;">
                                 <div style="text-align: center; ">
                                  <p><b> Bank Reconciliation Statement</b></p>
                                  <p class="modal_month">As At May, 2016</p>
                                  </div>
                                <table class="table" style="text-align: center;border:1px solid #e7ecf1;box-shadow: 10 ">


                            <tbody>
                                
                                <tr>
                                    <td>Balance as per Cashbok</td>
                                    <td style="/*border-bottom:1px solid #EEF1F5*/;" class="bal_cashbook">R 0.00</td>
                                </tr>
                                <tr>
                                    <td style="text-decoration: underline;font-weight:bold;">Add:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Credit Interest</td>
                                    <td style="border-bottom: 1px solid;" class="bal_credit">R 0.00</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th style="border-bottom: 1px solid;" class="bal_ccashbook">R 0.00</th>
                                </tr>
                                <tr>
                                    <td style="text-decoration: underline;font-weight:bold;">Less:</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Bank Charges</td>
                                    <td class="bal_bankchg">R 0.00</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th style="border-bottom: 1px solid;" class="bal_bcashbook">R 0.00</th>
                                </tr>
                                <tr>
                                    <td>Balance as per Bank Statement</td>
                                    <th style="border-bottom: 1px solid;" class="bal_bankstat">R 0.00</th>
                                </tr>
                                <tr>
                                    <th>Unreconcilable Difference</th>
                                    <th class="bal_diff">R 0.00</th>
                                </tr>
                             </tbody>
                        </table>
                            
                        </div>
                                </div>  -->
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                        <!-- <input type="button" onclick="printDiv('modal_cashbook')" value="Print Invoice" /> -->
                            <!-- <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                            <button type="button" onclick="printDiv('body_cashbook')" class="btn green">Print</button>
                            <button type="button"  class="btn green btn_cashbookpdf">PDF</button>
                            <button type="button"  class="btn green btn_cashbookcsv">CSV</button>
                            <button type="button"  class="btn green btn_cashbookxls">EXCEL</button> -->




                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <script type="text/javascript">
jQuery(document).ready(function() {


    $('[data-toggle=confirmation]').confirmation({
  rootSelector: '[data-toggle=confirmation]',
  // other options
});
    
            var table = $('#cash_details');

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
                { extend: 'pdf', className: 'btn green btn-outline' },
                { extend: 'csv', className: 'btn purple btn-outline ' }
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

function printDiv(divName) {
    

    var contents = document.getElementById(divName).innerHTML;
     var frame1 = document.createElement('iframe');


      var htmlToPrint = '' +
                        '<style type="text/css">' +
                        '@page{margin:25px 20px;}'+
                        'h1{padding-top:20px;}'+
                        'table th, table td {' +
                        'border:1px solid #ccc;' + 
                        'padding:0.5em;' +
                        '}' + 
                        'table, td, th{' +
                        ' border-collapse: collapse;'+
                        '}' +
                        '.table{'+
                        'margin-top: 10px;' +
                        '}'+
                         '.cbd_table{'+
                        'width:100%'+
                        '}'+
                        '.cbd_table {'+
                        'padding-top: 20%;'+
                        '}'+
                        '</style>';
                        contents += htmlToPrint;


                        frame1.name = "frame1";
                        frame1.style.position = "absolute";
                        frame1.style.top = "-1000000px";
                        document.body.appendChild(frame1);
                        var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1.contentDocument.document : frame1.contentDocument;
                        frameDoc.document.open();
                        frameDoc.document.write('<html><head><title>' + 'Cashbook' + '</title>');
                        frameDoc.document.write('</head><body>');
                       // frameDoc.document.write("<center><h1>Cashbook</h1></center>"+contents);
                        frameDoc.document.write(contents);
                        frameDoc.document.write('</body></html>');
                        frameDoc.document.close();
                        setTimeout(function () {
                            window.frames["frame1"].focus();
                            window.frames["frame1"].print();
                            document.body.removeChild(frame1);
                        }, 500);
                        return false;

/*var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;*/
}

jQuery(document).on('click','.view_cashbookyear',function(){
    // var data_month = jQuery(this).attr('data-month');
    // var data_month_name = jQuery(this).attr('data-month-name');
    var data_year = jQuery(this).attr('data-year');
    //console.log("data_month = "+data_month+" = data_year = "+data_year )
    ajax_cashbookyear(data_year)
})

            function ajax_cashbookyear(year){

                var filtered_client_name = "<?php echo $_SESSION['filtered_client_name']; ?>";
                // jQuery(".modal_month").val(month);
                // jQuery(".modal_month_name").val(month_name);
                jQuery(".modal_year").val(year);

                //jQuery(".modal_month").html("As At "+month_name+", "+year);
              //var option_html = '';
               src = '<?php echo BASE_URL; ?>'+'reports/ajax_cashbookyear';
                 $.ajax({
                    url: src,
                    type:'GET',
                    //dataType: "json",
                    dataType: "html",
                    data: {'year':year},
                    success: function(data) {
//jQuery(".modal_headd").html('<p style="font-weight: bold;text-align: center;font-size:19px;margin: 0px;">'+filtered_client_name+'</p><p style="font-weight: bold;text-align: center;font-size:13px;    margin: 10px 0px;">TRUST CASHBOOK </p>');
$(".cbd_div").html(data);
                     // console.log(data);

/*
cbd_txt = '';
if(data)
{
    jQuery.each(data,function(key,value){
        cbd_txt+= "<table class='table table-striped table-hover table-bordered  cbd_table'><thead><tr><td>Date</td><td>Details</td><td>File No</td><td>File Name</td><td>Dr</td><td>Cr</td><td>Balance</td></tr></thead>";
        var open_bal = value['open'];
        var all_val = value['all'];
        if(open_bal !='')
        {
            jQuery.each(open_bal,function(okey,ovalue){
                $odate = ovalue['openbal_date'];
                $oamount = ovalue['amount'];
                cbd_txt += "<tr><td>"+$odate+"</td><td>Opening Balance</td><td></td><td></td><td></td><td>"+$oamount+"</td><td></td></tr>";
            })
        }
        if(all_val !='')
        {
            jQuery.each(all_val,function(akey,avalue){
                $adate = avalue['selected_date'];
                $aamount = avalue['amount'];
                cbd_txt += "<tr><td>"+$adate+"</td><td>Opening Balance</td><td></td><td></td><td></td><td>"+$aamount+"</td><td></td></tr>";
            })
        }
         cbd_txt+= "</table>";

    })
}

jQuery(".modal_headd").html('<p style="font-weight: bold;text-align: center;font-size:19px;margin: 0px;">'+filtered_client_name+'</p><p style="font-weight: bold;text-align: center;font-size:13px;    margin: 10px 0px;">TRUST CASHBOOK </p><p style="font-weight: bold;text-align: center;font-size:13px;    margin: 10px 0px 15px;">'+year+'</p>');


$(".cbd_div").html(cbd_txt);

*/

/*
                      var receipt_details = data['receipt'];
                       var payment_details = data['payment'];
                       var openbal_details = data['openbal'];
                       console.log(receipt_details);
                       console.log(payment_details);
                       var receipt_tbody = '';
                       var payment_tbody = '';
                       var receipt_tfoot = '';
                       var payment_tfoot = '';


                        var rbalance_total = 0;
                        var rsundry_total1 = 'R 0.00';
                        var rclient_total1 = 'R 0.00';
                        var rbank_total1 = 'R 0.00';
                        var rbalance_total1 = 'R 0.00';

                        var rsundry_total=0;
                        var rclient_total = 0;
                        var rbank_total = 0;


                        var pbalance_total = 0;
                        var psundry_total1 = 'R 0.00';
                        var pclient_total1 = 'R 0.00';
                        var pbank_total1 = 'R 0.00';
                        var pbalance_total1 = 'R 0.00';
                        var psundry_total=0;
                        var pclient_total = 0;
                        var pbank_total = 0;

                        if(openbal_details !='')
                        {
                            $.each(openbal_details,function(key,value){
                                 var openbal_date = value['openbal_date'];
                                 openbal_date = date_Format(openbal_date);

                                // var fromDate = new Date(openbal_date);




                           //var date = new Date(fromDate).toDateString("yyyy-MM-dd");

                          // console.log("date = ==="+date);


                                var oamount = parseFloat(value['amount']);
                                //oformat_amount = "R".number_format($oamount,2);
                                // oformat_amount = oamount.toFixed(2)
                                var oformat_amount = oamount.toLocaleString('en-IN', {minimumFractionDigits: 2});
                               // var oformat_amount = oamount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

                                receipt_tbody +="<tr><td><b>"+openbal_date+"</b></td><td><b>Opening Balance</b></td><td></td><td></td><td><b>R "+oformat_amount+"</b></td><td><b>R "+oformat_amount+"</b></td></tr>";
                                rbank_total+=oamount;
                                rclient_total+=oamount;
                            });
                        }

if(receipt_details !='')
{
    
    $.each(receipt_details,function(key,value){
       
        var trans_txt='';
        var rsundry_amt = 0;
        var rclient_amt = 0;

         var ramount = parseFloat(value['amount']);
        var file_number = value['file_number'] || '';
        var file_name = value['file_name'] || '';

        var rformat_amount = ramount.toLocaleString('en-IN', {minimumFractionDigits: 2});
       // var rformat_amount = ramount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        var transaction_type = value['transaction_type'];

        if(transaction_type == 'deposit'){trans_txt = 'Deposit'; rsundry_amt='';rclient_amt = "R "+rformat_amount;
        rclient_total+=ramount;}
        else if(transaction_type == 'rtd'){trans_txt = 'RTD'; rsundry_amt='';rclient_amt = "R "+rformat_amount;rclient_total+=ramount; }
        else if(transaction_type == 'credit_interest'){trans_txt = 'Credit Interest'; rsundry_amt= "R "+rformat_amount;rclient_amt = "";
        rsundry_total+= ramount; }
        else {trans_txt=''; rsundry_amt='';rclient_amt = "R "+rformat_amount;rclient_total+= ramount;}
        var receipt_date = value['receipt_date'];
        receipt_date = date_Format(receipt_date);

        receipt_tbody +="<tr><td>"+receipt_date+"</td><td>"+trans_txt+"</td><td>"+file_name+"</td><td>"+rsundry_amt+"</td><td>"+rclient_amt+"</td><td>R "+rformat_amount+"</td></tr>";
        rbank_total+=ramount;

    });

  rsundry_total1 = rsundry_total.toLocaleString('en-IN', {minimumFractionDigits: 2});
  rclient_total1 = rclient_total.toLocaleString('en-IN', {minimumFractionDigits: 2});
  rbank_total1 = rbank_total.toLocaleString('en-IN', {minimumFractionDigits: 2});


  //rsundry_total1 = rsundry_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
  // rclient_total1 = rclient_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
   // rbank_total1 = rbank_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
rbalance_total = (rclient_total+rsundry_total) - rbank_total;

  rbalance_total1 = rbalance_total.toLocaleString('en-IN', {minimumFractionDigits: 2});
 //rbalance_total1 = rbalance_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
   
}

 receipt_tfoot = '<tr><td colspan="3"></td><td style="border-bottom: 2px solid;">R '+rsundry_total1+'</td><td style="border-bottom: 2px solid;">R '+rclient_total1+'</td><td style="border-bottom: 2px solid;">R '+rbank_total1+'</td></tr><tr><td colspan="3"></td><td></td><td colspan="2" style="font-weight:400!important;">R '+rbalance_total1+'</td></tr>  ';

                      jQuery("#creceipt_table tbody").html(receipt_tbody);
                      jQuery("#creceipt_table tfoot").html(receipt_tfoot);

                      if(payment_details !='')
{
    
    $.each(payment_details,function(key,value){
        //var cdate = value['payment_date'] || '';

        var payment_date = value['payment_date'];
        payment_date = date_Format(payment_date);


        var trans_txt='';
        var psundry_amt = 0;
        var pclient_amt = 0;

         var pamount = parseFloat(value['amount']);
        var file_number = value['file_number'] || '';
        var file_name = value['file_name'] || '';
        
        var  pformat_amount = pamount.toLocaleString('en-IN', {minimumFractionDigits: 2});
        //var pformat_amount = pamount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        var transaction_type = value['transaction_type'];

        if(transaction_type == 'refund'){trans_txt = 'Refund'; psundry_amt='';pclient_amt = "R "+pformat_amount;
        pclient_total+=pamount;}
        else if(transaction_type == 'cost'){trans_txt = 'Cost'; psundry_amt='';pclient_amt = "R "+pformat_amount;pclient_total+=pamount; }
        else if(transaction_type == 'bank_charges'){trans_txt = 'Bank Charges'; psundry_amt= "R "+pformat_amount;pclient_amt = "";
        psundry_total+= pamount; }

        else if(transaction_type == 'fee'){trans_txt = 'Fee'; psundry_amt= ''; pclient_amt = "R "+pformat_amount;pclient_total+=pamount;}

        else {trans_txt=''; psundry_total='';psundry_amt= '';pclient_amt = "R "+pformat_amount;pclient_total+= pamount;}






        payment_tbody +="<tr><td>"+payment_date+"</td><td>"+trans_txt+"</td><td>"+file_name+"</td><td>"+psundry_amt+"</td><td>"+pclient_amt+"</td><td>R"+pformat_amount+"</td></tr>";

        pbank_total+=pamount;

    });


    psundry_total1 = psundry_total.toLocaleString('en-IN', {minimumFractionDigits: 2});
    pclient_total1 = pclient_total.toLocaleString('en-IN', {minimumFractionDigits: 2});
    pbank_total1 = pbank_total.toLocaleString('en-IN', {minimumFractionDigits: 2});

 // psundry_total1 = psundry_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
  // pclient_total1 = pclient_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
  //  pbank_total1 = pbank_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
   pbalance_total = (pclient_total+psundry_total) - pbank_total;
    pbalance_total1 = pbalance_total.toLocaleString('en-IN', {minimumFractionDigits: 2});
 //pbalance_total1 = pbalance_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
    

}

var sundry_total = rsundry_total - psundry_total;
var sundry_total1 = sundry_total.toLocaleString('en-IN', {minimumFractionDigits: 2});
//var sundry_total1 = sundry_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

var client_total = rclient_total - pclient_total;
var client_total1 = client_total.toLocaleString('en-IN', {minimumFractionDigits: 2});
//var client_total1 = client_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');


var bank_total = rbank_total - pbank_total;

var bank_total1 = bank_total.toLocaleString('en-IN', {minimumFractionDigits: 2});
//var bank_total1 = bank_total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

//console.log("rbalance_total = "+rbalance_total);
//console.log("pbank_total = "+pbank_total);
//console.log("bank_total = "+bank_total);

 payment_tfoot = '<tr><td colspan="3"></td><td style="border-bottom: 2px solid;">R '+psundry_total1+'</td><td style="border-bottom: 2px solid;">R '+pclient_total1+'</td><td style="border-bottom: 2px solid;">R '+pbank_total1+'</td></tr><tr><td colspan="3"></td><td>R '+sundry_total1+'</td><td>R '+client_total1+'</td><td>R '+bank_total1+'</td></tr>  ';


                      jQuery("#cpayment_table tbody").html(payment_tbody);

                      jQuery("#cpayment_table tfoot").html(payment_tfoot);

jQuery(".bal_cashbook").html("R "+client_total1);
jQuery(".bal_credit").html("R "+rsundry_total1);

var bal_ccashbook = client_total + rsundry_total;

var bal_ccashbook1 = bal_ccashbook.toLocaleString('en-IN', {minimumFractionDigits: 2});
//var bal_ccashbook1 = bal_ccashbook.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');


jQuery(".bal_ccashbook").html("R "+bal_ccashbook1);

jQuery(".bal_bankchg").html("R "+psundry_total1);

var bal_bcashbook = bal_ccashbook - psundry_total;

var bal_bcashbook1 = bal_bcashbook.toLocaleString('en-IN', {minimumFractionDigits: 2});
//var bal_bcashbook1 = bal_bcashbook.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');

jQuery(".bal_bcashbook").html("R "+bal_bcashbook1);


jQuery(".bal_bankstat").html("R "+bank_total1);

var bal_diff = bank_total - bal_bcashbook;

//var bal_diff1 = bal_diff.toFixed(2);
var bal_diff1 = bal_diff.toLocaleString('en-IN', {minimumFractionDigits: 2});
//var bal_diff1 = bal_diff.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');


jQuery(".bal_diff").html("R "+bal_diff1);


*/
                 


                    }
                });

/*var
  form = $('#body_cashbook'),
  cache_width = form.width(),
  a4 = [595.28, 841.89]; // for a4 size paper width and height*/


  $('#modal_cashbook').modal('show');

            }




$('.btn_cashbookxls').on('click', function() {



$('.cash_xlsdownload')[0].click();




 });

// $('.btn_cashbookcsv').on('click', function() {

// $('.cash_csvdownload')[0].click();


//  });

$('.btn_cashbookpdf').on('click', function() {

    var modal_month = jQuery(".modal_month").val();
    var modal_month_name = jQuery(".modal_month_name").val();
    var modal_year = jQuery(".modal_year").val();


$('.cash_pdfdownload')[0].click();


   /* src = '<?php echo BASE_URL; ?>'+'reports/cashbook_pdf';
                 $.ajax({
                    url: src,
                    type:'POST',
                    dataType: "json",
                    data: {'month':modal_month,'month_name':modal_month_name,'year':modal_year},
                    success: function(data) {
                        //console.log("successsss");
                        $('.cash_pdfdownload')[0].click();

                    },
                    error: function(){
                      //  console.log("errrrrr");
                        $('.cash_pdfdownload')[0].click();
                    }
                });*/
               //  console.log("successsss");

 });



function date_Format(date_val){
    var fromDate = new Date(date_val);
    var curr_date = fromDate.getDate();
    var curr_month = fromDate.getMonth() ; //Months are zero based

    var month = new Array();
            month[0] = "Jan";
            month[1] = "Feb";
            month[2] = "Mar";
            month[3] = "Apr";
            month[4] = "May";
            month[5] = "June";
            month[6] = "July";
            month[7] = "Aug";
            month[8] = "Sept";
            month[9] = "Oct";
            month[10] = "Nov";
            month[11] = "Dec";
            var month_name = month[curr_month];


    var curr_year = fromDate.getFullYear();

    var New_date = curr_date+'-'+month_name+'-'+curr_year;
    //console.log(curr_year + "-" + month_name + "-" + curr_date);
    return New_date;
}



/*jQuery(document).ready(function(){

            var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

$('.btn_pdf').click(function () {
    doc.fromHTML($('#body_cashbook').html(), 15, 15, {
        'width': 800,
            'elementHandlers': specialElementHandlers
    });
    doc.save('sample-file.pdf');
});
})*/


/*
var
  form = $('#body_cashbook'),
  cache_width = form.width(),
  a4 = [595.28, 841.89]; // for a4 size paper width and height

$('.btn_pdf').on('click', function() {
  $('body').scrollTop(0);
  createPDF();
 });
 //create pdf
 function createPDF() {
  getCanvas().then(function(canvas) {
   var
    img = canvas.toDataURL("image/png"),
    doc = new jsPDF({
     unit: 'px',
     format: 'a3'
    });
   doc.addImage(img, 'JPEG', 20, 20);
   doc.save('techumber-html-to-pdf.pdf');
   form.width(cache_width);
  });
 }

 // create canvas object
 function getCanvas() {
  form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');
  return html2canvas(form, {
   imageTimeout: 2000,
   removeContainer: true
  });
 }


 */
            </script>





            
    
