
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
            
            <?php echo $this->session->flashdata('costcentre'); ?>
            <div class="col-md-12">
                <table class="table table-striped table-hover table-bordered1 stl_table" id="show_reporttb" style="width:100%">
                    <thead>
                        <tr>
                            <th> S.No </th>
                            <th> Category Name </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        //echo "<pre>";print_r($CostDetails);echo "</pre>";
                        if($CostDetails) { 
                        $i=0;
                        setlocale(LC_MONETARY, 'en_IN');
                        foreach($CostDetails as $CostDetail) {
                        $i++;
                        //echo "<pre>";print_r($CostDetail);echo "</pre>";
                        $cost_name  =$CostDetail->cost_name;
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
                            <td><?php echo $i; ?>  </td>
                            <td><?php echo $cost_name; ?>  </td>
                        
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
    //var page_slug = '<php echo $page_slug; ?>';
    location.href = "<?php echo BASE_URL; ?>costcentre/<?php echo $page_slug; ?>?client_id="+client_id;
})


});
            </script>
