<style type="text/css"> 

    table {
    border-collapse: collapse;
}

table, td, th {
    border-bottom: 1px solid black!important;
/*    border:none;*/
}
     #tab-content table, td, th {
    border: 1px solid black;
}


</style>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->
        
        <div class="cashbook_details" id="cashbook_details">
            <div class="row">
                <?php echo $this->session->flashdata('cashbook');?>
                    <div class="col-md-12" id="">
                        <div class="col-md-6 col-sm-6">

                            <table class="table table-striped table-hover table-bordered" id="cashbook1" style="width:100%;border:1px solid;">
                                <thead>
                                    <tr>
                                        <th colspan="6" style="text-align:center;border-bottom:1px solid;">RECEIPTS SIDE</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 15%;"> Date </th>
                                        <th style="width: 20%;"> Details </th>
                                        <th> File No </th>
                                        <th>  Sundry </th>
                                        <th> Client </th>
                                        <th> Bank </th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <td colspan="3"></td>
                                            <th>R1,755.15</th>
                                            <th>R1,214,038.96</th>
                                            <th>R1,215,794.11</th>
                                    </tr>
                                    <tr>
                                        <td colspan="3"></td>
                                        <td colspan="3" style="text-align:center;">R 0.00</td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <th style="text-align:left;">1-May-16</th>
                                        <th style="text-align:left;">OPENING BALANCE</th>
                                        <th></th>
                                        <th></th>
                                        <th>R 5,71,231.03</th>
                                        <th>R 5,71,231.03</th>
                                    </tr>
                                    <tr>
                                        <td>4-May-16</td>
                                        <td>NUM</td>
                                        <td> </td>
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
                            <table class="table" style="width:100%;border:1px solid;">
                                <thead>
                                    <tr>
                                        <th colspan="6" style="text-align:center;border-bottom:1px solid;">PAYMENT SIDE</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 15%;"> Date </th>
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
                                        <th>R 0.00</th>
                                        <th>R4,14,302.34</th>
                                        <th>R4,14,302.34</th>
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
                                        <td> R 30,000.00</td>
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
                                        <td> </td>
                                        <td>R 70,000.00</td>
                                        <td>R 70,000.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                     
                    <div class="row">
                      <!-- <div class="col-md-2 col-sm-2"></div> -->
                        <div class="col-md-8" id="tab-content">
                            <div style="text-align: center;margin-top:15px;">
                                <p><b> Bank Reconciliation Statement</b></p>
                                <p>As At May, 2016</p>
                            </div>
                            <table class="table" style="margin-top:15px;width:100%;">

                                <tbody>

                                    <tr>
                                        <td>Balance as per Cashbok</td>
                                        <td>R 7,99,736.62</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Add:</td>
                                    </tr>
                                    <tr>
                                        <td>Credit Interest</td>
                                        <td>R 1,755.15</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="font-weight:bold;border-bottom: 2px solid;">R 8,01,491.77</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Less:</td>
                                    </tr>
                                    <tr>
                                        <td>Bank Charges</td>
                                        <td>R 0.00</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="font-weight:bold;border-bottom: 2px solid;">R 8,01,491.77</td>
                                    </tr>
                                    <tr>
                                        <td>Balance as per Bank Statement</td>
                                        <td style="font-weight:bold;border-bottom: 2px solid;">R 8,01,491.77</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:bold;">Unreconcilable Difference</td>
                                        <td style="font-weight:bold;">R 0.00</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
            </div>

        </div>
    </div>
</div>