<style>
.btn-group {
    /*width: 140px;*/
    width: auto;
    position: relative;
    display: inline-flex;
}

.popover.confirmation.fade.top.in {
    margin-left: -5%;
}

.table_frminput {
    margin-bottom: 5px;
    clear: both;
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
                    <a href="#">Ledger</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span><?php echo $ledger_title; ?></span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">

            <?php echo $this->session->flashdata('report'); ?>
            <center>
                <h3><?php echo $ledger_title; ?> Details</h3>
            </center>
            <input type="hidden" name="current_userid" class="current_userid" value="<?php echo $current_userid; ?>">
            <input type="hidden" class="report_type" value="<?php echo $report_type; ?>">
            <input type="hidden" class="end_month" value="<?php echo $end_month; ?>">
            <input type="hidden" class="start_month" value="<?php echo $start_month; ?>">

            <?php 
            if($usertype == '5') { ?>
            <div class="col-md-12">
                <div class="col-md-3" style="text-align: right;"><span>Client Name</span></div>
                <div class="col-md-4">
                    <select name="client_id" class="form-control client_id">
                        <?php if($ClientDetails){
                    foreach($ClientDetails as $ClientDetail) { 
                        $selected = ($current_userid == $ClientDetail->id)?'selected':'';
                    echo "<option value='".$ClientDetail->id."' ".$selected.">".$ClientDetail->name."</option>";

                 } } else {echo "<option value=''>No clients Available</option>";} ?>
                    </select>
                </div>
                <div class="col-md-3"><button type="button" class="btn btn-info btn_fcreport">Filter Data</button></div>
                <br>
            </div><br>
            <?php } ?>



            <form method="post" id="saveform">
                <div class="col-md-12">

                    <a href="<?php echo BASE_URL; ?>/uploads/ledger_report.pdf" class="cash_pdfdownload" download
                        style="display: none;">Download</a>
                    <!-- <a href="<?php echo BASE_URL; ?>uploads/cashbook_list.csv" class="cash_csvdownload" download style="display: none;">Download</a> -->
                    <a href="<?php echo BASE_URL; ?>uploads/ledger_report.xls" class="cash_xlsdownload" download
                        style="display: none;">Download</a>

                    <table class="table table-striped table-hover table-bordered1 stl_table" id="show_reporttb"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th> S.no </th>
                                <th> Month & Year </th>
                                <th> Action </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                        //echo "<pre>";print_r($ReportDetails);echo "</pre>";
                        if($bank_stat_yr) { 
                        $i=0;
                        setlocale(LC_MONETARY, 'en_IN');
                        foreach($bank_stat_yr as $bank_stat) {
                        $i++;
                        $FiscalYear = $bank_stat->FiscalYear ;
                        ?>
                            <tr>
                                <td><?php echo $i ; ?> </td>
                                <td><?php echo $FiscalYear; ?></td>
                                <td><button type="button" class='btn purple btn-outline sbold view_bankstatyear'
                                        data-year='<?php echo $FiscalYear; ?>'>View</button>
                            </tr>
                            <?php 
                        } 
                        }
                        ?>
                        </tbody>
                    </table>


                </div>
            </form>
        </div>
    </div>
    <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->




<div class="modal bs-modal-lg fade bankstat_details" id="modal_bankstat" tabindex="-1" role="modal_bankstat"
    aria-hidden="true">
    <div id="editor"></div>

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="text-align: right;">
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button> -->
                <!--  <button type="button" class="btn btn-default"  data-dismiss="modal">Close</button> -->
                <button type="button" class="btn dark" onclick="printDiv('body_bankstat');"><i class="fa fa-print"></i>
                    Print</button>
                <button type="button" class="btn blue-hoki btn_bankstatpdf"><i class="fa fa-file-pdf-o"></i>
                    PDF</button>
                <!-- <button type="button"  class="btn green-haze btn_cashbookcsv"><i class="fa fa-file-excel-o"></i> CSV</button> -->
                <button type="button" class="btn purple-sharp btn_bankstatxls"><i class="fa fa-file-excel-o"></i>
                    EXCEL</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>


                <!-- <center><h4 class="modal-title">Cash Book</h4></center> -->
            </div>
            <div class="modal-body" id="body_bankstat">
                <div class="row">
                    <div class="modal_headd"></div>
                    <input type="hidden" class="modal_month">
                    <input type="hidden" class="modal_month_name">
                    <input type="hidden" class="modal_year">
                    <div class="col-md-12 cbd_div">
                    </div>
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
        buttons: [{
                extend: 'print',
                className: 'btn dark btn-outline'
            },
            {
                extend: 'pdf',
                className: 'btn green btn-outline'
            },
            {
                extend: 'csv',
                className: 'btn purple btn-outline '
            },
            {
                extend: 'colvis',
                className: 'btn yellow btn-outline '
            },

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

    jQuery(document).on('click', '.btn_fcreport', function() {
        var client_id = jQuery(".client_id").val();
        var report_url = "<?php echo $report_url; ?>";
        location.href = "<?php echo BASE_URL; ?>reports/" + report_url + "/?client_id=" + client_id;
    });


});




