
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
                    <a href="#">Manual Invoice</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Un-Analysis data</span>
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
                    <input type="hidden" class="month_val" value="<?php echo $month_val; ?>">
                    <input type="hidden" class="year_val" value="<?php echo $year_val; ?>">
                <select name="client_id" class="form-control client_id">
                <?php if($ClientDetails){
                    foreach($ClientDetails as $ClientDetail) { 
                        $selected = ($final_client_id == $ClientDetail->id)?'selected':'';
                    echo "<option value='".$ClientDetail->id."' ".$selected.">".$ClientDetail->name."</option>";

                 } } else {echo "<option value=''>No clients Available</option>";} ?>
                </select>
                </div>
                <div class="col-md-3"><button type="button" class="btn btn-info btn_fcreport">Filter Data</button></div>
                <div class="col-md-2"><a href="https://eshiro.app/reports/analysis_data_month/?client_id=<?php echo $final_client_id; ?>" class="btn dark" style="float: right;"><i class="fa fa-hand-o-left"></i> Back</a></div>
                <br>
                </div><br>
            <?php } ?>



<?php

$start_val = $year_val.'-'.$month_val."-01";
                        $end_val =  date("Y-m-t", strtotime($start_val));
$start_monthName = date('F', mktime(0, 0, 0, $month_val, 10)); 


        $start_fulldate = $start_monthName.' 1, '.$year_val;
        $end_fulldate = $start_monthName.' '.date('d',strtotime($end_val)).', '.$year_val;


                          echo '<p style="font-size:15px;margin-top:45px;"><center><b>Data Analysis: </b>From '.$start_fulldate.' - '.$end_fulldate."</center></h4>"; ?>
            <form method="post" id="saveform">
            <div class="col-md-12">
                
                <button type="submit" name="" class="btn btn-warning btn_saveinvcost" style="width: 300px;margin: 14px;display: none;">Save</button>

                <table class="table table-striped table-hover table-bordered1 stl_table" id="show_reporttb" style="width:100%">
                    <thead>
                        <tr>
                            <th> S.No </th>
                            <th> Report Date </th>
                            <th> Inv No </th>
                            <th> Ref No </th>
                            <th> Description </th>
                            <th> CR </th>
                            <th> DR </th>
                            <th>Cost Centre</th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // echo "<pre>";print_r($ReportDetails);echo "</pre>";
                        if($ReportDetails) { 
                        $i=0;
                        setlocale(LC_MONETARY, 'en_IN');
                        foreach($ReportDetails as $ReportDetail) {
                        $i++;
                        $report_date    =$ReportDetail->report_date ;
                        $inv_no = $ReportDetail->inv_no;
                        $ref_no = $ReportDetail->ref_no;
                        $description = $ReportDetail->description;
                        $amount_type = $ReportDetail->amount_type;
                        $tax_type = $ReportDetail->tax_type;
                        $amount = $ReportDetail->amount;
                       // $cost_name = $ReportDetail->cost_name;
                        $data_costid = $ReportDetail->cost_id;
                        $category_id = $ReportDetail->category_id;
                        $subcategory_id = $ReportDetail->subcategory_id;
                        $opt_sval = $category_id.'-'.$subcategory_id.'-'.$data_costid;

                        ?>
                        <tr>
                            <td><?php echo $i; ?>  </td>
                            <td><?php echo $report_date ; ?>  </td>
                            <td><?php echo $inv_no; ?>  </td>
                            <td><?php echo $ref_no; ?></td>
                            <td><?php echo $description; ?></td>
                            <?php
                            if($amount_type == 'sales') {
                                echo "<td>$amount</td><td></td>";
                            }
                            else
                            {
                                echo "<td></td><td>$amount</td>";
                                }?>
                            <td>
                                <input type="hidden" name="cost_details[<?php echo $i; ?>][report_id]" class="table_frminput form-control report_id" value="<?php echo $ReportDetail->report_id; ?>">
                               <!--  <input type="text" name="cost_details[<?php echo $i; ?>][cost_name]" class="table_frminput form-control cost_name" value="<?php echo $cost_name; ?>"> -->
                               <?php
                               //echo "<pre>";print_r($CostDetails);echo "</pre>"; ?>
                                <select name="cost_details[<?php echo $i; ?>][data_costid]" class="table_frminput form-control">
                                    <option value="">Select Cost Centre</option>
                                    <?php
                                    if($CostDetails)
                                    {
                                        foreach($CostDetails as $CostDetail)
                                        {
                                            $cost_id1 = $CostDetail->cost_id;
                                            $category_id1 = $CostDetail->category_id;
                                            $subcategory_id1 = $CostDetail->subcategory_id;
                                            $opt_val = $category_id1.'-'.$subcategory_id1.'-'.$cost_id1; 
                                            $selected = ($opt_sval == $opt_val)?'selected':'';
                                            echo "<option value='".$opt_val."' ".$selected.">".$CostDetail->cost_name."</option>";
                                        }
                                    }
                                    ?>
                                </select>

                                <!--<select name="cost_details[<?php echo $i; ?>][parent_cost]" class="table_frminput form-control parent_cost">
                                    <option value="">Select Parent</option>
                                    <?php
                                    if($ParentCost)
                                    {
                                        foreach($ParentCost as $Parentct)
                                        {
                                            $selected = ($parent_costid == $Parentct->cost_id)?'selected':'';
                                            echo "<option value='".$Parentct->cost_id."' ".$selected.">".$Parentct->cost_name."</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <select name="cost_details[<?php echo $i; ?>][child_cost]" class="table_frminput form-control child_cost">
                                    <?php
                                    if($parent_costid !=''){
                                       $childcost1 = $parent_childcost[$parent_costid];
                                        // $childcost1 = $this->costcentre_model->getDetails(array('parentcost' => $parent_costid));
                                        if($childcost1)
                                        {
                                            foreach($childcost1 as $childcost)
                                            {
                                                $child_costname1 = $childcost->cost_name;
                                                $child_costid1 = $childcost->cost_id;

                                                $selected = ($child_costid == $child_costid1)?'selected':'';

                                                echo '<option value="'.$child_costid1.'" '.$selected.'>'.$child_costname1.'</option>';
                                            }
                                        }
                                    }
                                    else {
                                        echo '<option value="">Select Parent First</option>';
                                    }
                                    ?>
                                    
                                </select>-->
                            <td>
                                <a class="report_investigate" data-toggle="confirmation" data-title="Investigation Data" data-singleton="true" data-popout="true" data-btn-ok-label="Investigate" data-btn-ok-icon="fa fa-trash" data-btn-ok-class="btn-sm btn-danger" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title="" aria-describedby="confirmation223268" href="<?php echo BASE_URL; ?>reports/investigate_report/<?php echo $ReportDetail->report_id; ?>"> <span class="color_orange">investigate</span></a>
                                <!-- <a class="report_investigate" data-toggle="confirmation" data-title="Investigation Data" data-singleton="true" data-popout="true" data-btn-ok-label="Restore" data-btn-ok-icon="fa fa-trash" data-btn-ok-class="btn-sm btn-danger" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title="" aria-describedby="confirmation223268" href="<?php echo BASE_URL; ?>reports/report_invrestore/<?php echo $ReportDetail->report_id; ?>"> <span class="color_orange">Restore</span></a> --> /

                                <a class="edit" href="<?php echo BASE_URL; ?>reports/edit_report/<?php echo $ReportDetail->report_id; ?>"> Edit </a> /

                                <a class="report_delete" data-toggle="confirmation" data-title="report details" data-singleton="true" data-popout="true" data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-trash" data-btn-ok-class="btn-sm btn-danger" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title="" aria-describedby="confirmation223268" href="<?php echo BASE_URL; ?>reports/delete_report/<?php echo $ReportDetail->report_id; ?>"> <span class="color_orange">Delete Permanently</span></a>

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


/*jQuery(document).on('change','.parent_cost',function(){
    var this_val = jQuery(this)
    var parent_cost = jQuery(this).val();
    var child_cost = jQuery(".child_cost").val();
    var src = '<?php echo BASE_URL; ?>'+'costcentre/get_childcost';
    this_val.closest('td').find(".child_cost").html('');
    $.ajax({
        url: src,
        type:'POST',
        dataType: "json",
        data: {'parent_cost':parent_cost},
        success: function(data) {
            console.log(data);
            var ChildCostDetails = data.ChildCostDetails;
            var child_val = '';
            jQuery.each(ChildCostDetails,function(key,value){
                child_val += "<option value='"+value['cost_id']+"'>"+value['cost_name']+"</option>";
            });
            this_val.closest('td').find(".child_cost").html(child_val);
        }
    });

});*/



jQuery(document).on('click','.btn_saveinvcostop',function(){
   // alert("cccccccccccc");
    jQuery('#saveform').submit();
})

 // Handle form submission event
   jQuery('#saveform').on('submit', function(e){
      var form = this;

      // Encode a set of form elements from all pages as an array of names and values
      var params = table.$('input,select,textarea').serializeArray();

      // Iterate over all form elements
      $.each(params, function(){
         // If element doesn't exist in DOM
         if(!$.contains(document, form[this.name])){
            // Create a hidden element
            jQuery(form).append(
               jQuery('<input>')
                  .attr('type', 'hidden')
                  .attr('name', this.name)
                  .val(this.value)
            );
         }
      });

      var src = '<?php echo BASE_URL; ?>'+'reports/saveinvcost';

      $.ajax({
        url: src,
        type:'POST',
        dataType: "json",
        data: $('#saveform').serialize(),
        success: function(data) {
            location.reload();
        }
    });


//e.preventDefault();
return false;
      
   });


jQuery(document).on('click','.btn_fcreport',function(){
    var client_id = jQuery(".client_id").val();
    var year_val = jQuery(".year_val").val();
    var month_val = jQuery(".month_val").val();
    location.href = "<?php echo BASE_URL; ?>/reports/unanalysis_data/?client_id="+client_id+"&month="+month_val+"&year="+year_val;
});


});
            </script>
