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
                    <a href="#"><?php echo $ledger_title; ?></a>
                    <i class="fa fa-angle-right"></i>
                 </li>
                 
                 <li>
                    <span>Financial Report</span>
                 </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">
            <input type="hidden" name="report_type" class="report_type" value="<?php echo $report_type; ?>">
            <?php 
            
            //echo "<pre>";print_r($this->session->userinfo);echo "</pre>"; 
            echo $this->session->flashdata('report'); ?>
                <div class="col-md-12">
                    <div class="portlet light portlet-fit  calendar">
                        <div class="portlet-body">
                            <div class="row">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-equalizer font-red-sunglo"></i>
                                            <span class="caption-subject font-red-sunglo bold uppercase">Fiancial Report</span>
                                            <span class="caption-helper">Financial Report</span>
                                         </div>
                                    </div>
                                    <div class="portlet-body form">
                                        <?php echo $this->session->flashdata('report'); ?>
                                        <!-- BEGIN FORM-->
                                        <div class="row">
                                            <form method="post" action="<?php echo BASE_URL; ?>reports/control_account">
                                                <div class="col-md-12">
                                                    <?php 
            if($usertype == '5') { ?>
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
            <?php } else {echo "<input type='hidden' class='client_id' value='".$this->session->userinfo->id."'>"; }?>
                                                    <div class="col-md-6">
                                                        <div class="form-group col-md-12">
                                                            <label class="col-md-4 control-label">Report Period</label>
                                                            <div class="col-md-8">
                                                                <div class="input-group input-large date-picker input-daterange"  >
                                                                    <input type="text" name="report_from" class="form-control report_from">
                                                                    <span class="input-group-addon"> to </span>
                                                                    <input type="text" name="report_to" class="form-control report_to"> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="col-md-5">
                                                        <div class="form-group col-md-12">
                                                            <label class="col-md-4 control-label">Register Number</label>
                                                            <div class="col-md-8">
                                                                <input type="text" class="form-control register_no" name="register_no" placeholder="Register Number" value="">
                                                            </div>
                                                        </div>
                                                        

                                                    </div> -->

                                                    <div class="col-md-2" style="text-align:right;margin-bottom:15px;">
                                                        <button type="button" class="btn btn-success btn_casubmit btn_ajaxstart">Show Report</button>
                                                        <button class="btn btn-success btn_ajaxend" style="display:none;"><i class="fa fa-refresh fa-spin"></i>Loading</button>

                                                    </div>
                                                </div>
                                            </form>
                                            </div>
                                            <div class="row">
                                            <div class="col-md-12">
                               <!-- <table class="table table-striped table-hover table-bordered1 cashbook_table" id="freport_details" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th> S.no </th>
                                            <th>Report Period </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>                                        
                                    <tbody>
                                        <?php
                                        if($financial_reports)
                                        {
                                            $kk=0;
                                            foreach ($financial_reports as $financial) {
                                                $kk++;
  
                                                ?>
                                          
                                        <tr>
                                            <td><?php echo $kk; ?></td>
                                            <td><?php echo $financial->start_date." to ".$financial->end_date; ?></td>
                                             <td><a href="https://eshiro.app/financialreport/fiancial_report_create?freport_id=<?php echo $financial->freport_id; ?>" class='btn purple btn-outline sbold ' >View</a> 
                                                   
                                            </td> 
                                        </tr>
                                        <?php
                                          }

                                        }
                                        ?>
                                    </tbody>
                                </table>-->
                        </div>
                       
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                  format: "mm-yyyy",
        viewMode: "months", 
        minViewMode: "months",
        startView: "months", 
                orientation: "bottom"
            });

var table = $('#freport_details');

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
            // buttons: [
            //     { extend: 'print', className: 'btn dark btn-outline' },
            //     { extend: 'pdf', className: 'btn green btn-outline' },
            //     { extend: 'csv', className: 'btn purple btn-outline ' }
            // ],

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

            // "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", 
            // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });






$(document).ajaxStart(function(){
    jQuery(".btn_ajaxstart").hide();
    jQuery(".btn_ajaxend").show();
});


$(document).ajaxComplete(function(){
    jQuery(".btn_ajaxstart").show();
    jQuery(".btn_ajaxend").hide();
});


jQuery(document).on('click','.btn_casubmit',function(){
    
    var report_from = $(".report_from").val();
    var report_to = $(".report_to").val();
    var client_id = $(".client_id").val() || '';
    var register_no = $(".register_no").val();
    var report_type = $(".report_type").val();
    //var report_type = $(".report_type").val();
    
    jQuery(".table_content").html('');
    
     var src = '<?php echo BASE_URL; ?>'+'financialreport/ajax_create_report';
     $.ajax({
                    url: src,
                    type:'POST',
                    //dataType: "json",
                    dataType: "json",
                    data: {'report_from':report_from,"report_to" : report_to,'client_id':client_id,'register_no':register_no,'report_type':report_type },
                    success: function(data) {
                        console.log(data);
                        console.log(data['insert_status']);
                        if(data['insert_status'])
                        {
                            window.location.href = '<?php echo BASE_URL; ?>'+'financialreport/fiancial_report_create?freport_id='+data['insert_status'];
                        }
                    }
                });

    
});
 
});
</script>
           