function printDiv(divName) {


    var contents = document.getElementById(divName).innerHTML;
    var frame1 = document.createElement('iframe');


    var htmlToPrint = '' +
        '<style type="text/css">' +
        '@page{margin:25px 20px;}' +
        'h1{padding-top:20px;}' +
        'table th, table td {' +
        'border:1px solid #ccc;' +
        'padding:0.5em;' +
        '}' +
        'table, td, th{' +
        ' border-collapse: collapse;' +
        '}' +
        '.table{' +
        'margin-top: 10px;' +
        '}' +
        '.cbd_table{' +
        'width:100%' +
        '}' +
        '.cbd_table {' +
        'padding-top: 20%;' +
        '}' +
        '</style>';
    contents += htmlToPrint;


    frame1.name = "frame1";
    frame1.style.position = "absolute";
    frame1.style.top = "-1000000px";
    document.body.appendChild(frame1);
    var frameDoc = frame1.contentWindow ? frame1.contentWindow : frame1.contentDocument.document ? frame1
        .contentDocument.document : frame1.contentDocument;
    frameDoc.document.open();
    frameDoc.document.write('<html><head><title>' + 'Bank Statement' + '</title>');
    frameDoc.document.write('</head><body>');
    // frameDoc.document.write("<center><h1>bankstat</h1></center>"+contents);
    frameDoc.document.write(contents);
    frameDoc.document.write('</body></html>');
    frameDoc.document.close();
    setTimeout(function() {
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

jQuery(document).on('click', '.view_bankstatyear', function() {
    // var data_month = jQuery(this).attr('data-month');
    // var data_month_name = jQuery(this).attr('data-month-name');
    var data_year = jQuery(this).attr('data-year');
    //console.log("data_month = "+data_month+" = data_year = "+data_year )
    ajax_bankstatyear(data_year)
})

function ajax_bankstatyear(year) {
    var report_type = jQuery(".report_type").val();
    var client_id = jQuery(".current_userid").val();
    var end_month = jQuery(".end_month").val();
    var start_month = jQuery(".start_month").val();
    // jQuery(".modal_month").val(month);
    // jQuery(".modal_month_name").val(month_name);
    jQuery(".modal_year").val(year);
    //   alert(report_type);
    if (report_type == 1) {
        // src = '<?php echo BASE_URL; ?>'+'reports/ajax_ledger_invoice';
        src = '<?php echo BASE_URL; ?>' + 'banktransactions/ajax_invoiceledger';
    } else {
        // src = '<?php echo BASE_URL; ?>'+'reports/ajax_ledger_bankjournal';
        // src = '<?php echo BASE_URL; ?>'+'reports/ajax_ledger';
        //arul edited bank transaction ledger
        src = '<?php echo BASE_URL; ?>' + 'banktransactions/ajax_ledger_new';

    }

    $.ajax({
        url: src,
        type: 'POST',
        //dataType: "json",
        dataType: "html",
        data: {
            'year': year,
            client_id: client_id,
            'report_type': report_type,
            'start_month': start_month,
            'end_month': end_month
        },
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


    var inputh_year = jQuery(this).closest('.modal-content').find('.inputh_year').val();
    var client_id = jQuery(".current_userid").val();
    var report_type = jQuery(".report_type").val();

    if (report_type == 1) {
        // src = '<?php echo BASE_URL; ?>'+'reports/ledger_pdf_invoice';
        src = '<?php echo BASE_URL; ?>' + 'banktransactions/ajax_invoiceledger_pdf';
    } else {
        //arul edited bank transaction ledger
        // src = '<?php echo BASE_URL; ?>'+'banktransactions/ledger_pdf_new';
        src = '<?php echo BASE_URL; ?>' + 'banktransactions/ajax_ledger_new_pdf';

        // src = '<?php echo BASE_URL; ?>'+'reports/ledger_pdf';
    }



    $.ajax({
        url: src,
        type: 'POST',
        dataType: "json",
        data: {
            'year': inputh_year,
            client_id: client_id,
            'report_type': report_type
        },
        success: function(data) {
            //console.log("successsss");
            $('.cash_pdfdownload')[0].click();
            $('#modal_bankstat button').prop('disabled', false);
            $('html, body').css("cursor", "auto");
        },
        error: function() {
            //  console.log("errrrrr");
            $('.cash_pdfdownload')[0].click();
            $('#modal_bankstat button').prop('disabled', false);
            $('html, body').css("cursor", "auto");
        }
    });
    //  console.log("successsss");

});



function date_Format(date_val) {
    var fromDate = new Date(date_val);
    var curr_date = fromDate.getDate();
    var curr_month = fromDate.getMonth(); //Months are zero based

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

    var New_date = curr_date + '-' + month_name + '-' + curr_year;
    //console.log(curr_year + "-" + month_name + "-" + curr_date);
    return New_date;
}
</script>