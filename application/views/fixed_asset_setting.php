<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <i class="fa fa-users"></i>
                    <a href="#">Settings</a>
                    <i class="fa fa-angle-right"></i>
                 </li>
                 <li>
                    <span>Fixed Asset</span>
                 </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">
            
                <div class="col-md-12">
                    <div class="portlet light portlet-fit  calendar">
                        <div class="portlet-body">
                            <div class="row">
                                <div class="portlet light bordered">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="icon-equalizer font-red-sunglo"></i>
                                            <span class="caption-subject font-red-sunglo bold uppercase">Fixed Asset</span>
                                            <!-- <span class="caption-helper">Financial Report</span> -->
                                         </div>
                                    </div>
                                    <div class="portlet-body form">
                                        
                                        <!-- BEGIN FORM-->
                                        <div class="row">
                                            <?php echo $this->session->flashdata('costcenter'); ?>
                                             <a href="<?php echo BASE_URL; ?>client/addBankAccount" class="btn btn-primary" style='float:right;'>Add Bank Account</a>
                                            <?php if($usertype == '5') { ?>
                                                <div class="col-md-12">
                                                    <div class="col-md-3" style="text-align: right;"><span>Client Name: </span></div>
                                                    <div class="col-md-4">
                                                    <select name="client_id" class="form-control client_id">
                                                    <?php if($ClientDetails){
                                                        foreach($ClientDetails as $ClientDetail) { 
                                                            $selected = ($fclient_id == $ClientDetail->id)?'selected':'';
                                                        echo "<option value='".$ClientDetail->id."' ".$selected.">".$ClientDetail->name."</option>";

                                                     } } else {echo "<option value=''>No clients Available</option>";} ?>
                                                    </select>
                                                    </div>
                                                    <div class="col-md-3"><button type="button" class="btn btn-info btn_fcreport">Filter Report</button></div>
                                                    </div>
                                                <?php } ?>      
                                            </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                <table class="table table-striped table-hover table-bordered1 cashbook_table" id="freport_details" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>S.no</th>
                                            <th>Asset Name</th>
                                            <th>Dep Percentage</th>
                                            <th>Residual Value</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>                                        
                                    <tbody>
                                        <?php
                                        if($assetDetails)
                                        {
                                            $kk=0;
                                            foreach ($assetDetails as $assetDetail) {
                                                $kk++;
  
                                                ?>
                                          
                                        <tr>
                                            <td><?php echo $kk; ?></td>
                                            <td><?php echo $assetDetail->cost_name; ?></td>
                                            <td><?php echo $assetDetail->dep_per; ?>%</td>
                                            <td><?php echo $assetDetail->residual_value; ?></td>
                                             <td><a href="<?php echo BASE_URL; ?>financialreport/edit_asset_dep?cost_id=<?php echo $assetDetail->cost_id; ?>" class='btn purple btn-outline sbold ' >Edit</a> 
                                                   
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



jQuery(document).on('click','.btn_fcreport',function(){
    var client_id = jQuery(".client_id").val();
    //var page_slug = '<php echo $page_slug; ?>';
    location.href = "<?php echo BASE_URL; ?>financialreport/fixed_asset_setting?client_id="+client_id;
})


$(document).ajaxStart(function(){
    jQuery(".btn_ajaxstart").hide();
    jQuery(".btn_ajaxend").show();
});


$(document).ajaxComplete(function(){
    jQuery(".btn_ajaxstart").show();
    jQuery(".btn_ajaxend").hide();
});



 
});
</script>
           

