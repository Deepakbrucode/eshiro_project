
<style>
    .btn-group{
        /*width: 140px;*/
        width: auto;
        position: relative;
        display: inline-flex;
    }
    .popover.confirmation.fade.top.in{margin-left: -5%;}

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
                    <a href="#">Cost Centre</a>
                    <i class="fa fa-angle-right"></i>
                </li>
                <li>
                    <span>Show Cost Centre</span>
                </li>
            </ul>
        </div>
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12" style="text-align:right;"> <a href="<?php echo BASE_URL; ?>costcentre/add_costcentre" class="btn btn-primary">Add Cost Centre</a>
                <?php
                $set_id = '';
                if($activeuserdetails){
                    foreach($activeuserdetails as $activeuserdetail){
                        $set_id = $activeuserdetail->set_id;
                    }
                }
                //if(($set_id == '' || $set_id == 0) && $usertype != '5'){
                ?>
                / <a href="<?php echo BASE_URL; ?>costcentre/active_costcentre" class="btn btn-primary">Activate Cost Centre</a>
            <?php //} ?>
            </div><br><br>
            <?php echo $this->session->flashdata('costcentre'); ?>
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

            <div class="col-md-12">
                <table class="table table-striped table-hover table-bordered1 stl_table" id="show_reporttb" style="width:100%">
                    <thead>
                        <tr>
                            <!-- <th style="display: none;"> S.no </th> -->
                            <th> Accounts </th>
                            <th> Name </th>
                            <th> Links </th>
                            <th> Category </th>
                           <th> Sub Category </th>
                           <?php if($usertype == '5') { ?><th> Set </th> <?php } ?>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        //echo "<pre>";print_r($CostDetails);echo "</pre>";
                        if($CostDetails) { 
                            $set_array = array();
                            if($Sets)
                            {
                                foreach($Sets as $Set)
                                {
                                    $set_id = $Set->set_id;
                                    $set_name = $Set->set_name;
                                    $set_array[$set_id] = $set_name;
                                }
                            }
                        $i=0;
                        setlocale(LC_MONETARY, 'en_IN');
                        foreach($CostDetails as $CostDetail) {
                        $i++;
                        //echo "<pre>";print_r($CostDetail);echo "</pre>";
                        $account_no = $CostDetail->account_no;
                        $set_id = $CostDetail->set_id;
                        $links = $CostDetail->links;
                        $cost_name	=$CostDetail->cost_name;
                        $status = $CostDetail->status;
                        $cost_id = $CostDetail->cost_id;
                        $category_id = $CostDetail->category_id;
                        $subcategory_id = $CostDetail->subcategory_id;
                        $category_name = $subcategory_name = '';
                        if($category_id !='')
                        {
                            $catcost = $this->costcentre_model->getDetails(array('cost_id' => $category_id));
                            if($catcost)
                            {
                                foreach($catcost as $ctcost)
                                {
                                    $category_name = $ctcost->cost_name;
                                }
                            }
                        }
                        if($subcategory_id !='')
                        {
                            $subcost = $this->costcentre_model->getDetails(array('cost_id' => $subcategory_id));
                            if($subcost)
                            {
                                foreach($subcost as $sbcost)
                                {
                                    $subcategory_name = $sbcost->cost_name;
                                }
                            }
                        }
                        

                        $status_txt = ($status == '1')?'Active':'In-Active';
                        ?>
                        <tr>
                            <!-- <td style="display: none;"><?php echo $i; ?></td> -->
                            <td><?php echo $account_no; ?>  </td>
                            <td><?php echo $cost_name; ?>  </td>
                            <td><?php echo $links; ?> </td>
                            <td><?php echo $category_name; ?>  </td>
                            <td><?php echo $subcategory_name; ?>  </td>
                           <?php if($usertype == '5') { ?> <td> <?php echo ($set_id !='' && $set_id !='0')?$set_array[$set_id]:''; ?></td> <?php } ?>
                            <td>
                                <a class="edit" href="<?php echo BASE_URL; ?>costcentre/edit_costcentre/<?php echo $cost_id; ?>"> Edit </a> /

                                <a class="cost_delete" data-toggle="confirmation" data-title="Cost Centre details" data-singleton="true" data-popout="true" data-btn-ok-label="Delete" data-btn-ok-icon="fa fa-trash" data-btn-ok-class="btn-sm btn-danger" data-btn-cancel-label="Dismiss" data-btn-cancel-icon="fa fa-times" data-btn-cancel-class="btn-sm btn-default" data-original-title="" title="" aria-describedby="confirmation223268" href="<?php echo BASE_URL; ?>costcentre/delete_costc/<?php echo $cost_id; ?>"> <span class="color_orange">Delete</span></a>

                            </td>

                        </tr>
                        <?php 
                        } 
                        }
                        else {
                        //echo "<tr><td colspan='5'>No records found </td></tr>";
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
                [5, 'asc']
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
    //var page_slug = '<php echo $page_slug; ?>';
    location.href = "<?php echo BASE_URL; ?>costcentre/<?php echo $page_slug; ?>?client_id="+client_id;
})


});
            </script>
