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
                    <span>Invoice ledger</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">

            <?php echo $this->session->flashdata('report'); ?>

            <?php 
            if($usertype == '5') { ?>
            <div class="col-md-8">
                <div class="col-md-2" style="text-align: right;"><span>Client Name</span></div>
                <div class="col-md-6">
                <select name="client_id" class="form-control client_id">
                <?php if($ClientDetails){
                    foreach($ClientDetails as $ClientDetail) { 
                        $selected = ($fclient_id == $ClientDetail->id)?'selected':'';
                    echo "<option value='".$ClientDetail->id."' ".$selected.">".$ClientDetail->name."</option>";

                 } } else {echo "<option value=''>No clients Available</option>";} ?>
                </select>
                </div>
                <div class="col-md-2"><button type="button" class="btn btn-info btn_fcreport">Filter Cost Group</button></div><br>
                </div><br>
            <?php } ?>

            <div class="col-md-12">
                <div class="col-md-8">
                    <div class="col-md-12">
                        <div class="modal-header" style="text-align: right;">
                            <input type="hidden" class="report_type" value="<?php echo $report_type; ?>">
                            <input type="hidden" class="filtered_client_id" value="<?php echo $filtered_client_id; ?>">
                            <button type="button" class="btn dark" onclick="printDiv('body_costgroup');"><i class="fa fa-print"></i> Print</button>
                            <a href='<?php echo BASE_URL."uploads/".$pdf_fname; ?>' class='btn blue-hoki btn-outline1 url_pdfdownload' download='' style="display: none;"><i class='fa fa-file-excel-o'></i> PDF</a>
                            <button type="button" class='btn blue-hoki btn-outline1 btn_pdfdownload'><i class='fa fa-file-excel-o'></i> PDF</button>
                            <a href='<?php echo BASE_URL."uploads/".$excel_fname; ?>' class='btn purple-sharp  btn-outline1 ' download=''><i class='fa fa-file-excel-o'></i> EXCEL</a>
        
                            
                             <!-- <button type="button" class="btn blue-hoki btn_bankstatpdf"><i class="fa fa-file-pdf-o"></i> PDF</button>
                             <button type="button" class="btn purple-sharp btn_bankstatxls"><i class="fa fa-file-excel-o"></i> EXCEL</button> -->
                        </div>
                    </div>
                    <div class="col-md-12" id="body_costgroup">
                        <?php 
                            echo $cost_txt;
                        ?>
                    </div>
                </div>
            </div>
            <br><br><br><br>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<script type="text/javascript">
    jQuery(document).on('click','.btn_fcreport',function(){
    var client_id = jQuery(".client_id").val();
    var report_url = "<?php echo $report_url; ?>";
    location.href = "<?php echo BASE_URL; ?>reports/"+report_url+"/?client_id="+client_id;
});

jQuery(document).on('click','.btn_pdfdownload',function(){
    var report_type = jQuery(".report_type").val();
    var filtered_client_id = jQuery(".filtered_client_id").val();
    var base_url = "<?php echo BASE_URL; ?>";
    jQuery("body").css({'cursor': 'progress'});
    $(".btn").attr("disabled", true);
    $.ajax({
        url: base_url+'reports/ledger_pdfcreation',
        type:'post',
        data:{'report_type':report_type,'filtered_client_id':filtered_client_id},
        dataType:'json',
        success:function(response){
            // console.log(response);
            jQuery(".url_pdfdownload")[0].click();
            jQuery("body").css({'cursor': 'default'});
            $(".btn").attr("disabled", false);
        }
    })
})

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
                        frameDoc.document.write('<html><head><title>' + 'Cost Group Report' + '</title>');
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
</script>

