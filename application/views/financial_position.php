
<style>
    .btn-group{
        /*width: 140px;*/
        width: auto;
        position: relative;
        display: inline-flex;
    }
    .popover.confirmation.fade.top.in{margin-left: -5%;}
    .table_frminput{    margin-bottom: 5px;
    clear: both;}
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
                    <a href="#">Financials</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>STATEMENT OF FINANCIAL POSITION</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">

            <?php echo $this->session->flashdata('report'); ?>
            <center><h3>STATEMENT OF FINANCIAL POSITION</h3></center>
            <input type="hidden" class="report_type" value="<?php echo $report_type; ?>">
            <a href="<?php echo BASE_URL; ?>/uploads/financial_position.pdf" class="cash_pdfdownload" download >Download</a>  
            <a href="<?php echo BASE_URL; ?>uploads/financial_position.xls" class="cash_xlsdownload" download style="display: none;">Download</a>
            
            <!-- BEGIN FORM-->
            <div class="col-md-12">
                <?php echo $financial_report_pdf; ?>
                <form method="post" action="<?php echo BASE_URL; ?>financialreport/ajax_financial_position">
                    <div class="col-md-12">
                        <?php if($usertype == '5') { ?>
                            <div class="col-md-12">
                                <div class="col-md-2" style="text-align: right;"><span>Client Name</span></div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <select name="client_id" class="form-control client_id">
                                            <?php if($ClientDetails){
                                                foreach($ClientDetails as $ClientDetail) { 
                                                    $selected = ($fclient_id == $ClientDetail->id)?'selected':'';
                                                echo "<option value='".$ClientDetail->id."' ".$selected.">".$ClientDetail->name."</option>";

                                             } } else {echo "<option value=''>No clients Available</option>";} ?>
                                        </select><br>
                                    </div>
                                </div>
                            </div>
                        <?php } 
                        else {
                            echo "<input type='hidden' class='client_id' value='".$this->session->userinfo->id."'>"; 
                        }?>
                        <div class="col-md-6">
                            <div class="form-group col-md-12">
                                <label class="col-md-4 control-label">Report Period</label>
                                <div class="col-md-8">
                                    <div class="input-group input-large date-picker input-daterange"  >
                                        <input type="text" name="start_date" class="form-control start_date">
                                        <span class="input-group-addon"> to </span>
                                        <input type="text" name="end_date" class="form-control end_date"> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" style="text-align:right;margin-bottom:15px;">
                            <button type="button" class="btn btn-success btn_casubmit btn_ajaxstart">Show Report</button>
                            <button class="btn btn-success btn_ajaxend" style="display:none;"><i class="fa fa-refresh fa-spin"></i>Loading</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->




