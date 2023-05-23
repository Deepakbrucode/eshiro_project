
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
                    <a href="#">Client</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Show Repors</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">

            <?php echo $this->session->flashdata('report'); ?>

            <?php 
            if($usertype == '5') { ?>
            <div class="col-md-12">
                <div class="col-md-3" style="text-align: right;"><span>Client Name</span></div>
                <div class="col-md-4">
                <select name="client_id" class="form-control client_id">
                <?php if($ClientDetails){
                    foreach($ClientDetails as $ClientDetail) { 
                        $selected = ($final_client_id == $ClientDetail->id)?'selected':'';
                    echo "<option value='".$ClientDetail->id."' ".$selected.">".$ClientDetail->name."</option>";

                 } } else {echo "<option value=''>No clients Available</option>";} ?>
                </select>
                </div>
                <div class="col-md-3"><button type="button" class="btn btn-info btn_fcreport">Filter Data</button></div><br>
                </div><br>
            <?php } ?>



            <form method="post" id="saveform">
            <div class="col-md-12">
                
                <button type="submit" name="" class="btn btn-warning btn_saveinvcost" style="width: 300px;margin: 14px;display: none;">Save</button>

                <table class="table table-striped table-hover table-bordered1 stl_table" id="show_reporttb" style="width:100%">
                    <thead>
                        <tr>
                            <th> S.No </th>
                            <th> Start Date </th>
                            <th> End Date </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        //echo "<pre>";print_r($ReportDetails);echo "</pre>";
                        if($ReportDetails_month) { 
                        $i=0;
                        setlocale(LC_MONETARY, 'en_IN');
                        foreach($ReportDetails_month as $ReportDetail) {
                        $i++;
                        $year_val	=$ReportDetail->year_val	;
                        $month_val = $ReportDetail->month_val;

                        $start_val = $year_val.'-'.$month_val."-01";
                        $end_val =  date("Y-m-t", strtotime($start_val));
                        ?>
                        <tr>
                            <td><?php echo $i; ?>  </td>
                            <td><?php echo $start_val; ?>  </td>
                            <td><?php echo $end_val; ?>  </td>
 
                            <td>
                                

                                <a class="btn-sm btn green btn-outline1" href="<?php echo BASE_URL; ?>banktransactions/analysis_data/?client_id=<?php echo $final_client_id; ?>&month=<?php echo $month_val; ?>&year=<?php echo $year_val; ?>&bank_id=<?php echo $bank_id; ?>"><i class="fa fa-eye"></i> View </a>

                            </td>

                        </tr>
                        <?php 
                        } 
                        }
                        // else {
                        // echo "<tr><td colspan='9'>No records found </td></tr>";
                        // } 
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
            buttons: [
                 { extend: 'print', className: 'btn dark btn-outline' },
                 { extend: 'pdf', className: 'btn green btn-outline'},
                { extend: 'csv', className: 'btn purple btn-outline ' },
                { extend: 'colvis', className: 'btn yellow btn-outline ' },
                
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










jQuery(document).on('click','.btn_fcreport',function(){
    var client_id = jQuery(".client_id").val();
    location.href = "<?php echo BASE_URL; ?>banktransactions/analysis_data_month/?client_id="+client_id;
});


});
            </script>
