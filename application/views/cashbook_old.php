
        <style type="text/css">
            .cashbook_details table td,.cashbook_details table th{
                   
                  text-align: center;
                }
           
            .cashbook_details .table>tbody>tr>td,.cashbook_details .table>tbody>tr>th {
                font-size: 12px;
                width: 70%;
            }
            .cashbook_details .table > tfoot > tr > td {
                padding:10px 7px!important;
                 
                
                }
              /*  .table>tbody>tr>th {
                font-size: 12px;
                width: 18%;
            }*/
                @media print {
                 
                              .cashbook_details h1 {
                    font-size: 12pt;
                }

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
                                <a href="#">Report</a>
                                <i class="fa fa-angle-right"></i>
                            </li>
                            <li>
                                <span>Cashbook</span>
                            </li>
                        </ul>
                    </div>
                    <!-- END PAGE HEADER-->
                    <div class="cashbook_details1" >
                    <div class="row">
                    <?php echo $this->session->flashdata('cashbook'); ?>
                        <div class="col-md-12">
                                <table class="table table-striped table-hover table-bordered" id="cash_details" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th> S.no </th>
                                            <th> Month & Year </th>
                                            <th> Action </th>
                                        </tr>
                                    </thead>                                        
                                    <tbody>
                                        <?php
                                       echo "<pre>"; print_r($CashDetails);echo "</pre>";
                                        if($CashDetails)
                                        {
                                            $kk=0;
                                            foreach ($CashDetails as $CashDetail) {
                                                $kk++;
                                                $cash_month = $CashDetail->cash_month;
                                                $cash_year = $CashDetail->cash_year;
                                                $cash_month_name =  date('M', strtotime($cash_month . '01'));
                                               echo "<tr><td>".$kk."</td><td>".$cash_month_name."-".$cash_year."</td><td><a class='btn purple btn-outline sbold' data-toggle='modal' href='#modal_cashbook'> View </a></td></tr>";
                                            }

                                        }
                                        ?>
                                        <!-- <tr>
                                            <td>1. </td>
                                            <td>Jun-2017</td>
                                            <td>View</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                        </div>
                        <div class="col-md-12 cashbook_details">
                            <div class="col-md-6 col-sm-6">
                                


                                  <table class="table table-striped table-hover table-bordered" id="cashbook1" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th colspan="6" style="text-align:center;">RECEIPTS SIDE</th>
                                            </tr>
                                           <tr>
                                                <th> Date </th>
                                                <th> Details </th>
                                                <th> File No </th>
                                                <th> Sundry </th>
                                                <th> Client </th>
                                                <th> Bank </th>
                                            </tr>
                                        </thead>   
                                          <tfoot>
                                            <tr>
                                            <td colspan="3"></td>
                                            <td style="border-bottom: 2px solid;">R1,755.15</td>
                                            <td style="border-bottom: 2px solid;">R1,214,038.96</td>
                                            <td style="border-bottom: 2px solid;">R1,215,794.11</td>
                                          </tr>
                                          <tr>
                                            <td colspan="3"></td>
                                            <td></td>
                                            <td colspan="3" style="font-weight:400!important;">R 0.00</td>
                                          </tr>                                          
                                        </tfoot>                                      
                                        <tbody>
                                            <tr>
                                                <th>1-May-16</th>
                                               <th>OPENING BALANCE</th>
                                                <th></th>
                                                <th></th>
                                                <th>R 5,71,231.03</th>
                                                <th>R 5,71,231.03</th>
                                            </tr>
                                              <tr>
                                                <td>4-May-16</td>
                                               <td>NUM</td>
                                                <td></td>
                                                <td> </td>
                                                <td>R 3,78,372.19</td>
                                                <td>R 3,78,372.19</td>
                                            </tr>
                                              <tr>
                                                <td>13-May-16</td>
                                               <td>NUM</td>
                                                <td></td>
                                                <td> </td>
                                                <td>R 47,975.74</td>
                                                <td>R 47,975.74</td>
                                            </tr>
                                            <tr>
                                                <td>13-May-16</td>
                                               <td>MINERALS OMINOPEX</td>
                                                <td></td>
                                                <td> </td>
                                                <td>R 37,620.00</td>
                                                <td>R 37,620.00</td>
                                            </tr>
                                             <tr>
                                                <td>23-May-16</td>
                                               <td>POPCRU</td>
                                                <td></td>
                                                <td> </td>
                                                <td>R 1,78,840.00</td>
                                                <td>R 1,78,840.00</td>
                                            </tr>
                                             <tr>
                                                <td>31-May-16</td>
                                               <td>CREDIT INTEREST</td>
                                                <td></td>
                                                <td>R 1,755.15 </td>
                                                <td></td>
                                                <td>R 1,755.15</td>
                                            </tr>                                          
                                        </tbody>

                                      
                                     </table>
                                   
                            </div>
                            
                            <div class="col-md-6 col-sm-6">
                            <table class="table table-striped table-hover table-bordered" id="cashbook_id" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th colspan="6" style="text-align:center;">PAYMENT SIDE</th>
                                            </tr>
                                            <tr>
                                                <th> Date </th>
                                                <th> Details </th>
                                                <th> File No </th>
                                                <th> Sundry </th>
                                                <th> Client </th>
                                                <th> Bank </th>

                                            </tr>
                                        </thead>
                                         <tfoot>
                                            <tr>
                                            <td colspan="3"></td>
                                            <td style="border-bottom: 2px solid; ">R 0.00</td>
                                            <td style="border-bottom: 2px solid; ">R4,14,302.34</td>
                                            <td style="border-bottom: 2px solid;">R4,14,302.34</td>
                                          </tr>
                                          <tr>
                                            <td colspan="3" style="font-weight:400!important"></td>
                                            <td>R1,755.15</td>
                                            <td>R7,99,736.62</td>
                                            <td>R8,01,491.77</td>
                                          </tr>                                          
                                        </tfoot> 
                                        <tbody>

                                            <tr>
                                                <td>3-May-16</td>
                                               <td>CHEQUE</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 59,302.34</td>
                                                <td>R 59,302.34</td>
                                            </tr>
                                            <tr>
                                                <td>4-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 40,000.00</td>
                                                <td>R 40,000.00</td>
                                            </tr>
                                            <tr>
                                                <td>5-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 30,000.00</td>
                                                <td>R 30,000.00</td>
                                            </tr>
                                            <tr>
                                                <td>10-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 25,000.00</td>
                                                <td>R 25,000.00</td>
                                            </tr>
                                             <tr>
                                                <td>16-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 20,000.00</td>
                                                <td>R 20,000.00</td>
                                            </tr>
                                             <tr>
                                                <td>23-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 50,000.00</td>
                                                <td>R 50,000.00</td>
                                            </tr>
                                             <tr>
                                                <td>23-May-16</td>
                                               <td>CHEQUE</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 25,000.00</td>
                                                <td>R 25,000.00</td>
                                            </tr>
                                            <tr>
                                                <td>26-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 25,000.00</td>
                                                <td>R 25,000.00</td>
                                            </tr>
                                            <tr>
                                                <td>27-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 30,000.00</td>
                                                <td>R 30,000.00</td>
                                            </tr>
                                             <tr>
                                                <td>28-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 20,000.00</td>
                                                <td>R 20,000.00</td>
                                            </tr>
                                             <tr>
                                                <td>30-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 20,000.00</td>
                                                <td>R 20,000.00</td>
                                            </tr>
                                             <tr>
                                                <td>31-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 70,000.00</td>
                                                <td>R 70,000.00</td>
                                            </tr>                                          
                                        </tbody>
                                    </table>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-2 col-sm-2"></div>
                        <div class="col-md-8 col-sm-8">
                         <div style="text-align: center; ">
                          <p><b> Bank Reconciliation Statement</b></p>
                          <p>As At May, 2016</p>
                          </div>
                        <table class="table">


                            <tbody>
                                
                                <tr>
                                    <td>Balance as per Cashbok</td>
                                    <td style="border-bottom:1px solid #EEF1F5;">R 7,99,736.62</td>
                                </tr>
                                <tr>
                                    <th style="text-decoration: underline;">Add:</th>
                                </tr>
                                <tr>
                                    <td>Credit Interest</td>
                                    <td style="border-bottom: 1px solid;">R 1,755.15</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th style="border-bottom: 1px solid;">R 8,01,491.77</th>
                                </tr>
                                <tr>
                                    <th style="text-decoration: underline;">Less:</th>
                                </tr>
                                <tr>
                                    <td>Bank Charges</td>
                                    <td>R 0.00</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th style="border-bottom: 2px solid;">R 8,01,491.77</th>
                                </tr>
                                <tr>
                                    <td>Balance as per Bank Statement</td>
                                    <th style="border-bottom: 2px solid;">R 8,01,491.77</th>
                                </tr>
                                <tr>
                                    <th>Unreconcilable Difference</th>
                                    <th>R 0.00</th>
                                </tr>
                             </tbody>
                        </table>
                            
                        </div>
                    </div>

                    </div>
                    <input type="button" onclick="printDiv('cashbook_details')" value="Print Invoice" />


                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->


            <div class="modal bs-modal-lg fade cashbook_details" id="modal_cashbook" tabindex="-1" role="modal_cashbook" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                            <center><h4 class="modal-title">Cash Book</h4></center>
                        </div>
                        <div class="modal-body"> 
                            <div class="row">
                                <div class="col-md-12"> 
                                    <div class="col-md-6">
                                        <table class="table table-striped table-hover table-bordered" id="cashbook1" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th colspan="6" style="text-align:center;">RECEIPTS SIDE</th>
                                            </tr>
                                           <tr>
                                                <th> Date </th>
                                                <th> Details </th>
                                                <th> File No </th>
                                                <th> Sundry </th>
                                                <th> Client </th>
                                                <th> Bank </th>
                                            </tr>
                                        </thead>   
                                          <tfoot>
                                            <tr>
                                            <td colspan="3"></td>
                                            <td style="border-bottom: 2px solid;">R1,755.15</td>
                                            <td style="border-bottom: 2px solid;">R1,214,038.96</td>
                                            <td style="border-bottom: 2px solid;">R1,215,794.11</td>
                                          </tr>
                                          <tr>
                                            <td colspan="3"></td>
                                            <td></td>
                                            <td colspan="3" style="font-weight:400!important;">R 0.00</td>
                                          </tr>                                          
                                        </tfoot>                                      
                                        <tbody>
                                            <tr>
                                                <th>1-May-16</th>
                                               <th>OPENING BALANCE</th>
                                                <th></th>
                                                <th></th>
                                                <th>R 5,71,231.03</th>
                                                <th>R 5,71,231.03</th>
                                            </tr>
                                              <tr>
                                                <td>4-May-16</td>
                                               <td>NUM</td>
                                                <td></td>
                                                <td> </td>
                                                <td>R 3,78,372.19</td>
                                                <td>R 3,78,372.19</td>
                                            </tr>
                                              <tr>
                                                <td>13-May-16</td>
                                               <td>NUM</td>
                                                <td></td>
                                                <td> </td>
                                                <td>R 47,975.74</td>
                                                <td>R 47,975.74</td>
                                            </tr>
                                            <tr>
                                                <td>13-May-16</td>
                                               <td>MINERALS OMINOPEX</td>
                                                <td></td>
                                                <td> </td>
                                                <td>R 37,620.00</td>
                                                <td>R 37,620.00</td>
                                            </tr>
                                             <tr>
                                                <td>23-May-16</td>
                                               <td>POPCRU</td>
                                                <td></td>
                                                <td> </td>
                                                <td>R 1,78,840.00</td>
                                                <td>R 1,78,840.00</td>
                                            </tr>
                                             <tr>
                                                <td>31-May-16</td>
                                               <td>CREDIT INTEREST</td>
                                                <td></td>
                                                <td>R 1,755.15 </td>
                                                <td></td>
                                                <td>R 1,755.15</td>
                                            </tr>                                          
                                        </tbody>

                                      
                                     </table>
                                    </div>
                                    <div class="col-md-6">
                                         <table class="table table-striped table-hover table-bordered" id="cashbook_id" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th colspan="6" style="text-align:center;">PAYMENT SIDE</th>
                                            </tr>
                                            <tr>
                                                <th> Date </th>
                                                <th> Details </th>
                                                <th> File No </th>
                                                <th> Sundry </th>
                                                <th> Client </th>
                                                <th> Bank </th>

                                            </tr>
                                        </thead>
                                         <tfoot>
                                            <tr>
                                            <td colspan="3"></td>
                                            <td style="border-bottom: 2px solid; ">R 0.00</td>
                                            <td style="border-bottom: 2px solid; ">R4,14,302.34</td>
                                            <td style="border-bottom: 2px solid;">R4,14,302.34</td>
                                          </tr>
                                          <tr>
                                            <td colspan="3" style="font-weight:400!important"></td>
                                            <td>R1,755.15</td>
                                            <td>R7,99,736.62</td>
                                            <td>R8,01,491.77</td>
                                          </tr>                                          
                                        </tfoot> 
                                        <tbody>

                                            <tr>
                                                <td>3-May-16</td>
                                               <td>CHEQUE</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 59,302.34</td>
                                                <td>R 59,302.34</td>
                                            </tr>
                                            <tr>
                                                <td>4-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 40,000.00</td>
                                                <td>R 40,000.00</td>
                                            </tr>
                                            <tr>
                                                <td>5-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 30,000.00</td>
                                                <td>R 30,000.00</td>
                                            </tr>
                                            <tr>
                                                <td>10-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 25,000.00</td>
                                                <td>R 25,000.00</td>
                                            </tr>
                                             <tr>
                                                <td>16-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 20,000.00</td>
                                                <td>R 20,000.00</td>
                                            </tr>
                                             <tr>
                                                <td>23-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 50,000.00</td>
                                                <td>R 50,000.00</td>
                                            </tr>
                                             <tr>
                                                <td>23-May-16</td>
                                               <td>CHEQUE</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 25,000.00</td>
                                                <td>R 25,000.00</td>
                                            </tr>
                                            <tr>
                                                <td>26-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 25,000.00</td>
                                                <td>R 25,000.00</td>
                                            </tr>
                                            <tr>
                                                <td>27-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 30,000.00</td>
                                                <td>R 30,000.00</td>
                                            </tr>
                                             <tr>
                                                <td>28-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 20,000.00</td>
                                                <td>R 20,000.00</td>
                                            </tr>
                                             <tr>
                                                <td>30-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 20,000.00</td>
                                                <td>R 20,000.00</td>
                                            </tr>
                                             <tr>
                                                <td>31-May-16</td>
                                               <td>TRF TO BUSINESS</td>
                                                <td></td>
                                                <td></td>
                                                <td>R 70,000.00</td>
                                                <td>R 70,000.00</td>
                                            </tr>                                          
                                        </tbody>
                                    </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-8 col-sm-8">
                         <div style="text-align: center; ">
                          <p><b> Bank Reconciliation Statement</b></p>
                          <p>As At May, 2016</p>
                          </div>
                        <table class="table">


                            <tbody>
                                
                                <tr>
                                    <td>Balance as per Cashbok</td>
                                    <td style="border-bottom:1px solid #EEF1F5;">R 7,99,736.62</td>
                                </tr>
                                <tr>
                                    <th style="text-decoration: underline;">Add:</th>
                                </tr>
                                <tr>
                                    <td>Credit Interest</td>
                                    <td style="border-bottom: 1px solid;">R 1,755.15</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th style="border-bottom: 1px solid;">R 8,01,491.77</th>
                                </tr>
                                <tr>
                                    <th style="text-decoration: underline;">Less:</th>
                                </tr>
                                <tr>
                                    <td>Bank Charges</td>
                                    <td>R 0.00</td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th style="border-bottom: 2px solid;">R 8,01,491.77</th>
                                </tr>
                                <tr>
                                    <td>Balance as per Bank Statement</td>
                                    <th style="border-bottom: 2px solid;">R 8,01,491.77</th>
                                </tr>
                                <tr>
                                    <th>Unreconcilable Difference</th>
                                    <th>R 0.00</th>
                                </tr>
                             </tbody>
                        </table>
                            
                        </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                            <button type="button" class="btn green btn_addfile">Add File</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->

            <script type="text/javascript">
jQuery(document).ready(function() {
            var table = $('#cash_details');

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

function printDiv(divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
            </script>



            
    