<div class="modal bs-modal-lg fade bankstat_details" id="modal_bankstat" tabindex="-1" role="modal_bankstat" aria-hidden="true">
    <div id="editor"></div>

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="text-align: right;">
       
                 <button type="button" class="btn dark" onclick="printDiv('body_bankstat');" ><i class="fa fa-print"></i> Print</button>
                <button type="button"  class="btn blue-hoki btn_bankstatpdf"><i class="fa fa-file-pdf-o"></i> PDF</button>   
                <button type="button"  class="btn purple-sharp btn_bankstatxls"><i class="fa fa-file-excel-o"></i> EXCEL</button>
                <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button>
            </div>
            <div class="modal-body" id="body_bankstat"> 
                <div class="row">
                    <div class="modal_headd"></div>

                    <input type="hidden" class="modal_month" >
                    <input type="hidden" class="modal_month_name" >
                    <input type="hidden" class="modal_year" >
                    <div class="col-md-12 cbd_div"></div>
                </div>
                            
            </div>
            <div class="modal-footer">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script type="text/javascript">
    

    jQuery(document).ready(function() {

       $('.date-picker').datepicker({
                autoclose: true,
                  format: "mm/yyyy",
        viewMode: "months", 
        minViewMode: "months",
        startView: "months", 
                orientation: "bottom"
            });



$(document).ajaxStart(function(){
    jQuery(".btn_ajaxstart").hide();
    jQuery(".btn_ajaxend").show();
});


$(document).ajaxComplete(function(){
    jQuery(".btn_ajaxstart").show();
    jQuery(".btn_ajaxend").hide();
});



});
$(document).ready(function() {
    $('[data-toggle=confirmation]').confirmation({
        rootSelector: '[data-toggle=confirmation]',
        // other options
    });

   



jQuery(document).on('click','.btn_fcreport',function(){
    var client_id = jQuery(".client_id").val();
    // var report_url = "<?php echo $report_url; ?>";
    location.href = "<?php echo BASE_URL; ?>financialreport/financial_position/?client_id="+client_id;
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
                        frameDoc.document.write('<html><head><title>' + 'Bank Statement' + '</title>');
                        frameDoc.document.write('</head><body>');
                       // frameDoc.document.write("<center><h1>bankstat</h1></center>"+contents);
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

jQuery(document).on('click','.btn_casubmit',function(){
    // var data_month = jQuery(this).attr('data-month');
    // var data_month_name = jQuery(this).attr('data-month-name');
    // var data_year = jQuery(this).attr('data-year');
    //console.log("data_month = "+data_month+" = data_year = "+data_year )
    ajax_bankstatyear()
})

            function ajax_bankstatyear(){
                var report_type = jQuery(".report_type").val();
                var client_id = jQuery(".client_id").val();
                // var end_month = jQuery(".end_month").val();
                // var start_month = jQuery(".start_month").val();
                 var end_date = jQuery(".end_date").val();
                var start_date = jQuery(".start_date").val();
                // jQuery(".modal_month").val(month);
                // jQuery(".modal_month_name").val(month_name);
                // jQuery(".modal_year").val(year);

                // if(report_type == 1)
                // {
                //     src = '<?php echo BASE_URL; ?>'+'reports/ajax_financial_statement_invoice';
                //      //src = '<?php echo BASE_URL; ?>'+'banktransactions/ajax_financial_statement_invoice';
                // }
                // else
                // {
                //      src = '<?php echo BASE_URL; ?>'+'banktransactions/ajax_financial_statement';
                //     //  src = '<?php echo BASE_URL; ?>'+'banktransactions/ajax_financial_statement';
                // }
              
                 $.ajax({
                    url: '<?php echo BASE_URL; ?>'+'financialreport/ajax_financial_position',
                    type:'POST',
                    //dataType: "json",
                    dataType: "html",
                    data: {client_id:client_id,'report_type':report_type,'start_date':start_date,'end_date':end_date},
                    success: function(data) {

$(".cbd_div").html(data);
                     // console.log(data);

                 


                    }
                });




  $('#modal_bankstat').modal('show');

            }




$('.btn_bankstatxls').on('click', function() {



$('.cash_xlsdownload')[0].click();




 });


$('.btn_bankstatpdf').on('click', function() {

$('#modal_bankstat button').prop('disabled', true);
$('html, body').css("cursor", "wait");


// var inputh_year = jQuery(this).closest('.modal-content').find('.modal_year').val();
var client_id = jQuery(".client_id").val();
var report_type = jQuery(".report_type").val();
 var end_date = jQuery(".end_date").val();
                var start_date = jQuery(".start_date").val();

src = '<?php echo BASE_URL; ?>'+'financialreport/pdf_financial_position';

    
                 $.ajax({
                    url: src,
                    type:'POST',
                    dataType: "json",
                    data: {client_id:client_id,'report_type':report_type,'start_date':start_date,'end_date':end_date},
                    success: function(data) {
                        //console.log("successsss");
                        $('.cash_pdfdownload')[0].click();
                        $('#modal_bankstat button').prop('disabled', false);
                        $('html, body').css("cursor", "auto");
                    },
                    error: function(){
                      //  console.log("errrrrr");
                        $('.cash_pdfdownload')[0].click();
                        $('#modal_bankstat button').prop('disabled', false);
                         $('html, body').css("cursor", "auto");
                    }
                });
               //  console.log("successsss");

 });




            </script>
