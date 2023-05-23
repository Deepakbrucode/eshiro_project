
        
           
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
                    <div class="row">
                    <?php echo $this->session->flashdata('cashbook'); ?>
                        <div class="col-md-12">
                            <table class="table table-striped table-hover table-bordered" id="cashbook" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th> S.No </th>
                                                <th> Date </th>
                                                <th> Client </th>

                                            </tr>
                                        </thead>
                                        <tbody>


                                            <tr>
                                                <td>1</td>
                                               <td>1</td>
                                                <td>1</td>


                                            </tr>
                                        <?php 

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
jQuery(document).ready(function() {
            var table = $('#cashbook');

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
            </script>



            
    